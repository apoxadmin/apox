<?php
while(!is_file('wp-load.php')){
  if(is_dir('../')){ chdir('../'); }
  else die('Could not find wp-load.php.');
}
require_once('wp-load.php');
// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') )
	wp_die(__("You are not allowed to be here"));
global $wp_scripts;
global $wpdb;
?>
<!DOCTYPE html>
<html>
<head>
<title>Easy Columns</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style>
.colPicker {
	float: left;
	width: 180px;
	border-collapse: separate;
	border-spacing: 0.9em;
}
.colPicker tr {
	cursor: hand;
}
.colPicker td {
	cursor: hand;
    background-color: #C3C3C3;
    border-color: #333333;
    border-radius: 7px 7px 7px 7px;
    border-style: solid;
    border-width: 1px;
    box-shadow: 0 2px;
    color: #4E4E4E;
    font-family: arial,helvetica,sans-serif;
    font-size: 12px;
    font-weight: bold;
    padding: 4px;
    text-align: center;
}
</style>
<script src="//code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
<script src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
<script>
var colTxt = ' ';
function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function insertColumns(col) {
	colTxt = '';
	colClass = jQuery('#txtColClass').val().trim();
	colClass = (colClass != '')? ' class="'+colClass+'"' : '' ;
	switch(col)
	{
		/* single columns */
		case 'quarter':
			colTxt += '[ezcol_1quarter]Quarter Column[/ezcol_1quarter]';
			break;
		case 'half':
			colTxt += '[ezcol_1half]Half Column[/ezcol_1half]';
			break;
		case 'threequarter':
			colTxt += '[ezcol_3quarter]Three Quarter Column[/ezcol_3quarter]';
			break;
		case 'third':
			colTxt += '[ezcol_1third]Third Column[/ezcol_1third]';
			break;
		case 'twothirds':
			colTxt += '[ezcol_2third]Two Thirds Column[/ezcol_2third]';
			break;
		case 'onefifth':
			colTxt += '[ezcol_1fifth]One Fifth Column[/ezcol_1fifth]';
			break;
		case 'twofifths':
			colTxt += '[ezcol_2fifth]Two Fifths Column[/ezcol_2fifth]';
			break;
		case 'threefifths':
			colTxt += '[ezcol_3fifth]Three Fifths Column[/ezcol_3fifth]';
			break;
		case 'fourfifths':
			colTxt += '[ezcol_4fifth]Four Fifths Column[/ezcol_4fifth]';
			break;

		/* 1/3, 2/3 */
		case '3third':
			colTxt += '[ezcol_1third'+colClass+']Third Column[/ezcol_1third] ';
			colTxt += '[ezcol_1third'+colClass+']Third Column[/ezcol_1third] ';
			colTxt += '[ezcol_1third_end'+colClass+']Third Column[/ezcol_1third_end]';
			break;
		case '1third2third':
			colTxt += '[ezcol_1third'+colClass+']Third Column[/ezcol_1third] ';
			colTxt += '[ezcol_2third_end'+colClass+']Two Thirds Column[/ezcol_2third_end]';
			break;
		case '2third1third':
			colTxt += '[ezcol_2third'+colClass+']Two Thirds Column[/ezcol_2third] ';
			colTxt += '[ezcol_1third_end'+colClass+']Third Column[/ezcol_1third_end]';
			break;

		/* 1/4, 1/2, 3/4 */
		case '4quarter':
			colTxt += '[ezcol_1quarter'+colClass+']Quarter Column[/ezcol_1quarter] ';
			colTxt += '[ezcol_1quarter'+colClass+']Quarter Column[/ezcol_1quarter] ';
			colTxt += '[ezcol_1quarter'+colClass+']Quarter Column[/ezcol_1quarter] ';
			colTxt += '[ezcol_1quarter_end'+colClass+']Quarter Column[/ezcol_1quarter_end]';
			break;
		case '1half2quarter':
			colTxt += '[ezcol_1half'+colClass+']Half Column[/ezcol_1half] ';
			colTxt += '[ezcol_1quarter'+colClass+']Quarter Column[/ezcol_1quarter] ';
			colTxt += '[ezcol_1quarter_end'+colClass+']Quarter Column[/ezcol_1quarter_end]';
			break;
		case 'quarterhalfquarter':
			colTxt += '[ezcol_1quarter'+colClass+']Quarter Column[/ezcol_1quarter] ';
			colTxt += '[ezcol_1half'+colClass+']Half Column[/ezcol_1half] ';
			colTxt += '[ezcol_1quarter_end'+colClass+']Quarter Column[/ezcol_1quarter_end]';
			break;
		case '2quarter1half':
			colTxt += '[ezcol_1quarter'+colClass+']Quarter Column[/ezcol_1quarter] ';
			colTxt += '[ezcol_1quarter'+colClass+']Quarter Column[/ezcol_1quarter] ';
			colTxt += '[ezcol_1half_end'+colClass+']Half Column[/ezcol_1half_end]';
			break;
		case '2half':
			colTxt += '[ezcol_1half'+colClass+']Half Column[/ezcol_1half] ';
			colTxt += '[ezcol_1half_end'+colClass+']Half Column[/ezcol_1half_end]';
			break;
		case '1quarter3quarter':
			colTxt += '[ezcol_1quarter'+colClass+']Quarter Column[/ezcol_1quarter] ';
			colTxt += '[ezcol_3quarter_end'+colClass+']Three Quarter Column[/ezcol_3quarter_end]';
			break;
		case '3quarter1quarter':
			colTxt += '[ezcol_3quarter'+colClass+']Three Quarter Column[/ezcol_3quarter] ';
			colTxt += '[ezcol_1quarter_end'+colClass+']Quarter Column[/ezcol_1quarter_end]';
			break;

		/* 1/5, 2/5, 3/5, 4/5 */
		case '5fifth':
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_1fifth_end'+colClass+']One Fifth Column[/ezcol_1fifth_end]';
			break;
		case '2fifth31fifth':
			colTxt += '[ezcol_2fifth'+colClass+']Two Fifths Column[/ezcol_2fifth] ';
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_1fifth_end'+colClass+']One Fifth Column[/ezcol_1fifth_end]';
			break;
		case '1fifth2fifth21fifth':
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_2fifth'+colClass+']Two Fifths Column[/ezcol_2fifth] ';
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_1fifth_end'+colClass+']One Fifth Column[/ezcol_1fifth_end]';
			break;
		case '21fifth2fifth1fifth':
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_2fifth'+colClass+''+colClass+']Two Fifths Column[/ezcol_2fifth] ';
			colTxt += '[ezcol_1fifth_end'+colClass+']One Fifth Column[/ezcol_1fifth_end]';
			break;
		case '31fifth2fifth':
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_2fifth_end'+colClass+']Two Fifths Column[/ezcol_2fifth_end]';
			break;
		case '3fifth21fifth':
			colTxt += '[ezcol_3fifth'+colClass+']Three Fifths Column[/ezcol_3fifth] ';
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_1fifth_end'+colClass+']One Fifth Column[/ezcol_1fifth_end]';
			break;
		case '1fifth3fifth1fifth':
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_3fifth'+colClass+']Three Fifths Column[/ezcol_3fifth] ';
			colTxt += '[ezcol_1fifth_end'+colClass+']One Fifth Column[/ezcol_1fifth_end]';
			break;
		case '21fifth3fifth':
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_3fifth_end'+colClass+']Three Fifths Column[/ezcol_3fifth_end]';
			break;
		case '2fifth3fifth':
			colTxt += '[ezcol_2fifth'+colClass+']Two Fifths Column[/ezcol_2fifth] ';
			colTxt += '[ezcol_3fifth_end'+colClass+']Three Fifths Column[/ezcol_3fifth_end]';
			break;
		case '3fifth2fifth':
			colTxt += '[ezcol_3fifth'+colClass+']Three Fifths Column[/ezcol_3fifth] ';
			colTxt += '[ezcol_2fifth_end'+colClass+']Two Fifths Column[/ezcol_2fifth_end]';
			break;
		case '1fifth4fifth':
			colTxt += '[ezcol_1fifth'+colClass+']One Fifth Column[/ezcol_1fifth] ';
			colTxt += '[ezcol_4fifth_end'+colClass+']Four Fifths Column[/ezcol_4fifth_end]';
			break;
		case '4fifth1fifth':
			colTxt += '[ezcol_4fifth'+colClass+']Four Fifths Column[/ezcol_4fifth] ';
			colTxt += '[ezcol_1fifth_end'+colClass+']One Fifth Column[/ezcol_1fifth_end]';
			break;
	}
	insertText();
}

