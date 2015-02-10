<?php 

include_once dirname(dirname(__FILE__)) . '/include/template.inc.php';
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

if(!isset($_SESSION['class']))
    show_note('You must be logged in to view this page.');

$si_width = $GLOBALS['PROFILE_WIDTH']/2;
$si_height = $GLOBALS['PROFILE_HEIGHT']/2;

$sd_width = $GLOBALS['PROFILE_WIDTH']/2;
$sd_height = $GLOBALS['PROFILE_HEIGHT']/2 + 25;

$bi_width = $GLOBALS['PROFILE_WIDTH'];
$bi_height = $GLOBALS['PROFILE_HEIGHT'];

$bd_width = $GLOBALS['PROFILE_WIDTH'];
$bd_height = $GLOBALS['PROFILE_HEIGHT'] + 15;

if(isset($_GET['user']))
    $user = $_GET['user'];
else
    $user = $_SESSION['id'];

function users_get()
{
	$sql = 'SELECT user_id, user_name AS name FROM user '
			. ' WHERE status_id NOT IN ('.STATUS_ADMINISTRATOR.','.STATUS_DEPLEDGE.','.STATUS_DEACTIVATED. ',' .STATUS_INACTIVE.  ',' .STATUS_ALUMNI
			. ') ORDER BY user_name';
	return db_select($sql);
}

$head = '
<script type="text/javascript">

function change() 
{
    // only if req shows "complete"
    if (req.readyState == 4)
	{
        // only if "OK"
        if (req.status == 200)
		{
			var response = req.responseXML.documentElement;

			var bigs = response.getElementsByTagName("bigs")[0];
            bigs = bigs.getElementsByTagName("person");
			var littles = response.getElementsByTagName("littles")[0];
            littles = littles.getElementsByTagName("person");
			var self =  response.getElementsByTagName("self")[0];
            self = self.getElementsByTagName("person")[0];

			var bigHTML = "";
			var littleHTML = "";

			for(var i=0; i<bigs.length; i++)
			{
				var user = bigs[i].getElementsByTagName("user")[0].firstChild.data;
				var name = bigs[i].getElementsByTagName("name")[0].firstChild.data;
				bigHTML += 
					"<div id=\"big" + i + "\" class=\"span3\">" +
					"<a href=\"javascript: load(\'/people/tree.xml.php?self=" + user + "\',change); \">" +
					"<img class=\"img-polaroid \"  src=\"/images/profiles/" + 
					user + ".jpg\"/><br/>" 
					+ name + "</a></div>";
			}
			
			for(var i=0; i<littles.length; i++)
			{
				var user = 
                    littles[i].getElementsByTagName("user")[0].firstChild.data;
				var name = 
                    littles[i].getElementsByTagName("name")[0].firstChild.data;
				littleHTML += 
					"<div class=\"span3\">" +
					"<a href=\"javascript: load(\'/people/tree.xml.php?self=" + user + "\',change)\">" +
					"<img class=\"img-polaroid max\" src=\"/images/profiles/" + 
					user + ".jpg\"/><br/>" 
					+ name + "</a></div>";
			}
			
			if(littles.length == 0)
				littleHTML = "<div class=\"general\"><h3>(No Known Littles)</h3></div>";
				
			if(bigs.length == 0)
				bigHTML = "<div class=\"general\"><h3>(No Known Bigs)</h3></div>";
			
			document.getElementById("bigs").innerHTML = 
                "<div class=\"row-fluid\">" + bigHTML + "</div>";
			document.getElementById("littles").innerHTML = 
                "<div class=\"row-fluid\">" + littleHTML + "</div>";
            
            document.getElementById("self_img").src = 
                "/images/profiles/" +
                self.getElementsByTagName("user")[0].firstChild.data +
                ".jpg";
            document.getElementById("self_name").innerHTML =
                self.getElementsByTagName("name")[0].firstChild.data;
            document.getElementById("self_address").innerHTML =
                self.getElementsByTagName("address")[0].firstChild.data;
            document.getElementById("self_pphone").innerHTML =
                self.getElementsByTagName("pphone")[0].firstChild.data;
            document.getElementById("self_bphone").innerHTML =
                self.getElementsByTagName("bphone")[0].firstChild.data;
            document.getElementById("self_aim").innerHTML =
                "<img src=\"http://api.oscar.aol.com/SOA/key=" +
                "PandorasBoxGoodUntilJan2006/presence/" +
                self.getElementsByTagName("aim")[0].firstChild.data +
                "\" />" +
                "<a href=\"aim:goim?screenname=" +
                self.getElementsByTagName("aim")[0].firstChild.data +
                "\">" +
                self.getElementsByTagName("aim")[0].firstChild.data +
                "</a>";
            document.getElementById("self_email").innerHTML =
                "<a href=\"mailto:" +
                self.getElementsByTagName("email")[0].firstChild.data +
                "\">" +
                self.getElementsByTagName("email")[0].firstChild.data +
                "</a>";
            document.getElementById("self_family").innerHTML =
                self.getElementsByTagName("family")[0].firstChild.data;
            document.getElementById("self_class").innerHTML =
                self.getElementsByTagName("class")[0].firstChild.data;
			        
        } else {
            alert("There was a problem retrieving the XML data:\n" + 
					req.statusText);
        }
    }
}
'
.
"
</script>

