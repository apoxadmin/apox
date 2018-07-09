import os
import shutil
import tempfile
import unittest

from trac.attachment import Attachment
from trac.search.web_ui import SearchModule
from trac.wiki.tests import formatter

SEARCH_TEST_CASES="""
============================== search: link resolver
search:foo
search:"foo bar"
[search:bar Bar]
[search:bar]
[search:]
------------------------------
<p>
<a class="search" href="/search?q=foo">search:foo</a>
<a class="search" href="/search?q=foo+bar">search:"foo bar"</a>
<a class="search" href="/search?q=bar">Bar</a>
<a class="search" href="/search?q=bar">bar</a>
<a class="search" href="/search?q=">search</a>
</p>
------------------------------
============================== search: link resolver with query arguments
search:?q=foo&wiki=on
search:"?q=foo bar&wiki=on"
[search:?q=bar&ticket=on Bar in Tickets]
------------------------------
<p>
<a class="search" href="/search?q=foo&amp;wiki=on">search:?q=foo&amp;wiki=on</a>
<a class="search" href="/search?q=foo+bar&amp;wiki=on">search:"?q=foo bar&amp;wiki=on"</a>
<a class="search" href="/search?q=bar&amp;ticket=on">Bar in Tickets</a>
</p>
------------------------------
"""

ATTACHMENT_TEST_CASES="""
============================== attachment: link resolver (deprecated)
attachment:wiki:WikiStart:file.txt (deprecated)
attachment:ticket:123:file.txt (deprecated)
[attachment:wiki:WikiStart:file.txt file.txt] (deprecated)
[attachment:ticket:123:file.txt] (deprecated)
------------------------------
<p>
<a class="attachment" href="/attachment/wiki/WikiStart/file.txt" title="Attachment 'file.txt' in WikiStart">attachment:wiki:WikiStart:file.txt</a> (deprecated)
<a class="attachment" href="/attachment/ticket/123/file.txt" title="Attachment 'file.txt' in Ticket #123">attachment:ticket:123:file.txt</a> (deprecated)
<a class="attachment" href="/attachment/wiki/WikiStart/file.txt" title="Attachment 'file.txt' in WikiStart">file.txt</a> (deprecated)
<a class="attachment" href="/attachment/ticket/123/file.txt" title="Attachment 'file.txt' in Ticket #123">ticket:123:file.txt</a> (deprecated)
</p>
------------------------------
============================== attachment: "foreign" links
attachment:file.txt:wiki:WikiStart
attachment:file.txt:ticket:123
[attachment:file.txt:wiki:WikiStart file.txt]
[attachment:file.txt:ticket:123]
attachment:foo.txt:wiki:SomePage/SubPage
------------------------------
<p>
<a class="attachment" href="/attachment/wiki/WikiStart/file.txt" title="Attachment 'file.txt' in WikiStart">attachment:file.txt:wiki:WikiStart</a>
<a class="attachment" href="/attachment/ticket/123/file.txt" title="Attachment 'file.txt' in Ticket #123">attachment:file.txt:ticket:123</a>
<a class="attachment" href="/attachment/wiki/WikiStart/file.txt" title="Attachment 'file.txt' in WikiStart">file.txt</a>
<a class="attachment" href="/attachment/ticket/123/file.txt" title="Attachment 'file.txt' in Ticket #123">file.txt:ticket:123</a>
<a class="attachment" href="/attachment/wiki/SomePage/SubPage/foo.txt" title="Attachment 'foo.txt' in SomePage/SubPage">attachment:foo.txt:wiki:SomePage/SubPage</a>
</p>
------------------------------
============================== attachment: "local" links
attachment:file.txt
[attachment:file.txt that file]
------------------------------
<p>
<a class="attachment" href="/attachment/wiki/WikiStart/file.txt" title="Attachment 'file.txt' in WikiStart">attachment:file.txt</a>
<a class="attachment" href="/attachment/wiki/WikiStart/file.txt" title="Attachment 'file.txt' in WikiStart">that file</a>
</p>
------------------------------
============================== attachment: "missing" links
attachment:foo.txt
[attachment:foo.txt other file]
------------------------------
<p>
<a class="missing attachment">attachment:foo.txt</a>
<a class="missing attachment">other file</a>
</p>
------------------------------
============================== attachment: "raw" links
raw-attachment:file.txt
[raw-attachment:file.txt that file]
------------------------------
<p>
<a class="attachment" href="/raw-attachment/wiki/WikiStart/file.txt" title="Attachment 'file.txt' in WikiStart">raw-attachment:file.txt</a>
<a class="attachment" href="/raw-attachment/wiki/WikiStart/file.txt" title="Attachment 'file.txt' in WikiStart">that file</a>
</p>
------------------------------
============================== attachment: raw format as explicit argument
attachment:file.txt?format=raw
[attachment:file.txt?format=raw that file]
------------------------------
<p>
<a class="attachment" href="/attachment/wiki/WikiStart/file.txt?format=raw" title="Attachment 'file.txt' in WikiStart">attachment:file.txt?format=raw</a>
<a class="attachment" href="/attachment/wiki/WikiStart/file.txt?format=raw" title="Attachment 'file.txt' in WikiStart">that file</a>
</p>
------------------------------
""" # "

def attachment_setup(tc):
    import trac.ticket.api
    import trac.wiki.api
    tc.env.path = os.path.join(tempfile.gettempdir(), 'trac-tempenv')
    os.mkdir(tc.env.path)
    attachment = Attachment(tc.env, 'wiki', 'WikiStart')
    attachment.insert('file.txt', tempfile.TemporaryFile(), 0)
    attachment = Attachment(tc.env, 'ticket', 123)
    attachment.insert('file.txt', tempfile.TemporaryFile(), 0)
    attachment = Attachment(tc.env, 'wiki', 'SomePage/SubPage')
    attachment.insert('foo.txt', tempfile.TemporaryFile(), 0)

def attachment_teardown(tc):
    shutil.rmtree(tc.env.path)

def suite():
    suite = unittest.TestSuite()
    suite.addTest(formatter.suite(SEARCH_TEST_CASES, file=__file__))
    suite.addTest(formatter.suite(ATTACHMENT_TEST_CASES, file=__file__,
                                  context=('wiki', 'WikiStart'),
                                  setup=attachment_setup,
                                  teardown=attachment_teardown))
    return suite

if __name__ == '__main__':
    unittest.main(defaultTest='suite')

