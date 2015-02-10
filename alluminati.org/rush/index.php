<?php 
include_once 'include/template.inc.php';

show_header($_SESSION['class'], $_SESSION['id']); 

$sql = 'SELECT author, subject, body, message_id FROM phorum_messages '
	. ' WHERE forum_id = \'7\' AND parent_id = \'0\' ORDER BY datestamp DESC LIMIT 8';

$headlines = db_select($sql);
?>

<p>Interested in community service? Building friendships that last a lifetime? Developing leadership skills? And much more??</p>
<p>Rush Alpha Phi Omega! Our rush week starts on Monday, October 8th! Come out, meet some of the brothers and get all your questions answered! All events are free!</p>
<p>Check out the fb event for more details!<br />
http://www.facebook.com/events/103945173095337/</p>


<table width="100%">
  <tr>
    <td class="nested" align="center">
      <div class="general">
		<img src="F2K8 Rush Flyer.jpg" />
        </div>
    </td>
  </tr>
</table>
<?php show_footer(); ?> 

