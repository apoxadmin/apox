<?php
if (get_option("wds_theme_version")) {
  $old_version = FALSE;
}
else {
  $old_version = TRUE;
}
?>
<div style="text-align:center; float: left;">
  <table class="data-bordered">
    <thead>
      <tr>
        <th class="top first" nowrap="nowrap" scope="col">Features of the Slider WD</th>
        <th class="top notranslate" nowrap="nowrap" scope="col">Free</th>
        <th class="top notranslate" nowrap="nowrap" scope="col">Pro Version</th>
      </tr>
    </thead>
    <tbody>
      <tr class="alt">
        <td>Responsive design and layout</td>
        <td class="icon-replace yes">yes</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <tr>
        <td>Unlimited amount of sliders and layers</td>
        <td class="icon-replace yes">yes</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <tr class="alt">
        <td>Full Width slider support</td>
        <td class="icon-replace yes">yes</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <?php if ($old_version) { ?>
      <tr>
        <td>Layers (text and image)</td>
        <td class="icon-replace yes">yes</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <?php } ?>
      <tr class="alt">
        <td>Possibility of linking slides to specific URLs</td>
        <td class="icon-replace yes">yes</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <tr>
        <td>Autoplay</td>
        <td class="icon-replace yes">yes</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <tr class="alt">
        <td>Shuffle</td>
        <td class="icon-replace yes">yes</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <tr>
        <td>Timer Bar</td>
        <td class="icon-replace yes">yes</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <tr class="alt">
        <td>Navigation bullets</td>
        <td class="icon-replace yes">yes</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <tr>
        <td>Right-click protection for slides</td>
        <td class="icon-replace yes">yes</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <tr class="alt">
        <td>Music playback</td>
        <td class="icon-replace yes">yes</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <tr>
        <td>Custom CSS</td>
        <td class="icon-replace yes">yes</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <tr class="alt">
        <td>Watermark support</td>
        <td class="icon-replace yes">yes</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <tr>
        <td>Transition effects</td>
        <td style="text-align:center;">5</td>
        <td style="text-align:center;">26</td>
      </tr>
      <tr>
        <td>Layer effects</td>
        <td style="text-align:center;"><?php ($old_version ? 5 : ''); ?></td>
        <td style="text-align:center;">38</td>
      </tr>
      <tr class="alt">
        <td>Video Slide support (YouTube and Vimeo)</td>
        <td class="icon-replace no">no</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <?php if (!$old_version) { ?>
      <tr>
        <td>Text and image layers</td>
        <td class="icon-replace no">no</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <?php } ?>
      <tr>
        <td>Social sharing buttons layer (Google+, Tumblr, Twitter, Pinterest and Facebook)</td>
        <td class="icon-replace no">no</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <?php if (!$old_version) { ?>
      <tr>
        <td>Navigation buttons and bullet styles</td>
        <td class="icon-replace no">no</td>
        <td class="icon-replace yes">yes</td>
      </tr>
      <?php } ?>
      <tr class="alt">
        <td>Filmstrip support</td>
        <td class="icon-replace no">no</td>
        <td class="icon-replace yes">yes</td>
      </tr>
    </tbody>
  </table>
</div>
<div style="float: right; text-align: right;">
    <a style="text-decoration: none;" target="_blank" href="http://web-dorado.com/files/fromslider.php">
      <img width="215" border="0" alt="web-dorado.com" src="<?php echo WD_S_URL . '/images/wd_logo.png'; ?>" />
    </a>
  </div>
<div style="float: left; clear: both;">
  <p>After purchasing the commercial version follow these steps:</p>
  <ol>
    <li>Deactivate Slider WD plugin.</li>
    <li>Delete Slider WD plugin.</li>
    <li>Install the downloaded commercial version of the plugin.</li>
  </ol>
</div>
