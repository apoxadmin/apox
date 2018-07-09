<?php
/**
 * @package peony
 */
$display_image      = peony_option('single_display_image');
$display_pagination = peony_option('display_pagination');
$display_meta_categories = peony_option('display_meta_categories');
?>

<section class="post-main" role="main" id="content">
  <article class="post-entry text-left">
    <div class="entry-header">
      <?php if ( $display_meta_categories == '1' ):?>
      <div class="entry-category">
        <?php the_category('<span>&middot;</span>');?>
      </div>
      <?php endif; ?>
      <h1 class="entry-title">
        <?php the_title();?>
      </h1>
      <?php peony_posted_on();?>
    </div>
    <?php if (  $display_image == '1' && has_post_thumbnail() ) : 
	$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), "large" );
	?>
    <div class="feature-img-box">
      <div class="img-box figcaption-middle text-center from-top fade-in">
        <?php the_post_thumbnail(); ?>
        <a rel='prettyPhoto' href="<?php echo esc_url($image_attributes[0]);?>">
        <div class="img-overlay">
          <div class="img-overlay-container">
            <div class="img-overlay-content"> <i class="fa fa-plus"></i> </div>
          </div>
        </div>
        </a>
      </div>
    </div>
    <?php endif;?>
    <div class="entry-main">
      <div class="entry-content">
        <?php the_content(); ?>
        <?php
		  
	$args  = array(
		'before'           => '<p>' . __( 'Pages:', 'peony' ),
		'after'            => '</p>',
		'link_before'      => '',
		'link_after'       => '',
		'next_or_number'   => 'number',
		'separator'        => ' ',
		'nextpagelink'     => __( 'Next page', 'peony' ),
		'previouspagelink' => __( 'Previous page', 'peony' ),
		'pagelink'         => '%',
		'echo'             => 1
	);
 
	wp_link_pages( $args  );
		
	?>
      </div>
      <?php
if (  $display_pagination == '1' ) :
?>
<div class="post-pagination">
<?php

$prev_post = get_previous_post();
if (!empty( $prev_post )): ?>
      <a title="<?php echo esc_attr($prev_post->post_title); ?>" href="<?php echo esc_url(get_permalink( $prev_post->ID )); ?>" rel="external nofollow" ><?php echo esc_attr($prev_post->post_title); ?><< </a>
      <?php endif; ?>
      <?php
$next_post = get_next_post();
if (!empty( $next_post )): ?>
      <a title="<?php echo esc_attr($next_post->post_title); ?>" style="float: right;" href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>" rel="external nofollow" > >><?php echo esc_attr($next_post->post_title); ?></a>
      <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </article>
  <div class="post-attributes">
    <!--About Author-->
    <?php if(peony_option('display_author_info_box') == '1'):?>
    <div class="about-author peony_display_author_info_box">
      <h3>
        <?php _e( 'About the author', 'peony' );?>
        :
        <?php the_author_link(); ?>
      </h3>
      <div class="author-avatar"> <?php echo get_avatar( get_the_author_meta( 'ID' ), 70 ); ?> </div>
      <div class="author-description">
        <?php the_author_meta('description');?>
      </div>
    </div>
    <?php endif;?>
    <!--About Author End-->
    <!--Comments Area-->
    <div class="comments-area text-left">
      <?php
            if ( comments_open()  ) :
                comments_template();
            endif;
        ?>
    </div>
    <!--Comments End-->
  </div>
</section>
