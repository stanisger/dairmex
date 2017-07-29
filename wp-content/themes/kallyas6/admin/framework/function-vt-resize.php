<?php
/*
 * Resize images dynamically using wp built in functions
 * Victor Teixeira
 *
 * php 5.2+
 *
 * Exemplo de uso:
 *
 * <?php
 * $thumb = get_post_thumbnail_id();
 * $image = vt_resize($thumb, '', 140, 110, true);
 * ?>
 * <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
 *
 * @param int $attach_id
 * @param string $img_url
 * @param int $width
 * @param int $height
 * @param bool $crop
 * @return array
*/
if ( ! function_exists( 'vt_resize' ) )
{
	/**
	 * @param null $attach_id
	 * @param null $img_url
	 * @param int $width
	 * @param int $height
	 * @param bool $crop
	 *
	 * @return array
	 */
	function vt_resize( $attach_id = null, $img_url = null, $width = 0, $height = 0, $crop = false )
	{
		// Default output
		$defaults = array(
			'url'    => '',
			'width'  => $width,
			'height' => $height
		);

		// Cast $width and $height to integer
		$width  = intval( $width );
		$height = intval( $height );

		// this is an attachment, so we have the ID
		if ( $attach_id ) {
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$file_path = get_attached_file( $attach_id );
			// this is not an attachment, let's use the image url
		} else if ( $img_url ) {
			if ( false === ( $upload_dir = wp_cache_get( 'upload_dir', 'zn_cache' ) ) ) {
				$upload_dir = wp_upload_dir();
				wp_cache_set( 'upload_dir', $upload_dir, 'zn_cache' );
			}

			$file_path = explode( $upload_dir['baseurl'], $img_url );
			$file_path = $upload_dir['basedir'] . $file_path['1'];

			//$file_path = ltrim($file_path['path'], '/');
			//$file_path = rtrim(ABSPATH, '/').$file_path['path'];

			$orig_size = @getimagesize( $file_path );

			$image_src[0] = $img_url;
			$image_src[1] = $orig_size[0];
			$image_src[2] = $orig_size[1];
		}

		if ( ! isset( $image_src ) || ! is_array( $image_src ) ) {
			$image_src = array();
		}
		if ( ! isset( $image_src[0] ) ) {
			$image_src[0] = '';
		}
		if ( ! isset( $image_src[1] ) ) {
			$image_src[1] = 0;
		}
		if ( ! isset( $image_src[2] ) ) {
			$image_src[2] = 0;
		}

		if ( ! isset( $file_path ) || empty( $file_path ) ) {
			return $defaults;
		}

		$file_info = pathinfo( $file_path );

		// check if file exists
		if ( empty( $file_info['dirname'] ) || empty( $file_info['filename'] ) || empty( $file_info['extension'] ) ) {
			return $defaults;
		}

		$base_file = $file_info['dirname'] . '/' . $file_info['filename'] . '.' . $file_info['extension'];
		if ( ! is_file( $base_file ) ) {
			return $defaults;
		}

		$extension = '.' . $file_info['extension'];

		// the image path without the extension
		$no_ext_path = $file_info['dirname'] . '/' . $file_info['filename'];

		$cropped_img_path = $no_ext_path . '-' . $width . 'x' . $height . $extension;

		// checking if the file size is larger than the target size
		// if it is smaller or the same size, stop right here and return
		if ( ! empty( $image_src[1] ) && ( $image_src[1] > $width ) ) {
			// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
			if ( file_exists( $cropped_img_path ) ) {
				$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );

				return array(
					'url'    => $cropped_img_url,
					'width'  => $width,
					'height' => $height
				);
			}

			// $crop = false or no height set
			if ( ! $crop || ! $height ) {
				// calculate the size proportionally
				$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
				$resized_img_path  = $no_ext_path . '-' . $proportional_size[0] . 'x' . $proportional_size[1] . $extension;

				// checking if the file already exists
				if ( file_exists( $resized_img_path ) ) {
					$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

					return array(
						'url'    => $resized_img_url,
						'width'  => $proportional_size[0],
						'height' => $proportional_size[1]
					);
				}
			}

			// Check if GD Library installed
			if ( ! function_exists( 'imagecreatetruecolor' ) ) {
				//echo 'GD Library Error: imagecreatetruecolor does not exist - please contact your web host and ask them to install the GD library';
				error_log( 'KALLYAS [' . realpath( __FILE__ ) . '] GD Library Error: imagecreatetruecolor does not exist - please contact your web host and ask them to install the GD library' );

				return $defaults;
			}

			// check if image width is smaller than set width
			$img_size = getimagesize( $file_path );
			if ( $img_size[0] <= $width ) {
				$width = $img_size[0];
			}

			// no cache files - let's finally resize it
			$image = wp_get_image_editor( $file_path );
			if ( ! is_wp_error( $image ) ) {
				$image->resize( $width, $height, $crop );
				$save_data = $image->save();
				if ( isset( $save_data['path'] ) ) {
					$new_img_path = $save_data['path'];
				}
			}

			// make sure we have a new image path
			if ( isset( $new_img_path ) ) {
				// resized output
				$new_img_size = getimagesize( $new_img_path );
				$new_img      = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

				return array(
					'url'    => $new_img,
					'width'  => ( isset( $new_img_size[0] ) ? $new_img_size[0] : $width ),
					'height' => ( isset( $new_img_size[1] ) ? $new_img_size[1] : $height )
				);
			}
			return $defaults;
		}
		// default output - without resizing
		return array(
			'url'    => $image_src[0],
			'width'  => $width,
			'height' => $height
		);
	}
}
