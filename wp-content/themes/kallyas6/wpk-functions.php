<?php
/**
 * Custom functions
 */

if(! class_exists('WpkZn'))
{
	class WpkZn
	{
		/**
		 * Display the page header
		 *
		 * @param array $znData
		 * @param int   $pageId
		 * @param array $meta_fields
		 */
		public static function displayPageHeader( $znData, $pageId, $meta_fields )
		{
			global $post, $wp_query;
			if ( ! isset( $znData ) || empty( $znData ) ) {
				$znData = get_option( OPTIONS );
			}
			$data = $znData;

			//	Set the default header
			$headerClass = 'zn_def_header_style';

			/*
			 * DOCUMENTATION
			 */
			if ( is_post_type_archive( 'documentation' ) || is_tax( 'documentation_category' ) || 'documentation' == get_post_type() ) {
				if ( ! empty( $data['zn_doc_header_style'] ) ) {
					$headerClass = 'uh_' . $data['zn_doc_header_style'] . ' zn_documentation_page';
				}
				// Display the page header
				self::displayDocumentationPageHeader( $headerClass, $znData, $wp_query, $pageId );
				return;
			}

			/*
			 * Display the page header
			 */

			$isPortfolioPostType = ( 'portfolio' == get_post_type() );

			if ( is_post_type_archive( 'portfolio' ) ) {
				// Use default
//				 $headerClass .= ' IS_POST_TYPE_ARCHIVE_PORTFOLIO';
			}
			//@wpk: #68
			elseif ( $isPortfolioPostType && is_singular() ) {
				if ( ! empty( $meta_fields ) ) {
					if ( isset( $meta_fields['header_area'] ) && ! empty( $meta_fields['header_area'] ) ) {
						$ha = $meta_fields['header_area'];
						if ( isset( $ha[0] ) && ! empty( $ha['0'] ) ) {
							if ( isset( $ha['0']['hm_header_style'] ) && ! empty( $ha['0']['hm_header_style'] ) ) {
								$headerClass = 'uh_' . $ha['0']['hm_header_style'];
							}
						}
                        $pageId = $post->ID;
//						$headerClass .= ' SINGLE_POST_TYPE_PORTFOLIO_ITEM';
					}
				}
			}
			elseif ( is_category() ) {
				$cat = get_the_category();
				if ( $cat && isset( $cat[0]->term_id ) ) {
					$id = $cat[0]->term_id;
					$ch = get_option( 'wpk_zn_select_custom_header_' . $id, false );
					if ( ! empty( $ch ) ) {
						if ( 'zn_def_header_style' != $ch ) {
							$headerClass = 'uh_' . $ch;
						}
					}
//					$headerClass .= ' IS_CATEGORY';
				}
			}
			elseif ( function_exists('is_shop') && is_shop() ) {
				if ( ! empty( $meta_fields ) ) {
					if ( isset( $meta_fields['header_area'] ) && ! empty( $meta_fields['header_area'] ) ) {
						$ha = $meta_fields['header_area'];
						if ( isset( $ha[0] ) && ! empty( $ha['0'] ) ) {
							if ( isset( $ha['0']['hm_header_style'] ) && ! empty( $ha['0']['hm_header_style'] ) ) {
								$headerClass = 'uh_' . $ha['0']['hm_header_style'];
							}
						}
//						$headerClass .= ' IS_SHOP';
					}
				}
			}
			/*
			 * Portfolio category
			 */
			elseif ( $isPortfolioPostType && is_archive() ) {
				global $wp_query;

				$qo = $wp_query->get_queried_object();
				$ch = get_option( 'wpk_zn_select_custom_header_' . $qo->term_id, false );
				if ( ! empty( $ch ) ) {
					$headerClass = $ch;
				}
				if ( 'zn_def_header_style' != $headerClass ) {
					$headerClass = 'uh_' . $ch;
				}
//				$headerClass .= ' IS_ARCHIVE_PORTFOLIO';
			}
			elseif ( is_archive() && (function_exists('is_product_category') && !is_product_category()) ) {
				if ( ! empty( $meta_fields ) ) {
					if ( isset( $meta_fields['header_area'] ) && ! empty( $meta_fields['header_area'] ) ) {
						$ha = $meta_fields['header_area'];
						if ( isset( $ha[0] ) && ! empty( $ha['0'] ) ) {
							if ( isset( $ha['0']['hm_header_style'] ) && ! empty( $ha['0']['hm_header_style'] ) ) {
								$headerClass = 'uh_' . $ha['0']['hm_header_style'];
							}
						}
					}
//					$headerClass .= ' IS_ARCHIVE';
				}
			}
			elseif ( is_page() ) {
				if ( ! empty( $meta_fields ) ) {
					if ( isset( $meta_fields['header_area'] ) && ! empty( $meta_fields['header_area'] ) ) {
						$ha = $meta_fields['header_area'];
						if ( isset( $ha[0] ) && ! empty( $ha['0'] ) ) {
							if ( isset( $ha['0']['hm_header_style'] ) && ! empty( $ha['0']['hm_header_style'] ) ) {
								$headerClass = 'uh_' . $ha['0']['hm_header_style'];
							}
						}
					}
//					$headerClass .= ' IS_PAGE';
				}
			}
			/*
		 * Product category
		 */
			elseif ( function_exists('is_product_category') && is_product_category() ) {

				global $wp_query;

				$qo = $wp_query->get_queried_object();
				$ch = get_option( 'wpk_zn_select_custom_header_' . $qo->term_id, false );
				if ( ! empty( $ch ) ) {
					$headerClass = $ch;
				}
				if ( 'zn_def_header_style' != $headerClass ) {
					$headerClass = 'uh_' . $ch;
				}
//				$headerClass .= ' THE_CAT_ID';
			}
			else {
				if ( ! empty( $meta_fields ) ) {
					if ( isset( $meta_fields['header_area'] ) && ! empty( $meta_fields['header_area'] ) ) {
						$ha = $meta_fields['header_area'];
						if ( isset( $ha[0] ) && ! empty( $ha['0'] ) ) {
							if ( isset( $ha['0']['hm_header_style'] ) && ! empty( $ha['0']['hm_header_style'] ) ) {
								$headerClass = 'uh_' . $ha['0']['hm_header_style'];
							}
						}
//						$headerClass .= ' ELSE';
					}
				}
			}
			// Display custom headers
			self::displayPageHeaderHelper( $headerClass, $znData, $wp_query, $pageId, $meta_fields );
		}

		private static function displayPageHeaderHelper( $headerClass, array $data, $wp_query, $page_id, $meta_fields )
		{
            // Whether or not this is a custom header
            $customHeader = (isset($meta['header_area'][0]) && !empty($meta['header_area'][0]));

            $style = 'style="';

            $meta  = get_post_meta( $page_id );

            // @since 3.6.9
            // Check if there is provided a custom height
            $height = (isset($data['def_header_custom_height']) && !empty($data['def_header_custom_height'])) ? absint($data['def_header_custom_height']) : '';
            if(! empty($height)){
                $style .= "min-height: {$height}px; height:{$height}px;";
            }
            if ($customHeader && isset( $meta['zn_meta_elements'][0] ) ) {
                $meta = maybe_unserialize( $meta['zn_meta_elements'][0] );
                if ( isset( $meta['header_area'][0] ) && isset( $meta['header_area'][0]['hm_header_height'] ) && ! empty( $meta['header_area'][0]['hm_header_height'] ) ) {
                    $style = 'min-height: ' . absint( $meta['header_area'][0]['hm_header_height'] ) . 'px;';
                }
            }
            $style .= '""';
            ?>
			<div id="page_header" class="<?php echo $headerClass; ?>" <?php echo $style; ?>>
				<div class="bgback"></div>
				<?php
					if ( isset ( $data['def_header_animate'] ) && ! empty ( $data['def_header_animate'] ) ) {
						echo '<div data-images="' . IMAGES_URL . '/" id="sparkles"></div>';
					}
				?>
				<!-- DEFAULT HEADER STYLE -->
				<div class="container">
					<div class="row">
						<div class="span6">
							<?php
                                // Breadcrumbs check

                                // Check Custom options - these have a higher precedence than Theme Options
                                if($customHeader){
                                    if($customHeader && isset($meta['header_area'][0]['hm_header_bread']) &&
                                       ($meta['header_area'][0]['hm_header_bread'] == '1')){
                                        zn_breadcrumbs();
                                    }
                                }
                                // Theme Options
                                else {
                                    if ( isset ( $data['def_header_bread'] ) && ! empty ( $data['def_header_bread'] ) ) {
                                        zn_breadcrumbs();
                                    }
                                }

								// Date check

                                // Check Custom options - these have a higher precedence than Theme Options
                                if($customHeader){
                                    if(isset($meta['header_area'][0]['hm_header_date']) && ($meta['header_area'][0]['hm_header_date'] == '1')){
                                        echo '<span id="current-date">' .
                                             date_i18n( get_option( 'date_format' ), strtotime( date( "l M d, Y" ) ) ) .
                                             '</span>';
                                    }
                                }
                                else {
                                    // Theme Options
                                    if ( isset ( $data['def_header_date'] ) && !empty ( $data['def_header_date'] ) ) {
                                        echo '<span id="current-date">' .
                                             date_i18n( get_option( 'date_format' ), strtotime( date( "l M d, Y" ) ) ) .
                                             '</span>';
                                    }
                                }
							?>
						</div>
						<div class="span6">
							<div class="header-titles">
								<?php
									// Title check

                                    if($customHeader){
                                        if ( isset($meta['header_area'][0]['hm_header_title']) && ! empty ( $meta['header_area'][0]['hm_header_title'] ) )
                                        {
                                            self::displayPageTitle($meta_fields, $data, $wp_query, $page_id);
                                        }
                                    }
                                    else {
                                        if ( isset ( $data['def_header_title'] ) && ! empty ( $data['def_header_title'] ) )
                                        {
                                            self::displayPageTitle($meta_fields, $data, $wp_query, $page_id);
                                        }
                                    }

									// Subtitle check
                                    if($customHeader){
                                        if ( isset ( $meta['header_area'][0]['hm_header_subtitle'] ) && ! empty ( $meta['header_area'][0]['hm_header_subtitle'] ) ) {
                                            self::displayPageSubtitle( $meta_fields, $data );
                                        }
                                    }
                                    else {
                                        if ( isset ( $data['def_header_subtitle'] ) && ! empty ( $data['def_header_subtitle'] ) ) {
                                            self::displayPageSubtitle( $meta_fields, $data );
                                        }
                                    }
								?>
							</div>
						</div>
					</div>
					<!-- end row -->
				</div>
				<div class="zn_header_bottom_style"></div>
			</div>
		<?php }

		private static function displayDocumentationPageHeader( $headerClass = 'zn_def_header_style' )
		{
            $style = 'style="';
            // @since 3.6.9
            // Check if there is provided a custom height
            $height = (isset($data['def_header_custom_height']) && !empty($data['def_header_custom_height'])) ? absint($data['def_header_custom_height']) : '';
            if(! empty($height)){
                $style .= "min-height: {$height}px; height:{$height}px;";
            }
            $style .= '""';
            ?>
			<div id="page_header" class="<?php echo $headerClass; ?> zn_documentation_page" <?php echo $style; ?>>
				<div class="bgback"></div>
				<div data-images="<?php echo IMAGES_URL; ?>/" id="sparkles"></div>
				<div class="container">
					<div class="row">
						<div class="span12">
							<div class="zn_doc_search">
								<form method="get" id="" action="<?php echo home_url(); ?>">
									<label class="screen-reader-text"
										   for="s"/><?php _e( "Search for:", THEMENAME ); ?></label>
									<input type="text" value="" name="s" id="s"
										   placeholder="<?php _e( "Search the Documentation", THEMENAME ); ?>"/>
									<input type="submit" id="searchsubmit" class="btn"
										   value="<?php _e( 'Search', THEMENAME );?>"/>
									<input type="hidden" name="post_type" value="documentation"/>
								</form>
							</div>
						</div>
					</div>
					<!-- end row -->
				</div>
				<div class="zn_header_bottom_style"></div>
			</div><!-- end page_header -->
		<?php }

		/**
		 * Whether or not the sidebar should be considered "active". In other words, whether the sidebar contains any widgets.
		 *
		 * @param int|string $sidebar Index, name, or ID of the dynamic sidebar.
		 *
		 * @since 3.6.5
		 *
		 * @return bool
		 */
		public static function isActiveSidebar( $sidebar )
		{
			$sidebar = strtolower(( is_int( $sidebar ) ) ? "sidebar-$sidebar" : sanitize_title( $sidebar ));
			$sidebars_widgets = wp_get_sidebars_widgets();
			if ( empty( $sidebars_widgets ) ) {
				return false;
			}

			$wpSidebars = get_option('sidebars_widgets');
            if(isset($wpSidebars[$sidebar]) && ! empty($wpSidebars[$sidebar])){
                return true;
            }

			global $wp_registered_sidebars;
			foreach ( (array) $wp_registered_sidebars as $index => $sidebarArray ) {
				$sn = strtolower(sanitize_title($sidebarArray['name']));
				if($sn == $sidebar) {
					$sidebarID = $sidebarArray['id'];
					if ( isset( $wpSidebars[ $sidebarID ] ) && ! empty( $wpSidebars[ $sidebarID ] ) ) {
						return true;
					}
					break;
				}
			}
			return false;
		}

		/**
		 * Retrieve the Category ID from a WP Category Object. Should be used in array_map context
		 *
		 * @param object $catObj The WP Category object
		 *
		 * @return int
		 */
		public static function wpk_extract_cat_id($catObj){
			if(isset($catObj->term_id)){
				return $catObj->term_id;
			}
		}

		/**
		 * Retrieve all product category Ids as an array
		 *
		 * @return array
		 */
		public static function getAllProductCategories(){
			$catArgs = array(
				'taxonomy'     => 'product_cat',
				'orderby'      => 'name',
				'show_count'   => 0,
				'pad_counts'   => 0,
				'hierarchical' => 0,
				'title_li'     => '',
				'hide_empty'   => 1,
			);
			$all_categories = get_categories( $catArgs );
			$allCats = array_map(array(get_class(),'wpk_extract_cat_id'), $all_categories);
			if(empty($allCats)){
				$allCats = array();
			}
			else {
				$allCats = array_values($allCats);
			}
			return $allCats;
		}

        /**
         * Updates the search query to include the Page Builder elements
         *
         * @param $query
         * @return mixed
         */
        public static function updateSearchQuery($query){
            $canSearch = ( ! is_admin() && $query->is_main_query() && is_search() && !empty($query));
            if($canSearch){
                // So we can include the post meta table
                $query->set( 'meta_query', array(
                    'relation' => 'OR',
                    array(
                        'key'     => 'zn_meta_elements',
                        'compare' => 'EXISTS',
                    ),
                ) );
                add_filter( 'posts_where', array(get_class(), 'updateSearchWhere'), 99 , 1);
            }
            return $query;
        }

        /**
         * Include the custom search query in the WHERE clause.
         *
         * @see: WpkZn::updateSearchQuery()
         *
         * @param string $where
         * @return string
         */
        public static function updateSearchWhere($where = ''){
            global $wpdb;

            $where .= " OR ( $wpdb->postmeta.meta_key = 'zn_meta_elements' AND CAST($wpdb->postmeta.meta_value AS CHAR) LIKE '%".get_search_query()."%') ";

            remove_filter( 'posts_where', array(get_class(), 'updateSearchWhere'), 99 );

            return $where;
        }

        public static function displayPageTitle($meta_fields, $data, $wp_query, $page_id)
        {
            if ( isset ( $meta_fields['page_title'] ) && ! empty ( $meta_fields['page_title'] ) ) {
                echo '<h2>' . do_shortcode( stripslashes( $meta_fields['page_title'] ) ) . '</h2>';
            }
            elseif ( is_post_type_archive( 'post' ) || is_home() ) {
                if ( isset ( $data['archive_page_title'] ) && ! empty ( $data['archive_page_title'] ) ) {
                    if ( function_exists( 'icl_t' ) ) {
                        $title = icl_t( THEMENAME, 'Archive Page Title', do_shortcode( stripslashes( $data['archive_page_title'] ) ) );
                    }
                    else {
                        $title = do_shortcode( stripslashes( $data['archive_page_title'] ) );
                    }
                    echo '<h2>' . $title . '</h2>';
                }
            }
            elseif ( is_category() ) {
                echo '<h2>' . single_cat_title( '', false ) . '</h2>';
            }
            elseif ( is_tax( 'product_cat' ) ) {
                $queried_object = $wp_query->get_queried_object();
                echo '<h2>' . $queried_object->name . '</h2>';
            }
            elseif ( is_search() ) {
                echo '<h2>' . __( "Search results for ", THEMENAME ) . '"' . get_search_query() . '"</h2>';
            }
            elseif ( is_day() ) {
                echo '<h2>' . get_the_time( 'd' ) . '</h2>';
            }
            elseif ( is_month() ) {
                echo '<h2>' . get_the_time( 'F' ) . '</h2>';
            }
            elseif ( is_year() ) {
                echo '<h2>' . get_the_time( 'Y' ) . '</h2>';
            }
            elseif ( is_tag() ) {
                echo '<h2>' . __( "Posts tagged ", THEMENAME ) . '"' . single_tag_title( '', false ) . '"</h2>';
            }
            elseif ( is_author() ) {
                global $author;
                if ( isset( $author ) && ! empty( $author ) ) {
                    $userdata = get_userdata( $author );
                    echo '<h2>' . __( "Articles posted by ", THEMENAME ) . $userdata->display_name . '</h2>';
                }
            }
            //@wpk: #68 - Replace "portfolio" with the one set by the user in the permalinks page
            elseif ( is_post_type_archive( 'portfolio' ) ) {
                $queried_object = $wp_query->get_queried_object();
                $menuItem       = $queried_object->name;
                if ( strcasecmp( 'portfolio', $queried_object->name ) == 0 ) {
                    $menuItem = $queried_object->rewrite['slug'];
                }
                echo '<h2>' . $menuItem . '</h2>';
            }
            // portfolio category
            elseif ( 'portfolio' == get_post_type() && is_archive() ) {
                $queried_object = $wp_query->get_queried_object();
                $menuItem       = $queried_object->name;
                echo '<h2>' . $menuItem . '</h2>';
            }
            //@wpk: #68
            elseif ( 'portfolio' == get_post_type() && is_singular() ) {
                echo '<h2>' . get_the_title( get_the_ID() ) . '</h2>';
            }
            else {
                // Default
                echo '<h2>' . get_the_title( $page_id ) . '</h2>';
            }
        }

        public static function displayPageSubtitle($meta_fields, $data)
        {
            if ( isset ( $meta_fields['page_subtitle'] ) && ! empty ( $meta_fields['page_subtitle'] ) ) {
                echo '<h4>' . do_shortcode( stripslashes( $meta_fields['page_subtitle'] ) ) . '</h4>';
            }
            elseif ( is_post_type_archive( 'post' ) || is_home() ) {
                if ( isset ( $data['archive_page_subtitle'] ) && ! empty ( $data['archive_page_subtitle'] ) ) {
                    if ( function_exists( 'icl_t' ) ) {
                        $subtitle = icl_t( THEMENAME, 'Archive Page Subtitle', do_shortcode( stripslashes( $data['archive_page_subtitle'] ) ) );
                    }
                    else {
                        $subtitle = do_shortcode( stripslashes( $data['archive_page_subtitle'] ) );
                    }
                    echo '<h4>' . $subtitle . '</h4>';
                }
            }
        }

        /**
         * This function will return true if the provided $screen matches the file in the URL thus making it safe to
         * load resources in only those pages where they're needed.
         *
         * @param string $screen
         * @param bool   $isFunction If set to true, then $screen will be executed as a function
         * @param array  $args The list of arguments to pass to $screen function if $isFunction is true.
         * @since 3.6.8
         * @return bool
         */
        public static function canLoadResources($screen, $isFunction = false, $args = array()){
            if(! isset($_SERVER['SCRIPT_FILENAME']) || empty($_SERVER['SCRIPT_FILENAME'])){
                return false;
            }
            $crtPath = basename($_SERVER['SCRIPT_FILENAME']);
            if(empty($screen) || empty($crtPath)){
                return false;
            }
            if($isFunction){
                if(! empty($args)){
                    return call_user_func_array($screen, $args);
                }
                else return call_user_func($screen);
            }
            return (strtolower($screen) == strtolower($crtPath));
        }
    }
}

