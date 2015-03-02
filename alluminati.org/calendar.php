<?php 
include_once 'include/template.inc.php';
include_once 'include/event.inc.php';
include_once 'include/signup.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

date_default_timezone_set("America/Los_Angeles");
$id = $class = false;
// if(!isset($_SESSION['class']))
//     show_note('You must be logged in to view this page. Message Admin VPs to gain access!');


if(isset($_GET['month'],$_GET['year']))
{
	$_SESSION['month'] = $_GET['month'];
	$_SESSION['year'] = $_GET['year'];
}
if(!isset($_SESSION['month'], $_SESSION['year']))
{
	$_SESSION['month'] = date("F",strtotime('now'));
	$_SESSION['year'] = date("Y",strtotime('now'));
}

$filter = $_COOKIE['filter'];

// begin calendar output code

if ( strcmp($_SESSION['class'], 'admin') !==0	&&	isset($_SESSION['id']) )
	$events = event_getMonth($_SESSION['year'], $_SESSION['month'], $_SESSION['id']);
else
	$events = event_getMonth($_SESSION['year'], $_SESSION['month']);

// initialize date pointers
$stamp = strtotime('1 ' . $_SESSION['month'] . ' ' . $_SESSION['year']);
$today12AM = strtotime('-'.date('w',$stamp).' days',$stamp);
$tomorrow12AM = strtotime('+1 day',$today12AM);

// calculate weeks to display
$weeks = ceil((date('w', $stamp) + date('t', $stamp)) / 7);

$s1 = strtotime('-1 month',$stamp);
$m1 = date('F',$s1); // last months month
$y1 = date('Y',$s1); // last months year

$s2 = strtotime('+1 month',$stamp);
$m2 = date('F',$s2); // next months month
$y2 = date('Y',$s2); // next months year

$my = date("F, Y",$stamp); // current month and year

$script = "var days = Array();\n";

for($i=0, $k=0; $i<$weeks; $i++) //for each row
{
	$script .= "days[$i] = Array();\n";
	
	for($j=0;$j<7;$j++) // for each column
	{
		$script .= "days[$i][$j] = Array();\n";
		$script .= "days[$i][$j].push(";
		
		$addComma = false;
		
		while($events[$k]['date']>=$today12AM && $events[$k]['date']<$tomorrow12AM)
		{
			// generate the event class			
			if($events[$k]['ic']==1)
			{
				$style = 'ic ';
				$ic = 1;
			}
			else
			{
				$style = '';
				$ic = 0;
				$fund= 0;
			}
			$type = $events[$k]['type'];
			$style .= "et{$events[$k]['type']}";
			$signedUp = $events[$k]['signedUp'];
			$id = $events[$k]['id'];
			$title = str_replace("'", "\\'", $events[$k]['name']);
			
			// put commas before each element after the first
			if($addComma)
				$script .= ', ';
			$addComma = true;
			
			if($events[$k]['type'] != EVENTTYPE_SERVICE)
				$script .= "{ id:$id, title:'$title', type:$type, ic:$ic, style:'$style', signedUp:'$signedUp' }";
			else
			{
				$c = fourC_get($events[$k]['id'], false);
				$cTxt = fourC_get($events[$k]['id'], true);
				$shifts = signup_getSummary($id);
				
				$hover = $cTxt . "<br/>";

				$full = true;

				foreach($shifts as $shift)
				{
					$start = date('g:i', strtotime($shift['start']));
					$end = date('g:i', strtotime($shift['end']));
					
					$hover .= $start . '-' . $end . ': ';
				
					if($shift['cap'] == 0)
					{
						$hover .= '<strong>unlimited</strong>';
						$full = false;
					}
					elseif($shift['current'] < $shift['cap'])
					{
						$hover .=  '<strong>' . ($shift['cap'] - $shift['current']) . ' left</strong>';
						$full = false;
					}
					else
						$hover .= '<strong>full</strong>';
					$hover .= '<br/>';
				}
				
				if($full)
					$hover = $cTxt . '<br/><strong>full</strong>';
				if(count($shifts) == 0)
					$hover = $cTxt . '<br/><strong>(no signups)</strong>';
				
				$script .= "{ id:$id, title:'$title', type:$type, ic:$ic, style:'$style', fourc:'fourc{$c}', hover:'$hover', signedUp:'$signedUp' }";
			}
							
			$k++;
		}
		
		$script .= ");\n";
				
		$today12AM = $tomorrow12AM; // lower bound to the next day
		$tomorrow12AM = strtotime('+1 day',$today12AM); // upper bound to the next day
				
	} // end for

} // end for


