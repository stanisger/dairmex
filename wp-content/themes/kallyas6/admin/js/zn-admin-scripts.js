"use strict";
(function ($)
{ /*global $, jQuery*/

$.ZnHtml = function ()
{
	// Here we can set some global variables if needed
	this.scope = ( $('#page_builder').length > 0 ) ? $('#page_builder') : $(document);
	//activate the plugin
	this.zinit();
};

$.ZnHtml.prototype =
{
	zinit: function ()
	{
		var fw = this;

		// Add actions that won't work in ajax calls
		fw.addactions();
		// Add actions that will work in ajax calls
		fw.refresh_events();
	},

	refresh_events : function (content)
	{
		var fw = this;
		// Color picker
		fw.enable_color_picker(content);
		// Date picker
		fw.enable_date_picker(content);
		// Enable timepicker
		fw.enable_time_picker(content);
		// Enable icon picker modal
		fw.launch_modal(content);
		// Enable the icon list functionality
		fw.icon_list(content);
		// Enable sortable function -- Used in group option
		fw.create_sortable(content);
		// Enable footer widgets option
		fw.enable_footer_widget_layouts(content);
		// Enable group edit
		// fw.enable_group_edit( content );
		// Enable group delete
		fw.enable_group_delete(content);
		// Enable group add
		fw.enable_group_add(content);
		// Enable cloning
		fw.clone_el(content);
		// Enable dependencies
		fw.dependencies(content);
	},

	// Adds actions that won't work in Ajax calls
	addactions : function ()
	{
		var fw = this;

		fw.scope.on('ZnNewContent', function (e)
		{
			fw.refresh_events(e.content);
		});

		// Runs when a sortable group edit button is clicked
		// fw.open_pb_edit();
		// Runs when a sortable group close button is clicked
		// fw.close_pb_edit();
		// Enables the functionality for the admin menu
		fw.enable_admin_menu();
	},

	/* Enabled TinyMCE when a group is opened */
	enable_tinymce : function (scope)
	{
		var length = (scope) ? scope.find('.zn_tinymce').length : $('.zn_tinymce').length;
		var elements = (scope) ? scope.find('.zn_tinymce') : $('.zn_tinymce');
		if (length > 0) {
			for (var i = 0; i < length; i++) {
				var id = elements[i].id, object = $(elements[i]);
				// Init Quicktag
				if (_.isUndefined(tinyMCEPreInit.qtInit[id])) {
					window.tinyMCEPreInit.qtInit[id] = _.extend({}, window.tinyMCEPreInit.qtInit[wpActiveEditor], {id: id});
					QTags(tinyMCEPreInit.qtInit[id]);
					QTags._buttonsInit();
				}

				// Init tinymce
				if (window.tinyMCEPreInit && window.tinyMCEPreInit.mceInit[wpActiveEditor] && !window.tinyMCEPreInit.mceInit[id]) {
					window.tinyMCEPreInit.mceInit[id] = _.extend({}, window.tinyMCEPreInit.mceInit[wpActiveEditor], {
						id: id
					});
					window.tinyMCE.execCommand('mceAddEditor', true, id);
					wpActiveEditor = id;
				}
				else {
					var content = tinymce.get(id).getContent();
					window.tinyMCE.execCommand('mceRemoveEditor', true, id);
					window.tinyMCE.execCommand('mceAddEditor', true, id);
					tinymce.get(id).setContent(content);
					wpActiveEditor = id;
				}
			}
		}
	},

	/* Enable color picker for inputs */
	enable_color_picker : function (scope)
	{
		var element = (scope) ? scope.find('.zn_colorpicker') : $('.zn_colorpicker');
		if (!element.length) {
			return false;
		}
		element.wpColorPicker();
	},

	/* Enable date picker for inputs */
	enable_date_picker : function (scope)
	{
		var element = (scope) ? scope.find('.zn_date_picker') : $('.zn_date_picker');
		element.datepicker({
			dateFormat: "yy-mm-dd"
		}).datepicker('widget').wrap('<div class="ll-skin-nigran"/>');
	},

	/* Enable date picker for inputs */
	enable_time_picker : function (scope)
	{
		var element = (scope) ? scope.find('.zn_time_picker') : $('.zn_time_picker');
		element.timepicker({
			'timeFormat': 'H:i'
		});
	},

	// Launch modals
	launch_modal : function (scope)
	{
		var fw = this, element = (scope) ? scope.find('.zn_modal_trigger') : $('.zn_modal_trigger');
		element.znmodal();
	},

	// Launch icon list
	icon_list : function (scope)
	{
		var fw = this, element = (scope) ? scope.find('.zn_icon_list_holder li a') : $('.zn_icon_list_holder li a');

		$(element).click(function ()
		{
			var icon = $(this).html(), modal_id = $(this).closest('.zn-modal-form').attr('id'), opts_container = $('.icon_holder_' + modal_id), image_container = opts_container.find('.zn-image-holder');

			opts_container.find('.logo_upload_input').val(icon).trigger('change');
			opts_container.closest('.zn_icon_op_container').find('.zicon_active').removeClass('zicon_active');

			// Add the icon to the icon container
			$(image_container).html('');
			$(image_container).html('<ul class="zn_icon_list_holder"><li class="' + icon + '"><a></a></li></ul><a class="zn-remove-icon" href="#">remove</a>');

			$.ZnModal.openInstance[0].close();
		});

		$(document).on('click', '.zn-remove-icon', function (e)
		{
			$(this).closest('.zn-option').find('.logo_upload_input').val('');
			$(this).parent().html('Nothing selected...');
			e.preventDefault();
		});
	},

	// Adds functionality for the jQuery sortable in group options
	create_sortable : function (scope)
	{
		var fw = this, element = (scope) ? scope.find('.zn_accordion') : $('.zn_accordion');

		if (!element.length) {
			return false;
		}

		element.find('ul').each(function ()
		{
			var id = $(this).attr('id');

			$('.zn_sortable').sortable({
				forcePlaceholderSize: false, placeholder: 'placeholder', opacity: 0.6, handle: '.zn_slide_header',

				start: function (event, ui)
				{
					var el_width = ui.item.width();
					var el_height = ui.item.height();
					$('.placeholder')
						.width(el_width - 12)
						.height(el_height);
				},

				update: function ()
				{
					$(this).zn_sortable_order();
				}
			});
		});
	},

	// Enables the admin menu tabs functionality
	enable_admin_menu : function ()
	{
		// Activates up the first menu page
		$('#zn-nav li a').removeClass('active'); // Remove all active
		$('#zn-nav ul > li:first-child > a + ul > li:first-child > a').addClass('active');
		$('#zn-nav ul > li:first-child > a + ul').fadeIn();

		// Add functionality for the menu tabs
		$('#zn-nav li a').click(function (e)
		{
			var is_parent = $(this).parent('.parent').length ? true : false, page = is_parent ? $(this).next('ul').find('a.normal').attr('href') : $(this).attr('href');

			$('#zn-nav li a').removeClass('active'); // Remove old active

			if (is_parent) {
				// close previously opened tab menu
				$('#zn-nav .parent ul').not($(this).closest('.parent').children('ul')).slideUp();

				$(this).next('ul').slideDown();
				$(this).next('ul').find('a.normal:first').addClass('active');
			}
			else {
				$(this).addClass('active'); // Add active class to current menu tab
				$('#zn-nav .parent ul').not($(this).closest('.parent').children('ul')).slideUp();
			}

			$('.zn_page').hide(); // Hide old page
			$(page).fadeIn(100); // Show the active page
			e.preventDefault();
		});

		$('.zn_page:first').fadeIn('100'); // Show first page
	},

	// Enable footer widgets option
	enable_footer_widget_layouts: function (scope)
	{
		var fw = this,
			element = (scope) ? scope.find('.zn_mp') : $('.zn_mp'),
			widget_columns = (scope) ? scope.find('.zn_mp .zn_nop ul li') : $('.zn_mp .zn_nop ul li'),
			widget_columns_styles = (scope) ? scope.find('.zn_mp .zn_position_var_options ul li') : $('.zn_mp .zn_position_var_options ul li');

		if (!element.length) {
			return false;
		}

		/* Columns numbers */
		widget_columns.on('click', function (e)
		{
			e.preventDefault();

			var val = $(this).html(),
				container = $(this).closest('.zn_mp'),
				json = container.find('.zn_all_options').html(),
				all_styles = $.parseJSON(json),
				divs = container.find('.zn_positions_display'),
				new_value = {},
				i;

			/* Add active class to current option*/
			$(this).closest('.zn_nop').children('input').attr("value", val);
			/* ADD ATTRIBUTE FOR NUMBER OF COLUMNS*/
			container.find('.zn_positions .zn_widgets_positions').attr("data-columns", val);
			new_value[val] = [all_styles[val][0]];
			/* UPDATE INPUT VALUE BASED ON SELECTION*/
			container.find('.zn_positions .zn_widgets_positions').attr("value", JSON.stringify(new_value));
			$(this).closest('.zn_nop').find('li').removeClass('active');
			$(this).addClass('active');
			/* Hide the extra divs*/
			divs.children().removeClass('hidden');
			divs.children().slice(val).addClass('hidden');
			for (i = 0; i < all_styles[val][0].length; i++) {
				container.find('.zn_position:nth-child(' + (i + 1) + ')').attr("class", "zn_position zn-grid-" + all_styles[val][0][i] + "");
			}

			/* Show the proper styles*/
			container.find('.zn_position_var_options .zn_number_list').html('');

			for (i = 0; i < all_styles[val].length; i++) {
				var css = '';
				if (i == 0) {
					css = 'class="active"';
				}
				container.find('.zn_position_var_options .zn_number_list').append('<li ' + css + '>' + (i + 1) + '</li>');
			}

		});

		/* Columns styles */
		element.on('click', '.zn_position_var_options ul li', function (e)
		{
			e.preventDefault();

			var val = $(this).html(), /* GET SELECTED MODULE VARIATION*/
				container = $(this).closest('.zn_mp'), divs = container.find('.zn_positions_display'), /* get option top parent*/
				all_val = container.find('.zn_positions .zn_widgets_positions').attr("data-columns"), /* GET THE SELECTED NUMBER OF COLUMNS*/
				json = container.find('.zn_all_options').html(), /* GET ALL POSSIBLE COMBINATIONS*/
				all_styles = $.parseJSON(json), new_value = {};
			/* CREATE NEW JSON ARRAY TO POPULATE THE INPUT*/

			/* UPDATE THE INPUT WITH SELECTED COMBINATION*/
			new_value[all_val] = [all_styles[all_val][(val - 1)]];

			$(this).closest('.zn_positions').children('input').val(JSON.stringify(new_value));
			$(this).closest('.zn_number_list').find('li').removeClass('active');
			$(this).addClass('active');
			/* Hide the extra divs*/
			divs.children().removeClass('hidden');
			divs.children().slice(all_val).addClass('hidden');
			for (var i = 0; i < all_styles[all_val][(val - 1)].length; i++) {
				container.find('.zn_position:nth-child(' + (i + 1) + ')').attr("class", "zn_position zn-grid-" + all_styles[all_val][(val - 1)][i] + "");
			}
		});
	},

	enable_group_delete: function (scope)
	{
		var fw = this, element = (scope) ? scope.find('.zn_slide_delete_button') : $('.zn_slide_delete_button');

		if (!element.length) {
			return false;
		}

		element.on('click', function (e) { /* We will pass this value to the function that set's the input names*/
			var el = $(this), containing_ul = $(this).closest('ul'), callback = function ()
			{
				/* Remove the containing li*/
				el.closest('li').remove();
				/* Recalculate the input's names*/
				$(containing_ul).zn_sortable_order();
			};
			new $.ZnModalConfirm('Are you sure you wish to delete this ?', 'No', 'Yes', callback);
			e.preventDefault();
		});
	},


	clone_el : function(scope){

		var fw = this,
			element = (scope) ? scope.find('.zn_slide_clone_button') : $('.zn_slide_clone_button');

		$(element).click(function(e) {

			e.preventDefault();

			// GET THE ELEMENT TO BE ADDED
			var container = $(this).closest('.zn_dynamic_list_container, .zn_normal_group').first(), // Container
				to_be_cloned = $(this).closest('.zn_group');

				// DISABLE TIYMCE AND REPLACE TINYMCE IDS
				to_be_cloned.find( '.zn_tinymce' ).each(function(){
					var id = $(this).attr('id');
					window.tinyMCE.execCommand( 'mceRemoveEditor', true, id );
				});

				// Repare textarea
				to_be_cloned.find( 'textarea' ).each(function(){
					var textarea_content = $(this).val();
					$(this).html( textarea_content );
				});

				var cloned_data = to_be_cloned.clone(), // Cloned data
					new_content = $(cloned_data);

				// Activate the editors again
				to_be_cloned.find( '.zn_tinymce' ).each(function(){
					var id = $(this).attr('id');
					window.tinyMCE.execCommand( 'mceAddEditor', true, id );
				});

				//console.log( cloned_data );

			// MAKE HIDDEN INPUTS AVAILABLE AGAIN
			// CHECK THE UNLIMITED HEADERS FOR THIS
			// new_content.find('.zn_class_text').children('input[type="hidden"]').attr( 'type', 'text' ).next(' div.disabled').remove();

			// Create an event for new content received
			fw.scope.trigger({type: "ZnNewContent",content : new_content});
			fw.repare_modals_ids(new_content);
			container.append(new_content).zn_sortable_order();
			
		});
	},

	// REPLACE THE MODAL IDS AND HREF SO THAT THEY WILL POINT CORRECTLY
	repare_modals_ids : function(el){

		// REPARE MODAL TRIGGERS
		el.find('.zn_modal_trigger').each(function(){
			var id = $(this).attr('href') + (new Date).getTime();
			el.find($(this).attr('href')).attr('id', id.replace('#',''));
			$(this).attr('href', id);
		});

		// Remove quicktags toolbar
		el.find('.quicktags-toolbar').remove();

		// REPARE TINYMCE's ID's
		el.find( '.zn_tinymce' ).each(function(){
			var old_id = $(this).attr('id'), // OLD id
				new_id = old_id + (new Date).getTime(), // New id
				replace_string = new RegExp(old_id,"g"), // Replace RegEx
				old_content = $(this).closest('.zn_opt_type_visual_editor'), // Get the old content object
				old_content_html = old_content.html(), // Get the old content HTML
				new_content = old_content_html.replace(replace_string,new_id); // Replace all editor id's to new one

			// Add content back
			old_content.html( new_content );
		});

	},


	enable_group_add: function (scope)
	{

		var fw = this, element = (scope) ? scope.find('.zn_slide_add_button') : $('.zn_slide_add_button');

		if (!element.length) {
			return false;
		}

		element.on('click', function (e)
		{
			e.preventDefault();

			// Don't add if the button is inactive
			if (jQuery(this).hasClass('zn_inactive')) {
				return false;
			}

			var this_button = jQuery(this);
			jQuery(this_button).addClass('zn_inactive zn-gray'); // Disable button
			jQuery(this_button).append('<span class="zn_ajax_loading"></span>');
			/* Add loading icon !*/

			// This will run on pagebuilder edit pages
			if ($(this).parents('.zn-dynamic-edit-mode').length == 0 && $(this).parents('.zn_options_container').length == 0 && jQuery(this).parents('.zn_meta_boxzn_dynamic_list').length > 0) {

				var slidesContainer = $(this).parents('.zn_page_area').children('ul , ul.zn_dynamic_list_container'),
					/* Get the container of all elements where we will append the new element*/
					zn_add_type = jQuery(this).parents('.zn_pb_area_name').children('.zn_add_type').html(),
					zn_pb_area = jQuery(this).attr("data-pbarea");

			}
			// This will run on non pagebuilder options
			else {

				var slidesContainer = $(this).parent().children('ul , ul.zn_dynamic_list_container'),
					/* Get the container of all elements where we will append the new element*/
					zn_add_type = jQuery(this).parent().children('.zn_add_type').html(),
					zn_pb_area = '';

			}

			var nonce = $('#zn_security').val(),
				element_type = 'element_type=' + zn_add_type + '&pb_area=' + zn_pb_area,
				data = {
					type: 'add_element', action: 'zn_ajax_post_action', zn_security: nonce, data: element_type
				};
			$('.zn_ajax_loading').fadeIn();

			$.post(ajaxurl, data, function (response)
			{
				var success = $('.zn-save-popup'),
					fail = $('.zn-fail-popup'),
					loading = $('.ajax-loading-img'),
					scope = ( $('#page_builder').length > 0 ) ? $('#page_builder') : $(document);

				loading.fadeOut().removeClass('zn_is_loading');

				var new_content = $(response);
				slidesContainer = slidesContainer.append(new_content).zn_sortable_order();
				scope.trigger({type: "ZnNewContent", content: new_content});

				/*remove the button inactive class*/
				jQuery(this_button).removeClass('zn_inactive zn-gray');
				/* Remove the loading*/
				jQuery(this_button).children('.zn_ajax_loading').remove();

				// If nothing is returned, show error
				if (!response) {
					fail.fadeIn();
				}

				window.setTimeout(function (){
					success.fadeOut();
					fail.fadeOut();
				}, 2000);
				/* Check if has a limit*/

				var limit = jQuery(this_button).attr('data-limit');
				var num_elements = jQuery(this_button).parents('.zn_page_area').children('ul.zn_dynamic_list_container').children().length;

				if (limit <= num_elements) {
					jQuery(this_button).addClass('zn_inactive zn-gray');
				}
			});
			return false;
		});
	},

	// Checks an option dependency
	dependencies : function (scope)
	{
		var fw = this, element = (scope) ? scope.find('[data-dependency]') : $('[data-dependency]');

		// THIS SCRIPT WILL SHOW AN OPTION BASED ON THE DEPENDENCY
		element.each(function () {
			var el = $(this), field = $(this).data('dependency'), values = $(this).data('value'), values = String(values).split(","), option = el.closest('.zn-modal-form').length ? el.closest('.zn-modal-form').find('[data-optionid="' + field + '"]') : $('[data-optionid="' + field + '"]');

			option.each(function () {
				var input = $(this).find('input, select, textarea');

				// This will check the inputs with the same name
				if (input.attr('type') == 'radio') {
					var checkedinput = $(this).find('input:checked');
					var sel_val = checkedinput.val();
				}
				else if (input.attr('type') == 'checkbox') {
					if (input.parent().hasClass('zn_toggle2')) {
						var checkedinput = input.parent().children('input:checked').last();
					}
					else {
						var checkedinput = $(this).find('input:checked');
					}
					var sel_val = checkedinput.val();
				}
				else {
					var sel_val = input.val();
				}

				if ($.inArray(sel_val, values) > -1) {
					el.show();
				}
				else {
					el.hide();
				}

				input.on('change', function () {
					var value = $(this).val();

					if (( $(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox' ) && $(this).is(':checked')) {
						var value = $(this).val();
					}
					else if ($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox') {
						var value = '';
					}

					if ($.inArray(value, values) > -1) {
						el.slideDown();
					}
					else {
						el.slideUp();
					}
				});
			});
		});
	}
};

$(document).on('ready', function ()
{
	$.zn_html = new $.ZnHtml();
});

jQuery(document).ready(function ($)
{
	/* Install dummy data */

	/* save everything */
	$('.zn_install_dummy').on('click', function (e) {
		if ($(this).hasClass('zn_inactive')) {
			return false;
		}

		e.preventDefault();

		var callback = function ()
		{
			var nonce = $('#zn_security').val();

			$('.ajax-loading-img').fadeIn().addClass('zn_is_loading');

			var serializedReturn = $('#zn_form :input[name][name!="zn_security"][name!="of_reset"]').serialize();

			var data = {
				type: 'install_dummy', action: 'zn_ajax_post_action', zn_security: nonce, data: serializedReturn
			};

			$.post(ajaxurl, data, function (response) {
				var znResponse = $('.zn_response');
				znResponse.html('').hide();
				znResponse.append(response);
				document.location.reload(true);
			});
		};
		new $.ZnModalConfirm('Are you sure you want to install the dummy data?', 'No', 'Yes', callback);
	});

	/* Install dummy data */

	/* save everything */
	$('#zn_form').on('click', '.zn_backup_options', function (e)
	{
		e.preventDefault();

		if (jQuery(this).hasClass('zn_inactive')) {
			return false;
		}

		var nonce = $('#zn_security').val(), loading = $('.ajax-loading-img'), bak_list = $('.zn_backup_list'), no_bak = $('.no_backups_text');

		// Show the hourglass
		loading.fadeIn().addClass('zn_is_loading');

		var serializedReturn = $('#zn_form :input[name][name!="zn_security"][name!="of_reset"]').serialize();

		var data = {
			type: 'zn_backup_options', action: 'zn_ajax_post_action', zn_security: nonce, data: serializedReturn
		};

		$.post(ajaxurl, data, function (response)
		{
			new $.ZnModalMessage('Options successfully backed up!');
			bak_list.append('<li><a class="zn_question zn_restore_option" data-backup="' + response + '" original-title="Restore this backup ?" href="#">' + response + '</a><span data-backup="' + response + '" class="zn_question zn_delete_backup zn_delete" original-title="Delete this backup ?">x</span><li>');
			no_bak.remove();
			loading.fadeOut().removeClass('zn_is_loading');
		});

	});

	/* Restore backup everything */
	$('#zn_form').on('click', '.zn_restore_option', function (e)
	{
		e.preventDefault();

		var nonce = $('#zn_security').val(), loading = $('.ajax-loading-img'), restore_options = jQuery(this).data('backup');

		var callback = function ()
		{
			// Show the hourglass
			loading.fadeIn().addClass('zn_is_loading');

			var data = {
				type: 'zn_restore_options', action: 'zn_ajax_post_action', zn_security: nonce, data: restore_options
			};

			$.post(ajaxurl, data, function (response)
			{
				new $.ZnModalMessage('Options successfully restored. The page will now refresh !');
				loading.fadeOut().removeClass('zn_is_loading');
				document.location.reload(true);
			});
		};
		new $.ZnModalConfirm('Are you sure you want to restore this backup?', 'No', 'Yes', callback);
	});

	/* Delete backup  */
	$('#zn_form').on('click', '.zn_delete_backup', function (e)
	{
		e.preventDefault();

		var nonce = $('#zn_security').val(), loading = $('.ajax-loading-img'), el = jQuery(this), restore_options = el.data('backup'), no_bak = $('.no_backups_text');

		var callback = function ()
		{
			// Show the hourglass
			loading.fadeIn().removeClass('zn_is_loading');

			var data = {
				type: 'zn_delete_backup', action: 'zn_ajax_post_action', zn_security: nonce, data: restore_options
			};

			$.post(ajaxurl, data, function (response)
			{
				new $.ZnModalMessage('The backup was successfully deleted!');
				el.parent('li').remove();
				if (el.closest('ul').children().length < 1) {
					no_bak.show();
				}
				loading.fadeOut().removeClass('zn_is_loading');
			});
		};
		new $.ZnModalConfirm('Are you sure you want to delete this backup?', 'No', 'Yes', callback);
	});

	/***********************************************************    Start Dynamic template**********************************************************/

	jQuery(".zn_select_dynamic").on('change', function ()
	{
		var selected_value = jQuery(':selected', this).val();
		var limit = jQuery(this).parents('.zn_pb_area_name').children('a.zn_slide_add_button').attr('data-limit');
		var num_elements = jQuery(this).parents('.zn_page_area').children('ul').children().length;

		if (selected_value == 'Select an element' || limit <= num_elements) {
			jQuery(this).parents('.zn_pb_area_name').children('a.zn_slide_add_button').addClass('zn_inactive zn-gray');
			return false;
		}
		else {
			jQuery(this).parents('.zn_pb_area_name').children('span.zn_add_type').html(selected_value);
			jQuery(this).parents('.zn_pb_area_name').children('a.zn_slide_add_button').removeClass('zn_inactive zn-gray');
		}
	});

	/***********************************************************    Make Dynamic template slides sortable**********************************************************/

	jQuery('.zn_dynamic_accordion').find('ul.zn_dynamic_list_container').each(function ()
	{ /*var id = jQuery(this).attr('id');*/
		jQuery('.zn_dynamic_list_container').sortable({
			forcePlaceholderSize: false,
			/*containment: '.zn_dynamic_list_container',*/
			items: 'li',
			handle: '.zn_dynamic_handle',
			placeholder: 'placeholder left',
			start: function (event, ui)
			{
				var el_width = ui.item.width(),
					el_height = ui.item.height(),
					placeholder = jQuery('.placeholder');
				placeholder.width(el_width - 12);
				placeholder.height(el_height - 12);
			},

			update: function ()
			{
				jQuery(this).zn_sortable_order()
			}
		});
	});
});
})(jQuery);

(function ($){
jQuery.fn.zn_sortable_order = function ()
{
	var baseid = '';
	if (jQuery(this).attr('data-baseid') != undefined) {
		baseid = jQuery(this).attr('data-baseid');
	}
	else {
		baseid = jQuery(this).parents('li.zn_group:first').attr('data-baseid');
	}

	// PREPARE THE BASEID
	var search_baseid = baseid.replace(/\[[\d+]\]/g, '[\\d+]');
	search_baseid = search_baseid.replace(/(\[)/g, '\\[');
	search_baseid = search_baseid.replace(/(\])/g, '\\]');
	var str = '(' + search_baseid + '\\[\\d+\\])', reg = new RegExp(str);

	this.children('li.zn_group').each(function (idx)
	{
		// CHANGE THE BASE ID
		jQuery(this).attr('data-baseid', baseid + '[' + idx + ']');
		jQuery(this).find('[data-baseid]').each(function ()
		{
			jQuery(this).attr('data-baseid', jQuery(this).attr('data-baseid').replace(reg, baseid + '[' + idx + ']'));
		});

		// CHANGE THE INPUT BASE ID's
		var $inp = jQuery(this).find(':input');
		$inp.each(function ()
		{
			this.name = this.name.replace(reg, baseid + '[' + idx + ']');
		})
	});
}
})(jQuery);



//---------------
// Force wp-editor to resize, to prevent Firefox browser from messing around with TinyMCE.
jQuery(window).load(function() {
	forceTinyMceIframeResize();
});
function forceTinyMceIframeResize() {
	jQuery('.mce-tinymce iframe').each(function(i){
		jQuery(this).height(jQuery(this).height()+1);
	});
}

/**
 * Prevent adding a value greater than 99 in the woo_show_products_per_page field
 *
 * @wpk
 * @since v3.6.5
 */
jQuery(function($){
	$('#woo_show_products_per_page').attr('maxLength', 2);
});



/** LOAD EXTRA PLUGINS **/
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a(jQuery)}(function(a){function b(a){if(a.minTime&&(a.minTime=s(a.minTime)),a.maxTime&&(a.maxTime=s(a.maxTime)),a.durationTime&&"function"!=typeof a.durationTime&&(a.durationTime=s(a.durationTime)),a.disableTimeRanges.length>0){for(var b in a.disableTimeRanges)a.disableTimeRanges[b]=[s(a.disableTimeRanges[b][0]),s(a.disableTimeRanges[b][1])];a.disableTimeRanges=a.disableTimeRanges.sort(function(a,b){return a[0]-b[0]});for(var b=a.disableTimeRanges.length-1;b>0;b--)a.disableTimeRanges[b][0]<=a.disableTimeRanges[b-1][1]&&(a.disableTimeRanges[b-1]=[Math.min(a.disableTimeRanges[b][0],a.disableTimeRanges[b-1][0]),Math.max(a.disableTimeRanges[b][1],a.disableTimeRanges[b-1][1])],a.disableTimeRanges.splice(b,1))}return a}function c(b){var c=b.data("timepicker-settings"),f=b.data("timepicker-list");if(f&&f.length&&(f.remove(),b.data("timepicker-list",!1)),c.useSelect){f=a("<select />",{"class":"ui-timepicker-select"});var g=f}else{f=a("<ul />",{"class":"ui-timepicker-list"});var g=a("<div />",{"class":"ui-timepicker-wrapper",tabindex:-1});g.css({display:"none",position:"absolute"}).append(f)}if(c.noneOption)if(c.noneOption===!0&&(c.noneOption=c.useSelect?"Time...":"None"),a.isArray(c.noneOption)){for(var i in c.noneOption)if(parseInt(i,10)===i){var k=d(c.noneOption[i],c.useSelect);f.append(k)}}else{var k=d(c.noneOption,c.useSelect);f.append(k)}c.className&&g.addClass(c.className),null===c.minTime&&null===c.durationTime||!c.showDuration||(g.addClass("ui-timepicker-with-duration"),g.addClass("ui-timepicker-step-"+c.step));var l=c.minTime;"function"==typeof c.durationTime?l=s(c.durationTime()):null!==c.durationTime&&(l=c.durationTime);var n=null!==c.minTime?c.minTime:0,o=null!==c.maxTime?c.maxTime:n+v-1;n>=o&&(o+=v),o===v-1&&-1!==c.timeFormat.indexOf("H")&&(o=v);for(var t=c.disableTimeRanges,u=0,w=t.length,i=n;o>=i;i+=60*c.step){var x=i,z=r(x,c.timeFormat);if(c.useSelect){var A=a("<option />",{value:z});A.text(z)}else{var A=a("<li />");A.data("time",86400>=x?x:x%86400),A.text(z)}if((null!==c.minTime||null!==c.durationTime)&&c.showDuration){var B=q(i-l,c.step);if(c.useSelect)A.text(A.text()+" ("+B+")");else{var C=a("<span />",{"class":"ui-timepicker-duration"});C.text(" ("+B+")"),A.append(C)}}w>u&&(x>=t[u][1]&&(u+=1),t[u]&&x>=t[u][0]&&x<t[u][1]&&(c.useSelect?A.prop("disabled",!0):A.addClass("ui-timepicker-disabled"))),f.append(A)}if(g.data("timepicker-input",b),b.data("timepicker-list",g),c.useSelect)f.val(e(b.val(),c)),f.on("focus",function(){a(this).data("timepicker-input").trigger("showTimepicker")}),f.on("blur",function(){a(this).data("timepicker-input").trigger("hideTimepicker")}),f.on("change",function(){m(b,a(this).val(),"select")}),b.hide().after(f);else{var D=c.appendTo;"string"==typeof D?D=a(D):"function"==typeof D&&(D=D(b)),D.append(g),j(b,f),f.on("click","li",function(){b.off("focus.timepicker"),b.on("focus.timepicker-ie-hack",function(){b.off("focus.timepicker-ie-hack"),b.on("focus.timepicker",y.show)}),h(b)||b[0].focus(),f.find("li").removeClass("ui-timepicker-selected"),a(this).addClass("ui-timepicker-selected"),p(b)&&(b.trigger("hideTimepicker"),g.hide())})}}function d(b,c){var d,e,f;return"object"==typeof b?(d=b.label,e=b.className,f=b.value):"string"==typeof b?d=b:a.error("Invalid noneOption value"),c?a("<option />",{value:f,"class":e,text:d}):a("<li />",{"class":e,text:d}).data("time",f)}function e(b,c){if(a.isNumeric(b)||(b=s(b)),null===b)return null;var d=60*c.step;return r(Math.round(b/d)*d,c.timeFormat)}function f(){return new Date(1970,1,1,0,0,0)}function g(b){var c=a(b.target),d=c.closest(".ui-timepicker-input");0===d.length&&0===c.closest(".ui-timepicker-wrapper").length&&(y.hide(),a(document).unbind(".ui-timepicker"))}function h(a){var b=a.data("timepicker-settings");return(window.navigator.msMaxTouchPoints||"ontouchstart"in document)&&b.disableTouchKeyboard}function i(b,c,d){if(!d&&0!==d)return!1;var e=b.data("timepicker-settings"),f=!1,g=30*e.step;return c.find("li").each(function(b,c){var e=a(c);if("number"==typeof e.data("time")){var h=e.data("time")-d;return Math.abs(h)<g||h==g?(f=e,!1):void 0}}),f}function j(a,b){b.find("li").removeClass("ui-timepicker-selected");var c=s(l(a));if(null!==c){var d=i(a,b,c);if(d){var e=d.offset().top-b.offset().top;(e+d.outerHeight()>b.outerHeight()||0>e)&&b.scrollTop(b.scrollTop()+d.position().top-d.outerHeight()),d.addClass("ui-timepicker-selected")}}}function k(b){if(""!==this.value){var c=a(this);if(c.data("timepicker-list"),!c.is(":focus")||b&&"change"==b.type){var d=s(this.value);if(null===d)return c.trigger("timeFormatError"),void 0;var e=c.data("timepicker-settings"),f=!1;if(null!==e.minTime&&d<e.minTime?f=!0:null!==e.maxTime&&d>e.maxTime&&(f=!0),a.each(e.disableTimeRanges,function(){return d>=this[0]&&d<this[1]?(f=!0,!1):void 0}),e.forceRoundTime){var g=d%(60*e.step);g>=30*e.step?d+=60*e.step-g:d-=g}var h=r(d,e.timeFormat);f?m(c,h,"error")&&c.trigger("timeRangeError"):m(c,h)}}}function l(a){return a.is("input")?a.val():a.data("ui-timepicker-value")}function m(a,b,c){if(a.is("input")){a.val(b);var d=a.data("timepicker-settings");d.useSelect&&a.data("timepicker-list").val(e(b,d))}return a.data("ui-timepicker-value")!=b?(a.data("ui-timepicker-value",b),"select"==c?a.trigger("selectTime").trigger("changeTime").trigger("change"):"error"!=c&&a.trigger("changeTime"),!0):(a.trigger("selectTime"),!1)}function n(b){var c=a(this),d=c.data("timepicker-list");if(!d||!d.is(":visible")){if(40!=b.keyCode)return!0;h(c)||c.focus()}switch(b.keyCode){case 13:return p(c)&&y.hide.apply(this),b.preventDefault(),!1;case 38:var e=d.find(".ui-timepicker-selected");return e.length?e.is(":first-child")||(e.removeClass("ui-timepicker-selected"),e.prev().addClass("ui-timepicker-selected"),e.prev().position().top<e.outerHeight()&&d.scrollTop(d.scrollTop()-e.outerHeight())):(d.find("li").each(function(b,c){return a(c).position().top>0?(e=a(c),!1):void 0}),e.addClass("ui-timepicker-selected")),!1;case 40:return e=d.find(".ui-timepicker-selected"),0===e.length?(d.find("li").each(function(b,c){return a(c).position().top>0?(e=a(c),!1):void 0}),e.addClass("ui-timepicker-selected")):e.is(":last-child")||(e.removeClass("ui-timepicker-selected"),e.next().addClass("ui-timepicker-selected"),e.next().position().top+2*e.outerHeight()>d.outerHeight()&&d.scrollTop(d.scrollTop()+e.outerHeight())),!1;case 27:d.find("li").removeClass("ui-timepicker-selected"),y.hide();break;case 9:y.hide();break;default:return!0}}function o(b){var c=a(this),d=c.data("timepicker-list");if(!d||!d.is(":visible"))return!0;if(!c.data("timepicker-settings").typeaheadHighlight)return d.find("li").removeClass("ui-timepicker-selected"),!0;switch(b.keyCode){case 96:case 97:case 98:case 99:case 100:case 101:case 102:case 103:case 104:case 105:case 48:case 49:case 50:case 51:case 52:case 53:case 54:case 55:case 56:case 57:case 65:case 77:case 80:case 186:case 8:case 46:j(c,d);break;default:return}}function p(a){var b=a.data("timepicker-settings"),c=a.data("timepicker-list"),d=null,e=c.find(".ui-timepicker-selected");if(e.hasClass("ui-timepicker-disabled"))return!1;if(e.length&&(d=e.data("time")),null!==d)if("string"==typeof d)a.val(d);else{var f=r(d,b.timeFormat);m(a,f,"select")}return!0}function q(a,b){var c,d,e=Math.round(a/60),f=[];return 60>e?f=[e,x.mins]:(c=Math.floor(e/60),d=e%60,30==b&&30==d&&(c+=x.decimal+5),f.push(c),f.push(1==c?x.hr:x.hrs),30!=b&&d&&(f.push(d),f.push(x.mins))),f.join(" ")}function r(a,b){if(null!==a){var c=new Date(u.valueOf()+1e3*a);if(!isNaN(c.getTime())){for(var d,e,f="",g=0;g<b.length;g++)switch(e=b.charAt(g)){case"a":f+=c.getHours()>11?x.pm:x.am;break;case"A":f+=c.getHours()>11?x.PM:x.AM;break;case"g":d=c.getHours()%12,f+=0===d?"12":d;break;case"G":f+=c.getHours();break;case"h":d=c.getHours()%12,0!==d&&10>d&&(d="0"+d),f+=0===d?"12":d;break;case"H":d=c.getHours(),a===v&&(d=24),f+=d>9?d:"0"+d;break;case"i":var h=c.getMinutes();f+=h>9?h:"0"+h;break;case"s":a=c.getSeconds(),f+=a>9?a:"0"+a;break;default:f+=e}return f}}}function s(a){if(""===a)return null;if(!a||a+0==a)return a;"object"==typeof a&&(a=a.getHours()+":"+t(a.getMinutes())+":"+t(a.getSeconds())),a=a.toLowerCase(),new Date(0);var b;if(-1===a.indexOf(":")?(b=a.match(/^([0-9]):?([0-5][0-9])?:?([0-5][0-9])?\s*([pa]?)m?$/),b||(b=a.match(/^([0-2][0-9]):?([0-5][0-9])?:?([0-5][0-9])?\s*([pa]?)m?$/))):b=a.match(/^(\d{1,2})(?::([0-5][0-9]))?(?::([0-5][0-9]))?\s*([pa]?)m?$/),!b)return null;var c,d=parseInt(1*b[1],10);c=b[4]?12==d?"p"==b[4]?12:0:d+("p"==b[4]?12:0):d;var e=1*b[2]||0,f=1*b[3]||0;return 3600*c+60*e+f}function t(a){return("0"+a).slice(-2)}var u=f(),v=86400,w={className:null,minTime:null,maxTime:null,durationTime:null,step:30,showDuration:!1,timeFormat:"g:ia",scrollDefaultNow:!1,scrollDefaultTime:!1,selectOnBlur:!1,disableTouchKeyboard:!1,forceRoundTime:!1,appendTo:"body",orientation:"ltr",disableTimeRanges:[],closeOnWindowScroll:!1,typeaheadHighlight:!0,noneOption:!1},x={am:"am",pm:"pm",AM:"AM",PM:"PM",decimal:".",mins:"mins",hr:"hr",hrs:"hrs"},y={init:function(d){return this.each(function(){var e=a(this),f=[];for(var g in w)e.data(g)&&(f[g]=e.data(g));var h=a.extend({},w,f,d);h.lang&&(x=a.extend(x,h.lang)),h=b(h),e.data("timepicker-settings",h),e.addClass("ui-timepicker-input"),h.useSelect?c(e):(e.prop("autocomplete","off"),e.on("click.timepicker focus.timepicker",y.show),e.on("change.timepicker",k),e.on("keydown.timepicker",n),e.on("keyup.timepicker",o),k.call(e.get(0)))})},show:function(b){b&&b.preventDefault();var d=a(this),e=d.data("timepicker-settings");if(e.useSelect)return d.data("timepicker-list").focus(),void 0;h(d)&&d.blur();var f=d.data("timepicker-list");if(!d.prop("readonly")&&(f&&0!==f.length&&"function"!=typeof e.durationTime||(c(d),f=d.data("timepicker-list")),!f.is(":visible"))){y.hide(),f.show();var j={};j.left="rtl"==e.orientation?d.offset().left+d.outerWidth()-f.outerWidth()+parseInt(f.css("marginLeft").replace("px",""),10):d.offset().left+parseInt(f.css("marginLeft").replace("px",""),10),j.top=d.offset().top+d.outerHeight(!0)+f.outerHeight()>a(window).height()+a(window).scrollTop()?d.offset().top-f.outerHeight()+parseInt(f.css("marginTop").replace("px",""),10):d.offset().top+d.outerHeight()+parseInt(f.css("marginTop").replace("px",""),10),f.offset(j);var k=f.find(".ui-timepicker-selected");if(k.length||(l(d)?k=i(d,f,s(l(d))):e.scrollDefaultNow?k=i(d,f,s(new Date)):e.scrollDefaultTime!==!1&&(k=i(d,f,s(e.scrollDefaultTime)))),k&&k.length){var m=f.scrollTop()+k.position().top-k.outerHeight();f.scrollTop(m)}else f.scrollTop(0);return a(document).on("touchstart.ui-timepicker mousedown.ui-timepicker",g),e.closeOnWindowScroll&&a(document).on("scroll.ui-timepicker",g),d.trigger("showTimepicker"),this}},hide:function(){var b=a(this),c=b.data("timepicker-settings");return c&&c.useSelect&&b.blur(),a(".ui-timepicker-wrapper:visible").each(function(){var b=a(this),c=b.data("timepicker-input"),d=c.data("timepicker-settings");d&&d.selectOnBlur&&p(c),b.hide(),c.trigger("hideTimepicker")}),this},option:function(d,e){var f=this,g=f.data("timepicker-settings"),h=f.data("timepicker-list");if("object"==typeof d)g=a.extend(g,d);else if("string"==typeof d&&"undefined"!=typeof e)g[d]=e;else if("string"==typeof d)return g[d];return g=b(g),f.data("timepicker-settings",g),h&&(h.remove(),f.data("timepicker-list",!1)),g.useSelect&&c(f),this},getSecondsFromMidnight:function(){return s(l(this))},getTime:function(a){var b=this,c=l(b);if(!c)return null;a||(a=new Date);var d=s(c),e=new Date(a);return e.setHours(d/3600),e.setMinutes(d%3600/60),e.setSeconds(d%60),e.setMilliseconds(0),e},setTime:function(a){var b=this,c=r(s(a),b.data("timepicker-settings").timeFormat);return m(b,c),b.data("timepicker-list")&&j(b,b.data("timepicker-list")),this},remove:function(){var a=this;if(a.hasClass("ui-timepicker-input")){var b=a.data("timepicker-settings");return a.removeAttr("autocomplete","off"),a.removeClass("ui-timepicker-input"),a.removeData("timepicker-settings"),a.off(".timepicker"),a.data("timepicker-list")&&a.data("timepicker-list").remove(),b.useSelect&&a.show(),a.removeData("timepicker-list"),this}}};a.fn.timepicker=function(b){return this.length?y[b]?this.hasClass("ui-timepicker-input")?y[b].apply(this,Array.prototype.slice.call(arguments,1)):this:"object"!=typeof b&&b?(a.error("Method "+b+" does not exist on jQuery.timepicker"),void 0):y.init.apply(this,arguments):this}});


(function ($) {
	var doc = {
			ready: function () {
				slider.init();
				jQuery('.zn-remove-image').live('click', function () {
					jQuery(this).parents('.zn-option').find('.logo_upload_input').val('');
					jQuery(this).parent().html( ZnAdminLocalize.nothing_selected );
					return false;
				})
			}
		},

		slider = {
			// the following 2 objects would be our backup containers
			// as we will be replacing the default media handlers
			media_send_attachment: null,
			field: false,
			media_close_window: null,
			init: function () {
				// bind the button's click the browse_clicked handler
				$('.zn_upload_image_button').live("click", slider.browse_clicked);
			},
			browse_clicked: function (event) {
				// cancel the event so we won't be navigated to href="#"
				event.preventDefault();

				slider.field = jQuery(this).prev();
				slider.field_alt = jQuery(this).parent().find('.zn_img_alt');
				slider.field_title = jQuery(this).parent().find('.zn_img_title');

				// backup editor objects first
				slider.media_send_attachment = wp.media.editor.send.attachment;
				slider.media_close_window = wp.media.editor.remove;

				// override the objects with our own
				wp.media.editor.send.attachment = slider.media_accept;
				wp.media.editor.remove = slider.media_close;

				// open up the media manager window
				wp.media.editor.open();
			},
			media_accept: function (props, attachment) {
				// this function is called when the media manager sends in media info
				// when the user clicks the "Insert into Post" button
				// this may be called multiple times (one for each selected file)
				// you might be interested in the following:
				// alert(attachment.id); // this stands for the id of the media attachment passed
				// alert(attachment.url); // this is the url of the media attachment passed
				// for now let's log it the console
				// not you can do anything Javascript-ly possible here

				var imgurl, image;
				if (slider.field != false) {

					if (attachment.filename.match(/.jpg$|.jpeg$|.ico$|.png$|.gif$/)) {
						imgurl = attachment.url;
						slider.field.val(imgurl);
						slider.field_alt.val(attachment.alt);
						slider.field_title.val(attachment.title);

						image = '<a href="#" class="zn-remove-image">'+ ZnAdminLocalize.remove_str +'</a><img class="zn_mu_image"	src="' + imgurl + '" alt="" />';

						slider.field.parent().children('.zn-image-holder').html(image);
					}
					else {
						imgurl = attachment.url;
						slider.field.val(imgurl);

						image = '<div class="attachment-preview type-video subtype-mp4 landscape"><img draggable="false" class="icon" src="'+ ZnAdminLocalize.images_url +'/video.png"><div class="filename"><div>' + attachment.filename + '</div></div></div>'

						//image = '<a href="#" class="zn-remove-image">remove</a>Media Selected';
						slider.field.parent().children('.zn-image-holder').html(image);
					}
				}
			},
			media_close: function (id) {
				// this function is called when the media manager wants to close
				// (either close button or after sending the selected items)

				// restore editor objects from backup
				wp.media.editor.send.attachment = slider.media_send_attachment;
				wp.media.editor.remove = slider.media_close_window;

				// nullify the backup objects to free up some memory
				slider.media_send_attachment = null;
				slider.media_close_window = null;

				// trigger the actual remove
				wp.media.editor.remove(id);
			}
		};
	$(document).ready(doc.ready);
})(jQuery);