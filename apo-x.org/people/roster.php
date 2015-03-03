<?php 
include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

if(isset($_SESSION['id']))
	$user = $_SESSION['id'];
else
	show_note('You are not logged in.');

if(isset($_SESSION['class']))
	$class = $_SESSION['class'];
/*
if(isset($_GET['search']))
	$_SESSION['search'] = $_GET['search'];
*/
if(!isset($_SESSION['sort']))
	$_SESSION['sort'] = 'name';
	
if($_SESSION['sort']==$_GET['sort'])
{
	if($_SESSION['order']=='ASC')
		$_SESSION['order'] = 'DESC';
	else
		$_SESSION['order'] = 'ASC';
}
else
{
	$_SESSION['order'] = 'ASC';
	if(isset($_GET['sort']))
		$_SESSION['sort'] = $_GET['sort'];
}

// set search query
if(isset($_GET['search']))
{
	$terms = explode(' ',$_GET['search']);
	foreach($terms as $term)
	{
		$search .= " AND (user_name LIKE '%$term%' OR "
				. " user_address LIKE '%$term%' OR user_aim LIKE '%$term%' OR "
				. " family_name LIKE '%$term%'  OR class_name LIKE '%$term%') ";
	}
}

if(isset($_SESSION['sort']))
{
	switch($_SESSION['sort'])
	{
		case 'name': $sort = 'user_name'; break;
		case 'address': $sort = 'user_address'; break;
		case 'cell': $sort = 'user_cell'; break;
		case 'email': $sort = 'user_email'; break;
		case 'aim': $sort = 'user_aim'; break;
		case 'family': $sort = 'family_name'; break;
		case 'class': $sort = 'user.class_id'; break;
		default: $sort = 'user_name'; break;
	}
	
	$sort = " AND $sort <> '' ORDER BY $sort {$_SESSION['order']}";
}
function userfull_get($search = false, $sort = false)
{
	$query = 'SELECT user_name as name, user_address, user_cell, '
	. ' LEFT(user_email, 27) AS user_email, user_aim, user_id, class_nick '
	. ' FROM user, family, class, text '
	. ' WHERE (class.class_id = user.class_id) AND (user.family_id = family.family_id) '
	. ' AND (status_id NOT IN ('.STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.','.STATUS_DEACTIVATED.')) '
	. ' AND (user_email IS NOT NULL)'
	        . ' AND (user_hidden !=1) ';
	
	if($search !== false)
		$query .= $search;
	
	if($sort !== false)
		$query .= $sort;
	else
		$query .= ' ORDER BY user_name';

	return db_select($query, "userfull_get()");
}

get_header();
?>

<script type="text/javascript">

<?php
$sql = 'SELECT user_id, status_id FROM user WHERE status_id NOT IN ('
		.STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.','.STATUS_DEACTIVATED.') ';
echo 'users = Array();';
foreach(db_select($sql) as $user)
{
	echo "users.push({id:'{$user['user_id']}', status:{$user['status_id']}});";
}?>

