<?php
/**
 * @package Tisson
 * @author Muffin group
 * @link http://muffingroup.com
 */

header( 'Content-type: text/css;' );
	
$url = dirname( __FILE__ );
$strpos = strpos( $url, 'wp-content' );
$base = substr( $url, 0, $strpos );

require_once( $base .'wp-load.php' );
?>

/********************** Backgrounds **********************/
	
	.the_content, .content-padding {
		background: <?php mfn_opts_show( 'background-content', '#fff' ) ?>;
	}
	
	.Latest_posts {
		background: <?php mfn_opts_show( 'background-latest-posts', '#fff' ) ?>;
	}
	
	.testimonial {
		background: <?php mfn_opts_show( 'background-testimonials', '#DFE3E5' ) ?>;
	}

	#Footer {
		background-color: <?php mfn_opts_show( 'background-footer', '#2c3e50' ) ?>;			
	}
	

/********************* Colors *********************/

/* Content font */
	body {
		color: <?php mfn_opts_show( 'color-text', '#717e8c' ) ?>;
	}
	
/* Links color */
	a {
		color: <?php mfn_opts_show( 'color-a', '#2c3e50' ) ?>;
	}
	
	a:hover {
		color: <?php mfn_opts_show( 'color-a-hover', '#192938' ) ?>;
	}
	
/* Grey notes */
	.Latest_posts ul li .desc p, .Recent_comments ul li p.author, .wp-caption .wp-caption-text, .post .meta span.sep, .post .meta,
	.post .footer p.tags a, .Twitter ul li > a {
		color: <?php mfn_opts_show( 'color-note', '#98a7a8' ) ?>;
	}
	
/* Strong */
	.Twitter ul li span, .widget_calendar caption, blockquote .author h6,
	.single-portfolio .sp-inside .sp-inside-left dd i {
		color: <?php mfn_opts_show( 'color-bold-note', '#2ecc71' ) ?>;
	}
	
/* Borders */
	.offer-page .offer-right, code, pre, .post, .post .meta, #comments .commentlist > li, #comments .commentlist > li .photo, 
	#comments .commentlist li .comment-body, .widget_calendar td, .widget_calendar th, .single-portfolio .sp-inside .sp-inside-left {
		border-color: <?php mfn_opts_show( 'border-borders', '#dfe3e5' ) ?>;
	}

/* Buttons */
	a.button, input[type="submit"], input[type="reset"], input[type="button"] {
		background-color: <?php mfn_opts_show( 'background-button', '#1BB852' ) ?>;
		color: <?php mfn_opts_show( 'color-button', '#fff' ) ?>;
	}
	
	a:hover.button, input[type="submit"]:hover, input[type="reset"]:hover, input[type="button"]:hover {
		background-color: <?php mfn_opts_show( 'background-button-hover', '#02AE3F' ) ?>;
		color: <?php mfn_opts_show( 'color-button-hover', '#fff' ) ?>;
	}
	
/* Headings font */
	h1, h1 a, h1 a:hover { color: <?php mfn_opts_show( 'color-h1', '#2c3e50' ) ?>; }
	h2, h2 a, h2 a:hover { color: <?php mfn_opts_show( 'color-h2', '#2c3e50' ) ?>; }
	h3, h3 a, h3 a:hover { color: <?php mfn_opts_show( 'color-h3', '#2c3e50' ) ?>; }
	h4, h4 a, h4 a:hover { color: <?php mfn_opts_show( 'color-h4', '#2c3e50' ) ?>; }
	h5, h5 a, h5 a:hover { color: <?php mfn_opts_show( 'color-h5', '#2c3e50' ) ?>; }
	h6, h6 a, h6 a:hover { color: <?php mfn_opts_show( 'color-h6', '#2c3e50' ) ?>; }
	
/* Header */

	#Header .sixteen, #Header #menu ul {
		background: <?php mfn_opts_show( 'background-header', '#2c3e50' ) ?>;
	}
	
	#Header #logo {
		background: <?php mfn_opts_show( 'background-logo', '#fff' ) ?>;
	}
	
	#Top_bar .phone i {
		color: <?php mfn_opts_show( 'color-phone-ico', '#bac4c5' ) ?>;
	}

	#Top_bar .phone a {
		color: <?php mfn_opts_show( 'color-phone-number', '#34495e' ) ?>;
	}
	
	#Top_bar .social li a {
		background: <?php mfn_opts_show( 'background-social', '#bac4c5' ) ?>;
		color: <?php mfn_opts_show( 'color-social', '#dfe3e5' ) ?> !important;
	}
	
	#Top_bar .social li a:hover {
		background: <?php mfn_opts_show( 'background-social-hover', '#2ecc71' ) ?>;
		color: <?php mfn_opts_show( 'color-social-hover', '#fff' ) ?> !important;
	}
	
/* Subheader */
	#Subheader .sixteen .title {
		background: <?php mfn_opts_show( 'background-subheader-title', '#fff' ) ?>;
		color: <?php mfn_opts_show( 'color-subheader-title', '#2c3e50' ) ?>;
	}
	
