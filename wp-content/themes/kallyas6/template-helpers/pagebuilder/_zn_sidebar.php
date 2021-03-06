<?php
/*--------------------------------------------------------------------------------------------------
	Sidebar
--------------------------------------------------------------------------------------------------*/
function _zn_sidebar( $options )
{
	$element_size = zn_get_size( $options['_sizer'] );

	$sidebar_css = '';

	if ( $options['sidebar_bg'] == 'no' ) {
		$sidebar_css = 'no_bg';
	}
	?>
	<div class="<?php echo $element_size['sizer']; ?>">
		<?php
			$uid = rand(124, 98548);
			echo '<div id="sidebar-widget-'.$uid.'" class="sidebar ' . $sidebar_css . '">';
			if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( $options['sidebar_select'] ) ) : endif;
			echo '</div>';
		?>
	</div>
<?php
}
