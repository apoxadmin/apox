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
<p><a href="https://docs.google.com/spreadsheets/d/16tbPWNwqOYa9-q9_OJm6fttFxWdKRIrqvU0xy4bBWYo/edit?usp=sharing">Alumni Contact Sheet</a>
<p><a href="https://www.instagram.com/apoucla/?hl=en">APO Instagram</a>
<p><a href="https://goo.gl/forms/NhvZ2NZAsVXJdfhB3">Anonymous Feedback Form</a>
<p><a href="https://drive.google.com/file/d/1kYWN5MZxHBiUSFxVmf_1jn3Cj0GO1Ttm/view?usp=sharing">C.A.R.L Guidelines</a>
<p><a href="https://docs.google.com/document/d/1jz50pjQnmck1BhEr9kS44mIafEDakQ9Wk8j6y4la49g/edit?usp=sharing">What's In C.A.R.L?</a>
<p><a href="https://goo.gl/Wt5oEC">Website Work Order</a>
<p><a href="http://www.apo-x.org/apo-x.org%20(oldsite)/arcade/games/index.php">Games</a>
<p><a href="https://goo.gl/mrkSX9">Active Tracker</a>
<p><a href="https://drive.google.com/file/d/1zZAKU3_XW0fjWyFX62Oxskc919Pl68uG/view?usp=sharing">Active Contract</a>
<p><a href="https://drive.google.com/file/d/1x-OHnVHfkmu0l-ngTebptnsssBuHammk/view?usp=sharing">Associate Contract</a>
<p><a href="https://goo.gl/4yxgws">Committee Masterlist</a>
<p><a href="https://docs.google.com/forms/d/e/1FAIpQLSeB-6Thz8J38LRgWQfc5zCuApRy_5p4ni9ia8eMcuogrLYU5g/viewform">Regular Reimbursement</a>
<p><a href="https://docs.google.com/forms/d/e/1FAIpQLSfY4BHA5n5xMwLNwhld4Od9GjN7CEUvy78lESZy91D3w21ZIw/viewform">Gas Reimbursement</a>
<p><a href="https://docs.google.com/forms/d/1znzQoH6fZYDN8OF55E4HLUDBeoFF6Kg9dszeL3975g4/viewform?edit_requested=true">Uber or Lyft Reimbursement</a>
<p><a href="https://docs.google.com/forms/d/e/1FAIpQLScZDyt5WP-N6LoXuiRn1n7QovwKT-LwpgdXcw85GqrJ83__EQ/viewform">Fellowship Events Feedback</a>
<p><a href="https://goo.gl/forms/8szUlLvy4wZS5BCC3">Chair Evaluations</a>
<p><a href="https://goo.gl/forms/Of2VCuY5cHCflFPO2">Event Feedback Form</a>
<p><a href="https://docs.google.com/spreadsheets/d/1_rXL5S-n5pgcjfITodLfWhiAw1rU37E6SEgHkuKU_9c/edit?usp=sharing">View All Chair Evaluations</a>
<p><a href="https://goo.gl/forms/uJeuqUYieCDhHCB83">Lost Pins Form</a>
<p><a href="https://goo.gl/forms/bqCK8YBmLPTCVZkj1">Strike Pledges Here</a>
<p><a href="https://goo.gl/forms/PjZfIlqTrthkYJpt2">Love Letters</a>
<p><a href="https://goo.gl/forms/pgSDz1nkhv6ZGa7H3">Brother of The Week Nominations</a>
<p><a href="https://docs.google.com/forms/d/1lGCTPOCsnsBKlubB79QYzQ6WByZ4kGJtHiT_3F6r6Lc/edit">Golden Eagle Nominations</a>


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