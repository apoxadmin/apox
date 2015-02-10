<?php
function generate_layout( $data )
{
	global $periods;
	
	$layout = '';
	
	if ( 'list' == $data['layout_type'] )
	{		
		foreach ( $periods as $pd => $val )
		{
			$section_layout = '<li class="countdown_section">' . 
								'<span class="countdown_amount">{' . $val . 'n}</span>' . 
								'<span class="countdown_label">{' . $val . 'l}</span>' .
								'</li>';
								
			switch ( $data[$pd] )
			{
				case $val:
					$layout .= '{' . $val . '<}' . $section_layout . '{' . $val . '>}';
					break;
				case strtoupper( $val ):
					$layout .= $section_layout;
					break;
				default: // ignore
					break;
			}
		}
		
		$layout = '<ul>' . $layout . '</ul>';
		
		if ( !empty( $data['description'] ) )
		{
			$layout .= '<div class="countdown_descr">{desc}</div>';
		}
	}
	
	return $layout;
}
?>