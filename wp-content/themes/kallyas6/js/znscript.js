/*--------------------------------------------------------------------------------------------------

 File: znscript.js

 Description: This is the main javascript file for this theme
 Please be careful when editing this file

 --------------------------------------------------------------------------------------------------*/

;(function ($)
{
	"use strict";

	$(document).ready(function (e)
	{
		$('body').bind('added_to_cart',function (evt,ret) {
			var mycart = $('#mycartbtn'); // ID must be provided
            if(mycart && mycart.length > 0) {
                var mycartTop = mycart.offset().top,
                    mycartLeft = mycart.offset().left,
                    butonCart = $('.to_cart button.addtocart '),
                    buttonCartHome = $('.add_to_cart_button '),
                    placeholderdiv = $('<div class="popupaddcart">'+zn_do_login.add_to_cart_text+'</div>');

                $('body').append(placeholderdiv);
                $(placeholderdiv).hide();
                $(placeholderdiv).fadeIn('slow', 'easeInOutExpo',function() {
                    //console.log( $(this) );
                    var zn_pos_top = $(this).offset().top,
                        zn_pos_left = $(this).offset().left;
                    $(this)
                        .css({margin:0,left:zn_pos_left,top:zn_pos_top,position:'absolute'})
                        .delay(800)
                        .animate(
                        {
                            top: mycartTop,
                            left:mycartLeft,
                            opacity:1
                        }, 2000, 'easeInOutExpo', function() {
                            $(this).remove();
                        });
                });
            }
		});

		/* sliding panel toggle (support panel) */
		var sliding_panel = $('#sliding_panel'),
            slider_panel_container = $('#sliding_panel .container'),
            slider_height = 0;
        if(slider_panel_container && slider_panel_container.length > 0) {
            slider_height = $('#sliding_panel .container').height();
        }
        var open_sliding_panel = $('#open_sliding_panel');
        if(open_sliding_panel && open_sliding_panel.length > 0)
        {
            open_sliding_panel.toggle(function (e){
                e.preventDefault();
                sliding_panel.animate({height: slider_height}, {duration: 100, queue: false, easing: 'easeOutQuint'});
                $(this).addClass('active');
            }, function (){
                sliding_panel.animate({height: 0}, {duration: 100, queue: false, easing: 'easeOutQuint'});
                $(this).removeClass('active');
            });
        }
		// --- end sliding panel

		// activate tooltips
        var tooltips = $('*[data-rel="tooltip"]');
        if(tooltips && tooltips.length > 0) {
            tooltips.tooltip();
        }
		// LOGIN FORM
        var zn_form_login = $('.zn_form_login');
        zn_form_login.on('click', function(event){
            event.preventDefault();

            var form = $(this),
                warning = false,
                button = $('.zn_sub_button', this),
                values = form.serialize();

            $('input', form).each(function ()
            {
                if (!$(this).val()) {
                    warning = true;
                }
            });

            if (warning) {
                button.removeClass('zn_blocked');
                return false;
            }

            if (button.hasClass('zn_blocked')) {
                return false;
            }

            button.addClass('zn_blocked');

            $.post(zn_do_login.ajaxurl, values, function (resp)
            {
                var data = $(document.createElement('div')).html(resp);

                if ($('#login_error', data).length) {
                    data.find('a').attr('onClick', 'ppOpen(\'#forgot_panel\', \'350\');return false;');
                    $('div.links', form).html(data);
                    button.removeClass('zn_blocked');
                }
                else {
                    if ($('.zn_login_redirect', form).length > 0) {
                        jQuery.prettyPhoto.close();
                        window.location = $('.zn_login_redirect', form).val();
                    }
                }
                button.removeClass('zn_blocked');
            });
        });

		// LOST PASSWORD
        var zn_form_lost_pass = $('.zn_form_lost_pass');
        zn_form_lost_pass.on('click', function(){
            event.preventDefault();

            var form = $(this),
                warning = false,
                button = $('.zn_sub_button', this),
                values = form.serialize() + '&ajax_login=true';

            $('input', form).each(function ()
            {
                if (!$(this).val()) {
                    warning = true;
                }
            });

            if (warning) {
                button.removeClass('zn_blocked');
                return false;
            }

            if (button.hasClass('zn_blocked')) {
                return;
            }

            button.addClass('zn_blocked');

            $.ajax({
                url: form.attr('action'), data: values, type: 'POST', cache: false, success: function (resp)
                {
                    var data = $(document.createElement('div')).html(resp);

                    $('div.links', form).html('');

                    if ($('#login_error', data).length) {
                        // We have an error
                        var error = $('#login_error', data);
                        error.find('a').attr('onClick', 'ppOpen(\'#forgot_panel\', \'350\');return false;');
                        $('div.links', form).html(error);
                    }
                    else if ($('.message', data).length) {
                        var message = $('.message', data);
                        $('div.links', form).html(message);
                    }
                    else {
                        jQuery.prettyPhoto.close();
                        window.location = $('.zn_login_redirect', form).val();
                    }
                    button.removeClass('zn_blocked');
                }, error: function (jqXHR, textStatus, errorThrown)
                {
                    $('div.links', form).html(errorThrown);
                }
            });
        });

		//hoverlink
        var links = $("a.hoverLink");
        if(links && links.length > 0){
            links.each(function (index, element)
            {
                var $t = $(this),
                    dtype = $t.data('type'),
                    img = $t.find('img'),
                    sp = 'fast',
                    app = '<span class="icon_wrap"><span class="icon ' + dtype + '"></span></span>';
                $t.append(app);

                $t.hover(function ()
                {
                    img.animate({'opacity': 0.5}, sp);
                    $t.find('.icon_wrap').animate({'opacity': 1}, sp);
                }, function ()
                {
                    img.animate({'opacity': 1}, sp);
                    $t.find('.icon_wrap').animate({'opacity': 0}, sp);
                });
            });
        }

		//activate collapsible accordions + Fix for collapsable in tabs
        var collapse = $('.collapse');
        if(collapse && collapse.length > 0){
            $(".collapse:visible").collapse({'toggle': false});
        }

        var menu_trigger = $('.zn_menu_trigger');
        if(menu_trigger && menu_trigger.length > 0){
            menu_trigger.unbind('click').bind('click', function (event){
                event.preventDefault();
                $('nav#main_menu .sf-menu').animate({height: 'toggle'});
            });
        }

		// --- search panel
		var searchBtn = $('#search').children('.searchBtn'),
			searchPanel = searchBtn.next(),
			searchP = searchBtn.parent();
        if(searchBtn && searchBtn.length > 0){
            searchBtn.click(function (e)
            {
                e.preventDefault();
                var _t = $(this);
                if (!_t.hasClass('active')) {
                    _t.addClass('active').find('span').removeClass('icon-search icon-white').addClass('icon-remove');
                    searchPanel.show();
                }
                else {
                    _t.removeClass('active').find('span').addClass('icon-search icon-white').removeClass('icon-remove');
                    searchPanel.hide();
                }
            }); // searchBtn.click //
            $(document).click(function ()
            {
                searchBtn.removeClass('active').find('span').addClass('icon-search icon-white').removeClass('icon-remove');
                searchPanel.hide(0);
            });
            searchP.click(function (event)
            {
                event.stopPropagation();
            });
        }
		// --- end search panel

		/* scroll to top */
        var toTop = $("#totop");
        if(toTop && toTop.length > 0){
            toTop.on('click',function (e)
            {
                e.preventDefault();
                $('body,html').animate({scrollTop: 0}, 800, 'easeOutExpo');
            });
        }
		// --- end scroll to top

	});	// doc.ready end //

	$(window).load(function ()
	{
        var hoverBorders = $('.hoverBorder');
        if(hoverBorders && hoverBorders.length > 0){
            hoverBorders.each(function (k,x) {
                $(this).find('img').wrap('<span class="hoverBorderWrapper"/>').after('<span class="theHoverBorder"></span>');
            });
        }

		/* RESPONSIVE VIDEOS */
		function adjustIframes()
		{
            var iframes = $(':not .img-full iframe');
            if(iframes && iframes.length > 0){
                iframes.each(function ()
                {
                    var $this = $(this),
                        proportion = $this.attr('data-proportion'),
                        actual_w = $this.width();

                    if (!proportion) {
                        proportion = $this.attr('height') / actual_w;
                        $this.attr('data-proportion', proportion);
                    }
                    $this.css('height', actual_w * proportion + 'px');
                });
            }
		}
		$(window).on('resize load', function () {
			adjustIframes();
		});
	}); // window.ready end //
})(jQuery);


