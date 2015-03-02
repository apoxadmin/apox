<?php 
include_once 'template.inc.php';
include_once 'assassins.php';

if(isset($_GET['id']))
	$user = $_GET['id'];
	
if(isset($_SESSION['id'])) {
	$id = $_SESSION['id'];

show_header();

?>
<table width=100%>
	<tr>
		<td class="heading">Assassin Rules</td>
	</tr>
	<tr>
		<th>Entering The Game</th>
	</tr>
	<tr>
		<td><p>All players must register with me by 11:59 PM on Sunday, November 10, 2013. You must have your real address (I should be able to look it up on Google Maps) listed on the roster to play.  You must live in Davis to play.  You must have already been tracked for at least one event this term to play.  The game will start promptly at 12:00 AM on Monday, November 11, 2013.</p></td>
	</tr>
	<tr>
		<th>Weapons and Killing</th>
	</tr>
	<tr>
		<td><p>There are very strict restrictions on weapons.  If you use an illegal weapon, you will be removed from the game.  And possibly punished by a blanket party from the God Squad.</p>
		<p>Your weapon must look like a weapon.  There is no theme for Assassins this term so have fun but also be creative. Nerf guns are allowed with the restriction that you may only have one bullet. (This is so that everyone has a fair advantage too)! Some examples of past weapons are throwing knives, ninja stars, nunchucks, whips/flails, daggers, staffs, wands, snowballs, and even dildos (for the brave). (They must still match the size requirements of other weapons). (They must still match the size requirements of other weapons.)</p>
		<p>Your weapon must be at least 6 inches long. There is no max length or width.  Parts of your weapon can be narrower than 2 inches, as long as some part of it is at least two inches.</p>
		<p>It must be constructed from both cardboard and duct tape, and nothing but cardboard and duct tape.  However, your weapon does not need to be completely covered in duct tape, as long as it is somehow used in the construction.  No other fillers are allowed to increase the strength or weight of your weapon.  (No plastic, pennies, etc. for safety reasons!)  You cannot use paper instead of cardboard or other kinds of tape.  Decorating your weapon is allowed - you can color it, even put fobby phone dangles on an Asian meat cleaver. (Yes, it's been done.)</p>
		<p>You can have as many weapons as you want, but any dropped weapons can be used against you.</p>
		<p>All weapons are considered poisoned, and one touch to any part of the body is considered instant death.  (You simply have to touch your weapon to your target.)  Blades can pass through clothing, but not through backpacks or similar items.  You cannot move shields of any type (including books, backpacks, people) to block or deflect attacks, but you can block attacks with your own weapons, dodge attacks, or hide behind things that were already there.</td></p>
		<p></td>
	</tr>
	<tr>
		<th>Targets</th>
	</tr>
	<tr>
		<td><p>The website will assign you a random codename, codeword, and target.  Memorize your codeword!  You must give your codeword to you killer immediately upon being killed so they can get credit for it.  Upon killing your target or your killer, enter their codeword into the website for credit and a new target.</p>
		<p>Targets are randomly chosen by the website, but assassins with more kills have a slightly better chance of not getting targeted.</p>
		<p>Because targets are randomly assigned, there could be zero-all other killers coming after you.  There could also be zero-all other killers going after your target.  Check your target regularly to make sure someone else has not killed it first.</p></td>
	</tr>
	<tr>
		<th>Safe Zones</th>
	</tr>
	<tr>
		<td><p>You are safe:</p><ul><li>At service and going to and from service - defined as the moment you step out of your house to go to service until you enter the building of your choice after getting dropped off from service</li><li>At any other APhiO events - defined as the location and times listed on the website calendar - there is no buffer for these other events, so as soon as you leave the location, you can be killed.  If the event ends at 8 p.m. on the calendar, you can be killed at 8:01, even if the event is still in progress!</li><li>On campus - defined as everything in the green area on <a href="http://campusmap.ucdavis.edu/">this map</a> EXCEPT dorms, which are treated like private residences</li><li>In a moving car - defined as when the engine is running.  However, buses are not safe, except for the bus driver.</li><li>And at work</li></ul>
		<p>Private residences are semi-safe.  You cannot sneak into someone's house without permission and kill him or her. This applies to any fenced off area, such as a backyard or a balcony.  However, you can throw a weapon into a residence to make a kill.</p>
		<p>You cannot kill while you are safe.  For example, if a target comes into your work, you are not allowed to kill it, even if you are on break.</p></td>
	</tr>
	<tr>
		<th>Things Not To Do!</th>
	</tr>
	<tr>
		<td><ul><li>Do not be stupid, do not do anything that would hurt yourself or others, and do not break the law.</li>
		<li>Do not help other players make a kill.  No scouting out locations, no flushing out targets, no harassing players that are not your target, etc.  (Driving another assassin is acceptable, as some assassins need help outside of times when Unitrans runs, but you must stay in the car and not participate in any way to the actual kill.)  If you do, I will remove both you and the person you are helping from the game.  This rule also applies to dead assassins and any other third parties.</li>
		<li>Do not harass other brothers (players or non-players).  Harassment can come in many forms, but the most common is threatening people who are not your target.  Harassment cases will be judged by severity and may be punished by a verbal warning, a visit from God Squad, and/or having your name written in God's Deathnote (which equals instant death).</li>
		<li>Do not damage or steal possessions or kidnap third parties in order to extort a kill.</li></td>
	</tr>
	<tr>
		<th>End of Game</th>
	</tr>
	<tr>
		<td><p>The game will run until there is one assassin left alive or night before banquet.  If the game proceeds to the night before banquet, there is no winner, and no one gets to pie God.</p></td>
	</tr>
	<tr>
		<th>Questions</th>
	</tr>
	<tr>
		<td><p> If you have any questions, ask God.  All decisions are final and God will have an invincible "God Squad" to enforce his rules and
decisions.  Have fun, and remember to kill hard, and die harder.</p></td>
	</tr>
</table>
<?php show_footer(); }

else
	show_note('You are not logged in.'); ?>
