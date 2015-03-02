<?php
function write_sel($n,$v){
	echo '<select id="'.$n.'" name="'.$n.'" class="ezcol-input">' . "\r\n";
	if($v == 'px'){
		echo '<option value="px" selected="selected">px</option>' . "\r\n";
		echo '<option value="%">%</option>' . "\r\n";
	} else {
		echo '<option value="px">px</option>' . "\r\n";
		echo '<option value="%" selected="selected">%</option>' . "\r\n";
	}
	echo '</select>' . "\r\n";
}
?>
<style>
.ezcol-input {
	border-radius: 3px !important;
	border: 1px solid #888 !important;
}
</style>
<div class="wrap" style="max-width:950px !important;">

	<a href="http://www.patrickfriedl.com.com/wordpress/easy-columns" target="_blank">
		<img src="<?php echo EZC_PLUGIN_URL; ?>/img/easy-column-logo.jpg" alt="Easy Columns - take control of your layout" style="margin:10px 0px 5px 0px;border:none;">
	</a>

<div id="paypal-float" style="float:right;margin-top:10px;width:260px;padding-top:8px;">
	<img src="<?php echo EZC_PLUGIN_URL; ?>/img/coffee.jpg" style="float:left;margin:-8px 8px 8px 0px;">
	Like Easy Columns?<br />
	Say, then how about a cup o' coffee?<br />
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
		<input type="hidden" name="cmd" value="_donations">
		<input type="hidden" name="business" value="T8V954QPLEW2J">
		<input type="hidden" name="lc" value="US">
		<input type="hidden" name="item_name" value="Easy Columns Plugin Donation">
		<input type="hidden" name="item_number" value="easy-columns">
		<input type="hidden" name="amount" id="amount" value="1.00">
		<input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="no_note" value="1">
		<input type="hidden" name="no_shipping" value="1">
		<input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHosted">
		<select id="multi-amount" onchange="changeAmount(this.options[this.selectedIndex].value);">
			<option value="1.00" selected="selected">$1.00 - Regular cup o' joe</option>
			<option value="5.00">$5.00 - Grande mocha</option>
			<option value="10.00">$10.00 - Venti caramel macchiato with whip</option>
			<option value="15.00">$15.00 - Nuclear alien coffee!</option>
		</select>
		<br />
		<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" style="float:right;">
		<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
	<script language="javascript">
	function changeAmount(v){ amt = document.getElementById('amount'); amt.value = v; }
	</script>
