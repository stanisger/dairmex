<?php
/**
 * Widget Muffin Contact Box
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

class Mfn_Contact_Box_Widget extends WP_Widget {

	
	/* ---------------------------------------------------------------------------
	 * Constructor
	 * --------------------------------------------------------------------------- */
	function Mfn_Contact_Box_Widget() {
		$widget_ops = array( 'classname' => 'widget_mfn_contact_box', 'description' => __( 'Displays a contact box on the page.', 'mfn-opts' ) );
		$this->WP_Widget( 'widget_mfn_contact_box', __( 'Muffin Contact Box', 'mfn-opts' ), $widget_ops );
		$this->alt_option_name = 'widget_mfn_contact_box';
	}
	
	
	/* ---------------------------------------------------------------------------
	 * Outputs the HTML for this widget.
	 * --------------------------------------------------------------------------- */
	function widget( $args, $instance ) {

		if ( ! isset( $args['widget_id'] ) ) $args['widget_id'] = null;
		extract( $args, EXTR_SKIP );

		echo $before_widget;
		
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base);
		if( $title ) echo $before_title . $title . $after_title;
		
		$output = '<div class="get_in_touch">';
			$output .= '<ul>';
				if( $instance['address'] ){
					$output .= '<li class="address">';
						$output .= '<i class="icon-map-marker"></i><p>'. nl2br( $instance['address'] ) .'</p>';
					$output .= '</li>';
				}
				if( $instance['telephone'] ){
					$output .= '<li class="phone">';
						$output .= '<i class="icon-phone"></i><p>'. $instance['telephone'] .'</p>';
					$output .= '</li>';
				}
				if( $instance['fax'] ){
					$output .= '<li class="fax">';
						$output .= '<i class="icon-print"></i><p>'. $instance['fax'] .'</p>';
					$output .= '</li>';
				}
				if( $instance['email'] ){
					$output .= '<li class="mail">';
						$output .= '<i class="icon-envelope"></i><p><a href="mailto:'. $instance['email'] .'">'. $instance['email'] .'</a></p>';
					$output .= '</li>';
				}
				if( $instance['www'] ){
					$output .= '<li class="www">';
						$output .= '<i class="icon-globe"></i><p><a href="http://'. $instance['www'] .'">'. $instance['www'] .'</a></p>';
					$output .= '</li>';
				}
			$output .= '</ul>';
		$output .= '</div>'."\n";
		
		echo $output;

		echo $after_widget;
	}


	/* ---------------------------------------------------------------------------
	 * Deals with the settings when they are saved by the admin.
	 * --------------------------------------------------------------------------- */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['address'] = strip_tags( $new_instance['address'] );
		$instance['telephone'] = strip_tags( $new_instance['telephone'] );
		$instance['fax'] = strip_tags( $new_instance['fax'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		$instance['www'] = strip_tags( $new_instance['www'] );
		
		return $instance;
	}

	
	/* ---------------------------------------------------------------------------
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 * --------------------------------------------------------------------------- */
	function form( $instance ) {
		
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
		$address = isset( $instance['address']) ? esc_attr( $instance['address'] ) : '';
		$telephone = isset( $instance['telephone']) ? esc_attr( $instance['telephone'] ) : '';
		$fax = isset( $instance['fax']) ? esc_attr( $instance['fax'] ) : '';
		$email = isset( $instance['email']) ? esc_attr( $instance['email'] ) : '';
		$www = isset( $instance['www']) ? esc_attr( $instance['www'] ) : '';

		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>"><?php _e( 'Address:', 'mfn-opts' ); ?></label>
				<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'address' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'address' ) ); ?>"><?php echo esc_attr( $address ); ?></textarea>
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'telephone' ) ); ?>"><?php _e( 'Telephone:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'telephone' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'telephone' ) ); ?>" type="text" value="<?php echo esc_attr( $telephone ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'fax' ) ); ?>"><?php _e( 'Fax:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'fax' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'fax' ) ); ?>" type="text" value="<?php echo esc_attr( $fax ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>"><?php _e( 'E-mail:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'email' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'email' ) ); ?>" type="text" value="<?php echo esc_attr( $email ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'www' ) ); ?>"><?php _e( 'WWW:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'www' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'www' ) ); ?>" type="text" value="<?php echo esc_attr( $www ); ?>" />
			</p>
			
		<?php
	}
}
?>