function singleInsert(){
	sel = document.getElementById("selSingles");
	selVal = sel.options[sel.selectedIndex].value;
	insertColumns(selVal);
}

function insertDiv(){
	colTxt = ' ';
	divID = document.getElementById('txtID').value;
	divClass = document.getElementById('txtClass').value;
	divStyle = document.getElementById('txtStyle').value;
	colTxt += '[ezdiv id="';
	if(divID != ''){
		colTxt += divID;
	}
	colTxt += '" class="';
	if(divClass != ''){
		colTxt += divClass;
	}
	colTxt += '" style="';
	if(divStyle != ''){
		colTxt += divStyle;
	}
	colTxt += '"]Custom Div[/ezdiv] ';
	insertText();
}

function insertClear(){
	colTxt = ' ';
	var sel = document.getElementById('selClearType');
	var classType = sel.options[sel.selectedIndex].value;
	switch(classType)
	{
		case 'left':
			colTxt += '[ezcol_end_left]';
			break;
		case 'right':
			colTxt += '[ezcol_end_right]';
			break;
		case 'both':
			colTxt += '[ezcol_end_both]';
			break;
		case 'divider':
			colTxt += '[ezcol_divider]';
			break;
	}
	insertText();
}

function insertText(){
	if(window.tinyMCE) {
		if(window.tinyMCE.execInstanceCommand){
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, colTxt);	
		} else {
			window.tinymce.activeEditor.execCommand('mceInsertContent', false, colTxt);	
		}
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}
</script>
<base target="_self" />
<style type="text/css">
img {
	border: none;
}
input[type="text"] {
	font-size: 12px;
	border: 1px solid #777;
	line-height: 14px;
	height: 16px;
}
select {
	font-size: 12px;
}
.panel {
	margin-bottom: 8px;
}
.hdrRow {
	padding-top: 4px;
	padding-bottom: 4px;
	font-weight: bold;
}
</style>
</head>
<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');">
<form name="columnPicker" action="#">

		<div class="panel">

			<table border="0" cellpadding="3" cellspacing="0" width="100%">
			<tr>
				<td class="hdrRow" colspan="3">
					<h3>Insert Column Combinations</h3>
				</td>
			</tr>
			</table>

			<!-- column combinations -->
			<table cellspacing="0" cellpadding="0" border="0">
				<tr>
					<td valign="top" align="center">

						<strong>1/3, 2/3, 3/3</strong><br />
						<table cellspacing="3" cellpadding="0" border="0" class="colPicker">
							<tr onclick="insertColumns('3third')">
								<td width="33.333%">1/3</td>
								<td width="33.333%">1/3</td>
								<td width="33.333%">1/3</td>
							</tr>
							<tr onclick="insertColumns('1third2third')">
								<td width="33.333%">1/3</td>
								<td colspan="2">2/3</td>
							</tr>
							<tr onclick="insertColumns('2third1third')">
								<td width="33.333%" colspan="2">2/3</td>
								<td width="33.333%">1/3</td>
							</tr>
						</table>

					</td>
					<td valign="top" align="center">

						<strong>1/4, 1/2, 3/4</strong><br />
						<table cellspacing="3" cellpadding="0" border="0" class="colPicker">
							<tr onclick="insertColumns('4quarter')">
								<td width="25%">1/4</td>
								<td width="25%">1/4</td>
								<td width="25%">1/4</td>
								<td width="25%">1/4</td>
							</tr>
							<tr onclick="insertColumns('1half2quarter')">
								<td colspan="2">1/2</td>
								<td width="25%">1/4</td>
								<td width="25%">1/4</td>
							</tr>
							<tr onclick="insertColumns('quarterhalfquarter')">
								<td width="25%">1/4</td>
								<td colspan="2">1/2</td>
								<td width="25%">1/4</td>
							</tr>
							<tr onclick="insertColumns('2quarter1half')">
								<td width="25%">1/4</td>
								<td width="25%">1/4</td>
								<td colspan="2">1/2</td>
							</tr>
							<tr onclick="insertColumns('2half')">
								<td colspan="2">1/2</td>
								<td colspan="2">1/2</td>
							</tr>
							<tr onclick="insertColumns('1quarter3quarter')">
								<td width="25%">1/4</td>
								<td colspan="3">3/4</td>
							</tr>
							<tr onclick="insertColumns('3quarter1quarter')">
								<td colspan="3">3/4</td>
								<td width="25%">1/4</td>
							</tr>
						</table>

					</td>
					<td valign="top" align="center">

						<strong>1/5, 2/5, 3/5, 4/5</strong><br />
						<table cellspacing="3" cellpadding="0" border="0" class="colPicker">
							<tr onclick="insertColumns('5fifth')">
								<td width="20%">1/5</td>
								<td width="20%">1/5</td>
								<td width="20%">1/5</td>
								<td width="20%">1/5</td>
								<td width="20%">1/5</td>
							</tr>
							<tr onclick="insertColumns('2fifth31fifth')">
								<td colspan="2">2/5</td>
								<td width="20%">1/5</td>
								<td width="20%">1/5</td>
								<td width="20%">1/5</td>
							</tr>
							<tr onclick="insertColumns('1fifth2fifth21fifth')">
								<td width="20%">1/5</td>
								<td colspan="2">2/5</td>
								<td width="20%">1/5</td>
								<td width="20%">1/5</td>
							</tr>
							<tr onclick="insertColumns('21fifth2fifth1fifth')">
								<td width="20%">1/5</td>
								<td width="20%">1/5</td>
								<td colspan="2">2/5</td>
								<td width="20%">1/5</td>
							</tr>
							<tr onclick="insertColumns('31fifth2fifth')">
								<td width="20%">1/5</td>
								<td width="20%">1/5</td>
								<td width="20%">1/5</td>
								<td colspan="2">2/5</td>
							</tr>
						</table>
						<table cellspacing="3" cellpadding="0" border="0" class="colPicker">
							<tr onclick="insertColumns('3fifth21fifth')">
								<td colspan="3">3/5</td>
								<td width="20%">1/5</td>
								<td width="20%">1/5</td>
							</tr>
							<tr onclick="insertColumns('1fifth3fifth1fifth')">
								<td width="20%">1/5</td>
								<td colspan="3">3/5</td>
								<td width="20%">1/5</td>
							</tr>
							<tr onclick="insertColumns('21fifth3fifth')">
								<td width="20%">1/5</td>
								<td width="20%">1/5</td>
								<td colspan="3">3/5</td>
							</tr>
							<tr onclick="insertColumns('2fifth3fifth')">
								<td colspan="2">2/5</td>
								<td colspan="3">3/5</td>
							</tr>
							<tr onclick="insertColumns('3fifth2fifth')">
								<td colspan="3">3/5</td>
								<td colspan="2">2/5</td>
							</tr>
							<tr onclick="insertColumns('4fifth1fifth')">
								<td colspan="4">4/5</td>
								<td width="20%">1/5</td>
							</tr>
							<tr onclick="insertColumns('1fifth4fifth')">
								<td width="20%">1/5</td>
								<td colspan="4">4/5</td>
							</tr>
						</table>

					</td>
				</tr>
			</table>

			<table border="0" cellpadding="2" cellspacing="0">
				<tr>
					<td class="hdrRow">
						<h3><label for="txtColClass">Add Class to Columns:</label></h3>
					</td>
					<td>
						<input type="text" id="txtColClass" size="10">
					</td>
				</tr>
			</table>

			<hr>

			<table border="0" cellpadding="2" cellspacing="0" width="100%">
				<tr>
					<td class="hdrRow">
						<h3>Insert Single Column</h3>
					</td>
					<td class="hdrRow">
						<h3>Insert Clear Div</h3>
					</td>
				</tr>
				<tr>

					<td  valign="top">
						<select id="selSingles">
						<option value="quarter">One Quarter Column</option>
						<option value="half">One Half Column</option>
						<option value="threequarter">One Three Quarter Column</option>
						<option value="third">One Third Column</option>
						<option value="twothirds">One Two Thirds Column</option>
						<option value="onefifth">One One Fifth Column</option>
						<option value="twofifths">One Two Fifths Column</option>
						<option value="threefifths">One Three Fifths Column</option>
						<option value="fourfifths">One Four Fifths Column</option>
						</select>
						<input type="button" id="insert" name="insert" value="Insert" onclick="singleInsert()">
					</td>

					<td valign="top">
						<select id="selClearType">
							<option value="left" selected="selected">left</option>
							<option value="right">right</option>
							<option value="both">both</option>
							<option value="divider">divider</option>
						</select>
						<input type="button" id="insert" name="insert" value="Insert" onclick="insertClear();" />
					</td>

				</tr>
			</table>

			<table border="0" cellpadding="2" cellspacing="0">
				<tr>
					<td colspan="4" class="hdrRow">
						<h3>Insert Custom DIV</h3>
					</td>
				</tr>
				<tr>
					<td>
						<label for="txtID">ID:</label>
					</td>
					<td>
						<input type="text" id="txtID" size="10">
					</td>
					<td>
						<label for="txtClass">Class:</label>
					</td>
					<td>
						<input type="text" id="txtClass" size="10">
					</td>
					<td rowspan="2" align="center" valign="bottom">
						<input type="button" id="insert" name="insert" value="Insert" onclick="insertDiv();" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="txtStyle">Inline Style:</label>
					</td>
					<td colspan="3">
						<input type="text" id="txtStyle" size="31">
					</td>
				</tr>
			</table>

		</div><!-- panel -->

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="Cancel" onclick="tinyMCEPopup.close();" />
		</div>
	</div><!-- mceActionPanel -->

</form>
</body>
</html>