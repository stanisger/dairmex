jQuery(document).ready(function(o){var r=o("#wpr_menu_pos"),e=r.val(),l=r.closest("tr").first().next("tr");"top"==e?l.hide():l.show(),r.on("change",function(){e=o(this).val(),"top"==e?l.hide():l.show()}),o("#upload_bar_logo_button").click(function(r){r.preventDefault();var e=wp.media({title:"Select your logo for responsive menu",button:{text:"Select image"},multiple:!1}).on("select",function(){var r=e.state().get("selection").first().toJSON();console.log(r.url),o(".wprmenu_bar_logo_prev").attr("src",r.url).show(),o(".wprmenu_bar_logo_url").val(r.url)}).open()}),o(".wprmenu_disc_bar_logo").click(function(r){r.preventDefault(),o(".wprmenu_bar_logo_prev").hide(),o(".wprmenu_bar_logo_url").val("")}),o("#wprmenu_bar_bgd_picker").wpColorPicker({defaultColor:"#0D0D0D"}),o("#wprmenu_bar_color_picker").wpColorPicker({defaultColor:"#F2F2F2"}),o("#wprmenu_menu_bgd_picker").wpColorPicker({defaultColor:"#2E2E2E"}),o("#wprmenu_menu_color_picker").wpColorPicker({defaultColor:"#CFCFCF"}),o("#wprmenu_menu_color_hover_picker").wpColorPicker({defaultColor:"#606060"}),o("#wprmenu_menu_border_top_picker").wpColorPicker({defaultColor:"#474747"}),o("#wprmenu_menu_border_bottom_picker").wpColorPicker({defaultColor:"#131212"}),o("#wprmenu_menu_icon_color_picker").wpColorPicker({defaultColor:"#F2F2F2"})});