<?php
/*--------------------------------------------------------------------------------------------------
	SPACER
--------------------------------------------------------------------------------------------------*/

function _pb_spacer_element( $options )
{
	$element_size = zn_get_size( $options['_sizer'] );

	$height = 30; // the default value

	if(isset($options['spacer_height']) && !empty($options['spacer_height'])){
		$height = absint($options['spacer_height']);
	}

	echo '<div class="' . $element_size['sizer'] . '" style="height: '.$height.'px;"></div>';
}