<style type=\"text/css\">
#bigs, #littles, #self
{
}

div.hide
{
	display: none;
}

img.smallprofile
{
	width: {$si_width}px;
	height: {$si_height}px;
	border: 0px;
}

img.bigprofile
{
	width: {$bi_width}px;
	height: {$bi_height}px;
	border: 0px;
}

div.bigprofile table.selftable
{
    color: white;
    font-size: small;
	float: left;
	width: {$bd_width}px;
	height: {$bd_height}px;
	border: 1px black solid;
	background: black;
}

div.smallprofile
{
	float: left;
	width: {$sd_width}px;
	height: {$sd_height}px;
	border: 1px black solid;
	background: black;
}

div.smallprofile a:hover
{
    color: white;
}

div.outerprofile
{
	text-align: center;
}

div.clear
{
    height: 10px;
	clear: both;
}

</style>";

show_calhead($head, "load('/people/tree.xml.php?self=$user',change)"); 

?>
<!--<div class="page-header">
  	<h1 class="entry-title">Line Viewer <small> View your whole line</small></h1>
</div>-->
<form name="start" action="/people/lineview.php" method="GET" style="margin:0px">
<div class="general" style="width:325px;">
<select id="whocares" name="user" onChange="document.forms['start'].submit();">
	<option value="none">Select a brother...</option>
	<?php
	foreach(users_get() as $u)
    {
		echo "<option value=\"{$u['user_id']}\" $selected>",
             "{$u['name']}</option>\n";
    }
	?>
</select>
</form>
</div>

<?php
if($_SESSION['class'] != 'admin' || $_SESSION['id'] != $user)
{
	?>
	<div id="bigs" class="thumbnail"></div><div class="clear"></div>
	<div class="thumbnail">
	<img id="self_img" class="img-polaroid"/>
	<p class="heading" id="self_name"></p>
	</div>
	<!--<table id="selftable" class="table table-condensed table-bordered">
	<tr>
		<td colspan="3" class="heading" id="self_name"></td>
	</tr>
	<tr>
		<td rowspan="7"><img id="self_img" /></td>
		<td>Address: </td>
		<td id="self_address"></td>
	</tr>
	<tr>
		<td>Primary Phone: </td>
		<td id="self_pphone"></td>
	</tr>
	<tr>
		<td>Backup Phone: </td>
		<td id="self_bphone"></td>
	</tr>
	<tr>
		<td>Email: </td>
		<td id="self_email"></td>
	</tr>
	<tr>
		<td>AIM sn: </td>
		<td id="self_aim"></td>
	</tr>
	<tr>
		<td>Family: </td>
		<td id="self_family"></td>
	</tr> 
	<tr>
		<td>Class: </td>
		<td id="self_class"></td>
	</tr>
</table>-->

	<div class="clear"></div>
    <div id="littles" class="thumbnail"></div><div class="clear"></div>
	<div class="general">Please report wrong/missing links to <a href="mailto:historian@apo-x.org">Historians</a>.</div>
    <?php
}
show_footer();
?>
