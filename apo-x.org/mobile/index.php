<?php 
include_once dirname(dirname(__FILE__)) . '/include/mobiletemplate.inc.php';

     show_header();
?>

<?php

 $sql = 'SELECT author, subject, body, message_id FROM phorum_messages '
        . ' WHERE forum_id = \'7\' AND parent_id = \'0\' ORDER BY datestamp DESC LIMIT 3';

    $headlines = db_select($sql);

    foreach($headlines as $headline)
    {
        $body = str_replace("\n",'<br/>',$headline['body']);
        echo '<div class="general">';
        echo '<div class="forumbox">';
       echo "<font class=\"big\"><a href=\"/forums/read.php?7,{$headline['message_id']}\">{$headline['subject']}</a></span> &nbsp&nbsp ";
       echo "<br>";
        echo "<span style=\"color:#D3D3D3;\">Posted by {$headline['author']}</span>";
        echo '</div>';
        echo "<p>$body</p>";
        echo '</div>';
    }

?>


<?php
	
show_footer(); 
?> 