/*--------------------------------------------------------------------------------------------------
 Ios Slider : Fixed position
 --------------------------------------------------------------------------------------------------*/

function wpk_iosSliderResizeSliderFill(container, $){
	var $slideShow = $('#slideshow');
	if ($slideShow.hasClass('slider_fixedd')) {
		var css = 0;
		if ($('#wpadminbar').length > 0) {
			css = $('#wpadminbar').height();
		}
		$slideShow.addClass('slider_fixed');
		$('.zn_fixed_slider_fill, #slideshow').css({
			'height': parseInt(container.height()) - css  + 'px'
		});
		$('#content').css({
			'background-color': $('body').css('background-color'), 'margin-top': '0px', 'padding-top': '50px'
		});
	}
}
jQuery(window).resize(function(){
	var container = jQuery('.iosSlider .slider .item > img');
    if(container && container.length > 0) {
        wpk_iosSliderResizeSliderFill(container, jQuery);
    }
});
jQuery(function($){
	var container = $('#slideshow .iosSlider');
    if(container && container.length > 0) {
	    wpk_iosSliderResizeSliderFill(container, $);
    }
});
//#!-- End Ios Slider Fixed position




/*
 * @theme   kallyas
 * @wpk
 *
 * @desc Inspect the scrolled distance and change the class name of the "scroll to top" button
 */
