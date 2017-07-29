<script>
jQuery(document).ready(function() {
 
jQuery('#upload_img_button').click(function() {
 //formfield = jQuery('#img').attr('name');
 formfield = 'img';
 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
 return false;
});

jQuery('#upload_thumbnail_button').click(function() {
 //formfield = jQuery('#thumbnail').attr('name');
 formfield = 'thumbnail';
 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
 return false;
});
 
window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src');
 jQuery('#'+formfield).val(imgurl);
 tb_remove();
 
 
}
 
});
</script>

<div class="wrap">
	<div id="lbg_logo">
			<h2>Playlist for banner: <span style="color:#FF0000; font-weight:bold;"><?php echo $_SESSION['xname']?> - ID #<?php echo $_SESSION['xid']?></span> - Add New</h2>
 	</div>

    <form method="POST" enctype="multipart/form-data" id="form-add-playlist-record">
	    <input name="bannerid" type="hidden" value="<?php echo $_SESSION['xid']?>" />
		<table class="wp-list-table widefat fixed pages" cellspacing="0">
		  <tr>
		    <td align="left" valign="middle" width="25%">&nbsp;</td>
		    <td align="left" valign="middle" width="77%"><a href="?page=lbg_zoominoutslider_Playlist" style="padding-left:25%;">Back to Playlist</a></td>
		  </tr>
		  <tr>
		    <td colspan="2" align="left" valign="middle">&nbsp;</td>
	      </tr>
		  <tr>
		    <td align="right" valign="middle" class="row-title">Set It First</td>
		    <td align="left" valign="top"><input name="setitfirst" type="checkbox" id="setitfirst" value="1" checked="checked" />
		      <label for="setitfirst"></label></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Image </td>
		    <td width="77%" align="left" valign="top"><input name="img" type="text" id="img" size="60" value="<?php echo $_POST['img']?>" /> <input name="upload_img_button" type="button" id="upload_img_button" value="Upload Image" />
	        <br />
	        Enter an URL or upload an image<br />
	        <br />
	        Recommended size: width &amp; height of the banner</td>
		  </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Link For The Image</td>
		    <td align="left" valign="top"><input name="data-link" type="text" size="60" id="data-link" value="<?php echo $_POST['data-link'];?>"/></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Link Target</td>
		    <td align="left" valign="top"><select name="data-target" id="data-target">
              <option value="" <?php echo (($_POST['data-target']=='')?'selected="selected"':'')?>>select...</option>
		      <option value="_blank" <?php echo (($_POST['data-target']=='_blank')?'selected="selected"':'')?>>_blank</option>
		      <option value="_self" <?php echo (($_POST['data-target']=='_self')?'selected="selected"':'')?>>_self</option>
		      
	        </select></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Thumbnail </td>
		    <td width="77%" align="left" valign="top"><input name="thumbnail" type="text" id="thumbnail" size="60" value="<?php echo $_POST['thumbnail']?>" /> <input name="upload_thumbnail_button" type="button" id="upload_thumbnail_button" value="Upload Image" />
	        <br />
	        Enter an URL or upload an image<br />
	        <br />
	        Recommended size for each skin: <br />
	        - opportune:
	        80px x 80px<br />
	        - opportune:
	        110px x 60px<br />
	        - generous:
	        110px x 65px</td>
		  </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Image Title/Alternative Text</td>
		    <td align="left" valign="top"><input name="alt_text" type="text" size="60" id="alt_text" value="<?php echo $_POST['alt_text'];?>"/>    </td>
		  </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Video Beneath Image</td>
		    <td align="left" valign="middle"><select name="data-video" id="data-video">
		      <option value="false" <?php echo (($_POST['data-video']=='false')?'selected="selected"':'')?>>false</option>
		      <option value="true" <?php echo (($_POST['data-video']=='true')?'selected="selected"':'')?>>true</option>
	        </select></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Content</td>
		    <td align="left" valign="top"><textarea name="content" id="content" cols="45" rows="5"><?php echo $_POST['content']?></textarea></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">&nbsp;</td>
		    <td align="left" valign="top">&nbsp;</td>
	      </tr>
		  <tr>
		    <td colspan="2" align="center" valign="top" class="lbg_regGray">- Zoom In/Out Effect Settings -</td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Horizontal Position</td>
		    <td align="left" valign="middle"><select name="data-horizontalPosition" id="data-horizontalPosition">
              <option value="">select...</option>
		      <option value="left" <?php echo (($_POST['data-horizontalPosition']=='left')?'selected="selected"':'')?>>left</option>
		      <option value="center" <?php echo (($_POST['data-horizontalPosition']=='center')?'selected="selected"':'')?>>center</option>
		      <option value="right" <?php echo (($_POST['data-horizontalPosition']=='right')?'selected="selected"':'')?>>right</option>
		      </select>
		      <i>(If you don't select a value, 'Default Horizontal Position value from 'Banner Settings' will be used)</i></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Vertical Position</td>
		    <td align="left" valign="middle"><select name="data-verticalPosition" id="data-verticalPosition">
              <option value="">select...</option>
		      <option value="top" <?php echo (($_POST['data-verticalPosition']=='top')?'selected="selected"':'')?>>top</option>
		      <option value="center" <?php echo (($_POST['data-verticalPosition']=='center')?'selected="selected"':'')?>>center</option>
		      <option value="bottom" <?php echo (($_POST['data-verticalPosition']=='bottom')?'selected="selected"':'')?>>bottom</option>
		      </select>
		      <i>(If you don't select a value, 'Default Vertical Position' value from 'Banner Settings' will be used)</i></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Initial Zoom</td>
		    <td align="left" valign="middle"><input name="data-initialZoom" type="text" size="25" id="data-initialZoom" value="<?php echo $_POST['data-initialZoom'];?>"/>
		      <i>(We recommend values between 0.5 - 1. If you leave it blank, 'Default Initial Zoom' value from 'Banner Settings' will be used)</i></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Final Zoom</td>
		    <td align="left" valign="middle"><input name="data-finalZoom" type="text" size="25" id="data-finalZoom" value="<?php echo $_POST['data-finalZoom'];?>"/>
		      <i>(We recommend values between 0.5 - 1. If you leave it blank, 'Default Final Zoom' value from 'Banner Settings' will be used)</i></td>
	      </tr>
		  <tr>
		    <td align="right" valign="top" class="row-title">Zoom In/Out Effect Duration</td>
		    <td align="left" valign="middle"><input name="data-duration" type="text" size="25" id="data-duration" value="<?php echo $_POST['data-duration'];?>"/>
	        <i>seconds (If you leave it blank, 'Default Zoom In/Out Effect Duration' value from 'Banner Settings' will be used)</i></td>
	      </tr>
		  <tr>
            <td align="right" valign="top" class="row-title">&nbsp;</td>
		    <td align="left" valign="top">&nbsp;</td>
	      </tr>
		  <tr>
		    <td colspan="2" align="left" valign="middle">&nbsp;</td>
		  </tr>
		  <tr>
		    <td colspan="2" align="center" valign="middle"><input name="Submit<?php echo $_POST['ord']?>" id="Submit<?php echo $_POST['ord']?>" type="submit" class="button-primary" value="Add Record"></td>
		  </tr>
		</table>     
  </form>






</div>				