/* Breadcrumbs */
	ul.breadcrumbs li, ul.breadcrumbs li a {
		color: <?php mfn_opts_show( 'color-breadcrumbs', '#99AEB0' ) ?>;
	}
	
/* Menu */
	#Header #menu > ul > li > a {
		color: <?php mfn_opts_show( 'color-menu-a', '#fff' ) ?>;
	}

	#Header #menu > ul > li.current-menu-item > a,
	#Header #menu > ul > li.current_page_item > a,
	#Header #menu > ul > li.current-menu-ancestor > a,
	#Header #menu > ul > li.current_page_ancestor > a {
		background: <?php mfn_opts_show( 'background-menu-a-active', '#2ecc71' ) ?>;
		color: <?php mfn_opts_show( 'color-menu-a-active', '#fff' ) ?>;		
	}
	
	#Header #menu > ul > li > a:hover,
	#Header #menu > ul > li.hover > a {
		background: <?php mfn_opts_show( 'background-menu-a-active', '#2ecc71' ) ?> !important;
		color: <?php mfn_opts_show( 'color-menu-a-active', '#fff' ) ?>;
	}

	#Header #menu > ul > li ul {
		background: <?php mfn_opts_show( 'background-menu-a-active', '#2ecc71' ) ?>;
	}
		
	#Header #menu > ul > li ul li a {
		color: <?php mfn_opts_show( 'color-submenu-a', '#fff' ) ?>;
		border-color: <?php mfn_opts_show( 'border-submenu-a', '#39d67c' ) ?>;
	}
	
	#Header #menu > ul > li ul li a:hover, 
	#Header #menu > ul > li ul li.hover > a {
		background: <?php mfn_opts_show( 'background-submenu-a-hover', '#27BC66' ) ?> !important;
		color: <?php mfn_opts_show( 'color-submenu-a-hover', '#fff' ) ?> !important;
	}

/* Info Box */	
	.info_box { 
		background: <?php mfn_opts_show( 'background-info-box', '#2ecc71' ) ?>;
		color: <?php mfn_opts_show( 'color-info-box', '#fff' ) ?>;
	}
	.info_box h4 {
		color: <?php mfn_opts_show( 'color-info-box-heading', '#fff' ) ?>;
	}
	
/* Captions mask */
	.wp-caption .mask, .da-thumbs li a div,
	.gallery .gallery-item {
		background-color: <?php hex2rgba( mfn_opts_get( 'background-portfolio-overlay', '#2084C6' ), 0.8, true ) ?>;
	}

/* Portfolio */
	.da-thumbs li a div {
		background-color: <?php hex2rgba( mfn_opts_get( 'background-portfolio-overlay', '#2084C6' ), 0.8, true ) ?>;
	}
	.Projects_header .categories ul li a:hover, .Projects_header .categories ul li.current-cat a {
		background: <?php mfn_opts_show( 'background-portfolio-category-active', '#31be63' ) ?>;
	}
	
/* Get in touch */
	.get_in_touch {
		background: <?php mfn_opts_show( 'background-contact-box', '#DFE3E5' ) ?>;
	}
	
/* Recent works */
	.recent_works {
		background: <?php mfn_opts_show( 'background-recent-works', '#2c3e50' ) ?>;
	}
	.recent_works .header h3 {
		color: <?php mfn_opts_show( 'color-recent-works-header', '#fff' ) ?>;
	}
	.recent_works .desc {
		color: <?php mfn_opts_show( 'color-recent-works', '#2abd68' ) ?>;
	}
	
/* Call to action */
	.call_to_action .inner-padding {
		background-color: <?php hex2rgba( mfn_opts_get( 'background-call-to-action', '#2084C6' ), 0.85, true ) ?>;
	}
	.call_to_action h4 {
		color: <?php mfn_opts_show( 'color-call-to-action', '#fff' ) ?>;
	} 
	.call_to_action h4 span {
		color: <?php mfn_opts_show( 'color-call-to-action-highlight', '#BAEFF8' ) ?>;
	}
	
/* Team */
	.team h4 {
		color: <?php mfn_opts_show( 'color-our-team-title', '#2ecc71' ) ?>;
	}
	
/* Our clients slider */
	.Our_clients_slider {
		background: <?php mfn_opts_show( 'background-clients-slider', '#c9d0d2' ) ?>;
	}
	
/* Faq & Accordion & Tabs */
	.accordion .question h5,.faq .question h5 {
		background: <?php mfn_opts_show( 'background-accordion-title', '#2ecc71' ) ?>;
		color: <?php mfn_opts_show( 'color-accordion-title', '#fff' ) ?>;
	}
	.faq .active h5, .accordion .active h5 {
		background: <?php mfn_opts_show( 'background-accordion-title', '#2ecc71' ) ?>;
		color: <?php mfn_opts_show( 'color-accordion-title', '#fff' ) ?>;
	}
	.accordion .answer, .faq .answer {
		background: <?php mfn_opts_show( 'background-accordion-text', '#2abd68' ) ?>;
		color: <?php mfn_opts_show( 'color-accordion-text', '#fff' ) ?>;
	}
	
	.ui-tabs .ui-tabs-nav li a {
		background: <?php mfn_opts_show( 'background-tabs-title', '#bac4c5' ) ?>;
		color: <?php mfn_opts_show( 'color-tabs-title', '#2c3e50' ) ?>;
	}
	.ui-tabs .ui-tabs-nav li.ui-state-active a {
		background: <?php mfn_opts_show( 'background-tabs-title-active', '#fff' ) ?>;
		color: <?php mfn_opts_show( 'color-tabs-title-active', '#2ecc71' ) ?>;
	}
	.ui-tabs .ui-tabs-panel {
		background: <?php mfn_opts_show( 'background-tabs-content', '#fff' ) ?>;
		color: <?php mfn_opts_show( 'color-tabs-content', '#717E8C' ) ?>;
	}
	
