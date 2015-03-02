<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';

if($_SESSION['class']=='admin')
	$admin = true;

show_header();

function comm_getList()
{
	$sql = 'SELECT comm_id, comm_title, comm_body FROM comm ORDER BY comm_title ASC';

	return db_select($sql, "comms()");
}

if ($admin==true) {
	if ( $_GET['action']=='delete' )
		if ( isset( $_GET['id'] ) && $_GET['id'] > 0 )
		{
			$sql = 'DELETE FROM comm WHERE comm_id='.$_GET['id'];
			db_select( $sql , "comms()" );
		}
}

$list = comm_getList();

if ($admin) {?>
<script type="text/javascript">
function DeleteComm( id ) {
	window.location.href='index.php?id=' + id +'&action=delete';
}
</script>
<ul><li><a href="edit.php?comm_id=''">Create a new comm</a></li></ul>
<?php
}
foreach($list as $comm)
{
	if($admin)
	{
		$name = str_replace(' ','+',$comm['comm_title']);
		$title = "<a href=\"/comms/edit.php?name=$name\">{$comm['comm_title']}</a><input type='button' value='Delete' onclick='DeleteComm(\"".$comm['comm_id']."\")' />";
	}
	else
		$title = $comm['comm_title'];
	
	echo "<div class=\"general\" id=\"{$comm['comm_id']}\">";
	echo "<div class=\"general boxtop\"><span class=\"big\">$title</span></div>";
	echo '<div class="general">';
	echo $comm['comm_body'];
	echo '</div></div>';
}

?>

<?php
show_footer();
?>
