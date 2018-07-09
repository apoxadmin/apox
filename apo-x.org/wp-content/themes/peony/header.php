<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<?php
$body_class     = peony_body_class();
$wrapper_class  = peony_wrapper_class();
$body_class     = apply_filters('peony_body_class', $body_class);
$wrapper        = apply_filters('peony_wrapper_class', $wrapper_class);
$default_header = peony_default_header();
?>
<body <?php body_class($body_class); ?>>
<div class="wrapper <?php echo $wrapper;?>">
	<div class="top-wrap">
        <?php do_action('peony_before_header');?>
        <?php echo apply_filters('peony_header',$default_header);?>
        <?php do_action('peony_after_header');?>
	</div>