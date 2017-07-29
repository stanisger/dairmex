function MfnBuilder(){

	// Page Template --------------------------------------------------
	var mfn_wrapper = jQuery("#mfn-wrapper");
	var wrapper_builder = jQuery("#mfn-builder");
	var wrapper_switch = jQuery("#mfn-meta-page table tr:first-child");
	
	function page_template(dom){
		if( ( dom.val() == 'default' )
		 || ( dom.val() == 'subpage.php' ) ){
			wrapper_builder.show();
			wrapper_switch.show();
		} else {
			wrapper_builder.hide();
			wrapper_switch.hide();
		}
	}
	
	page_template(jQuery("#page_template"));
	
	jQuery("#page_template").change(function(){
		page_template(jQuery(this));
	});
	
	
	var desktop = jQuery('#mfn-desk');
	// sortable --------------------------------------------------
	desktop.sortable({ 
		cancel: ".mfn-item-btn",
		forcePlaceholderSize: true, 
		placeholder: 'placeholder'
	});
	
	
	// available items ----------------------------------------
	var items = {
		'accordion'			: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'blockquote'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],		
		'call_to_action'	: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],		
		'clients'			: [ '1/1' ],
		'code'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'column'			: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'contact_box'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'contact_form'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'content'			: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'divider'			: [ '1/1' ],
		'faq'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'feature_box'		: [ '1/4', '1/3', '1/2' ],
		'image'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'info_box'			: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'latest_posts'		: [ '1/4', '1/3' ],
		'map'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'offer'				: [ '1/1' ],
		'offer_page'		: [ '1/1' ],
		'our_team'			: [ '1/4', '1/3' ],
		'portfolio'			: [ '1/4', '1/3' ],
		'pricing_item'		: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'tabs'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'testimonials'		: [ '1/4', '1/3', '1/2' ],
		'testimonials_page'	: [ '1/1' ],
		'vimeo'				: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ],
		'youtube'			: [ '1/4', '1/3', '1/2', '2/3', '3/4', '1/1' ]
	};	
	
	
	// available classes ------------------------------------------
	var classes = {
		'1/4' : 'mfn-item-1-4',
		'1/3' : 'mfn-item-1-3',
		'1/2' : 'mfn-item-1-2',
		'2/3' : 'mfn-item-2-3',
		'3/4' : 'mfn-item-3-4',
		'1/1' : 'mfn-item-1-1'
	};
	
	
	// increase item size --------------------------------------
	jQuery('.mfn-item-size-inc').click(function(){
		var item = jQuery(this).parents('.mfn-item');
		var item_type = item.find('.mfn-item-type').val();
		var item_sizes = items[item_type];
		
		for( var i = 0; i < item_sizes.length-1; i++ ){
		
			if( ! item.hasClass( classes[item_sizes[i]] ) ) continue;
			
			item
				.removeClass( classes[item_sizes[i]] )
				.addClass( classes[item_sizes[i+1]] )
				.find('.mfn-item-size').val( item_sizes[i+1] );
			
			item.find('.mfn-item-desc').text( item_sizes[i+1] );
	
			break;
		}	
	});
	
	
	// decrease size ----------------------------------------------
	jQuery('.mfn-item-size-dec').click(function(){
		var item = jQuery(this).parents('.mfn-item');
		var item_type = item.find('.mfn-item-type').val();
		var item_sizes = items[item_type];
		
		for( var i = 1; i < item_sizes.length; i++ ){
			
			if( ! item.hasClass( classes[item_sizes[i]] ) ) continue;
			
			item
				.removeClass( classes[item_sizes[i]] )
				.addClass( classes[item_sizes[i-1]] )
				.find('.mfn-item-size').val( item_sizes[i-1]);
			
			item.find('.mfn-item-desc').text( item_sizes[i-1] );
			
			break;
		}		
	});
	
	
	// add item ----------------------------------------------------
	jQuery('.mfn-add-btn').click(function(){
		var item = jQuery(this).siblings('#mfn-add-select').val();
		var clone = jQuery('#mfn-items').find('div.mfn-item-'+ item ).clone(true);
	
		clone
			.hide()
			.find('.mfn-item-content input').each(function() {
				jQuery(this).attr('name',jQuery(this).attr('class')+'[]');
			});
	
		desktop.append(clone).find(".mfn-item").fadeIn(500);
	});
	
	
	// delete item ----------------------------------------------------
	jQuery('.mfn-item-delete').click(function(){
		var item = jQuery(this).parents('.mfn-item');
		
		jQuery.confirm({
			'title'		: 'Delete Confirmation',
			'message'	: 'You are about to delete this item. <br />It cannot be restored at a later time! Continue?',
			'buttons'	: {
				'Yes'	: {
					'class'	: 'blue',
					'action': function(){
						item.fadeOut(500,function(){jQuery(this).remove();});
					}
				},
				'No'	: {
					'class'	: 'gray',
					'action': function(){}
				}
			}
		});
		
	});
	
	
	var source_item = '';
	
	// popup - edit item ------------------------------------------
	jQuery('.mfn-item-edit').click(function(){
		jQuery('#mfn-content, .form-table').fadeOut(50);
		source_item = jQuery(this).parents('.mfn-item');
		var clone_meta = source_item.find('.mfn-item-meta').clone(true);
	
		jQuery('#mfn-popup')
			.append(clone_meta)
			.fadeIn(500);
		
		source_item.find('.mfn-item-meta').remove();
	});
	
	// popup - close ----------------------------------------------
	jQuery('#mfn-popup .mfn-popup-close, #mfn-popup .mfn-popup-save').click(function(){
		jQuery('#mfn-content, .form-table').fadeIn(500);
		var popup = jQuery('#mfn-popup');
		var clone = popup.find('.mfn-item-meta').clone(true);

		source_item.append(clone);
		
		popup.fadeOut(50);
	
		setTimeout(function(){
			popup.find('.mfn-item-meta').remove();
		},500);
	});		
		
}
	
jQuery(document).ready(function(){
	var mfn_bldr = new MfnBuilder();
});

// clone fix
(function (original) {
	jQuery.fn.clone = function () {
	    var result = original.apply (this, arguments),
		my_textareas = this.find('textarea, select'),
	    result_textareas = result.find('textarea, select');
	
	    for (var i = 0, l = my_textareas.length; i < l; ++i)
	    	jQuery(result_textareas[i]).val (jQuery(my_textareas[i]).val());
	
	    return result;
	};
}) (jQuery.fn.clone);