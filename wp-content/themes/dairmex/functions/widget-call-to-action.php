<?php
/**
 * Widget Muffin Call To Action
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

class Mfn_Call_To_Action_Widget extends WP_Widget {

	
	/* ---------------------------------------------------------------------------
	 * Constructor
	 * --------------------------------------------------------------------------- */
	function Mfn_Call_To_Action_Widget() {
		$widget_ops = array( 'classname' => 'widget_mfn_call_to_action', 'description' => __( 'Displays a Call To Action box on the page.', 'mfn-opts' ) );
		$this->WP_Widget( 'widget_mfn_call_to_action', __( 'Muffin Call To Action', 'mfn-opts' ), $widget_ops );
		$this->alt_option_name = 'widget_mfn_call_to_action';
	}
	
	
	/* ---------------------------------------------------------------------------
	 * Outputs the HTML for this widget.
	 * --------------------------------------------------------------------------- */
	function widget( $args, $instance ) {

		if ( ! isset( $args['widget_id'] ) ) $args['widget_id'] = null;
		extract( $args, EXTR_SKIP );

		echo $before_widget;
		
		// background image
		if( $instance['image'] ){
			$bg = ' style="background:url('. $instance['image'] .') center center;"';
		} else {
			$bg = false;
		}
		
		$output = '<div class="call_to_action"'. $bg .'>';
			$output .= '<div class="inner-padding">';
				$output .= '<div class="vertical-align-middle">';
					$output .= '<h4>'. $instance['text'] .'</h4>';
					if( $instance['btn_link'] ) $output .= '<a href="'. $instance['btn_link'] .'" class="button">'. $instance['btn_title'] .'</a>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>'."\n";
	
		echo $output;

		echo $after_widget;
	}


	/* ---------------------------------------------------------------------------
	 * Deals with the settings when they are saved by the admin.
	 * --------------------------------------------------------------------------- */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['image'] 		= strip_tags( $new_instance['image'] );
		$instance['text'] 		= $new_instance['text'];
		$instance['btn_title'] 	= strip_tags( $new_instance['btn_title'] );
		$instance['btn_link'] 	= strip_tags( $new_instance['btn_link'] );
		
		return $instance;
	}

	
	/* ---------------------------------------------------------------------------
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 * --------------------------------------------------------------------------- */
	function form( $instance ) {

		$image 		= isset( $instance['image']) ? esc_attr( $instance['image'] ) : '';
		$text 		= isset( $instance['text']) ? $instance['text'] : '';
		$btn_title 	= isset( $instance['btn_title']) ? esc_attr( $instance['btn_title'] ) : '';
		$btn_link	= isset( $instance['btn_link']) ? esc_attr( $instance['btn_link'] ) : '';

		?>
	
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php _e( 'Background image:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="text" value="<?php echo esc_attr( $image ); ?>" />
				<span class="description"><?php echo __('Please upload image using WP Media Library and paste an uploaded image URL.', 'mfn-opts'); ?></span>
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'Text:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
				<span class="description"><?php echo __('Wrap text into "span" tag to highlight it.', 'mfn-opts'); ?></span>
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'btn_title' ) ); ?>"><?php _e( 'Button title:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'btn_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'btn_title' ) ); ?>" type="text" value="<?php echo esc_attr( $btn_title ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'btn_link' ) ); ?>"><?php _e( 'Button link:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'btn_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'btn_link' ) ); ?>" type="text" value="<?php echo esc_attr( $btn_link ); ?>" />
			</p>

			
		<?php
	}
}
?>