<script type="text/javascript">
	jQuery(document).ready(function($){
		$('#frs-select-slideshow-menu').hide();
	})
</script>

<?php 
/**
 * save options
 */
if($_POST)
{
	/**
	 * Tonjoo License
	 */
	$plugins = 'frs-premium';
	$new_key = $_POST['pjc_slideshow_license']['license_key'];
	
	$PluginLicense = new TonjooPluginLicenseFRS($plugins, $new_key);
	$PluginLicense->set_license();

	// update option
	update_option('pjc_slideshow_license', $_POST['pjc_slideshow_license']);
	
	$location = admin_url("edit.php?post_type=pjc_slideshow&page=frs-setting-page&tab=$current&tabtype=license&settings-updated=true");
	echo "<meta http-equiv='refresh' content='0;url=$location' />";
	echo "<h2>Loading...</h2>";
	exit();
}

$options = get_option('pjc_slideshow_license');
?>

<form method="post" action="" id="frs-option-form">
<?php settings_fields('pjc_options'); ?>


<div class="metabox-holder columns-2" style="margin-right: 300px;">
<div class="postbox-container" style="width: 100%;min-width: 463px;float: left; ">
<div class="meta-box-sortables ui-sortable">
<div id="adminform" class="postbox">
<h3 class="hndle" data-step="6" data-intro="Configure and setting up your slideshow options"><span>License</span></h3>
<div class="inside" style="z-index:1;">
<!-- Extra style for options -->
<style type="text/css">
	#license_status input {
		width: 200px;
	}
</style>

<?php
	$PluginLicense = new TonjooPluginLicenseFRS('frs-premium', $options['license_key']);
	$license = $PluginLicense->get_license();

	if(! $license)
	{
		$license_status = "<span style='color:red'>";

		if($options['license_key'] == ""){
			$license_status.= __('Unregistered',TONJOO_ECAE);
		}else{
			$license_status.= __('Invalid code or deleted access',TONJOO_ECAE);
		}

		$license_status.= "</span>";
	}
	else
	{
		$license_status = "<span style='color:blue'>";
		$license_status.= __('Registered',TONJOO_ECAE);
		$license_status.= "</span>";
	}

	
?>

<table class="form-table">	
	<tr valign="top" id="license_status">
		<th scope="row">Your License Code</th>
		<td style="width: 300px;" colspan="2">
			<input type="text" name="pjc_slideshow_license[license_key]" value="<?php echo $options['license_key'] ?>" style="width:300px;">	
		</td>
	</tr>
	<tr valign="top" id="license_status">
		<th scope="row">Status</th>
		<td style="width: 300px;" colspan="2">
			<?php echo $license_status ?>
		</td>
	</tr>

	<tr valign="top">
		<th colspan=3>
			<?php 
				_e('Register your license code here to get all benefit of Fluid Responsive Slideshow. ',TONJOO_ECAE);
				echo '<div style="height:10px;"></div>';
				_e('Find your license code at ',TONJOO_ECAE);
			?> 
			<a href="https://tonjoostudio.com/manage/plugin" target="_blank">https://tonjoostudio.com/manage/plugin</a>
		</th>
	</tr>
</table>

</div>			
</div>			
</div>			
</div>			


<div class="postbox-container" style="float: right;margin-right: -300px;width: 280px;">
<div class="metabox-holder" style="padding-top:0px;">	
<div class="meta-box-sortables ui-sortable">
	<div id="email-signup" class="postbox">
		<h3 class="hndle"><span>Save Options</span></h3>
		<div class="inside" style="padding-top:10px;">
			Save your changes to apply the options
			<br>
			<br>
			<input type="submit" class="button button-primary button-frs" value="<?php _e('Save Options', 'pjc_slideshow_options'); ?>" data-step="7" data-intro="Save your changes to apply the options" />
			
		</div>
	</div>

	<!-- ADS -->
		<div class="postbox">			
		<script type="text/javascript">
			/**
			 * Setiap dicopy-paste, yang find dan dirubah adalah
			 * - var pluginName
			 * - premium_exist
			 */

			jQuery(function(){					
				var pluginName = "frs";
				var url = 'http://tonjoo.com/about/?promo=get&plugin=' + pluginName;
				var promoFirst = new Array();
				var promoSecond = new Array();

				<?php if(function_exists('is_frs_premium_exist')): ?>
				var url = 'http://tonjoo.com/about/?promo=get&plugin=' + pluginName + '&premium=true';
				<?php endif ?>

				// strpos function
				function strpos(haystack, needle, offset) {
					var i = (haystack + '')
						.indexOf(needle, (offset || 0));
					return i === -1 ? false : i;
				}

				jQuery.ajax({url: url, dataType:'jsonp'}).done(function(data){
					
					if(typeof data =='object')
					{
						var fristImg, fristUrl;

					    // looping jsonp object
						jQuery.each(data, function(index, value){

							<?php if(! function_exists('is_frs_premium_exist')): ?>

							fristImg = pluginName + '-premium-img';
							fristUrl = pluginName + '-premium-url';

							// promoFirst
							if(index == fristImg)
						    {
						    	promoFirst['img'] = value;
						    }

						    if(index == fristUrl)
						    {
						    	promoFirst['url'] = value;
						    }

						    <?php else: ?>

						    if(! fristImg)
						    {
						    	// promoFirst
								if(strpos(index, "-img"))
							    {
							    	promoFirst['img'] = value;

							    	fristImg = index;
							    }

							    if(strpos(index, "-url"))
							    {
							    	promoFirst['url'] = value;

							    	fristUrl = index;
							    }
						    }

						    <?php endif; ?>

							// promoSecond
							if(strpos(index, "-img") && index != fristImg)
						    {
						    	promoSecond['img'] = value;
						    }

						    if(strpos(index, "-url") && index != fristUrl)
						    {
						    	promoSecond['url'] = value;
						    }
						});

						//promo_1
						jQuery("#promo_1 img").attr("src",promoFirst['img']);
						jQuery("#promo_1 a").attr("href",promoFirst['url']);

						//promo_2
						jQuery("#promo_2 img").attr("src",promoSecond['img']);
						jQuery("#promo_2 a").attr("href",promoSecond['url']);
					}
				});
			});
		</script>

		<!-- <h3 class="hndle"><span>This may interest you</span></h3> -->
		<div class="inside" style="margin: 23px 10px 6px 10px;">
			<div id="promo_1" style="text-align: center;padding-bottom:17px;">
				<a href="http://tonjoo.com" target="_blank">
					<img src="<?php echo plugins_url(FRS_DIR_NAME."/assets/loading-big.gif") ?>" width="100%" <?php if(! function_exists('is_frs_premium_exist')): ?> data-step="8" data-intro="If you like this slider, please consider the premium version to support us and get all the skins.<b>Fluid Responsive Slideshow</b> !" <?php endif ?>>
				</a>
			</div>
			<div id="promo_2" style="text-align: center;">
				<a href="http://tonjoo.com" target="_blank">
					<img src="<?php echo plugins_url(FRS_DIR_NAME."/assets/loading-big.gif") ?>" width="100%">
				</a>
			</div>
		</div>
	</div>
</div>
</div>
</div>	

</div>

</form>	