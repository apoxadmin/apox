<?php
	include_once '../include/template.inc.php';

	get_header();
	
	// permissions?
	if($_SESSION['class']!="admin")
		show_note('You must be an administrator to access this page.');

	// for readability (not a threat since only POST is used anyway);
	if ( isset( $_POST["class"] ) )
	{
		set_requirements($_POST["class"], $_POST["status"]);
		if($_POST["status"] == 8){
			set_requirements($_POST["class"], "1");
		}
		else if($_POST["status"] == 1){
			set_requirements($_POST["class"], "8");
		}
	}
	$sql = "SELECT * FROM status";
	$result = mysql_query( $sql ) or die("ERROR :". mysql_error());
	$statusList = array();
	while ( $row = mysql_fetch_array( $result ) )
	{
		$statusList[ $row[ "status_id" ] ] = $row[ "status_name" ];
	}
	$sql = "SELECT class_name , c.class_id as id, r.* FROM class c LEFT OUTER JOIN requirements r ON r.class_id=c.class_id";
	$result = mysql_query( $sql );
	$terms = array();
	while ( $row = mysql_fetch_array( $result ) )
	{
		if ( !isset( $terms[ $row[ "id" ] ] ) ) {
			$terms[ $row[ "id" ] ] = array();
			$terms[ $row[ "id" ] ][ 0 ] = array();
			$terms[ $row[ "id" ] ][ 0 ][ "name" ] = $row[ "class_name" ];
			$terms[ $row[ "id" ] ][ 0 ][ "fellowship" ] = $row[ "fellowship" ];
			$terms[ $row[ "id" ] ][ 0 ][ "leadership" ] = $row[ "leadership" ];
			$terms[ $row[ "id" ] ][ 0 ][ "caw" ] = $row[ "caw" ];
			$terms[ $row[ "id" ] ][ 0 ][ "meeting" ] = $row[ "meeting" ];
			$terms[ $row[ "id" ] ][ 0 ][ "service" ] = $row[ "service" ];
			$terms[ $row[ "id" ] ][ 0 ][ "fundraiser" ] = $row[ "fundraiser" ];
			$terms[ $row[ "id" ] ][ 0 ][ "dues" ] = $row[ "dues" ];
			$terms[ $row[ "id" ] ][ 0 ][ "committee" ] = $row[ "committee" ];
		}
		if ( $row[ "status_id" ]==null )
			continue;
		$terms[ $row[ "id" ] ][ $row[ "status_id" ] ] = array();
		$terms[ $row[ "id" ] ][ $row[ "status_id" ] ][ "name" ] = $row[ "class_name" ];
		$terms[ $row[ "id" ] ][ $row[ "status_id" ] ][ "fellowship" ] = $row[ "fellowship" ];
		$terms[ $row[ "id" ] ][ $row[ "status_id" ] ][ "leadership" ] = $row[ "leadership" ];
		$terms[ $row[ "id" ] ][ $row[ "status_id" ] ][ "caw" ] = $row[ "caw" ];
		$terms[ $row[ "id" ] ][ $row[ "status_id" ] ][ "meeting" ] = $row[ "meeting" ];
		$terms[ $row[ "id" ] ][ $row[ "status_id" ] ][ "service" ] = $row[ "service" ];
		$terms[ $row[ "id" ] ][ $row[ "status_id" ] ][ "fundraiser" ] = $row[ "fundraiser" ];
		$terms[ $row[ "id" ] ][ $row[ "status_id" ] ][ "dues" ] = $row[ "dues" ];
		$terms[ $row[ "id" ] ][ $row[ "status_id" ] ][ "committee" ] = $row[ "committee" ];
	}

	// Added 08/24/2014 Modified behavior for term requirements so that function is now portable
	function set_requirements($class_variable, $status_variable){
		// check if the term requirement already exists in the database
		$sql = "SELECT class_id FROM requirements WHERE class_id=" . 
		$class_variable . 
		" AND status_id=" . 
		$status_variable;

		$result = mysql_query( $sql ) or die("ERROR :". mysql_error());
		$rows = mysql_num_rows( $result );
		if ( $rows > 0 )
		{
			// insert it since it doesn't exist
			$sql = "UPDATE requirements SET fellowship=" . $_POST["fellowship"] . 
			" , leadership=" . $_POST["leadership"] . 
			" , meeting=" . $_POST['meeting'] .
				" , caw=" . $_POST["caw"] . 
				" , service=" . $_POST["service"] . 
				" , fundraiser=" . $_POST["fundraiser"] .
				" , dues=" . $_POST["dues"] . 
				" , committee=" . $_POST["committee"] . 
				" WHERE class_id=" . $class_variable . 
				" AND status_id=" . $status_variable;
		} else {
			// insert it since it doesn't exist
			$sql = "INSERT INTO requirements ( fellowship , leadership , meeting , caw , service , fundraiser , dues , committee , class_id , status_id ) VALUES ( "
				. $_POST["fellowship"] . " , " . $_POST["leadership"] . " , " . $_POST['meeting'] . " , " . $_POST["caw"] . " , " . $_POST["service"] . " , " . $_POST["fundraiser"]
					. " , " . $_POST["dues"] . " , " . $_POST["committee"] . " , " . $class_variable . " , " . $status_variable . " );";
		}
		$result = mysql_query( $sql ) or die("ERROR :". mysql_error());
		if ( !$result )
		{
			echo $sql;
			echo "Requirements not updated.";
		}

		if($class_variable > 99 && ($_POST["status"] = 8 || $_POST["status"] = 1)){ // check to make sure that badges are only added for newer terms 
			//after Jaromay and only for Actives and pledges
			//Section which updates badge requirements
			$sql = "SELECT badge_id FROM badges WHERE class_id=" .
			$class_variable;  // grabs the corresponding row from badges table

			$result = mysql_query($sql) or die("ERROR :". mysql_error());
			$rows = mysql_num_rows($result);

			$service_badge_req = $_POST["service"] * 2;
			$fellowship_badge_req = $_POST["fellowship"] * 2;
			if( $rows > 0){
				$sql = "UPDATE badges SET min_Fellowships=" . $fellowship_badge_req .
				       ", min_Hours=" . $service_badge_req;
				$result = mysql_query($sql) or die("ERROR :". mysql_error());
				if(!$result){
					echo "Unable to update badge requirements for term.";
					exit;
				}
			}
			else{
				$sql = "SELECT class_nick, class_start FROM class WHERE class_id = $class_variable"; //sql query which uses class id to grab the class nick 
				// and class start date in a table
				$result = mysql_query($sql) or die("ERROR :". mysql_error()); //grabs the result
				$new_term_data = array(); // create the array
				while($line = mysql_fetch_array($result)){
					array_push($new_term_data, $line);
				}
				foreach($new_term_data as $row){  //go trhough the table and respresent each row as variable (i.e. $row)
					$class_nick = $row["class_nick"];
					$term_start = $row["class_start"];
				}
				//Insert query for the database
				$sql = "INSERT INTO badges (min_Hours, min_Fellowships, class_nick, term_start, badge_id, class_id) VALUES" .
				"( $service_badge_req , $fellowship_badge_req, '$class_nick', '$term_start', $class_variable, $class_variable );";
				//run the query
				$result = mysql_query($sql) or die("ERROR :". mysql_error());
				//check if the query succeeded
				if(!$result){
					echo "Query failed; unable to add badge requirements";
					exit; // exit the program if the query fails
				}
				//set the value for the previous class
				$previous_class = $class_variable - 1;
				//update the row with the new end term
				$sql = "UPDATE badges SET term_end= '$term_start' WHERE class_id = '$previous_class'";
				//check if query succeeded
				$result = mysql_query($sql) or die("ERROR :". mysql_error());
				if(!$result){
					echo "Unable to add term end for previous term";
					exit;
				}
			}
		}


	}