$head = '
<script type="text/javascript">
' . $script . '
function showhover(theEvent, txt)
{
	var x,y;
	if (self.pageYOffset) // all except Explorer
	{
		x = self.pageXOffset;
		y = self.pageYOffset;
	}
	else if (document.documentElement && document.documentElement.scrollTop)
		// Explorer 6 Strict
	{
		x = document.documentElement.scrollLeft;
		y = document.documentElement.scrollTop;
	}
	else if (document.body) // all other Explorers
	{
		x = document.body.scrollLeft;
		y = document.body.scrollTop;
	}

	var theDiv = document.getElementById("hover");
	var newX = theEvent.clientX + x + 10;
	var newY = theEvent.clientY + y - 50;
	theDiv.innerHTML = txt;
	theDiv.style.display = "block";
	theDiv.style.top = newY + "px";
	theDiv.style.left = newX + "px";
}

function hidehover()
{
	var theDiv = document.getElementById("hover");
	theDiv.style.display = "none";
}

function fill()
{
	dropDown("monthDropDown", "yearDropDown")
	var txt = document.getElementsByName("filters")[0].options[document.getElementsByName("filters")[0].selectedIndex].value;
	
	var myrows = document.getElementById("calendar").rows;

	for(var row=0; row<days.length; row++)
	{
		for(var column=0; column<7; column++)
		{
			var myrow = myrows[row+1];
			var inner = "";
			
			for(var i=0; i<days[row][column].length; i++)
			{
				var myevent = days[row][column][i];
			
				var show = false;
			
				if(txt == "0") 
					show = (myevent.type != 9);
				else if(txt == "1")
					show = (myevent.type == 1);
				else if(txt == "2")
					show = (myevent.type == 2);
				else if(txt == "5")
					show = (myevent.type == 5 || myevent.type == 6);
				else if(txt == "9")
					show = (myevent.type == 9);
				else if(txt == "10")
					show = (myevent.type == 10);
				else if(txt == "7")
					show = (myevent.type != 1 && myevent.type != 2 && myevent.type != 5 && myevent.type != 6 && myevent.type != 9);
				else if(txt == "myEvents")
					show = (myevent.signedUp == "1");
				
				if(txt == "3")
					show = (myevent.ic == 1);
			
				if(show)
				{
					var signup = "";
					if(myevent.signedUp == "1" && txt != "myEvents")
						signup = \'class="signedUp" \'
						
					if(txt != "1")
						inner += "<p class=\"" + myevent.style + "\"><a " + signup + " href=\"/event/show.php?id=" + 
							myevent.id + "\">" + myevent.title + "</a></p>";
					else
						inner += "<p class=\"" + myevent.fourc + "\"><a " + signup + " href=\"/event/show.php?id=" + 
							myevent.id + "\" onmouseover=\"showhover(event, \'" + myevent.hover + "\')\" onmousemove=\"showhover(event, \'" + myevent.hover + "\')\" onmouseout=\"hidehover()\" " + 
							">" + myevent.title + "</a></p>";
				}
			}
			
			myrow.cells[column].getElementsByTagName("div")[0].innerHTML = inner;
		}
	}
	
	Set_Cookie("filter",txt,false);
}

</script>';

show_calhead($head, 'fill()');

?>
<script type="text/javascript">

			var monthName=['January','February','March','April','May','June','July','August','September','October','November','December'];



			function dropDown(monthField, yearField){

			var today=new Date()

			var monthField=document.getElementById(monthField)

			var yearField=document.getElementById(yearField)

			for (var m=0; m<12; m++)

			{

			monthField.options[m]=new Option(monthName[m], monthName[m])

			monthField.options[today.getMonth()]=new Option(monthName[today.getMonth()], monthName[today.getMonth()], true, true) //select today's month

			}

			var thisYear=today.getFullYear()+1;

			var numYears=thisYear-2004;

			for (var y=thisYear-2004; y>-1; y--){

				yearField.options[y]=new Option(thisYear, thisYear);

				thisYear-=1;

			}

			yearField.options[numYears]=new Option( today.getFullYear()+1, today.getFullYear()+1 ); //, true, true) //select today's year
			yearField.options[<? echo $_SESSION['year']; ?>-2004].selected=true;

			}

		</script>

<?php
if ( isset( $_SESSION['id'] ) )
{ ?>
<!--<td><a href="javascript:var%20KICKASSVERSION='2.0';var%20s%20=%20document.createElement('script');s.type='text/javascript';document.body.appendChild(s);s.src='//hi.kickassapp.com/kickass.js';void(0);">Destroy &nbsp </a></td>--><?php } ?>

