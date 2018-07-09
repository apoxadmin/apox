<?php

class CreateFileTest extends WP_UnitTestCase {

	function test_new_file_remote() {

        $usr = wp_create_user('test_admin', 'test_admin');
        $this->assertNotWPError($usr);
        wp_set_current_user($usr);

        wpfb_loadclass('Admin');
		$res = WPFB_Admin::InsertFile(array(
            /* must be an image ! */
            'file_remote_uri' => 'https://wpfilebase.com/wp-content/blogs.dir/2/files/2015/03/banner_023.png'
        ));
        $this->assertEmpty($res['error'], $res['error']);

        /** @var WPFB_File $file */
        $file = $res['file'];

        $this->assertTrue($file->IsLocal(),'IsLocal false');
        $this->assertFileExists($file->GetLocalPath());


        $this->assertNotEmpty($file->file_thumbnail);
        $this->assertFileExists($file->GetThumbPath());

        $this->assertTrue($file->Remove());
	}
}