?>
<p> Utilize this tool to edit the term requirements for each type of member in the chapter. Please keep in mind that whenever you change the requirements
	for an Active, it will, by default, also change the requirements for pledges as well. </p>
	<br></br>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.min.js"></script>
	<script type="text/javascript">

		$( document ).ready( function () {
			// make the option list for terms
			var termList = eval( "( <? echo  addslashes( str_replace( 'null' , '0' , json_encode( $terms ) ) ); ?> )" );
			var select = document.createElement( "select" );
			for ( i in termList )
			{
				option = document.createElement( "option" );
				$( option ).val( i );
				$( option ).html( termList[ i ][ 0 ][ "name" ] );
				$( option ).prependTo( $( select ) );
			}
			option = document.createElement( "option" )
			$( option ).val( "-1" );
			$( option ).html( "select a term" );
			$( option ).prependTo( $( select ) );
			
			$( select ).appendTo( $( "#termlist" ) ); 
			$( select ).change( function () {
				$( "#formHolder" ).css( "display" , "none" );
				var id = $( this ).val();
				if ( id < 0 ) 
				{
					$( "#statusList" ).css( "display" , "none" );
					return;
				}
				$( "#class" ).val( id );
				$( "#statusList" ).css( "display" , "block" );
			} );
			// done with that option...
			
			// make the options
			var statuses = eval( "( <? echo addslashes( str_replace( 'null' , '0' , json_encode( $statusList ) ) ); ?> )" );
			var select = document.createElement( "select" );
			for ( i in statuses )
			{
				option = document.createElement( "option" );
				$( option ).val( i );
				$( option ).html( statuses[ i ] );
				$( option ).prependTo( $( select ) );
			}
			option = document.createElement( "option" )
			$( option ).val( "-1" );
			$( option ).html( "select user status" );
			$( option ).prependTo( $( select ) );
			$( select ).attr( "id" , "statusList" );
			$( select ).css( "display" , "none" );
			$( select ).appendTo( $( "#termlist" ) ); 
			$( select ).change( function () {
				var status_id = $( this ).val();
				var id = $( "#class" ).val( );
				if ( id < 0 ) 
				{
					$( "#formHolder" ).css( "display" , "none" );
					return;
				}
				$( "#status" ).val( status_id );
				if ( typeof termList[ id ][ status_id ]==='undefined' ) {
					$( "#fellowship" ).val( "0" );
					$( "#leadership" ).val( "0" );
					$( "#caw" ).val( "0" );
					$( "#meeting" ).val( "0" );
					$( "#fundraiser" ).val( "0" );
					$( "#service" ).val( "0" );
					$( "#dues" ).val( "0" );
					$( "#committee" ).val( "0" );
				} 
				else {
					$( "#fellowship" ).val( termList[ id ][ status_id ]["fellowship"] );
					$( "#leadership" ).val( termList[ id ][ status_id ]["leadership"] );
					$( "#caw" ).val( termList[ id ][ status_id ]["caw"] );
					$( "#meeting" ).val( termList[ id ][ status_id ]["meeting"] );
					$( "#fundraiser" ).val( termList[ id ][ status_id ]["fundraiser"] );
					$( "#service" ).val( termList[ id ][ status_id ]["service"] );
					$( "#dues" ).val( termList[ id ][ status_id ]["dues"] );
					$( "#committee" ).val( termList[ id ][ status_id ]["committee"] );
				}
				$( "#formHolder" ).css( "display" , "block" );
			} );
			// submit the darn form already!
			
			$( "#form" ).submit( function() {
				if ( $( "#class" ).val() < 0 )
					return false;
				if ( $( "#fellowship" ).val() >= 0 && $( "#leadership" ).val() >= 0 && $( "#service" ).val() >= 0 && $( "#caw" ).val() >= 0
					&& $( "#meeting" ).val() >= 0 && $( "#fundraiser" ).val() >= 0 && $( "#dues" ).val() >= 0 && $( "#committee" ).val() >= 0 )
				{
				} else {
					$( "#message" ).html( "You missed a field. All of them should be a number equal or greater than 0!" );
					$( "#message" ).css( "display" , "block" );
					return false;
				}
			} );;
		} );
	</script>
	<div id="termlist">
			Select Term to modify:
	</div>
		<div id="formHolder" style="display: none">
		<form method="post" action="./requirements.php" id="form">
		<div id="message" style="display: none"></div>
		<table>
			<tr>
				<td>Number of Fellowship required</td>
				<td><input type="text" id="fellowship" name="fellowship" /></td>
			</tr><tr>
				<td>Leadership hours required</td>
				<td><input type="text" id="leadership" name="leadership" /></td>
			</tr><tr>
				<td>Number of Meetings required</td>
				<td><input type="text" id="meeting" name="meeting" /></td>
			</tr><tr>
				<td>CAW hours required</td>
				<td><input type="text" id="caw" name="caw" /></td>
			</tr><tr>
				<td>Service hours required</td>
				<td><input type="text" id="service" name="service" /></td>
			</tr><tr>
				<td>Number of Fundraisers required</td>
				<td><input type="text" id="fundraiser" name="fundraiser" /></td>
			</tr><tr>
				<td>Dues?</td>
				<td><input type="text" id="dues" name="dues" /></td>
			</tr><tr>
				<td>Number of Committees required</td>
				<td><input type="text" id="committee" name="committee" /></td>
			</tr><tr>
				<td><input type="hidden" id="status" name="status" /><input type="hidden" id="class" name="class" /></td>
				<td><input type="submit" id="submit" value="update!" /></td>
			</tr>
		</table>
		</form>
		</div>
<?php
show_footer(); 
?> 