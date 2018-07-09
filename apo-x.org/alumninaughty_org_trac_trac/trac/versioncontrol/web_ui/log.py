# -*- coding: utf-8 -*-
#
# Copyright (C) 2003-2009 Edgewall Software
# Copyright (C) 2003-2005 Jonas Borgström <jonas@edgewall.com>
# Copyright (C) 2005-2006 Christian Boos <cboos@neuf.fr>
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
# Author: Jonas Borgström <jonas@edgewall.com>
#         Christian Boos <cboos@neuf.fr>

import re
import urllib

from genshi.core import Markup
from genshi.builder import tag

from trac.config import IntOption
from trac.core import *
from trac.mimeview import Context
from trac.perm import IPermissionRequestor
from trac.util import Ranges
from trac.util.datefmt import http_date
from trac.util.html import html
from trac.util.text import wrap
from trac.util.translation import _
from trac.versioncontrol.api import Changeset, NoSuchChangeset
from trac.versioncontrol.web_ui.changeset import ChangesetModule
from trac.versioncontrol.web_ui.util import *
from trac.web import IRequestHandler
from trac.web.chrome import add_ctxtnav, add_link, add_stylesheet, \
                            INavigationContributor, Chrome
from trac.wiki import IWikiSyntaxProvider, WikiParser 

