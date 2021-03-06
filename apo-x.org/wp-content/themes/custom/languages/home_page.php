<?php

/* template name:Home Page */
?>
<?php
/**
 * @package WordPress
 * @subpackage Coraline
 * @since Coraline 1.0
 */
include_once($_SERVER['DOCUMENT_ROOT'] . '/statistics/sql.php');
get_header(); 
?>
<style> 
.entry-title, #creditfooter{
	display: none;
}
</style> 
<?php
if ( isset( $_SESSION['id'] ) )
{ ?>

<div class="row-fluid">
	<div class="span12">
				<table class="table table-condensed table-bordered span3">
				<tbody>
				<th><h4 style="text-align:center">Upcoming Events</h4></th>
				<?php  // Show next 10 events and color by type
                                        $query = 'SELECT event_id,event_name,eventtype_id FROM event WHERE event_date > NOW() ORDER BY event_date ASC LIMIT 10';
                                        $result = db_select($query);
                                        foreach ($result as $event) {
											$event['event_name'] = htmlentities($event['event_name'], ENT_QUOTES);
											echo '<tr class="black"><td class="et'.$event['eventtype_id'].'"><a href="/event/show.php?id='.$event['event_id'].'">'.$event['event_name'].'</a></td></tr>';
                  }?>
                  </tbody>
                  </table>
<?php 
?>

<?php
$tempflag = 1;
if ($tempflag) {
$most = stats_service();
$rank = 0;
echo '<div class="span3">';
echo '<table  class="table table-bordered table-condensed">';
echo '<thead>';
echo '<tr><th colspan="3"> <h4 style="text-align:center">Most Service</h4></th></tr>';
echo '<tr><th>Rank</th><th>Name</th><th>Hours</th></tr>';
echo '</thead>';

echo '<tbody>';
foreach($most as $rank=>$person) {
	echo '<tr>';
	echo '<td>',$rank+1,'</td>';
	echo '<td>',$person['name'],'</td>';
	echo '<td>',$person['hours'],'</td>';
	echo '</tr>';
}
echo '</tbody>';
echo '</table>';
echo '</div>';
}
?>

<div class="span3">
<table  class="table table-bordered table-condensed">
<thead>
<tr>
        <th colspan="3"> <h4 style="text-align:center">Most Fundraiser</h4></th>
        </tr>
<tr>
       <th>Rank</th>
       <th>Name</th>
        <th>Amount</th>
  </tr>
  </thead>
<tbody>

<?php
$most = stats_caw();

$rank = 0;
foreach($most as $rank=>$person)
{
	echo '<tr>';
	echo '<td>',$rank+1,'</td>';
	echo '<td>',$person['name'],'</td>';
	echo '<td>','$'. $person['hours'],'</td>';
	echo '</tr>';
}
?>
</tbody>
</table>
</div>

<div class="span3">
<table  class="table table-bordered table-condensed">
<thead>
<tr>
	<th colspan="3"> <h4 style="text-align:center">Quick Links</h4></th>
	</tr>
<tr>
<th>
<p><a href="https://docs.google.com/spreadsheets/d/1ynEAVQXtb-XBIlGemPd2M8qCa_8QvSgAuJGx_BCFQz4/edit#gid=0">Active Tracker</a>
<p><a href="https://docs.google.com/forms/d/e/1FAIpQLSce-JCBw3a7M8ahlgukFe1x2Jb1h4nhN5xBAe2SLYeMbaY1ew/viewform">Chair Evaluations</a>
<p><a href="https://docs.google.com/spreadsheets/d/1_rXL5S-n5pgcjfITodLfWhiAw1rU37E6SEgHkuKU_9c/edit?usp=sharing">View All Chair Evaluations</a>
<p><a href="https://docs.google.com/document/d/1u2HvKjRlx6A5xOQ5YKxvmXTFuABHszFK55Qkh6X-qSI/edit">Active Contract</a>
<p><a href="https://docs.google.com/document/u/1/d/13gwXBHKuWg_9QmYlTX1Nmh3t1ls3KoNKqUGbLcTu-Cc/edit">Associate Contract</a>
<p><a href="https://drive.google.com/open?id=1dFGAVFfcMjsCdXMDxbHX05ahYUjrekI_yuHkzbJlwnU">Regular Reimbursement</a>
<p><a href="https://drive.google.com/open?id=1CqAvmD1RNq3wDU5OMQzld_7EhlXr5fGeqTsiCFHWyTI">Gas Reimbursement</a>
<p><a href="https://drive.google.com/open?id=1Maf0YM3sRzCIsQ4N3XgJ9Tpp914UIZoXHaW_2i15Q2U">Uber/Lyft Reimbursement</a>
<p><a href="https://goo.gl/forms/uJeuqUYieCDhHCB83">Lost Pins Form</a>
<p><a href="https://goo.gl/forms/bqCK8YBmLPTCVZkj1">Strike Pledges</a>
<p><a href="https://goo.gl/forms/q5Qelt0t1kAO8CcP2">Tutor Form</a>
<p><a href="https://goo.gl/forms/Zzqv48DNE2kGloXK2">Tutor Request Form</a>
<p><a href="https://docs.google.com/document/d/1MJxKAdtk4k-wdUww7V3a9gPoMLwwAa21VInWbsbPlPE/edit">Donations List</a>
<p><a href="https://docs.google.com/forms/d/1lZKburQ9UVykxST-uQR4Z63Krf21BE_B4A0ErxW86Hg/edit">APO Directory Form</a>
<p><a href="https://goo.gl/forms/BPQjnnvKKKnAPMd82">Brother of the Week Nomination Form</a>
<p><a href="https://goo.gl/forms/BPQjnnvKKKnAPMd82">Anonymous IG Compliments Form</a>
	<p><a href="https://docs.google.com/document/d/1n-NkvOYJBv5lO-I-BB6uDuZ_VtafVGJf_XBYpW4qvew/mobilebasic?fbclid=IwAR0fgpBBpknpLHQc-67D7It4R9bqNcFeW5P6Rcd-rUxgc24Z5aXNS-0iSAg">Drivers Contract</a>
</th> 
  </tr>
  </thead>
<tbody>

</tbody>
</table>
</div>

		<!--<div class="span3">
		<div class="nborder">
			<h4  style="text-align:center; padding: 4px 0 14px 0; border-bottom: 1px solid lightgray;">Recent Forum Posts</h4>
		</div>
		</div> end of recent -->
	</div>
</div>

<?php /*
<div class="row-fluid">
<table class="table table-bordered">
	<h4 class="lead center">General Announcements </h4>
<?php
	// merging the home.php page with the requirements
 $sql = 'SELECT author, subject, body, message_id, datestamp FROM phorum_messages '
        . ' WHERE forum_id = \'7\' AND parent_id = \'0\' ORDER BY datestamp DESC LIMIT 2';

    $headlines = db_select($sql);
    foreach($headlines as $headline)
    {
        $headline['body'] = str_replace("\n","<br/>",$headline['body']);
//		$headline['body'] = str_replace('"' , '&quot;' , $headline['body'] );
		$headline['subject'] = htmlentities($headline['subject'], ENT_QUOTES);
		$headline['author'] = htmlentities($headline['author'], ENT_QUOTES);
		$body = $headline['body'];
		echo "<th class='big'><a href='/forums/read.php?7,".$headline['message_id']."'>".$headline['subject']."</a>";
		echo "<p class='pull-right'>Posted on  ".date('m-d-Y',$headline['datestamp'])."&nbsp by  ".$headline['author']."</p></th>";
        echo "<tr class='homegeneral'>";
        echo "<td class='hometop'>";
        echo $body."</td>";
        echo '</tr>';
    }
?>
</table>	 <!-- end of announcement -->
*/
?>


</div>	
<? } else { ?>
	<div id="homecontent" role="main">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'coraline' ), 'after' => '</div>' ) ); ?>
						<?php edit_post_link( __( 'Edit', 'coraline' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-## -->

				<?php if ( comments_open() ) comments_template( '', true ); ?>

			<?php endwhile; ?>
	<div id="footer-widget-area" class="row-fluid">
		<div class="span12">
			<?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?>
				<div id="first" class="widget-area span4">
					<ul class="xoxo unstyled">
						<?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
					</ul>
				</div><!-- #first .widget-area -->
			<?php endif; ?>
			
				<?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?>
				<div id="second" class="widget-area span4">
					<ul class="xoxo unstyled ">
						<?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
					</ul>
				</div><!-- #second .widget-area -->
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'third-footer-widget-area' ) ) : ?>
				<div id="third" class="widget-area span4">
					<ul class="xoxo unstyled ">
						<?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
					</ul>
				</div><!-- #third .widget-area -->
			<?php endif; ?>	
			</div>
</div>


		<?php } ?>
<?php get_footer(); ?>

			</div><!-- #content -->
				</div><!-- #content-container -->