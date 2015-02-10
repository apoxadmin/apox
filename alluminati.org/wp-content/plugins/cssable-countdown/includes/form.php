<?php
$widget_options = wp_parse_args( $instance, $this->defaults );
extract( $widget_options, EXTR_SKIP );

$event = esc_attr($event);

$checked = 'checked="checked"';
$selected = 'selected="selected"';

global $periods;
?>

<p>
	<label for="<?php echo $this->get_field_id('month'); ?>">
		<?php _e('Date:'); ?>
	</label>
	
	<input id="<?php echo $this->get_field_id('month'); ?>"
			name="<?php echo $this->get_field_name('month'); ?>"
			type="text"
			value="<?php echo $month; ?>"
			size="2"
			placeholder="MM"
			maxlength="2" />
	
	/
	
	<input id="<?php echo $this->get_field_id('day'); ?>"
			name="<?php echo $this->get_field_name('day'); ?>"
			type="text"
			value="<?php echo $day; ?>"
			size="2"
			placeholder="DD"
			maxlength="2" />
			
	/
	
	<input id="<?php echo $this->get_field_id('year'); ?>"
			name="<?php echo $this->get_field_name('year'); ?>"
			type="text"
			value="<?php echo $year; ?>"
			size="4"
			placeholder="YYYY"
			maxlength="4" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('hour'); ?>">
		<?php _e('Time:'); ?>
	</label>
	
	<input id="<?php echo $this->get_field_id('hour'); ?>"
			name="<?php echo $this->get_field_name('hour'); ?>"
			type="text"
			value="<?php echo $hour; ?>"
			size="2"
			placeholder="hh"
			maxlength="2" />
	
	:
	
	<input id="<?php echo $this->get_field_id('minutes'); ?>"
			name="<?php echo $this->get_field_name('minutes'); ?>"
			type="text"
			value="<?php echo $minutes; ?>"
			size="2"
			placeholder="mm"
			maxlength="2" />
			
	:
	
	<input id="<?php echo $this->get_field_id('seconds'); ?>"
			name="<?php echo $this->get_field_name('seconds'); ?>"
			type="text"
			value="<?php echo $seconds; ?>"
			size="2"
			placeholder="ss"
			maxlength="2" />
</p>

<p>
	<label for="<?php echo $this->get_field_id('direction'); ?>">
		<?php _e('Countdown style:'); ?>
	</label>
	
	<select name="<?php echo $this->get_field_name('direction'); ?>"
			id="<?php echo $this->get_field_id('direction'); ?>" >
		<option value="down" <?php echo ( $direction == 'down' ) ? $selected : ''; ?>>Countdown</option>
		<option value="up" <?php echo ( $direction == 'up' ) ? $selected : ''; ?>>Countup</option>
	</select>
</p>

<div class="ccw_toggle-option ccw_basic-formatting">
	<h4><a href="#">&blacktriangledown;</a>Period Display</h4>
	
	<div class="ccw_toggled">			
		<p class="ccw_tooltip">
			Note: This setting will be overridden if you enter a <tt>format</tt> in the "Advanced Formatting" section below.
		</p>
		
		<ul class="periods">
			<?php foreach ( $periods as $pd => $val ) : ?>
			<li>
				<label for="<?php echo $this->get_field_id($pd); ?>"><?php echo ucwords( str_replace( 'format_', '', $pd ) ) . ':'; ?></label>
				<select name="<?php echo $this->get_field_name($pd); ?>"
						id="<?php echo $this->get_field_id($pd); ?>" >
					<option value="<?php echo strtoupper( $val ); ?>" <?php selected( $$pd, strtoupper( $val ) ); ?>>Always show</option>
					<option value="<?php echo $val; ?>" <?php selected( $$pd, $val ); ?>>Show if not zero</option>
					<option value="-1" <?php selected( $$pd, '-1' ); ?>>Never show</option>
				</select>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div><!-- add text -->

<div class="ccw_toggle-option ccw_basic-layout">
	<h4><a href="#">&blacktriangledown;</a>Layout</h4>
	
	<div class="ccw_toggled">			
		<p class="ccw_tooltip">
			If you choose a layout other than the default, a minimum of CSS will be applied.  You can still add your own styling and colors.
		</p>
		
		<p class="ccw_tooltip">
			Note: This setting will be overridden if you enter a <tt>format</tt> in the "Advanced Formatting" section below.
		</p>
		
		<ul>
			<li>
				<label>
					<input type="radio"
								name="<?php echo $this->get_field_name('layout_type'); ?>"
								id="<?php echo $this->get_field_id('layout_type'); ?>"
								value="default"
								<?php checked( $layout_type, 'default' ); ?> />
					Horizontal blocks (default)
				</label>
			</li>
			<li>							
				<label>
					<input type="radio"
								name="<?php echo $this->get_field_name('layout_type'); ?>"
								id="<?php echo $this->get_field_id('layout_type'); ?>"
								value="list"
								<?php checked( $layout_type, 'list' ); ?> />
					Bulleted list
				</label>
			</li>
			<li>
				<label>
					<input type="radio"
								name="<?php echo $this->get_field_name('layout_type'); ?>"
								id="<?php echo $this->get_field_id('layout_type'); ?>"
								value="text"
								<?php checked( $layout_type, 'text' ); ?> />
					Text
				</label>
			</li>
			<li>
				<label>
					<input type="radio"
								name="<?php echo $this->get_field_name('layout_type'); ?>"
								id="<?php echo $this->get_field_id('layout_type'); ?>"
								value="compact"
								<?php checked( $layout_type, 'compact' ); ?> />
					Compact
				</label>
			</li>
		</ul>
	</div>