(function($){
	/**
	 * Basic flag that will indicate whether or not the change to original value happened
	 * @type {boolean}
	 */
	$.wpkClassChangedMin = false;
	/**
	 * Basic flag that will indicate whether or not the change to the new value happened
	 * @type {boolean}
	 */
	$.wpkClassChangedMax = false;
	/**
	 * Inspect the scrolled distance and apply changes
	 */
	$(window).scroll(function () {
		var scrolled = $(window).scrollTop(),
			minHeight = 300,
			element = $('#totop');
		if(scrolled >= minHeight){
			if($.wpkClassChangedMax){
				return false;
			}
			else {
				$.wpkClassChangedMax = true;
				$.wpkClassChangedMin = false;
			}
			element.removeClass('off').addClass('on');
		}
		else if(scrolled <= minHeight) {
			if($.wpkClassChangedMin){
				return false;
			}
			else {
				$.wpkClassChangedMin = true;
				$.wpkClassChangedMax = false;
			}
			element.removeClass('on').addClass('off');
		}
	});
})(jQuery);



/* Featured Products, Latest Products & Bestsellers carousels */
jQuery(function($){
    var lists = $('.tab-content .shop-latest-carousel > ul');
    if(lists && lists.length > 0) {
        lists.each(function (index, element) {
            $(element).carouFredSel({
                responsive: true,
                scroll: 1,
                auto: false,
                items: {width: 300, visible: {min: 1, max: 4}},
                prev: {button: $(this).parent().find('a.prev'), key: 'left'},
                next: {button: $(this).parent().find('a.next'), key: 'right'}
            });
        });
    }
});

/*
 * Latest Posts Carousels
 * @wpk
 * @since v3.6.8
 */
jQuery(function($){
    var icarousel = $('.lp_carousel');
    if(icarousel && icarousel.length > 0) {
        icarousel.carouFredSel({
            responsive: true,
            scroll: 1,
            auto: false,
            items: {
                width: 400,
                visible: {
                    min: 3,
                    max: 10
                }
            },
            prev: {
                button: function () {
                    return $(this).closest('.latest-posts-carousel').find('.prev');
                },
                key: "left"
            },
            next: {
                button: function () {
                    return $(this).closest('.latest-posts-carousel').find('.next');
                },
                key: "right"
            }
        });
    }
});



