;(function ($) {
	"use strict";

	$.ZnModal = function (options)
	{
		var defaults = {
			modal_title: "", // THE MODAL TITLE
			modal_class: "", // MODAL CSS CLASS
			modal_backdrop_class: "", // MODAL CSS CLASS
			modal_content: "", // MODAL CONTENT
			type: false, // MODAL CONTENT
			hidden_class: 'zn_hidden', // MODAL CONTENT
			current_element: false, // MODAL CONTENT
			modal_ajax_hook: false, // AJAX HOOK
			modal_ajax_params: {}, // EXTRA AJAX PARAMS
			show_close_button: true, // EXTRA AJAX PARAMS -- deprecated, use show_save_button
			//@since 3.6.5
			show_save_button: false,
			modal_on_ajax_load: function (e) {
			},
			modal_on_close: function (e) {
			}

		};

		this.instanceNr = $.ZnModal.openInstance.length;
		this.options = $.extend({}, defaults, options);
		this.modal = $('<div class="zn-modal"></div>');
		this.backdrop = $('<div class="zn-modal-backdrop"></div>');
		this.init();

	};

	// Keep the open modals
	$.ZnModal.openInstance = [];

	$.ZnModal.prototype =
	{
		init: function ()
		{
			if (this.options.type == 'inline' && this.options.current_element.length) {
				this.launch_inline();
			}
			else {
				this.open();
			}
		},

		launch_inline: function ()
		{
			var fw = this,
				options = fw.options,
				el = options.current_element,
				placeholder = $(el.attr('href')).after('<div class="zn_modal_placeholder_' + this.instanceNr + ' ' + options.hidden_class + '"></div>').detach().removeClass(options.hidden_class),
				on_close = this.options.modal_on_close;

			this.options.modal_on_close = function (modal) {

				var modal_content = modal.modal.find('.zn-modal-inner-content').children().detach();
				$('.zn_modal_placeholder_' + fw.instanceNr).after($(modal_content).addClass(options.hidden_class)).detach();
				on_close(modal);
			};

			this.open();
			var new_content = this.modal.find('.zn-modal-inner-content').append(placeholder);

			$.zn_html.enable_tinymce(new_content);
		},

		// OPEN
		open: function () {
			$.ZnModal.openInstance.unshift(this);
			this.create_html();
			this.add_behaviour();
			$('body').trigger('zn_modal_open', this);
		},

		// BIND THE SAVE, CLOSE 
		add_behaviour: function () {
			var znmd = this;
			// CLOSE BEHAVIOUR
			this.backdrop.add(".zn-attach-close-event", this.modal).on('click', function () {
				znmd.close();
				return false;
			});
		},

		// CREATE THE MODAL HTML
		create_html: function () {
			var content = this.options.modal_content ? this.options.modal_content : "",
				loading_class = !this.options.modal_content && this.options.modal_ajax_hook ? "zn-modal-loading" : "",
				title = this.options.modal_title ? '<h3 class="zn-modal-title">' + this.options.modal_title + '</h3>' : '',
				output = '<div class="zn-modal-wrapper">';

			output += '<div class="zn-modal-inner">';
			output += '<div class="zn-modal-inner-header">' + title;

			if (this.options.show_close_button) {
				output += '<a href="#close" class="zn-modal-close zn-attach-close-event">&times;</a>';
			}
			else if(this.options.show_save_button) {
				output += '<a href="#close" class="zn-modal-save dashicons dashicons-yes zn-attach-close-event"></a>';
			}

			output += '</div>';
			output += '<div class="zn-modal-inner-content ' + loading_class + '">' + content + '</div>';
			output += '<div class="zn-modal-inner-footer">';

			// ADD FOOTER BUTTONS HERE

			output += '</div></div></div>';

			// ADD MODAL CLASS IF PASSED IN OPTIONS
			if (this.options.modal_class) {
				this.modal.addClass(this.options.modal_class);
			}

			// ADD Backdrop CLASS IF PASSED IN OPTIONS
			if (this.options.modal_backdrop_class) {
				this.backdrop.addClass(this.options.modal_backdrop_class);
			}

			// PLACE THE MODAL IN BODY
			this.modal.html(output);
			var st = $(this.backdrop).appendTo('body');
			var st2 = $(this.modal).appendTo('body');

			var multiplier = this.instanceNr - 1,
				z_old = parseInt(this.modal.css('zIndex'), 10);

			this.modal.css({zIndex: (z_old + multiplier + 1 )});
			this.backdrop.css({zIndex: (z_old + multiplier)});

			// This will help css animations to work
			setTimeout(function () {
				st.addClass('zn-modal-backdrop-visible');
				st2.addClass('zn-modal-visible');
			}, 16);

			this.make_draggable();

			if (this.options.modal_ajax_hook) {
				this.get_ajax_content();
			}
		},

		get_ajax_content: function () {
			var znmd = this,
				content_container = znmd.modal.find('.zn-modal-inner-content'),
				zn_ajax_url = ajaxurl ? ajaxurl : ZnThemeAjax.ajaxurl;

			var zn_ajax_config = {
					action: this.options.modal_ajax_hook,
					security: ZnAjax.security
				},
				zn_ajax_config = $.extend({}, this.options.modal_ajax_params, zn_ajax_config);

			$.ajax({
				type: "POST",
				url: zn_ajax_url,
				data: zn_ajax_config,
				error: function () {
					// SHOW AN ERROR MESSAGE 
				},
				success: function (response) {
					if (response == 0) {
						// SOMETHING WRONG HERE
					}
					else if (response == "-1") // nonce timeout
					{
						// NONCE IS NOT OK
					}
					else {
						var new_content = $(response);

						content_container.html(new_content);
						$.zn_html.enable_tinymce(new_content);
						$.zn_html.scope.trigger({type: "ZnNewContent", content: new_content});
						znmd.options.modal_on_ajax_load(znmd);
					}
				},
				complete: function (response) {
					content_container.removeClass('zn-modal-loading');
				}
			});
		},

		make_draggable: function () {
			this.modal.find('.zn-modal-inner').draggable({
				handle: ".zn-modal-inner-header",
				containment: "document"
			});
		},


		// CLOSE
		close: function () {
			$.ZnModal.openInstance.shift();
			this.options.modal_on_close(this);
			this.modal.remove();
			this.backdrop.remove();
			$('body').trigger('zn_modal_close', this);
		}
	};

	// This will show a modal notification
	$.ZnModalMessage = function (message)
	{
		this.confirmModal = $('<div class="zn_modal_confirm zn_modal_message">' +
		'<p>' + message + '</p>' +
		'</div>');

		var params = {};
		params.modal_content = this.confirmModal.wrap('<p/>').parent().html();
		params.show_close_button = false;

		var modal = new $.ZnModal(params);

		// Close the message after 1.5 seconds
		setTimeout(function () {
			modal.close();
		}, 1500);
	};

	$.ZnModalConfirm = function (message, cancelButtonTxt, okButtonTxt, callback, callback2)
	{
		this.confirmModal = $('<div class="zn_modal_confirm">' +
		'<p>' + message + '</p>' +
		'<a href="#" class="zn-btn-confirm zn-modal-ok zn-btn-ok">' + okButtonTxt + '</a>' +
		'<a href="#" class="zn-btn-confirm zn-btn-cancel zn-attach-close-event">' + cancelButtonTxt + '</a>' +
		'</div>');

		var params = {}
		params.modal_content = this.confirmModal.wrap('<p/>').parent().html();
		params.show_close_button = false;

		var modal = new $.ZnModal(params);

		$.ZnModal.openInstance[0].modal.find('.zn-modal-ok').click(function (event) {
			event.preventDefault();
			callback();
			modal.close();
		});

		$.ZnModal.openInstance[0].modal.find('.zn-btn-cancel').click(function (event) {
			event.preventDefault();
			if (typeof callback2 != 'undefined') {
				callback2();
			}
			modal.close();
		});
	};

	// MAKE THE MODAL ACCESSIBLE TROUGH jQuery
	$.fn.znmodal = function (options)
	{
		var options = $.extend({}, options);

		return this.each(function () {
			if ($(this).attr('href')) {
				$(this).on('click', function (e) {
					options.current_element = $(this);
					options.type = 'inline';
					options.modal_title = $(this).data('modal_title') ? $(this).data('modal_title') : '';
					new $.ZnModal(options);
					e.preventDefault();
				});
			}
			else { new $.ZnModal(options); }
		});
	};
})(jQuery);