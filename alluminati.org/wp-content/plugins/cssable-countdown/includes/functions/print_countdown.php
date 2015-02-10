<?php
function print_countdown( $unique, $build_args, $print_args )
{
	// build the format
	if ( $print_args['kbw_format'] )
	{
		$build_args['format'] = $build_args['kbw_format'];
		
		// countdown doesn't need to print this option
		unset( $print_args['kbw_format'] );
	}
	else
	{
		global $periods;
		
		foreach ( $periods as $pd => $val )
		{
			if ( !empty( $build_args[$pd] ) && $build_args[$pd] != '-1' )
			{
				$build_args['format'] .= $build_args[$pd];
			}
		}
	}
?>
	<div id="<?php echo $unique; ?>" class="cssable-countdown layout-type_<?php echo $build_args['layout_type']; ?>"></div>
			
	<script type="text/javascript"> 
	jQuery(document).ready(function($) {
		$('#<?php echo $unique; ?>').countdown({
<?php
		foreach ( $print_args as $req_arg => $do_quote)
		{
			// ignore empty expiryText
			if ( 'expiryText' == $req_arg && false === $build_args['hasExpiryText'] )
			{
				continue;
			}
			
			echo "\t\t\t" . $req_arg . ': ' . ( $do_quote ? "'" : '' ) . $build_args[$req_arg] . ( $do_quote ? "'" : '' ) . ',' . "\n";
		}
?>
		}); 
	});
	</script>
<?php
}
?>