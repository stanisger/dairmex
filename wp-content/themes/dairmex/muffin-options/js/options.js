function MfnOptions(){
			
	// show 1st at start	
	if( jQuery('#last_tab').val() == 0 ){
		this.tabid = jQuery('.mfn-submenu-a:first').attr('data-rel');
	} else {
		this.tabid = jQuery('#last_tab').val();
	}

	jQuery('#'+this.tabid+'-mfn-section').show();
	jQuery('#'+this.tabid+'-mfn-submenu-li').addClass('active').parent('ul').show().parent('li').addClass('active');
	
	// parent manu click - show childrens and select 1st
	jQuery('.mfn-menu-a').click(function(){
		
		if( ! jQuery(this).parent().hasClass('active') ) {
			
			jQuery('.mfn-menu-li').removeClass('active');
			jQuery('.mfn-submenu').slideUp('fast');
			
			jQuery(this).next('ul').stop().slideDown('fast');
			jQuery(this).parent('li').addClass('active');
			
			jQuery('.mfn-submenu-li').removeClass('active');
			jQuery('.mfn-section').hide();
			
			this.tabid = jQuery(this).next('ul').children('li:first').addClass('active').children('a').attr('data-rel');
			jQuery('#'+this.tabid+'-mfn-section').stop().fadeIn(1200);
			jQuery('#last_tab').val(this.tabid);
		}
		
	});
	
	// submenu click
	jQuery('.mfn-submenu-a').click(function(){
		
		if( ! jQuery(this).parent().hasClass('active') ) {

			jQuery('.mfn-submenu-li').removeClass('active');
			jQuery(this).parent('li').addClass('active');
			
			jQuery('.mfn-section').hide();
			
			this.tabid = jQuery(this).attr('data-rel');
			jQuery('#'+this.tabid+'-mfn-section').stop().fadeIn(1200);
			jQuery('#last_tab').val(this.tabid);
		}
		
	});
	
	// last w menu
	jQuery('.mfn-submenu .mfn-submenu-li:last-child').addClass('last');

}
	
jQuery(document).ready(function(){
	var mfn_opts = new MfnOptions();
});