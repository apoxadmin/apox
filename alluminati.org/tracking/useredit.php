<?php 
include_once (dirname(dirname(__FILE__))) . '/include/template.inc.php';
include_once (dirname(dirname(__FILE__))) . '/include/event.inc.php';
include_once (dirname(dirname(__FILE__))) . '/include/show.inc.php';

include_once 'sql.php';

if(isset($_GET['event'])) // Extract event id from GET query string for the event to be tracked
  $event_id = $_GET['event'];
else
    show_note("No event was selected!");
  
if(!isset($_SESSION['id'])) // Check if logged in
    show_note('You must be logged in.');

show_calhead('<script src="/script/tracking.js" type="text/javascript"></script>');

$event = event_get($event_id);      // Get all event info for the event to be tracked
$users = getTrackedEvent($event_id);  /* $users is now an array of arrays, containing an array for each non-hidden user, with each sub-array
                          containing tracking, trackingbyuser, and chair info for that user and this event */
build_myusers($users);  // Make a table of all users with tracking info for this event
build_users();      // Make a table of all users

$coho = ($event['typeid'] == 9);  // Coho tracking is different

switch($event['typeid'])  // Make a link to the old tracking page
{
case 1:
    $link = '/tracking/service/edit.php';
    break;
case 9:
    $link = '/tracking/caw/edit.php';
    break;
default:
    $link = '/tracking/fellowship/edit.php';
}

$link .= '?event=' . $event_id;

?>
<script type="text/javascript">
function defaults(u)
{
    if(u.comments == null)
        u.comments = '';
    <?php if(!$coho): ?>
    if(u.miles == null)
        u.miles = <?= $event['mileage'] ?>;
    if(u.passengers == null)
        u.passengers = 0;
    <?php endif; ?>
}

function makerow(u, row)
{
  var user = myusers[u];
  var miles_shown;
    
    row.insertCell(0);
    row.insertCell(0);
    
    row.cells[0].innerHTML = '<input type="hidden" ' +
        'name="user[]" value="'+user.id+'" />' +
        user.name;
  row.cells[1].innerHTML = 
      '<input type="text" name="details['+user.id+']" size="100" ' +
            ' value="'+user.comments+'" />';
    <?php if(!$coho): ?>
    row.insertCell(-1);

  /* if the user hasn't been tracked, fill in the event's default value for mileage */
  if ( typeof myusers[user.id] != "undefined" )
    miles_shown = <?= $event['mileage']; ?>;
  else  
    miles_shown = user.miles;

    /*row.cells[2].innerHTML =
        '<input name="ppl['+user.id+']" type="text" id="decimal" ' +
        'size="1" maxlength="5" value="'+user.passengers+'" />ppl' +
         '<input name="mi['+user.id+']" type="text" id="decimal" size="2" ' + 
        'maxlength="5" value="'+miles_shown+'" />mi';*/
    <?php endif; ?>
}

function save(u, row)
{
    myusers[u].comments = row.cells[1].firstChild.value;
    <?php if(!$coho): ?>
    myusers[u].passengers = row.cells[2].firstChild.value;
    myusers[u].miles = row.cells[2].childNodes[2].value;
    <?php endif; ?>
}
</script>
<?php
function build_myusers($users)
{
  echo '<script type="text/javascript">';
  echo "var myusers = [ \n";
    foreach($users as $user){ 
        if(isset($user['details']))
    {
            if($notfirst++)
                echo ",\n";
        
        extract($user);
        echo "{ id:$user_id, name:'$name', ",
                 "comments:'", htmlentities($details, ENT_QUOTES), "', ",
                 "passengers: $ppl, miles: $mi }";
    }
  }
    echo "];";
    echo '</script>';
}

switch($event['typeid'])
{
case 1:
case 9:
    $comments = 'sign in/out time, comments, etc.';
    break;
default:
    $comments = 'Comments (optional)';
}

$title = date('m/d/y',$event['date']).' '.$event['name'];
$heading = "<th>Name</th><th>$comments</th> <th> </th>";

echo '<div class="general">';
echo "<a href=\"$link\">Old Tracking Page</a>";
echo '</div>';

?>
<script type="text/javascript">
var t = new Tracking("out");
var s = new Search("in");

s.notify = t.add;
s.notifyObject = t;
t.notify = s.add;
t.notifyObject = s;

t.save = save;
t.makerow = makerow;
t.defaults = defaults;

s.write();

document.write('<form name="settrackingdetails" method="post"'
               + 'action="/tracking/input.php">');
t.write("<?= $title ?>", "<?= $heading ?>");
document.write("<div style=\"clear: right\"></div>");

document.write('<input type="hidden" name="action" value="setdetails" />' +
'<input type="hidden" name="redirect"' +
    'value="/tracking/useredit.php?event=<?= $event_id ?>" />' +
'<input type="hidden" name="event" value="<?= $event_id ?>" />' +
'<input style="float: right" type="submit" name="submit" value="Submit Tracking" />' +
'</form>');

document.write("<div style=\"clear: both\"></div>");

t.start();
s.start();
</script>

<?php
show_footer();
?>
