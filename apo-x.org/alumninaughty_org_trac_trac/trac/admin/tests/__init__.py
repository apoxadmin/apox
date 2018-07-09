import unittest

from trac.admin.tests import console

def suite():

    suite = unittest.TestSuite()
    suite.addTest(console.suite())
    return suite

if __name__ == '__main__':
    unittest.main(defaultTest='suite')