/*--------------------------------------------------------------------------------------------------
 Sparkles
 --------------------------------------------------------------------------------------------------*/
if (jQuery("#sparkles[data-images]:visible").length > 0) {
	var sP = jQuery.noConflict(),
		sparkles_container = sP(document.getElementById("sparkles")),
		images_location = sparkles_container.attr("data-images");
	var Spark = function ()
	{
		this.b = images_location + "sparkles/";
		this.s = ["spark.png", "spark2.png", "spark3.png", "spark4.png", "spark5.png", "spark6.png"];
		this.i = this.s[this.random(this.s.length)];
		this.f = this.b + this.i;
		this.n = document.createElement("img");
		this.newSpeed().newPoint().display().newPoint().fly()
	};
	Spark.prototype.display = function ()
	{
		sP(this.n).attr("src", this.f).css("position", "absolute").css("z-index", this.random(-3)).css("top", this.pointY).css("left", this.pointX);
		sparkles_container.append(this.n);
		return this
	};
	Spark.prototype.fly = function ()
	{
		var a = this;
		sP(this.n).animate({top: this.pointY, left: this.pointX}, this.speed, "linear", function ()
		{
			a.newSpeed().newPoint().fly()
		})
	};
	Spark.prototype.newSpeed = function ()
	{
		this.speed = (this.random(10) + 5) * 1100;
		return this
	};
	Spark.prototype.newPoint = function ()
	{
		this.pointX = this.random(sparkles_container.width());
		this.pointY = this.random(sparkles_container.height());
		return this
	};
	Spark.prototype.random = function (a)
	{
		return Math.ceil(Math.random() * a) - 1
	};
	sP(function ()
	{
		if (sP.browser.msie && sP.browser.version < 9) {
			return
		}
		var a = 40,
			b = [],
			i = 0;
		for (i; i < a; i++) {
			b[i] = new Spark()
		}
	});
}

/*--------------------------------------------------------------------------------------------------
 Pretty Photo
 --------------------------------------------------------------------------------------------------*/

function ppOpen(panel, width)
{
	jQuery.prettyPhoto.close();
	setTimeout(function ()
	{
		jQuery.fn.prettyPhoto({
			social_tools : false,
			deeplinking  : false,
			show_title   : false,
			default_width: width,
			theme        : 'pp_kalypso'
		});
		jQuery.prettyPhoto.open(panel);
	}, 300);

} // function to open different panel within the panel
jQuery(function($){
    var pfLinks = $("a[data-rel^='prettyPhoto'], .prettyphoto_link");
    if(pfLinks && pfLinks.length > 0) {
        $("a[data-rel^='prettyPhoto'], .prettyphoto_link").prettyPhoto({
            theme: 'pp_kalypso',
            social_tools: false,
            deeplinking: false
        });
    }
    pfLinks = $("a[rel^='prettyPhoto']");
    if(pfLinks && pfLinks.length > 0) {
        $("a[rel^='prettyPhoto']").prettyPhoto({theme: 'pp_kalypso'});
        $("a[data-rel^='prettyPhoto[login_panel]']").prettyPhoto({
            theme: 'pp_kalypso',
            default_width: 800,
            social_tools: false,
            deeplinking: false
        });
    }
    var pft = $(".prettyPhoto_transparent");
    if(pft && pft.length > 0) {
        pft.click(function (e) {
            e.preventDefault();
            $.fn.prettyPhoto({
                social_tools: false,
                deeplinking: false,
                show_title: false,
                default_width: 980,
                theme: 'pp_kalypso transparent',
                opacity: 0.95
            });
            $.prettyPhoto.open($(this).attr('href'), '', '');
        });
    }
});

if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
	var msViewportStyle = document.createElement("style");
	msViewportStyle.appendChild(document.createTextNode("@-ms-viewport{width:auto!important}"));
	document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
}