function peopleFilter(filter)
{
	var pledge, element;
	document.getElementById("loading").style.display = 'block';
	for(var i=0; i<users.length; i++)
	{
		element = document.getElementById("r"+users[i].id);
		if(element != null)
		{
			pledge = (users[i].status == <?= STATUS_PLEDGE ?>);
			if((pledge && filter==1) || (!pledge && filter==2))
				element.style.display = "none";
			else
				element.style.display = "table-row";
		}
	}
	document.getElementById("loading").style.display = 'none';
}
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script>
	$(document).ready( function() {
		var tid = "#srch";
		var dataOut = new Array();
		var toggle = "";	// used to determine whether it's up or down
		
		function SortBy( sortBy ) {
			function compare( a, b )
			{
				if ( a[sortBy] < b[sortBy] )
					return -1;
				if ( a[sortBy] > b[sortBy] )
					return 1;
				return 0;
			}
			function compareDesc( b, a )
			{
				if ( a[sortBy] < b[sortBy] )
					return -1;
				if ( a[sortBy] > b[sortBy] )
					return 1;
				return 0;
			}
			if ( toggle==sortBy ) {
				toggle = "";
				dataOut.sort( compareDesc );	// descending order if it's already up
			} else {
				toggle = sortBy;
				dataOut.sort( compare );
			}
					var proc = '<tr><th><div id="sortName">Name</div></th><th><div id="sortAddress">Address</div></th><th><div id="sortCell">Phone</div></th><th><div id="sortText">Text</div></th><th><div id="sortEmail">Email</div></th><th><div id="sortAim">Screen Name</div></th><th><div id="sortClass">Class</div></th></tr>';
					
					var counter=0;
					// break up the data into the rows
					// first get the user id's
					for ( var i in dataOut )
					{
						// the information is nested inside this
						proc += "<tr id=r"+dataOut[ i ].user_id+">";
						for ( var j in dataOut[ i ] )
						{
							if ( j=="user_id" ) {
								continue;
							} else if ( j=="name" ) {
								proc += "<td><a href=\"/people/profile.php?user=" + dataOut[ i ].user_id + "\">" +dataOut[ i ][ j ] + "</a></td>";
							} else if ( j=="user_email" ) {
								proc += "<td><a href=\"mailto:" + dataOut[ i ][ j ] + "\">" + dataOut[ i ][ j ] + "</a></td>";
							} else if ( j=="user_aim" ) {
								proc += "<td><img class=\"aimstatus\" src=\"http://api.oscar.aol.com/SOA/key=PandorasBoxGoodUntilJan2006/presence/" + dataOut[ i ][ j ] + "\" /><a href=\"aim:goim?screenname=" + dataOut[ i ][ j ] + "\">" + dataOut[ i ][ j ] + "</a></td>";
							} else {
								proc += "<td>" + dataOut[ i ][ j ] + "</td>";
							}
						}
						proc += "</tr>";
					}
					
					// assign data
					$( "#userList" ).html( proc );
					$("#sortName").click( function() {
						SortBy( "name" );
					});
					$("#sortAddress").click( function() {
						SortBy( "user_address" );
					});
					$("#sortCell").click( function() {
						SortBy( "user_cell" );
					});
					$("#sortText").click( function() {
						SortBy( "text_type" );
					});
					$("#sortEmail").click( function() {
						SortBy( "user_email" );
					});
					$("#sortAim").click( function() {
						SortBy( "user_aim" );
					});
					$("#sortClass").click( function() {
						SortBy( "class_nick" );
					});
		}
		function Search() {
			$.ajax( {
				url: "ajax.php",
				type: "GET",
				data: {
					search: $(tid).val()
				},
				context: $("#userList"),
				success: function( data ) {
					// evaluate the JSON string
					var ret = eval( "(" + data + ")" );
					var proc = '<tr><th><div id="sortName">Name</div></th><th><div id="sortAddress">Address</div></th><th><div id="sortCell">Phone</div></th><th><div id="sortText">Text</div></th><th><div id="sortEmail">Email</div></th><th><div id="sortAim">Screen Name</div></th><th><div id="sortClass">Class</div></th></tr>';
					
					dataOut = new Array();
					var counter=0;
					// break up the data into the rows
					// first get the user id's
					for ( var i in ret )
					{
						dataOut[counter++] = ret[ i ];
						proc += "<tr id=r"+i+">";
						// the information is nested inside this
						for ( var j in ret[ i ] )
						{
							if ( j=="user_id" ) {
								continue;
							} else if ( j=="name" ) {
								proc += "<td><a href=\"/people/profile.php?user=" + i + "\">" + ret[ i ][ j ] + "</a></td>";
							} else if ( j=="user_email" ) {
								proc += "<td><a href=\"mailto:" + ret[ i ][ j ] + "\">" + ret[ i ][ j ] + "</a></td>";
							} else if ( j=="user_aim" ) {
								proc += "<td><img class=\"aimstatus\" src=\"http://api.oscar.aol.com/SOA/key=PandorasBoxGoodUntilJan2006/presence/" + ret[ i ][ j ] + "\" /><a href=\"aim:goim?screenname=" + ret[ i ][ j ] + "\">" + ret[ i ][ j ] + "</a></td>";
							} else {
								proc += "<td>" + ret[ i ][ j ] + "</td>";
							}
						}	
						proc += "</tr>";
					}
					
					// assign data
					$( this ).html( proc );
					$("#sortName").click( function() {
						SortBy( "name" );
					});
					$("#sortAddress").click( function() {
						SortBy( "user_address" );
					});
					$("#sortCell").click( function() {
						SortBy( "user_cell" );
					});
					$("#sortText").click( function() {
						SortBy( "text_type" );
					});
					$("#sortEmail").click( function() {
						SortBy( "user_email" );
					});
					$("#sortAim").click( function() {
						SortBy( "user_aim" );
					});
					$("#sortClass").click( function() {
						SortBy( "class_nick" );
					});
				}
			});
		}
		$(tid).keypress( function() {
			clearTimeout($.data(this, 'timer'));
			var wait = setTimeout(Search, 500);
			$(this).data('timer', wait);
		}); 
		$(tid).keypress(function(e) {
  			if(e.keyCode == 13)
     			{
         			e.preventDefault();
         			sendSelected(this.value);
        			$(this).autocomplete('close');
     			}
		});
	});
</script>
<div class="general">
	<div class="page-header">
	  <h1>Search <small>Find members' name, address, phone number, or pledge class</small></h1>
	</div>
	<div class="general">
		<form class="form-inline">
				<input type="text" id="srch" />
				<select name="filters" onchange="peopleFilter(this.value)" style="margin: 0px; padding: 0px">
					<option value="0" <?php echo ($filterx==0)?'selected':'' ?>>Everyone</option>
					<option value="1" <?php echo ($filterx==1)?'selected':'' ?>>Actives</option>
					<option value="2" <?php echo ($filterx==2)?'selected':'' ?>>Pledges</option>
					<option value="3" <?php echo ($filterx==3)?'selected':'' ?>>Alumni</option>
				</select><br /><br />
				<input type="submit" />
		</form>
	</div>
</div>
<table class="table table-condensed table-bordered" id="userList">
</table>
<?php
show_footer(); ?> 

