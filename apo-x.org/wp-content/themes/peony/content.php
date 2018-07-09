<?php
/**
 * @package peony
 */
	$display_image = peony_option('archive_display_image');
	$display_meta_readmore   = peony_option('display_meta_readmore');
	$display_meta_categories = peony_option('display_meta_categories');
	$display_meta_comments   = peony_option('display_meta_comments');
	
	$post_class = 'entry-box-wrap';
	$has_post_thumbnail = '';
	if ( $display_image == '1' && has_post_thumbnail() ){
		$has_post_thumbnail = '1';
		}
?>

<div id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>
  <div class="entry-box-wrap">
    <article class="entry-box">
      <?php if (  $has_post_thumbnail == '1' ) :
	  			$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), "large" );
	  
	  ?>
      <div class="entry-image">
        <div class="img-box figcaption-middle text-center fade-in">
          <?php the_post_thumbnail();  ?>
          <div class="img-overlay">
            <div class="img-overlay-container">
              <div class="img-overlay-content">
                <div class="img-overlay-icons"> 
                <a href="<?php the_permalink();?>"><i class="fa fa-link"></i></a>
                <a rel='prettyPhoto' href="<?php echo esc_url($image_attributes[0]);?>"><i class="fa fa-search"></i></a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php endif;?>
      <div class="entry-main">
        <div class="entry-header">
        <?php if ( $display_meta_categories == '1' ):?>
          <div class="entry-category"><?php the_category('<span>&middot;</span>');?></div>
          <?php endif; ?>
          <h2 class="entry-title"><a href="<?php the_permalink();?>">
            <?php the_title();?>
            </a></h2>
          <?php peony_posted_on(); ?>
        </div>
        <div class="entry-summary"><?php echo peony_get_summary();?></div>
        <div class="entry-footer clearfix">
          <?php if ( $display_meta_readmore == '1' ): ?>
          <div class="pull-left">
            <div class="entry-more"><a href="<?php the_permalink();?>"><?php _e( 'Continue Reading', 'peony' );?>&hellip;</a></div>
          </div>
          <?php endif; ?>
          <?php if ( $display_meta_comments == '1' ):?>
          <div class="pull-right">
            <div class="entry-comments"><?php echo peony_get_comments_popup_link('', __( '1 comment', 'peony'), __( '% comments', 'peony'), 'read-comments', '');?></div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </article>
  </div>
</div>