/* Pricing box */
	.pricing-box {
		border-color: <?php mfn_opts_show( 'border-pricing', '#2ecc71' ) ?>;
		background: <?php mfn_opts_show( 'background-pricing', '#577899' ) ?>;
	}
	
	.pricing-box, .pricing-box h3,
	.pricing-box .plan-header .price sup.period {
		color: <?php mfn_opts_show( 'color-pricing', '#fff' ) ?>;
	}

	.pricing-box .plan-header .price {
		color: <?php mfn_opts_show( 'color-pricing-price', '#2ecc71' ) ?>;
	}
	
	.pricing-box-featured {
		background: <?php mfn_opts_show( 'background-pricing-featured', '#24609b' ) ?>;
	}
	
/* Pager */
	.pager a.page {
		color: <?php mfn_opts_show( 'color-pager-link', '#b5bfc0' ) ?>;
	}
	.pager a.active {
		color: <?php mfn_opts_show( 'color-pager-link-active', '#04a448' ) ?>;
	}

/* Posts */
	.post h3 a, .post .meta a {
		color: <?php mfn_opts_show( 'color-blog-title', '#2ecc71' ) ?>;
	}

/* widget_archive  */
	.widget_archive {
		background: <?php mfn_opts_show( 'background-widget-archives', '#2ecc71' ) ?>;
	}
	.widget_archive h3,
	.widget_archive li a  {
		color: <?php mfn_opts_show( 'color-widget-archives', '#fff' ) ?>;
	}
	.widget_archive li a:hover {
		color: <?php mfn_opts_show( 'color-widget-archives-hover', '#2C3E50' ) ?>;
	}
	
/* widget_mfn_menu, widget_categories */
	.widget_mfn_menu, .widget_categories {
		background: <?php mfn_opts_show( 'background-widget-menu', '#2c3e50' ) ?>;
	}
	.widget_mfn_menu h3, .widget_categories h3,
	.widget_mfn_menu li a, .widget_categories li a {
		color: <?php mfn_opts_show( 'color-widget-menu', '#fff' ) ?>;
	}
	.widget_mfn_menu li a i.icon-angle-right, .widget_mfn_menu li.current_page_item a, .widget_mfn_menu li a:hover, .widget_categories li a:hover, .widget_categories li.current-cat a {
		color: <?php mfn_opts_show( 'color-widget-menu-hover', '#2ecc71' ) ?>;
	}

/* Footer headers and text */
	#Footer,
	#Footer .Recent_posts ul li .desc p, #Footer .Recent_comments ul li p.author, #Footer .Twitter ul li > a  {
		color: <?php mfn_opts_show( 'color-footer', '#dfe3e5' ) ?>;
	}

	#Footer a { 
		color: <?php mfn_opts_show( 'color-footer-link', '#2ecc71' ) ?>;
	}

	#Footer a:hover { 
		color: <?php mfn_opts_show( 'color-footer-link-hover', '#26ec7a' ) ?>;
	}
	
	#Footer h1, #Footer h1 a, #Footer h1 a:hover,
	#Footer h2, #Footer h2 a, #Footer h2 a:hover,
	#Footer h3, #Footer h3 a, #Footer h3 a:hover,
	#Footer h4, #Footer h4 a, #Footer h4 a:hover,
	#Footer h5, #Footer h5 a, #Footer h5 a:hover,
	#Footer h6, #Footer h6 a, #Footer h6 a:hover,
	#Footer .Twitter ul li span {
		color: <?php mfn_opts_show( 'color-footer-heading', '#fff' ) ?>;
	}
	
	#Footer aside > h4 {
		color: <?php mfn_opts_show( 'color-footer-widget-title', '#2ecc71' ) ?>;
	}
	
	#Footer .copyrights p {
		color: <?php mfn_opts_show( 'color-footer-copyrights', '#61727b' ) ?>;
	}
	
	#Footer .social li a {
		background: <?php mfn_opts_show( 'background-footer-social', '#61727b' ) ?>;
		color: <?php mfn_opts_show( 'color-footer-social', '#2c3e50' ) ?> !important;
	}
	
	#Footer .social li a:hover {
		background: <?php mfn_opts_show( 'background-footer-social-hover', '#2ecc71' ) ?>;
		color: <?php mfn_opts_show( 'color-footer-social-hover', '#fff' ) ?> !important;
	}
