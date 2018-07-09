# -*- coding: utf-8 -*-
#
# Copyright (C)2005-2009 Edgewall Software
# Copyright (C) 2005 Christopher Lenz <cmlenz@gmx.de>
# All rights reserved.
#
# This software is licensed as described in the file COPYING, which
# you should have received as part of this distribution. The terms
# are also available at http://trac.edgewall.org/wiki/TracLicense.
#
# This software consists of voluntary contributions made by many
# individuals. For the exact contribution history, see the revision
# history and logs, available at http://trac.edgewall.org/log/.
#
# Author: Christopher Lenz <cmlenz@gmx.de>

import os
import re
import weakref

from trac.core import *
from trac.db.api import IDatabaseConnector
from trac.db.util import ConnectionWrapper
from trac.util import get_pkginfo

_like_escape_re = re.compile(r'([/_%])')

try:
    import pysqlite2.dbapi2 as sqlite
    have_pysqlite = 2
except ImportError:
    try:
        import sqlite3 as sqlite
        have_pysqlite = 2
    except ImportError:
        try:
            import sqlite
            have_pysqlite = 1
        except ImportError:
            have_pysqlite = 0

if have_pysqlite == 2:
    _ver = sqlite.sqlite_version_info
    sqlite_version = _ver[0] * 10000 + _ver[1] * 100 + int(_ver[2])
    sqlite_version_string = '%d.%d.%d' % (_ver[0], _ver[1], int(_ver[2]))

    class PyFormatCursor(sqlite.Cursor):
        def _rollback_on_error(self, function, *args, **kwargs):
            try:
                return function(self, *args, **kwargs)
            except sqlite.DatabaseError, e:
                self.cnx.rollback()
                raise
        def execute(self, sql, args=None):
            if args:
                sql = sql % (('?',) * len(args))
            return self._rollback_on_error(sqlite.Cursor.execute, sql,
                                           args or [])
        def executemany(self, sql, args=None):
            if args:
                sql = sql % (('?',) * len(args[0]))
            return self._rollback_on_error(sqlite.Cursor.executemany, sql,
                                           args or [])

elif have_pysqlite == 1:
    _ver = sqlite._sqlite.sqlite_version_info()
    sqlite_version = _ver[0] * 10000 + _ver[1] * 100 + _ver[2]
    sqlite_version_string = '%d.%d.%d' % _ver

    class SQLiteUnicodeCursor(sqlite.Cursor):
        def _convert_row(self, row):
            return tuple([(isinstance(v, str) and [v.decode('utf-8')] or [v])[0]
                          for v in row])
        def fetchone(self):
            row = sqlite.Cursor.fetchone(self)
            return row and self._convert_row(row) or None
        def fetchmany(self, num):
            rows = sqlite.Cursor.fetchmany(self, num)
            return rows != None and [self._convert_row(row)
                                     for row in rows] or []
        def fetchall(self):
            rows = sqlite.Cursor.fetchall(self)
            return rows != None and [self._convert_row(row)
                                     for row in rows] or []


def _to_sql(table):
    sql = ["CREATE TABLE %s (" % table.name]
    coldefs = []
    for column in table.columns:
        ctype = column.type.lower()
        if column.auto_increment:
            ctype = "integer PRIMARY KEY"
        elif len(table.key) == 1 and column.name in table.key:
            ctype += " PRIMARY KEY"
        elif ctype == "int":
            ctype = "integer"
        coldefs.append("    %s %s" % (column.name, ctype))
    if len(table.key) > 1:
        coldefs.append("    UNIQUE (%s)" % ','.join(table.key))
    sql.append(',\n'.join(coldefs) + '\n);')
    yield '\n'.join(sql)
    for index in table.indices:
        unique = index.unique and 'UNIQUE' or ''
        yield "CREATE %s INDEX %s_%s_idx ON %s (%s);" % (unique, table.name,
              '_'.join(index.columns), table.name, ','.join(index.columns))