</div>

	<br />

	<!--<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.patrickfriedl.com.com%2Fwordpress%2Feasy-columns&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like&amp;font=lucida+grande&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe>-->

	<div class="dbx-content">

		<form name="frmEasyColumns" action="<?php echo $action_url ?>" method="post">

			<input type="hidden" name="submitted" value="1" />
			<?php wp_nonce_field('easycol-nonce'); ?>

			<p>
				Easy Columns options are for those times when you need pixel level control over the width and margins of the columns
				in your theme. Most of the time, the standard percentage widths work just fine!
			</p>

			<h3>Column Options</h3>
			<table border="0" cellpadding="2" cellspacing="4">
				<tr>
					<td valign="middle">
						<strong>Use Custom Options?</strong>
					</td>
					<td valign="middle">
						<?php if($this->options['use_custom']){ ?>
						<input type="checkbox" id="use_custom" name="use_custom" value="true" checked="checked" class="ezcol-input">
						<?php } else { ?>
						<input type="checkbox" id="use_custom" name="use_custom" value="true" class="ezcol-input">
						<?php } ?>
					</td>
				</tr>
			</table>

			<table border="0" cellpadding="2" cellspacing="4">

				<tr>
					<td colspan="6"><hr></td>
				</tr>

				<tr>
					<td valign="middle" colspan="2">
						<strong>1/4 Column Options</strong>
					</td>
					<td valign="middle" colspan="2">
						<strong>1/2 Column Options</strong>
					</td>
					<td valign="middle" colspan="2">
						<strong>3/4 Column Options</strong>
					</td>
				</tr>

				<tr>
					<td valign="middle">
						Width
					</td>
					<td valign="middle">
						<input type="text" id="quarter_width" name="quarter_width" value="<?php echo $this->options['quarter_width']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('quarter_width_type',$this->options['quarter_width_type']); ?>
					</td>
					<td valign="middle">
						Width
					</td>
					<td valign="middle">
						<input type="text" id="onehalf_width" name="onehalf_width" value="<?php echo $this->options['onehalf_width']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('onehalf_width_type',$this->options['onehalf_width_type']); ?>
					</td>
					<td valign="middle">
						Width
					</td>
					<td valign="middle">
						<input type="text" id="threequarter_width" name="threequarter_width" value="<?php echo $this->options['threequarter_width']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('threequarter_width_type',$this->options['threequarter_width_type']); ?>
					</td>
				</tr>

				<tr>
					<td valign="middle">
						Margin
					</td>
					<td valign="middle">
						<input type="text" id="quarter_margin" name="quarter_margin" value="<?php echo $this->options['quarter_margin']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('quarter_margin_type',$this->options['quarter_margin_type']); ?>
					</td>
					<td valign="middle">
						Margin
					</td>
					<td valign="middle">
						<input type="text" id="onehalf_margin" name="onehalf_margin" value="<?php echo $this->options['onehalf_margin']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('onehalf_margin_type',$this->options['onehalf_margin_type']); ?>
					</td>
					<td valign="middle">
						Margin
					</td>
					<td valign="middle">
						<input type="text" id="threequarter_margin" name="threequarter_margin" value="<?php echo $this->options['threequarter_margin']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('threequarter_margin_type',$this->options['threequarter_margin_type']); ?>
					</td>
				</tr>

				<tr>
					<td colspan="6"><hr></td>
				</tr>

				<tr>
					<td valign="middle" colspan="2">
						<strong>1/3 Column Options</strong>
					</td>
					<td valign="middle" colspan="2">
						<strong>2/3 Column Options</strong>
					</td>
					<td valign="middle" colspan="2">
						&nbsp;
					</td>
				</tr>

				<tr>
					<td valign="middle">
						Width
					</td>
					<td valign="middle">
						<input type="text" id="onethird_width" name="onethird_width" value="<?php echo $this->options['onethird_width']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('onethird_width_type',$this->options['onethird_width_type']); ?>
					</td>
					<td valign="middle">
						Width
					</td>
					<td valign="middle">
						<input type="text" id="twothird_width" name="twothird_width" value="<?php echo $this->options['twothird_width']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('twothird_width_type',$this->options['twothird_width_type']); ?>
					</td>
					<td colspan="2">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td valign="middle">
						Margin
					</td>
					<td valign="middle">
						<input type="text" id="onethird_margin" name="onethird_margin" value="<?php echo $this->options['onethird_margin']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('onethird_margin_type',$this->options['onethird_margin_type']); ?>
					</td>
					<td valign="middle">
						Margin
					</td>
					<td valign="middle">
						<input type="text" id="twothird_margin" name="twothird_margin" value="<?php echo $this->options['twothird_margin']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('twothird_margin_type',$this->options['twothird_margin_type']); ?>
					</td>
					<td valign="middle" colspan="2">
						&nbsp;
					</td>
				</tr>

				<tr>
					<td colspan="6"><hr></td>
				</tr>

				<tr>
					<td valign="middle" colspan="2">
						<strong>1/5 Column Options</strong>
					</td>
					<td valign="middle" colspan="2">
						<strong>2/5 Column Options</strong>
					</td>
					<td valign="middle" colspan="2">
						<strong>3/5 Column Options</strong>
					</td>
				</tr>

				<tr>
					<td valign="middle">
						Width
					</td>
					<td valign="middle">
						<input type="text" id="onefifth_width" name="onefifth_width" value="<?php echo $this->options['onefifth_width']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('onefifth_width_type',$this->options['onefifth_width_type']); ?>
					</td>
					<td valign="middle">
						Width
					</td>
					<td valign="middle">
						<input type="text" id="twofifth_width" name="twofifth_width" value="<?php echo $this->options['twofifth_width']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('twofifth_width_type',$this->options['twofifth_width_type']); ?>
					</td>
					<td valign="middle">
						Width
					</td>
					<td valign="middle">
						<input type="text" id="threefifth_width" name="threefifth_width" value="<?php echo $this->options['threefifth_width']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('threefifth_width_type',$this->options['threefifth_width_type']); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle">
						Margin
					</td>
					<td valign="middle">
						<input type="text" id="onefifth_margin" name="onefifth_margin" value="<?php echo $this->options['onefifth_margin']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('onefifth_margin_type',$this->options['onefifth_margin_type']); ?>
					</td>
					<td valign="middle">
						Margin
					</td>
					<td valign="middle">
						<input type="text" id="twofifth_margin" name="twofifth_margin" value="<?php echo $this->options['twofifth_margin']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('twofifth_margin_type',$this->options['twofifth_margin_type']); ?>
					</td>
					<td valign="middle">
						Margin
					</td>
					<td valign="middle">
						<input type="text" id="threefifth_margin" name="threefifth_margin" value="<?php echo $this->options['threefifth_margin']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('threefifth_margin_type',$this->options['threefifth_margin_type']); ?>
					</td>
				</tr>

				<tr>
					<td valign="middle" colspan="6">
						<strong>4/5 Column Options</strong>
					</td>
				</tr>

				<tr>
					<td valign="middle">
						Width
					</td>
					<td valign="middle" colspan="5">
						<input type="text" id="fourfifth_width" name="fourfifth_width" value="<?php echo $this->options['fourfifth_width']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('fourfifth_width_type',$this->options['fourfifth_width_type']); ?>
					</td>
				</tr>
				<tr>
					<td valign="middle">
						Margin
					</td>
					<td valign="middle" colspan="5">
						<input type="text" id="fourfifth_margin" name="fourfifth_margin" value="<?php echo $this->options['fourfifth_margin']; ?>" size="6" class="ezcol-input">
						&nbsp;
						<?php write_sel('fourfifth_margin_type',$this->options['fourfifth_margin_type']); ?>
					</td>
				</tr>
				<tr>
					<td colspan="6">
						<hr>
					</td>
				</tr>
			</table>

			<table border="0" cellpadding="2" cellspacing="4">
				<tr>
					<td valign="middle" colspan="6">
						<strong>Custom CSS</strong>
					</td>
				</tr>
				<tr>
					<td valign="middle">
						<textarea id="custom_css" name="custom_css" cols="80" rows="10" class="ezcol-input"><?php echo $this->options['custom_css']; ?></textarea>
					</td>
				</tr>
			</table>

			<p>
				<input type="submit" value="Update" name="submit" class="button button-primary button-large">
			</p>

		</form>

		<h3>Column Shortcodes</h3>
		<strong>1/4 columns</strong><br />
		[ezcol_1quarter id="" class="" style=""][/ezcol_1quarter]<br />
		[ezcol_1quarter_end id="" class="" style=""][/ezcol_1quarter_end]<br />
		<br />
		<strong>1/2 columns</strong><br />
		[ezcol_1half id="" class="" style=""][/ezcol_1half]<br />
		[ezcol_1half_end id="" class="" style=""][/ezcol_1half_end]<br />
		<br />
		<strong>3/4 columns</strong><br />
		[ezcol_3quarter id="" class="" style=""][/ezcol_3quarter]<br />
		[ezcol_3quarter_end id="" class="" style=""][/ezcol_3quarter_end]<br />
		<br />
		<strong>1/3 columns</strong><br />
		[ezcol_1third id="" class="" style=""][/ezcol_1third]<br />
		[ezcol_1third_end id="" class="" style=""][/ezcol_1third_end]<br />
		<br />
		<strong>2/3 columns</strong><br />
		[ezcol_2third id="" class="" style=""][/ezcol_2third]<br />
		[ezcol_2third_end id="" class="" style=""][/ezcol_2third_end]<br />
		<br />
		<strong>1/5 columns</strong><br />
		[ezcol_1fifth id="" class="" style=""][/ezcol_1fifth]<br />
		[ezcol_1fifth_end id="" class="" style=""][/ezcol_1fifth_end]<br />
		<br />
		<strong>2/5 columns</strong><br />
		[ezcol_2fifth id="" class="" style=""][/ezcol_2fifth]<br />
		[ezcol_2fifth_end id="" class="" style=""][/ezcol_2fifth_end]<br />
		<br />
		<strong>3/5 columns</strong><br />
		[ezcol_3fifth id="" class="" style=""][/ezcol_3fifth]<br />
		[ezcol_3fifth_end id="" class="" style=""][/ezcol_3fifth_end]<br />
		<br />
		<strong>4/5 columns</strong><br />
		[ezcol_4fifth id="" class="" style=""][/ezcol_4fifth]<br />
		[ezcol_4fifth_end id="" class="" style=""][/ezcol_4fifth_end]<br />
		<br />
		<strong>special columns</strong><br />
		[ezdiv id="" class="" style=""][/ezdiv] (easily create DIVs in your content without editing raw HTML!)<br />
		<br />
		[ezcol_divider] (clears all floats and creates a 2px high, 100% width div)<br />
		[ezcol_end_left] (clears left float)<br />
		[ezcol_end_right] (clears right float)<br />
		[ezcol_end_both] (clears both)

		<p>
			As you can see, column shortcodes take the attributes of "id", "class", and "style". This way you can
			have even more control over your columns, apply an additional class or use inline CSS.
		</p>

		<h4>Easy Columns plugin by <a href="http://www.patrickfriedl.com" target="_blank">PatrickFriedl.com</a></h4>
		<h4>If you like Easy Columns, be sure to check out our other plugins
			<a href="http://www.fanpageconnect.com" target="_blank">Fanpage Connect</a> to create Facebook fanpages from your blog,
			or <a href="http://www.wp-geolocation.com" target="_blank">WP-Geolocation</a> to personalize your content with a user's location.</h4>

	</div><!-- dbx-content -->

</div><!-- wrap -->