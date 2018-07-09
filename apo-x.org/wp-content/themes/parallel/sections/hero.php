<?php
/**
 * Hero Section for our theme
 * @subpackage Parallel
 * @since Parallel 1.0
 */
?>
<?php global $parallel; ?>
<section id="welcome" class="hero">
<?php if($parallel['hero-overlay-toggle']==1) { ?><div class="blacklayer"></div><?php } ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="title text-center">
			<?php if ($parallel['hero-title']) { ?><h1><?php echo esc_html($parallel['hero-title']); ?></h1><?php } ?>
			<?php if ($parallel['hero-subtitle']) { ?><h2><?php echo wp_kses_post($parallel['hero-subtitle']); ?></h2><?php } ?>
			</div>
			<?php if ($parallel['hero-tagline']) { ?>
            <div class="lead text-center">
                <p><?php echo str_replace("\n", "<br>", $parallel['hero-tagline']); ?></p>
            </div>
            <?php } ?>
			<?php if($parallel['hero-btn1-toggle']==true && $parallel['hero-btn2-toggle']==false) { ?>
            <div class="col-md-12 text-center">
                <a href="<?php echo esc_url($parallel['hero-btn1-url']); ?>" class="btn btn-lg btn-secondary"><?php echo esc_html($parallel['hero-btn1-text']); ?></a>
			</div>
			<?php } else if($parallel['hero-btn1-toggle']==true){ ?>
			<div class="col-md-6 text-right">
                <a href="<?php echo esc_url($parallel['hero-btn1-url']); ?>" class="btn btn-lg btn-secondary"><?php echo esc_html($parallel['hero-btn1-text']); ?></a>
			</div>
			<?php } ?>
			<?php if($parallel['hero-btn2-toggle']==true && $parallel['hero-btn1-toggle']==false) { ?>
			<div class="col-md-12 text-center">
                <a href="<?php echo esc_url($parallel['hero-btn2-url']); ?>" class="btn btn-lg btn-primary"><?php echo esc_html($parallel['hero-btn2-text']); ?></a>
			</div>
			<?php } else if($parallel['hero-btn2-toggle']==true) { ?>
			<div class="col-md-6 text-left">
                <a href="<?php echo esc_url($parallel['hero-btn2-url']); ?>" class="btn btn-lg btn-primary"><?php echo esc_html($parallel['hero-btn2-text']); ?></a>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
</section><!--hero-->