</div><!-- layout type -->

<div class="ccw_toggle-option ccw_add-text">
	<h4><a href="#">&blacktriangledown;</a>Add Text</h4>
	
	<div class="ccw_toggled">
		<p>
			<label for="<?php echo $this->get_field_id('event'); ?>">
				<?php _e('Event Description:'); ?>
			</label>
			
			<input class="widefat"
					id="<?php echo $this->get_field_id('event'); ?>"
					name="<?php echo $this->get_field_name('event'); ?>"
					type="text"
					value="<?php echo stripslashes( $event ); ?>" />
		</p>
	</div>
</div><!-- add text -->

<div class="ccw_toggle-option ccw_expiry-text">
	<h4><a href="#">&blacktriangledown;</a>Expiration Options</h4>
	
	<div class="ccw_toggled">
		<p class="ccw_tooltip">
			When the countdown expires, it will continue to display 00:00 unless you set an expiration text.
			Alternatively, you can redirect to a specified URL.  Note: If both expiry text and expiry URL are set,
			the expiry text has precedence (and thus the page will not redirect).
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('expiryText'); ?>">
				<?php _e('Expiration Text:'); ?>
			</label>
			
			<input class="widefat"
					id="<?php echo $this->get_field_id('expiryText'); ?>"
					name="<?php echo $this->get_field_name('expiryText'); ?>"
					type="text"
					value="<?php echo stripslashes( $expiryText ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('expiryUrl'); ?>">
				<?php _e('Redirect to:'); ?>
			</label>
			
			<input class="widefat"
					id="<?php echo $this->get_field_id('expiryUrl'); ?>"
					name="<?php echo $this->get_field_name('expiryUrl'); ?>"
					type="text"
					placeholder="http://"
					value="<?php echo $expiryUrl; ?>" />
		</p>
	</div>
</div><!-- expiry options -->

<div class="ccw_toggle-option ccw_expiry-text">
	<h4><a href="#">&blacktriangledown;</a>Change Timezone</h4>
	
	<div class="ccw_toggled">
		<p class="ccw_tooltip">
			The countdown counts down in your local (server) time unless you set the timezone elsewhere.
		</p>
		
		<p class="curr_date-time">
			<?php echo date( 'D F j, Y', current_time( 'timestamp', 0 ) ); ?>
			<br />
			<?php echo date( 'g:i a ' . convert_decimal_to_timezone( get_option( 'gmt_offset' ) ), current_time( 'timestamp', 0 ) ) . ' GMT'; ?>
		</p>
		
		<p class="ccw_tooltip">If this time is wrong, make sure your GMT offset is set under <a href="options-general.php" title="Settings > General">Settings > General > Timezone!</a></p>
		
		<label for="<?php echo $this->get_field_id('timezone'); ?>">
			<?php _e('Target timezone:'); ?>
		</label>
		
		<select class="widefat"
				name="<?php echo $this->get_field_name('timezone'); ?>"
				id="<?php echo $this->get_field_id('timezone'); ?>" >
		<?php
			$list_of_timezones = list_of_timezones();
			
			foreach ( $list_of_timezones as $offset )
			{						
				$option = '<option value="' . $offset . '"' . ( selected( convert_decimal_to_timezone( $timezone ), $offset ) ) . '>';
				$option .= $offset; 
				$option .= '</option>' . "\n";
				echo $option;
			} 
		?>
		</select>
	</div>
</div><!-- timezone -->

<p class="ccw_tooltip">
	<strong>ADVANCED OPTIONS:</strong> Only change these settings if you know what you're doing!
	Changing options here will override any settings in <tt>Basic Formatting</tt> and <tt>Layout</tt>.
</p>

<div class="ccw_toggle-option ccw_formatting">
	<h4><a href="#">&blacktriangledown;</a>Advanced Formatting</h4>
	
	<div class="ccw_toggled">				
		<p>
			<label for="<?php echo $this->get_field_id('kbw_format'); ?>">
				<?php _e('Format:'); ?>
			</label>
				
			<input id="<?php echo $this->get_field_id('kbw_format'); ?>"
					name="<?php echo $this->get_field_name('kbw_format'); ?>"
					type="text"
					value="<?php echo $kbw_format; ?>"
					size="10"
					maxlength="8" />
			
			<small>YOWDHMS</small>
			<small><abbr title="Case-sensitive; uppercase always displays, lowercase displays if non-zero, non-existent doesn't display at all.">[?]</abbr></small>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('significant'); ?>">
				<?php _e('Significant Periods:'); ?>
			</label>
			
			<select name="<?php echo $this->get_field_name('significant'); ?>"
					id="<?php echo $this->get_field_id('significant'); ?>" >
			<?php 
				for ( $i = -1; $i < 8; $i++ )
				{
					if ( $i != 0 )
					{
						$option = '<option value="' . $i . '" ' . ( $significant == $i ? $selected : '' ) .'>';
						$option .= ( $i == -1 ) ? 'All' : $i;
						$option .= '</option>\n';
						echo $option;
					}
				} 
			?>
			</select> 
			
			<small><abbr title="Control how many significant (non-zero) periods are shown.">[?]</abbr></small>
		</p>
	</div>
</div><!-- advanced formatting -->