<div  class="row-fluid">
	<div class="span12 calborder">
	<div class="span3 visible-desktop">
		<select name="filters" onchange="fill()" class="span8 ">
			<option value="0" <?php echo ($filter==0)?'selected':'' ?>>All Events except C/A/W hours</option>
			<option value="myEvents" <?php echo ($filter=='myEvents')?'selected':'' ?>>My Events</option>
			<option value="1" <?php echo ($filter==1)?'selected':'' ?>>Service</option>
			<option value="2" <?php echo ($filter==2)?'selected':'' ?>>Fellowship</option>
			<option value="3" <?php echo ($filter==3)?'selected':'' ?>>Inter-Chapter</option>
			<option value="5" <?php echo ($filter==5)?'selected':'' ?>>Meetings and Committees</option>
			<option value="7" <?php echo ($filter==7)?'selected':'' ?>>Leadership and Misc.</option>
			<option value="9" <?php echo ($filter==9)?'selected':'' ?>>C/A/W Hours</option>
			<option value="10" <?php echo ($filter==10)?'selected':'' ?>>Interviews</option>
		</select>
	</div>
	<div class="span6" style="text-align:center">
<a href="calendar.php?month=<?php echo $m1 ?>&amp;year=<?php echo $y1 ?>" class="btn" style="vertical-align: 2px;"><i class="icon-chevron-left"></i></a> 
<span style="padding: 0 20px;" class="lead" ><?php echo $my?></span>
<a href="calendar.php?month=<?php echo $m2 ?>&amp;year=<?php echo $y2 ?>" class="btn" style="vertical-align: 2px;"><i class="icon-chevron-right"></i></a>
</div>
<div class="span3 visible-desktop">
	<form  class="form-inline " action="http://www.apo-x.org/calendar.php" name="quickJump">
				<select name="month" id="monthDropDown" class="span4 offset1 " ></select>
				<select name="year" id="yearDropDown" class="span4"></select>
				<input class="btn span3"  type="submit" value="Go" onClick="http://www.apo-x.org/calendar.php">
	</form>
	</div>
	</div>
	</div>
	<div>
	<?php	
		if($_SESSION['class'] == 'admin') // make a link to add a new event if admin
		{
			$date = date("m/d/Y",$today12AM);
			echo "<a href=\"/event/edit.php?page=create\">Add an Event";			
			echo '</a>';
		}
?>
</div>
<table id="calendar" class="table table-condensed table-bordered">
	<!--using divs instead of th, because it somehow breaks the onfill()-->
<tr class="calheading">
	<td>Sunday</td>
	<td>Monday</td>
	<td>Tuesday</td>
	<td>Wednesday</td>
	<td>Thursday</td>
	<td>Friday</td>
	<td>Saturday</td>
</tr>

<?php 

// This section creates a table representing the calendar.  $today12AM (a horrible name for a counter, I think it's
// reused from above) is initialized to the Sunday before the first day of the month, then is incremented by 1 day
// each time through the loop. -Isaac

// initialize date pointers
$month = $_SESSION['month']; // Currently displayed month
$year = $_SESSION['year']; // Currently displayed year
$stamp = strtotime('1 ' . $month . ' ' . $year); // Set $stamp to first day of the displayed month
$today12AM = strtotime('-'.date('w',$stamp).' days',$stamp); // Set $today12AM to the first Sunday before $stamp

$my = date("F, Y",$stamp); // Displayed month and year

for($i=0,$k=0; $i<$weeks; $i++) // One row for each week
{
	echo '<tr>';
	for($j=0;$j<7;$j++) // One column for each day of the week
	{
		$style = "cal";
		
		// If not in current month, use "calOut" style
		if(date("F",$today12AM)!=$month)
			$style = "calOut";
			
		// If today, highlight using "calToday" style
 $extraHour = date("I", $today12AM)*60*60; // daylight saving hour
  if ( strtotime( "now" )-$today12AM > 25200+$extraHour && strtotime( "now" )-$today12AM < 111600+$extraHour ) 
  {
   $style = "calToday";
  }
			
		echo "<td class=\"$style\">";
		
		echo '<span class="number">';
		if($_SESSION['class'] == 'admin') // make a link to add a new event if admin
		{
			$date = date("m/d/Y",$today12AM);
			echo "<a href=\"/event/edit.php?page=create&date=$date\">";
			echo date("j",$today12AM);
			echo '</a>';
		}
		else
			echo date("j",$today12AM);
		echo "</span>\n<br />";
		echo "<div></div></td>";
		
		$today12AM = strtotime('+1 day',$today12AM); // to the next day
	}
	echo '</tr>';
} // end for
echo '</table>';

echo '<div id="hover" class="notice" style="z-index: 100; position: absolute; display:none; width: 120px; "></div>';
  ?>
  </div>
  </div>
  <?php
  show_footer();
  ?>

  