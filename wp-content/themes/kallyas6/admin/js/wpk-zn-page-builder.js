/*
 * @wpk
 *
 * Page Builder related scripts
 */
"use strict";
jQuery(document).ready(function($)
{
	/**
	 * The list of valid sizes
	 *
	 * @type {{four: string, one-third: string, eight: string, two-thirds: string, twelve: string, sixteen: string}}
	 */
	var sizes = {
		'four': '1/4',
		'one-third': '1/3',
		'eight': '1/2',
		'two-thirds': '2/3',
		'twelve': '3/4',
		'sixteen': '1/1'
	};

	var $pageBuilder = $('#page_builder');

	function _increase(_element, sizes){
		var element = _element.parents('.zn_slide'),
			size_input = _element.parents('.zn_slide_header').next('.zn_slide_body').children('.zn_size_input'),
			size_container = _element.parents('.zn_slide_buttons').children('.zn_slide_size'),
			current_size = '',
			is_not_max = false,
			allowed_sizes = _element.parents('.zn_slide_buttons').children('.zn_slide_size').data('sizes'),
			new_sizes = allowed_sizes.split(",");

		for (var i = 0; i < new_sizes.length - 1; i++) {
			if (element.hasClass(new_sizes[i])) {
				current_size = new_sizes[i];
				is_not_max = true;
			}
			if (is_not_max) {
				if (i == new_sizes.length - 2) {
					$(element).removeClass(new_sizes[i]);
					$(element).addClass(new_sizes[i + 1]);
					$(size_container).html(sizes[new_sizes[i + 1]]);
					$(size_input).val(new_sizes[i + 1]);
					$(this).addClass('zn-size-inactive');
					$(this).prev().removeClass('zn-size-inactive');
				}
				else {
					$(element).removeClass(new_sizes[i]);
					$(element).addClass(new_sizes[i + 1]);
					$(size_container).html(sizes[new_sizes[i + 1]]);
					$(size_input).val(new_sizes[i + 1]);
					$(this).prev().removeClass('zn-size-inactive');
				}
				break;
			}
		}
	}
	function _decrease(_element, sizes){
		var element = _element.parents('.zn_slide'),
			size_input = _element.parents('.zn_slide_header').next('.zn_slide_body').children('.zn_size_input'),
			size_container = _element.parents('.zn_slide_buttons').children('.zn_slide_size'),
			current_size = '',
			is_not_max = false,
			allowed_sizes = _element.parents('.zn_slide_buttons').children('.zn_slide_size').data('sizes'),
			new_sizes = allowed_sizes.split(",");

		for (var i = new_sizes.length - 1; i > 0; i--) {
			if (element.hasClass(new_sizes[i])) {
				current_size = new_sizes[i];
				is_not_max = true;
			}
			if (is_not_max) {
				if (i == 1) {
					$(element).removeClass(new_sizes[i]);
					$(element).addClass(new_sizes[i - 1]);
					$(size_container).html(sizes[new_sizes[i - 1]]);
					$(size_input).val(new_sizes[i - 1]);
					$(this).addClass('zn-size-inactive');
					$(this).next().removeClass('zn-size-inactive');
				}
				else {
					$(element).removeClass(new_sizes[i]);
					$(element).addClass(new_sizes[i - 1]);
					$(size_container).html(sizes[new_sizes[i - 1]]);
					$(size_input).val(new_sizes[i - 1]);
					$(this).next().removeClass('zn-size-inactive');
				}
				break;
			}
		}
	}

	/**
	 * Register event listeners for the increase & decrease size buttons for Page Builder elements
	 */
	$pageBuilder.on('click',  $('.zn_dynamic_list_container .zn_slide_increase_button, .zn_dynamic_list_container .zn_slide_decrease_button'), function(e){
		e.preventDefault();
		e.stopPropagation();

		var _element = $(e.target);

		if ($(this).hasClass('zn-size-inactive')) {
			return false;
		}

		if(_element.hasClass('zn_slide_increase_button')){
			_increase(_element, sizes);
			return false;
		}
		else if(_element.hasClass('zn_slide_decrease_button')){
			_decrease(_element, sizes);
			return false;
		}

		return false;
	});


	/*******    Make Dynamic template slides sortable *******/

	$('.zn_dynamic_accordion').find('ul.zn_dynamic_list_container').each(function ()
	{
		$('.zn_dynamic_list_container').sortable({
			forcePlaceholderSize: false,
			/*containment: '.zn_dynamic_list_container',*/
			items: 'li',
			handle: '.zn_dynamic_handle',
			placeholder: 'placeholder left',
			start: function (event, ui)
			{
				var el_width = ui.item.width(),
					el_height = ui.item.height(),
					placeholder = $('.placeholder');
				placeholder.width(el_width - 12);
				placeholder.height(el_height - 12);
			},
			update: function ()
			{
				$(this).zn_sortable_order()
			}
		});
	});
});