class SQLiteConnector(Component):
    """SQLite database support."""
    implements(IDatabaseConnector)

    def __init__(self):
        self._version = None

    def get_supported_schemes(self):
        return [('sqlite', 1)]

    def get_connection(self, path, params={}):
        if not self._version:
            global sqlite_version_string
            self._version = get_pkginfo(sqlite).get(
                'version', '%d.%d.%s' % sqlite.version_info)
            self.env.systeminfo.extend([('SQLite', sqlite_version_string),
                                        ('pysqlite', self._version)])
        return SQLiteConnection(path, params)

    def init_db(cls, path, params={}):
        if path != ':memory:':
            # make the directory to hold the database
            if os.path.exists(path):
                raise TracError('Database already exists at %s' % path)
            os.makedirs(os.path.split(path)[0])
        if isinstance(path, unicode): # needed with 2.4.0
            path = path.encode('utf-8')
        cnx = sqlite.connect(path, timeout=int(params.get('timeout', 10000)))
        cursor = cnx.cursor()
        from trac.db_default import schema
        for table in schema:
            for stmt in cls.to_sql(table):
                cursor.execute(stmt)
        cnx.commit()

    def to_sql(cls, table):
        return _to_sql(table)


class SQLiteConnection(ConnectionWrapper):
    """Connection wrapper for SQLite."""

    __slots__ = ['_active_cursors']
    poolable = have_pysqlite and os.name == 'nt' and sqlite_version >= 30301

    def __init__(self, path, params={}):
        assert have_pysqlite > 0
        self.cnx = None
        if path != ':memory:':
            if not os.access(path, os.F_OK):
                raise TracError('Database "%s" not found.' % path)

            dbdir = os.path.dirname(path)
            if not os.access(path, os.R_OK + os.W_OK) or \
                   not os.access(dbdir, os.R_OK + os.W_OK):
                from getpass import getuser
                raise TracError('The user %s requires read _and_ write ' \
                                'permission to the database file %s and the ' \
                                'directory it is located in.' \
                                % (getuser(), path))

        if have_pysqlite == 2:
            self._active_cursors = weakref.WeakKeyDictionary()
            timeout = int(params.get('timeout', 10.0))
            if isinstance(path, unicode): # needed with 2.4.0
                path = path.encode('utf-8')
            cnx = sqlite.connect(path, detect_types=sqlite.PARSE_DECLTYPES,
                                 check_same_thread=sqlite_version < 30301,
                                 timeout=timeout)
        else:
            timeout = int(params.get('timeout', 10000))
            cnx = sqlite.connect(path, timeout=timeout, encoding='utf-8')
            
        ConnectionWrapper.__init__(self, cnx)

    if have_pysqlite == 2:
        def cursor(self):
            cursor = self.cnx.cursor(PyFormatCursor)
            self._active_cursors[cursor] = True
            cursor.cnx = self
            return cursor

        def rollback(self):
            for cursor in self._active_cursors.keys():
                cursor.close()
            self.cnx.rollback()

    else:
        def cursor(self):
            self.cnx._checkNotClosed("cursor")
            return SQLiteUnicodeCursor(self.cnx, self.cnx.rowclass)

    def cast(self, column, type):
        if sqlite_version >= 30203:
            return 'CAST(%s AS %s)' % (column, type)
        elif type == 'int':
            # hack to force older SQLite versions to convert column to an int
            return '1*' + column
        else:
            return column

    def concat(self, *args):
        return '||'.join(args)

    def like(self):
        if sqlite_version >= 30100:
            return "LIKE %s ESCAPE '/'"
        else:
            return 'LIKE %s'

    def like_escape(self, text):
        if sqlite_version >= 30100:
            return _like_escape_re.sub(r'/\1', text)
        else:
            return text

    if have_pysqlite == 2:
        def get_last_id(self, cursor, table, column='id'):
            return cursor.lastrowid
    else:
        def get_last_id(self, cursor, table, column='id'):
            return self.cnx.db.sqlite_last_insert_rowid()
