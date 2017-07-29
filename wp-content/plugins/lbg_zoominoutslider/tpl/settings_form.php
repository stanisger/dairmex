<div class="wrap">
	<div id="lbg_logo">
			<h2>Banner Settings for banner: <span style="color:#FF0000; font-weight:bold;"><?php echo $_SESSION['xname']?> - ID #<?php echo $_SESSION['xid']?></span></h2>
 	</div>
  <form method="POST" enctype="multipart/form-data">
	<script>
	jQuery(function() {
		var icons = {
			header: "ui-icon-circle-arrow-e",
			headerSelected: "ui-icon-circle-arrow-s"
		};
		jQuery( "#accordion" ).accordion({
			icons: icons,
			autoHeight: false
		});
	});
	</script>


<div id="accordion">
  <h3><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;General Settings</a></h3>
  <div style="padding:30px;">
	  <table class="wp-list-table widefat fixed pages" cellspacing="0">
     
		  <tr>
		    <td align="right" valign="top" class="row-title" width="30%">Banner Name</td>
		    <td align="left" valign="top" width="75%"><input name="name" type="text" size="40" id="name" value="<?php echo $_SESSION['xname'];?>"/></td>
	      </tr>
		  <tr>
            <td width="30%" align="right" valign="top" class="row-title">Banner Width</td>
		    <td width="75%" align="left" valign="top"><input name="width" type="text" size="25" id="width" value="<?php echo $_POST['width'];?>"/></td>
	    </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Banner Height</td>
		    <td align="left" valign="top"><input name="height" type="text" size="25" id="height" value="<?php echo $_POST['height'];?>"/></td>
	    </tr>