class LogModule(Component):

    implements(INavigationContributor, IPermissionRequestor, IRequestHandler,
               IWikiSyntaxProvider)

    default_log_limit = IntOption('revisionlog', 'default_log_limit', 100,
        """Default value for the limit argument in the TracRevisionLog
        (''since 0.11'').""")

    # INavigationContributor methods

    def get_active_navigation_item(self, req):
        return 'browser'

    def get_navigation_items(self, req):
        return []

    # IPermissionRequestor methods

    def get_permission_actions(self):
        return ['LOG_VIEW']

    # IRequestHandler methods

    def match_request(self, req):
        match = re.match(r'/log(/.*)?$', req.path_info)
        if match:
            req.args['path'] = match.group(1) or '/'
            return True

    def process_request(self, req):
        req.perm.assert_permission('LOG_VIEW')

        mode = req.args.get('mode', 'stop_on_copy')
        path = req.args.get('path', '/')
        rev = req.args.get('rev')
        stop_rev = req.args.get('stop_rev')
        revs = req.args.get('revs', rev)
        format = req.args.get('format')
        verbose = req.args.get('verbose')
        limit = int(req.args.get('limit') or self.default_log_limit)

        repos = self.env.get_repository(req.authname)
        normpath = repos.normalize_path(path)
        revranges = None
        rev = revs
        if revs:
            try:
                revranges = Ranges(revs)
                rev = revranges.b
            except ValueError:
                pass
        rev = unicode(repos.normalize_rev(rev))    
        path_links = get_path_links(req.href, path, rev)
        if path_links:
            add_link(req, 'up', path_links[-1]['href'], _('Parent directory'))

        # The `history()` method depends on the mode:
        #  * for ''stop on copy'' and ''follow copies'', it's `Node.history()`
        #    unless explicit ranges have been specified
        #  * for ''show only add, delete'' we're using
        #   `Repository.get_path_history()` 
        if mode == 'path_history':
            rev = revranges.b
            def history(limit):
                for h in repos.get_path_history(path, rev, limit):
                    yield h
        else:
            if not revranges or revranges.a == revranges.b:
                history = get_existing_node(req, repos, path, rev).get_history
            else:
                def history(limit):
                    prevpath = path
                    ranges = list(revranges.pairs)
                    ranges.reverse()
                    for (a,b) in ranges:
                        while b >= a:
                            rev = repos.normalize_rev(b)
                            node = get_existing_node(req, repos, prevpath, rev)
                            node_history = list(node.get_history(2))
                            p, rev, chg = node_history[0]
                            if rev < a:
                                yield (p, rev, None) # separator
                                break
                            yield node_history[0]
                            prevpath = node_history[-1][0] # follow copy
                            b = rev-1
                            if b < a and len(node_history) > 1:
                                p, rev, chg = node_history[1]
                                yield (p, rev, None)

        # -- retrieve history, asking for limit+1 results
        info = []
        depth = 1
        fix_deleted_rev = False
        previous_path = normpath
        for old_path, old_rev, old_chg in history(limit+1):
            if fix_deleted_rev:
                fix_deleted_rev['existing_rev'] = old_rev
                fix_deleted_rev = False
            if stop_rev and repos.rev_older_than(old_rev, stop_rev):
                break
            old_path = repos.normalize_path(old_path)

            item = {
                'path': old_path, 'rev': old_rev, 'existing_rev': old_rev,
                'change': old_chg, 'depth': depth,
            }
            
            if old_chg == Changeset.DELETE:
                fix_deleted_rev = item
            if not (mode == 'path_history' and old_chg == Changeset.EDIT):
                info.append(item)
            if old_path and old_path != previous_path \
               and not (mode == 'path_history' and old_path == normpath):
                depth += 1
                item['depth'] = depth
                item['copyfrom_path'] = old_path
                if mode == 'stop_on_copy':
                    break
            if len(info) > limit: # we want limit+1 entries
                break
            previous_path = old_path
        if info == []:
            node = get_existing_node(req, repos, path, rev)
            if repos.rev_older_than(stop_rev, node.created_rev):
                # FIXME: we should send a 404 error here
                raise TracError(_("The file or directory '%(path)s' doesn't "
                    "exist at revision %(rev)s or at any previous revision.", 
                    path=path, rev=rev), _('Nonexistent path'))

        def make_log_href(path, **args):
            link_rev = rev
            if rev == str(repos.youngest_rev):
                link_rev = None
            params = {'rev': link_rev, 'mode': mode, 'limit': limit}
            params.update(args)
            if verbose:
                params['verbose'] = verbose
            return req.href.log(path, **params)

        if len(info) == limit+1: # limit+1 reached, there _might_ be some more
            next_rev = info[-1]['rev']
            next_path = info[-1]['path']
            add_link(req, 'next', make_log_href(next_path, rev=next_rev),
                     _('Revision Log (restarting at %(path)s, rev. %(rev)s)',
                       path=next_path, rev=next_rev))
            # only show fully 'limit' results, use `change == None` as a marker
            info[-1]['change'] = None
        
        revs = [i['rev'] for i in info]
        changes = get_changes(repos, revs)
        extra_changes = {}
        email_map = {}
        
        if format == 'rss':
            # Get the email addresses of all known users
            if Chrome(self.env).show_email_addresses:
                for username,name,email in self.env.get_known_users():
                    if email:
                        email_map[username] = email
        elif format == 'changelog':
            for rev in revs:
                changeset = changes[rev]
                cs = {}
                cs['message'] = wrap(changeset.message, 70,
                                     initial_indent='\t',
                                     subsequent_indent='\t')
                files = []
                actions = []
                for cpath, kind, chg, bpath, brev in changeset.get_changes():
                    files.append(chg == Changeset.DELETE and bpath or cpath)
                    actions.append(chg)
                cs['files'] = files
                cs['actions'] = actions
                extra_changes[rev] = cs
        data = {
            'context': Context.from_request(req, 'source', path),
            'path': path, 'rev': rev, 'stop_rev': stop_rev,
            'mode': mode, 'verbose': verbose,
            'path_links': path_links, 'limit' : limit,
            'items': info, 'changes': changes,
            'email_map': email_map, 'extra_changes': extra_changes,
            'wiki_format_messages':
            self.config['changeset'].getbool('wiki_format_messages')
        }

        if req.args.get('format') == 'changelog':
            return 'revisionlog.txt', data, 'text/plain'
        elif req.args.get('format') == 'rss':
            data['context'] = Context.from_request(req, 'source', path,
                                                   absurls=True)
            return 'revisionlog.rss', data, 'application/rss+xml'

        add_stylesheet(req, 'common/css/diff.css')
        add_stylesheet(req, 'common/css/browser.css')

        rss_href = make_log_href(path, format='rss', stop_rev=stop_rev)
        add_link(req, 'alternate', rss_href, _('RSS Feed'),
                 'application/rss+xml', 'rss')
        changelog_href = make_log_href(path, format='changelog',
                                       stop_rev=stop_rev)
        add_link(req, 'alternate', changelog_href, _('ChangeLog'), 'text/plain')

        add_ctxtnav(req, _('View Latest Revision'), 
                    href=req.href.browser(path))
        if 'next' in req.chrome['links']:
            next = req.chrome['links']['next'][0]
            add_ctxtnav(req, tag.span(tag.a(_('Older Revisions'), 
                                            href=next['href']),
                                      Markup(' &rarr;')))

        return 'revisionlog.html', data, None

    # IWikiSyntaxProvider methods

    REV_RANGE = r"(?:%s|%s)" % (Ranges.RE_STR, ChangesetModule.CHANGESET_ID)
    #                          int rev ranges or any kind of rev
    
    def get_wiki_syntax(self):
        yield (
            # [...] form, starts with optional intertrac: [T... or [trac ...
            r"!?\[(?P<it_log>%s\s*)" % WikiParser.INTERTRAC_SCHEME +
            # <from>:<to> + optional path restriction
            r"(?P<log_revs>%s)(?P<log_path>[/?][^\]]*)?\]" % self.REV_RANGE,
            lambda x, y, z: self._format_link(x, 'log1', y[1:-1], y, z))
        yield (
            # r<from>:<to> form (no intertrac and no path restriction)
            r"(?:\b|!)r%s\b" % Ranges.RE_STR,
            lambda x, y, z: self._format_link(x, 'log2', '@' + y[1:], y))

    def get_link_resolvers(self):
        yield ('log', self._format_link)

    def _format_link(self, formatter, ns, match, label, fullmatch=None):
        if ns == 'log1':
            it_log = fullmatch.group('it_log')
            revs = fullmatch.group('log_revs')
            path = fullmatch.group('log_path') or '/'
            target = '%s%s@%s' % (it_log, path, revs)
            # prepending it_log is needed, as the helper expects it there
            intertrac = formatter.shorthand_intertrac_helper(
                'log', target, label, fullmatch)
            if intertrac:
                return intertrac
            path, query, fragment = formatter.split_link(path)
        else:
            assert ns in ('log', 'log2')
            if ns == 'log':
                match, query, fragment = formatter.split_link(match)
            else:
                query = fragment = ''
            path = match
            revs = ''
            if self.LOG_LINK_RE.match(match):
                indexes = [sep in match and match.index(sep) for sep in ':@']
                idx = min([i for i in indexes if i is not False])
                path, revs = match[:idx], match[idx+1:]
        try:
            revs = self._normalize_ranges(formatter.req, revs)
        except NoSuchChangeset:
            revs = None
        if revs and query:
            query = '&' + query[1:]
        href = formatter.href.log(path or '/', revs=revs) + query + fragment
        if 'LOG_VIEW' in formatter.perm:
            return html.A(label, class_='source', href=href)
        else:
            return html.A(label, class_='missing source')

    LOG_LINK_RE = re.compile(r"([^@:]*)[@:]%s?" % REV_RANGE)

    def _normalize_ranges(self, req, revs):
        ranges = revs.replace(':', '-')
        try:
            # fast path; only numbers
            revranges = Ranges(ranges) 
        except ValueError:
            # slow path, normalize each rev
            repos = self.env.get_repository(req.authname)
            splitted_ranges = re.split(r'([-,])', ranges)
            revs = [repos.normalize_rev(r) for r in splitted_ranges[::2]]
            seps = splitted_ranges[1::2]+['']
            ranges = ''.join([str(rev)+sep for rev, sep in zip(revs, seps)])
            revranges = Ranges(ranges)
        return str(revranges) or None
               
