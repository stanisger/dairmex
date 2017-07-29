"use strict";
jQuery(function($){
	//hide hidden section on page load.
	$('#section-body_bg, #section-body_bg_custom, #section-body_bg_properties').hide();

	//hides warning if js is enabled
	$('#js-warning').hide();

	/* save everything */
	$(document).on('click','.zn_save',function()
	{
		$('.ajax-loading-img').fadeIn().addClass('zn_is_loading');

		var nonce = $('#zn_security').val(),
			serializedReturn = $('#zn_form :input[name][name!="zn_security"][name!="of_reset"]').serialize(),
			data = {
			type: 'save',
			action: 'zn_ajax_post_action',
			zn_security: nonce,
			data: serializedReturn
		};

		$.post(ajaxurl, data, function(response) {
			var success = $('.zn-save-popup');
			var fail = $('.zn-fail-popup');
			var loading = $('.ajax-loading-img').removeClass('zn_is_loading');
			loading.fadeOut();

			if (response==1) {
				success.fadeIn();
			} else {
				fail.fadeIn();
			}

			window.setTimeout(function(){
				success.fadeOut();
				fail.fadeOut();
			}, 2000);
		});
		return false;
	});
}); //end doc ready