<tr>
		    <td align="right" valign="top" class="row-title">Width 100%</td>
		    <td align="left" valign="middle"><select name="width100Proc" id="width100Proc">
              <option value="true" <?php echo (($_POST['width100Proc']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['width100Proc']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>
<tr>
		    <td align="right" valign="top" class="row-title">Height 100%</td>
		    <td align="left" valign="middle"><select name="height100Proc" id="height100Proc">
              <option value="true" <?php echo (($_POST['height100Proc']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['height100Proc']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>        
        <tr>
		    <td align="right" valign="top" class="row-title">Responsive</td>
		    <td align="left" valign="middle"><select name="responsive" id="responsive">
              <option value="true" <?php echo (($_POST['responsive']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['responsive']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>
        <tr>
		    <td align="right" valign="top" class="row-title">Responsive Relative To Browser</td>
		    <td align="left" valign="middle"><select name="responsiveRelativeToBrowser" id="responsiveRelativeToBrowser">
              <option value="true" <?php echo (($_POST['responsiveRelativeToBrowser']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['responsiveRelativeToBrowser']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>        
		  <tr>
		    <td align="right" valign="top" class="row-title">Skin Name</td>
		    <td align="left" valign="middle"><select name="skin" id="skin">
		      <option value="opportune" <?php echo (($_POST['skin']=='opportune')?'selected="selected"':'')?>>opportune</option>
		      <option value="majestic" <?php echo (($_POST['skin']=='majestic')?'selected="selected"':'')?>>majestic</option>
		      <option value="generous" <?php echo (($_POST['skin']=='generous')?'selected="selected"':'')?>>generous</option>
            </select></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Auto Play (in seconds)</td>
		    <td align="left" valign="middle"><input name="autoPlay" type="text" size="25" id="autoPlay" value="<?php echo $_POST['autoPlay'];?>"/></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Loop</td>
		    <td align="left" valign="middle"><select name="loop" id="loop">
              <option value="true" <?php echo (($_POST['loop']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['loop']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>

		  <tr>
		    <td align="right" valign="top" class="row-title">Fade Slides</td>
		    <td align="left" valign="middle"><select name="fadeSlides" id="fadeSlides">
		      <option value="true" <?php echo (($_POST['fadeSlides']=='true')?'selected="selected"':'')?>>true</option>
		      <option value="false" <?php echo (($_POST['fadeSlides']=='false')?'selected="selected"':'')?>>false</option>
		      </select></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Pause On Mouse Over</td>
		    <td align="left" valign="middle"><select name="pauseOnMouseOver" id="pauseOnMouseOver">
		      <option value="true" <?php echo (($_POST['pauseOnMouseOver']=='true')?'selected="selected"':'')?>>true</option>
		      <option value="false" <?php echo (($_POST['pauseOnMouseOver']=='false')?'selected="selected"':'')?>>false</option>
	        </select></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Target Window For Link</td>
		    <td align="left" valign="middle"><select name="target" id="target">
		      <option value="_blank" <?php echo (($_POST['target']=='_blank')?'selected="selected"':'')?>>_blank</option>
		      <option value="_self" <?php echo (($_POST['target']=='_self')?'selected="selected"':'')?>>_self</option>
            </select></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Enable Touch Screen</td>
		    <td align="left" valign="middle"><select name="enableTouchScreen" id="enableTouchScreen">
              <option value="true" <?php echo (($_POST['enableTouchScreen']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['enableTouchScreen']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>        

        
      </table>
  </div>
<h3><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Zoom In/Out Effect Default Settings</a></h3>
  <div style="padding:30px;">
	  <table class="wp-list-table widefat fixed pages" cellspacing="0">
		<tr>
		    <td align="right" valign="top" class="row-title" width="30%">Default Horizontal Position</td>
		    <td align="left" valign="middle" width="70%"><select name="horizontalPosition" id="horizontalPosition">
              <option value="left" <?php echo (($_POST['horizontalPosition']=='left')?'selected="selected"':'')?>>left</option>
              <option value="center" <?php echo (($_POST['horizontalPosition']=='center')?'selected="selected"':'')?>>center</option>
              <option value="right" <?php echo (($_POST['horizontalPosition']=='right')?'selected="selected"':'')?>>right</option>
            </select></td>
	    </tr>      
		<tr>
		    <td align="right" valign="top" class="row-title" width="30%">Default Vertical Position</td>
		    <td align="left" valign="middle" width="70%"><select name="verticalPosition" id="verticalPosition">
              <option value="top" <?php echo (($_POST['verticalPosition']=='top')?'selected="selected"':'')?>>top</option>
              <option value="center" <?php echo (($_POST['verticalPosition']=='center')?'selected="selected"':'')?>>center</option>
              <option value="bottom" <?php echo (($_POST['verticalPosition']=='bottom')?'selected="selected"':'')?>>bottom</option>
            </select></td>
	    </tr> 
		<tr>
		  <td align="right" valign="top" class="row-title">Default Initial Zoom</td>
		  <td align="left" valign="middle"><input name="initialZoom" type="text" size="25" id="initialZoom" value="<?php echo $_POST['initialZoom'];?>"/>
		    (<i>We recommend values between 0.5 - 1</i>)</td>
		  </tr>
		<tr>
		  <td align="right" valign="top" class="row-title">Default Final Zoom</td>
		  <td align="left" valign="middle"><input name="finalZoom" type="text" size="25" id="finalZoom" value="<?php echo $_POST['finalZoom'];?>"/>
		    (<i>We recommend values between 0.5 - 1</i>)</td>
		  </tr>
		<tr>
		  <td align="right" valign="top" class="row-title">Default Zoom In/Out Effect Duration</td>
		  <td align="left" valign="middle"><input name="duration" type="text" size="25" id="duration" value="<?php echo $_POST['duration'];?>"/> 
		    <i>seconds</i></td>
		  </tr>
		<tr>
		  <td align="right" valign="top" class="row-title">Zoom In/Out Effect IE Duration Fix</td>
		  <td align="left" valign="middle"><input name="durationIEfix" type="text" size="25" id="durationIEfix" value="<?php echo $_POST['durationIEfix'];?>"/>
		    <i>seconds</i></td>
		  </tr>
		<tr>
		  <td align="right" valign="top" class="row-title">&nbsp;</td>
		  <td align="left" valign="middle"><i>this value will be added to the 'Default Zoom In/Out Effect Duration' value for IE browsers if Width 100%=true.   This is done because IE doesn't support css3 transitions and IE rendering engine is very poor. For IE browsers, if you have full width or   full screen banners you need to make the move slower.</i></td>
		  </tr>
      
      </table>
  </div>
        
  
  <h3><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Controllers Settings</a></h3>
  <div style="padding:30px;">
	  <table class="wp-list-table widefat fixed pages" cellspacing="0">

		  <tr>
		    <td align="right" valign="top" class="row-title" width="30%">Show All Controllers</td>
		    <td align="left" valign="middle" width="70%"><select name="showAllControllers" id="showAllControllers">
              <option value="true" <?php echo (($_POST['showAllControllers']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['showAllControllers']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>
        <tr>
		    <td align="right" valign="top" class="row-title">Show Navigation Arrows</td>
		    <td align="left" valign="middle"><select name="showNavArrows" id="showNavArrows">
              <option value="true" <?php echo (($_POST['showNavArrows']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['showNavArrows']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>
         <tr>
		    <td align="right" valign="top" class="row-title">Show Navigation Arrows On Init</td>
		    <td align="left" valign="middle"><select name="showOnInitNavArrows" id="showOnInitNavArrows">
              <option value="true" <?php echo (($_POST['showOnInitNavArrows']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['showOnInitNavArrows']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>
         <tr>
		    <td align="right" valign="top" class="row-title">Auto Hide Navigation Arrows</td>
		    <td align="left" valign="middle"><select name="autoHideNavArrows" id="autoHideNavArrows">
              <option value="true" <?php echo (($_POST['autoHideNavArrows']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['autoHideNavArrows']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>
        <tr>
		    <td align="right" valign="top" class="row-title">Show Bottom Navigation</td>
		    <td align="left" valign="middle"><select name="showBottomNav" id="autoPlay">
              <option value="true" <?php echo (($_POST['showBottomNav']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['showBottomNav']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>
        <tr>
		    <td align="right" valign="top" class="row-title">Show Bottom Navigation On Init</td>
		    <td align="left" valign="middle"><select name="showOnInitBottomNav" id="showOnInitBottomNav">
              <option value="true" <?php echo (($_POST['showOnInitBottomNav']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['showOnInitBottomNav']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>
        <tr>
		    <td align="right" valign="top" class="row-title">Auto Hide Bottom Navigation</td>
		    <td align="left" valign="middle"><select name="autoHideBottomNav" id="autoHideBottomNav">
              <option value="true" <?php echo (($_POST['autoHideBottomNav']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['autoHideBottomNav']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>
        <tr>
		    <td align="right" valign="top" class="row-title">Show Preview Thumbs</td>
		    <td align="left" valign="middle"><select name="showPreviewThumbs" id="showPreviewThumbs">
              <option value="true" <?php echo (($_POST['showPreviewThumbs']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['showPreviewThumbs']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>
        <tr>
          <td align="right" valign="top" class="row-title">Number Of Thumbs Per Screen</td>
          <td align="left" valign="middle"><input name="numberOfThumbsPerScreen" type="text" size="25" id="numberOfThumbsPerScreen" value="<?php echo $_POST['numberOfThumbsPerScreen'];?>"/>  <i>If you set it to 0, it will be calculated automatically.</i></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="row-title">Thumbs On Margin Top</td>
          <td align="left" valign="middle"><input name="thumbsOnMarginTop" type="text" size="15" id="thumbsOnMarginTop" value="<?php echo $_POST['thumbsOnMarginTop'];?>"/></td>
        </tr>
        <tr>
          <td align="right" valign="top" class="row-title">Thumbs Wrapper Margin Top</td>
          <td align="left" valign="middle"><input name="thumbsWrapperMarginTop" type="text" size="15" id="thumbsWrapperMarginTop" value="<?php echo $_POST['thumbsWrapperMarginTop'];?>"/></td>
        </tr>
        

      </table>
  </div>


<h3><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Circle Timer Settings</a></h3>
  <div style="padding:30px;">
	  <table class="wp-list-table widefat fixed pages" cellspacing="0">
		<tr>
		    <td align="right" valign="top" class="row-title" width="30%">Show Circle Timer</td>
		    <td align="left" valign="middle" width="70%"><select name="showCircleTimer" id="showCircleTimer">
              <option value="true" <?php echo (($_POST['showCircleTimer']=='true')?'selected="selected"':'')?>>true</option>
              <option value="false" <?php echo (($_POST['showCircleTimer']=='false')?'selected="selected"':'')?>>false</option>
            </select></td>
	    </tr>
        <tr>
		    <td align="right" valign="top" class="row-title">Circle Radius</td>
		    <td align="left" valign="middle"><input name="circleRadius" type="text" size="15" id="circleRadius" value="<?php echo $_POST['circleRadius'];?>"/></td>
	    </tr>
        <tr>
		    <td align="right" valign="top" class="row-title">Circle Line Width</td>
		    <td align="left" valign="middle"><input name="circleLineWidth" type="text" size="15" id="circleLineWidth" value="<?php echo $_POST['circleLineWidth'];?>"/></td>
	    </tr>
<tr>
		    <td align="right" valign="top" class="row-title">Circle Color</td>
		    <td align="left" valign="top"><input name="circleColor" type="text" size="25" id="circleColor" value="<?php echo $_POST['circleColor'];?>" style="background-color:#<?php echo $_POST['circleColor'];?>" />
                <script>
jQuery('#circleColor').ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
		jQuery(el).val(hex);
		jQuery(el).css("background-color",'#'+hex);
		jQuery(el).ColorPickerHide();
	},
	onBeforeShow: function () {
		jQuery(this).ColorPickerSetColor(this.value);
	}
})
.bind('keyup', function(){
	jQuery(this).ColorPickerSetColor(this.value);
});
              </script>            </td>
	    </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Circle Alpha</td>
		    <td align="left" valign="middle"><script>
	jQuery(function() {
		jQuery( "#circleAlpha-slider-range-min" ).slider({
			range: "min",
			value: <?php echo $_POST['circleAlpha'];?>,
			min: 0,
			max: 100,
			slide: function( event, ui ) {
				jQuery( "#circleAlpha" ).val(ui.value );
			}
		});
		jQuery( "#circleAlpha" ).val( jQuery( "#circleAlpha-slider-range-min" ).slider( "value" ) );
	});
	        </script>
                <div id="circleAlpha-slider-range-min" class="inlinefloatleft"></div>
		      <div class="inlinefloatleft" style="padding-left:20px;">%
		        <input name="circleAlpha" type="text" size="10" id="circleAlpha" style="border:0; color:#000000; font-weight:bold;"/>
	          </div></td>
	    </tr>
        <tr>
		    <td align="right" valign="top" class="row-title">Behind Circle Color</td>
		    <td align="left" valign="top"><input name="behindCircleColor" type="text" size="25" id="behindCircleColor" value="<?php echo $_POST['behindCircleColor'];?>" style="background-color:#<?php echo $_POST['behindCircleColor'];?>" />
                <script>
jQuery('#behindCircleColor').ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
		jQuery(el).val(hex);
		jQuery(el).css("background-color",'#'+hex);
		jQuery(el).ColorPickerHide();
	},
	onBeforeShow: function () {
		jQuery(this).ColorPickerSetColor(this.value);
	}
})
.bind('keyup', function(){
	jQuery(this).ColorPickerSetColor(this.value);
});
              </script>            </td>
	    </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Behind Circle Alpha</td>
		    <td align="left" valign="middle"><script>
	jQuery(function() {
		jQuery( "#behindCircleAlpha-slider-range-min" ).slider({
			range: "min",
			value: <?php echo $_POST['behindCircleAlpha'];?>,
			min: 0,
			max: 100,
			slide: function( event, ui ) {
				jQuery( "#behindCircleAlpha" ).val(ui.value );
			}
		});
		jQuery( "#behindCircleAlpha" ).val( jQuery( "#behindCircleAlpha-slider-range-min" ).slider( "value" ) );
	});
	        </script>
                <div id="behindCircleAlpha-slider-range-min" class="inlinefloatleft"></div>
		      <div class="inlinefloatleft" style="padding-left:20px;">%
		        <input name="behindCircleAlpha" type="text" size="10" id="behindCircleAlpha" style="border:0; color:#000000; font-weight:bold;"/>
	          </div></td>
	    </tr>      
      </table>
  </div>
  
  
  
</div>

<div style="text-align:center; padding:20px 0px 20px 0px;"><input name="Submit" type="submit" id="Submit" class="button-primary" value="Update Banner Settings"></div>

</form>
</div>