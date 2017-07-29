function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function mfn_mce_submit() {

	var output;
	var shortcode = document.getElementById('shortcode').value;
	
	switch( shortcode ) {
		case 0:
		case "0":
			tinyMCEPopup.close();
			break;
	
		// ************************* general **********************
		case "blockquote":
			output = "[" + shortcode + " photo=\"\" author=\"\" company=\"\" link=\"\" target=\"_blank\"]" +
				" Insert your content here " +
				"[/" + shortcode + "]";
			break;
			
		case "button":
			output = "[" + shortcode + " title=\"\" link=\"\" target=\"_blank\" size=\"\" color=\"\" class=\"\"]";
			break;

		case "call_to_action":
			output = "[" + shortcode + " image=\"\" title=\"\" btn_title=\"\" btn_link=\"\" class=\"\"]";
			break;
			
		case "contact_box":
			output = "[" + shortcode + " title=\"\" address=\"\" telephone=\"\" fax=\"\" email=\"\" www=\"\"]";
			break;
			
		case "divider":
			output = "[" + shortcode + " height=\"30\" line=\"1\"]";
			break;

		case "image":
			output = "[" + shortcode + " src=\"\" align=\"\" caption=\"\" link=\"\" link_type=\"\" target=\"\" alt=\"\"]";
			break;
			
		case "ico":
			output = "[" + shortcode + " type=\"\"]";
			break;
			
		case "latest_posts":
			output = "[" + shortcode + " title=\"\" count=\"2\"]";
			break;
			
		case "map":
			output = "[" + shortcode + " lat=\"\" lng=\"\" height=\"200\" zoom=\"8\"]";
			break;
			
		case "our_team":
			output = "[" + shortcode + " image=\"\" title=\"\" subtitle=\"\" email=\"\" facebook=\"\" twitter=\"\" linkedin=\"\"]";
			break;
			
		case "portfolio":
			output = "[" + shortcode + " title=\"Latest projects\" size=\"1/1\" type=\"\" link_title=\"\" link=\"\" orderby=\"menu_order\" order=\"ASC\"]";
			break;
			
		case "pricing_item":
			output = "[" + shortcode + " title=\"\" price=\"\" currency=\"\" period=\"\" link_title=\"\" link=\"\" featured=\"\"]" +
				" Insert your content here " +
				"[/" + shortcode + "]";
			break;
			
		case "recent_comments":
			output = "[" + shortcode + " title=\"\" count=\"2\"]";
			break;
			
		case "table":
			output = "<table><thead><tr><th>Column 1 heading</th><th>Column 2 heading</th><th>Column 3 heading</th></tr></thead><tbody><tr><td>Row 1 col 1 content</td><td>Row 1 col 2 content</td><td>Row 1 col 3 content</td></tr><tr><td>Row 2 col 1 content</td><td>Row 2 col 2 content</td><td>Row 2 col 3 content</td></tr></tbody></table>";
			break;	

		case "tabs":
			output = "[" + shortcode + "]" +
				"[tab title=\"Tab 1 title\"] Tab 1 content [/tab]" +
				"[tab title=\"Tab 2 title\"] Tab 2 content [/tab]" +
				"[/" + shortcode + "]";
			break;
			
		case "tab":
			output = "[" + shortcode + " title=\"Tab 1 title\"]" +
				" Insert your tab content here " +
				"[/" + shortcode + "]";
			break;
		
		case "testimonials":
			output = "[" + shortcode + " title=\"\" orderby=\"menu_order\" order=\"ASC\"]";
			break;

		case "vimeo":
			output = "[" + shortcode + " video=\"1084537\" width=\"700\" height=\"400\"]";
			break;
			
		case "youtube":
			output = "[" + shortcode + " video=\"YE7VzlLtp-4\" width=\"700\" height=\"420\"]";
			break;
		
		// ---------------------- pages -----------------------	
		case "clients":
			output = "[" + shortcode + " target=\"\"]";
			break;
			
		case "offer":
			output = "[" + shortcode + " image=\"\" image_position=\"left\" title=\"\" link_title=\"Read more\" link=\"\" alt=\"\" width=\"\" height=\"\"]" +
				" Insert your content here " +
				"[/" + shortcode + "]";
			break;
	
		default:
			output = "[" + shortcode + "] Insert your content here [/" + shortcode + "]";
	}
	

	if (window.tinyMCE) {
		window.tinyMCE.execInstanceCommand('content', 'mceInsertContent',false, output);
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return true;
}