if(! class_exists('WpkZnPagination'))
{
	class WpkZnPagination
	{
		/**
		 * @param \WP_Query $theQuery The reference to the instance of the WP_Query class. Usually retrieved like:
		 *                            $theQuery = new Wp_Query($args);
         * @param int $showMaxPages  The max number of pages to show. -1 to show all
         * @param int $currentPage   The current page to show. Defaults to 1
		 */
		public static function show( $theQuery = null, $showMaxPages = -1, $currentPage = 1)
		{
            if(empty($theQuery)){
                global $wp_query;
                $theQuery = $wp_query;
            }
			$allResults = $theQuery->found_posts;
            if(empty($currentPage)) {
                $currentPage = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : null;
                if(is_null($currentPage)){
                    $currentPage = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
                }
            }
			$showPerPage = (isset($theQuery->query_vars['showposts']) ? (int)$theQuery->query_vars['showposts'] : 4);

			// If no pages || only one page
			if(empty($allResults) || empty($currentPage) || (1 == $allResults)){
				self::showDefault();
				return;
			}

			// Get the number of pages for pagination
			$pages = 1;
            if($showMaxPages < 1) {
                if ( $allResults > $showPerPage ) {
                    $pages = ceil( $allResults / $showPerPage );
                }
            }
            else { $pages = $showMaxPages; }

			if(empty($pages)){
				self::showDefault();
				return;
			}

			// Display pagination
			echo "<div class='pagination'>";
			echo '<ul>';
				self::prevStart($currentPage);
					self::innerPages($pages, $currentPage);
				self::nextEnd($currentPage, $pages);
			echo '</ul>';
			echo '<div class="clear"></div>';
			echo '' . __( 'Page', THEMENAME ) . ' ' . $currentPage . ' ' . __( 'of', THEMENAME ) . ' ' . $pages;
			echo "</div>\n";
		}

		/**
		 * Display the default emty pagination container when there is no pagination
		 */
		public static function showDefault(){
			echo "<div class='pagination'>";
				echo '<ul></ul>';
				echo '<div class="clear"></div>';
				echo __( 'Page', THEMENAME ) . __( '1 of 1', THEMENAME );
			echo "</div>\n";
		}

		/**
		 * Display the first two links: Start & Prev
		 *
		 * @param $paged
		 */
		public static function prevStart($paged){
			if ( 1 == $paged ) {

				echo '<li class="pagination-start"><span class="pagenav">' . __( 'Start', THEMENAME ) . '</span></li>';

				echo '<li class="pagination-prev"><span class="pagenav">' . __( 'Prev', THEMENAME ) . '</span></li>';
			}
			else {

				echo '<li class="pagination-start"><a href="' . get_pagenum_link( 1 ) . '">' . __( 'Start', THEMENAME ) . '</a></li>';

				echo '<li class="pagination-prev"><a href="' . get_pagenum_link( $paged - 1 ) . '">' . __( 'Prev', THEMENAME ) . '</a></li>';
			}
		}

		/**
		 * Display the last two links: Next & End
		 * @param $currentPage
		 * @param $pages
		 */
		public static function nextEnd($currentPage, $pages){
			if ( $currentPage < $pages ) {

				echo '<li class="pagination-next"><a href="' . get_pagenum_link( $currentPage + 1 ) . '">' . __( 'Next', THEMENAME ) . '</a></li>';

				echo '<li class="pagination-end"><a href="' . get_pagenum_link( $pages ) . '">' . __( 'End', THEMENAME ) . '</a></li>';
			}
			else {

				echo '<li class="pagination-next"><span class="pagenav">' . __( 'Next', THEMENAME ) . '</span></li>';

				echo '<li class="pagination-end"><span class="pagenav">' . __( 'End', THEMENAME ) . '</span></li>';
			}
		}

		/**
		 * Display the inner pagination
		 *
		 * @param $pages
		 * @param $currentPage
		 */
		public static function innerPages($pages, $currentPage){
			for ( $i = 1; $i <= $pages; $i++ ) {
				echo ( $currentPage == $i ) ? '<li><span class="pagenav">' . $i . '</span></li>' : '<li><a href="' . get_pagenum_link( $i ) . '">' . $i . '</a></li>';
			}
		}

	}
}
