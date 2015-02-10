<?php 
include_once 'template.inc.php';

show_header();
?>


<div class="leftcolumn">
<?php
	if($_SESSION['class']) {// Only show left column if logged in
?>

	<div class="general">
        <div class="boxtop">
            Upcoming Events
        </div>
        <div class="general" id="calendar" > 
<?php                           // Show next 10 events and color by type
                                        $query = 'SELECT event_id,event_name,eventtype_id FROM event WHERE event_date > NOW() ORDER BY event_date ASC LIMIT 10';
                                        $result = db_select($query);
                                        foreach ($result as $event) {
                                                echo '<p class="et'.$event['eventtype_id'].'"><a href="/event/show.php?id='.$event['event_id'].'">'.$event['event_name'].'</a></p>';
                                        }
?>     
                        
         </div> 
	</div>
	<!--
	<div class= "general">
	Campus Books Widget Begin <div style="border:0; overflow:visible"><iframe src="http://widgets.campusbooks.com/widget.php?wuid=0e6229eb7d03551dabfb5b6f93b7889c" width="200" height="700" border="0" frameborder="0" style="border: 0px;" ><a href="http://widgets.campusbooks.com/widget.php?wuid=0e6229eb7d03551dabfb5b6f93b7889c">Widget</a></iframe></div><a href="http://www.campusbooks.com/" style="text-decoration: none;">Textbook</a> Prices by CampusBooks.comCampus Books Widget End
		<embed src="http://wp.vizu.com/vizu_poll.swf" quality="high" scale="noscale" wmode="transparent" bgcolor="#ffffff" width="160" height="368" name="vizu_poll" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" FlashVars="js=false&pid=214722&ad=false&vizu=true&links=true&mainBG=283570&questionText=FFFFFF&answerZoneBG=EEEEEE&answerItemBG=FFFFFF&answerText=000000&voteBG=C8C8C8&voteText=000000"></embed>

	</div> -->
<?php } ?>
</div>
<!--
	<div class="general"> -->
	<?php
	if($_SESSION['class']) {// Only show right column if logged in
?>



		
	<?php } ?>


<div class="middlecolumn">


<?php

 $sql = 'SELECT author, subject, body, message_id FROM phorum_messages '
        . ' WHERE forum_id = \'7\' AND parent_id = \'0\' ORDER BY datestamp DESC LIMIT 3';

    $headlines = db_select($sql);

    foreach($headlines as $headline)
    {
        $body = str_replace("\n",'<br/>',$headline['body']);
        echo '<div class="general">';
        echo '<div class="boxtop">';
       echo "<font class=\"big\"><a href=\"/forums/read.php?7,{$headline['message_id']}\">{$headline['subject']}</a></span> &nbsp&nbsp ";
       
        echo "<span style=\"color: black;\">posted by {$headline['author']}</span>";
        echo '</div>';
        echo "<p>$body</p>";
        echo '</div>';
    }

?>
</div> 
<?php
	if($_SESSION['class']) {// Only show right column if logged in
?>

<div class="rightcolumn">
	<div class="general">
                        <div class="boxtop">
                                Recent Forum Posts
                        </div>
                        <script src="http://feeds2.feedburner.com/iphi?format=sigpro" type="text/javascript" ></script>
                        <style>
#creditfooter
{display: none;}
</style>
      </div>
<?php
	if ($_SESSION['class'] == 'admin') { // Menu to show if logged in as ExComm
?>
		<div class="general">
			<div class="boxtop">
				ExComm Tools
			</div>
			<div class="general">
				<ul>
					<li><a href="/people/change.php">Change Passwords</a></li>						
					<li><a href="/people/adduser.php">Add User</a></li>
					<li><a href="/statistics/index.php">Member Statistics</a></li>
					<li><a href="/people/lineedit.php">Line Editor</a></li>						
					<li><a href="/people/bdays.php">Birthdays</a></li>
					<li><a href="/config/index.php">Excomm Pages</a></li>		
					<li><a href="/tracking/event.php">Tracking by Event</a></li>
					<li><a href="/tracking/check.php">Tracking by User</a></li>
					<li><a href="/tracking/totals.php">Tracking Totals</a></li>	
				</ul>
			</div>
			
		</div>

<?php } ?>
</div>
<?php
	}
show_footer(); 
?> 

