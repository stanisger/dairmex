<?php
/**
 * Widget Muffin Twitter
 *
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

class Mfn_Twitter_Widget extends WP_Widget {

	
	/* ---------------------------------------------------------------------------
	 * Constructor
	 * --------------------------------------------------------------------------- */
	function Mfn_Twitter_Widget() {
		$widget_ops = array( 'classname' => 'widget_mfn_twitter', 'description' => __( 'Use this widget on pages to display photos from Twitter photostream.', 'mfn-opts' ) );
		$this->WP_Widget( 'widget_mfn_twitter', __( 'Muffin Twitter', 'mfn-opts' ), $widget_ops );
		$this->alt_option_name = 'widget_mfn_twitter';
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
		
		if(empty($instance['consumerkey']) || empty($instance['consumersecret']) || empty($instance['accesstoken']) || empty($instance['accesstokensecret']) || empty($instance['userID'])){
			echo 'Please fill all widget settings!' . $after_widget;
			return;
		}
		
		$connection = new TwitterOAuth ($instance['consumerkey'], $instance['consumersecret'], $instance['accesstoken'], $instance['accesstokensecret']);
		$tweets = $connection->get( "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=". $instance['userID'] ."&count=". $instance['count'] ) or die( 'Couldn\'t retrieve tweets! Wrong username?' );
		
		if( !empty( $tweets->errors ) ){
			if( $tweets->errors[0]->message == 'Invalid or expired token' ){
				echo '<strong>'.$tweets->errors[0]->message.'!</strong><br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!' . $after_widget;
			} else {
				echo '<strong>'.$tweets->errors[0]->message.'</strong>' . $after_widget;
			}
			return;
		}
		
		function convert_links( $status, $targetBlank=true, $linkMaxLen=250 ){			 
			$target=$targetBlank ? " target=\"_blank\" " : "";
			$status = preg_replace("/((http:\/\/|https:\/\/)[^ )
]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);
			$status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);
			$status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);
			return $status;
			
		}

		if( is_array( $tweets ) ){
			echo '<div class="Twitter">';
				echo '<ul>';
					foreach( $tweets as $tweet ){
						echo '<li><span>'. convert_links( $tweet->text ) .'</span><a class="twitter_time" target="_blank" href="http://twitter.com/'. $instance['userID'] .'/statuses/'. $tweet->id_str .'">'. date( 'j.m.Y G:i:s', strtotime( $tweet->created_at ) ) .'</a></li>';
					}
				echo '</ul>';
			echo '</div>';
		}

		echo $after_widget;
	}


	/* ---------------------------------------------------------------------------
	 * Deals with the settings when they are saved by the admin.
	 * --------------------------------------------------------------------------- */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['consumerkey'] = strip_tags( $new_instance['consumerkey'] );
		$instance['consumersecret'] = strip_tags( $new_instance['consumersecret'] );
		$instance['accesstoken'] = strip_tags( $new_instance['accesstoken'] );
		$instance['accesstokensecret'] = strip_tags( $new_instance['accesstokensecret'] );
		$instance['userID'] = strip_tags( $new_instance['userID'] );
		$instance['count'] = (int) $new_instance['count'];
		
		return $instance;
	}

	
	/* ---------------------------------------------------------------------------
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 * --------------------------------------------------------------------------- */
	function form( $instance ) {
		
		$title = isset( $instance['title']) ? esc_attr( $instance['title'] ) : '';
		$consumerkey = isset( $instance['consumerkey']) ? esc_attr( $instance['consumerkey'] ) : '';
		$consumersecret = isset( $instance['consumersecret']) ? esc_attr( $instance['consumersecret'] ) : '';
		$accesstoken = isset( $instance['accesstoken']) ? esc_attr( $instance['accesstoken'] ) : '';
		$accesstokensecret = isset( $instance['accesstokensecret']) ? esc_attr( $instance['accesstokensecret'] ) : '';
		$userID = isset( $instance['userID']) ? esc_attr( $instance['userID'] ) : 'Muffin_Group';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 2;

		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			
			<p><strong>Twitter API key:</strong></p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'consumerkey' ) ); ?>"><?php _e( 'Customer Key:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumerkey' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumerkey' ) ); ?>" type="text" value="<?php echo esc_attr( $consumerkey ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'consumersecret' ) ); ?>"><?php _e( 'Customer Secret:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumersecret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumersecret' ) ); ?>" type="text" value="<?php echo esc_attr( $consumersecret ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'accesstoken' ) ); ?>"><?php _e( 'Access Token:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'accesstoken' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'accesstoken' ) ); ?>" type="text" value="<?php echo esc_attr( $accesstoken ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'accesstokensecret' ) ); ?>"><?php _e( 'Access Token Secret:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'accesstokensecret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'accesstokensecret' ) ); ?>" type="text" value="<?php echo esc_attr( $accesstokensecret ); ?>" />
			</p>
			
			<p><a target="_blank" href="https://dev.twitter.com/discussions/631">How to get my <strong>API key</strong></a></p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'userID' ) ); ?>"><?php _e( 'Twitter Username:', 'mfn-opts' ); ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'userID' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'userID' ) ); ?>" type="text" value="<?php echo esc_attr( $userID ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php _e( 'Number of tweets:', 'mfn-opts' ); ?></label>
				<input id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" size="3"/>
			</p>
		<?php
	}
}
?>