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
$most = stats_service_byclass();
echo '<div class="span3">';
echo '<table  class="table table-bordered table-condensed">';
echo '<thead>';
echo '<tr><th colspan="3"> <h4 style="text-align:center">Most Service</h4></th></tr>';
echo '<tr><th>Rank</th><th>Class</th><th>Hours</th></tr>';
echo '</thead>';

echo '<tbody>';
foreach($most as $rank=>$class) {
	echo '<tr>';
	echo '<td>',$rank+1,'</td>';
	echo '<td>',$class['class_nick'],'</td>';
	echo '<td>',$class['hours'],'</td>';
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
	<th colspan="3"> <h4 style="text-align:center">Most Fellowships</h4></th>
	</tr>
<tr>
       <th>Rank</th>
       <th>Name</th>
        <th>Events</th>
  </tr>
  </thead>
<tbody>

<?php
$most = stats_fellowships();

$rank = 0;
foreach($most as $rank=>$person)
{
	echo '<tr>';
	echo '<td>',$rank+1,'</td>';
	echo "<td>{$person['name']}</td>";
	echo "<td>{$person['events']}</td>";
	echo '</tr>';
}
?>
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
<div  id="footer-widget-area" class="border">
<span class="pull-left">
  <form><button class="btn btn-primary">Need Volunteers?</button>
  <button class="btn btn-primary" >Want to Sponsor us?</button>
  </form>
</span>
 <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fapodavis%3Ffref%3Dts&amp;width=450&amp;height=35&amp;colorscheme=light&amp;layout=standard&amp;action=like&amp;show_faces=false&amp;send=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>
</div>
		<?php } ?>
<?php get_footer(); ?>

			</div><!-- #content -->
				</div><!-- #content-container -->