<div class="wrap">
<h2>Carousel of Post Images</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<?php settings_fields('copi'); ?>

<table class="form-table">

<tr valign="top">
     <th scope="row">Skin to use<br><small>Note:CSS files must exist<small></th>
<td><input type="text" name="copi_skin" value="<?php echo get_option('copi_skin'); ?>" /></td>
</tr>
</table>
<input type="hidden" name="action" value="update" />
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</form>
<hr>
<h2>Donations</h2>
<p>Donations are always welcome as a reward for my many hours of hard work putting together this plugin.
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="SD4XCQVTGAJT8">
<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</p>
</form>
</div>
