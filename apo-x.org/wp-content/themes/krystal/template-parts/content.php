<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package krystal
 */
?>


	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="blog-wrapper blog-list wow fadeInUp animated" data-wow-delay="0.2s">
            <?php
                if ( has_post_thumbnail()) {
                    ?>
                        <div class="image">
                            <?php
                                the_post_thumbnail('full');
                            ?>
                        </div>                      
                    <?php                    
                }                   
            ?>
            <div class="meta-wrapper">
                <div class="meta">
                    <?php
                        if(is_sticky()){
                            ?>                                        
                                <span class="meta-item">
                                    <i class="fa fa-thumb-tack"></i><?php _e('Sticky Post','krystal') ?>
                                </span> 
                            <?php       
                        }                                
                    ?>              
                    <span class="meta-item">
                        <i class="fa fa-clock-o"></i><?php the_time(get_option('date_format')) ?>
                    </span>                                            
                    <span class="meta-item">
                        <i class="fa fa-user"></i><a class="author-post-url" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>"><?php the_author() ?></a>
                    </span>                        
                    <span class="meta-item">
                        <i class="fa fa-commenting"></i><a class="post-comments-url" href="<?php the_permalink() ?>#comments"><?php comments_number('0','1','%'); ?> <?php _e('Comments','krystal'); ?></a>
                    </span>
                </div>  
            </div>
            <div class="blog-content">
                <div class="heading">
                    <h3>
                        <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                    </h3>
                </div>
                <?php 
                    if(is_single()){
                        ?>
                            <div class="blog-content">
                                <p><?php the_content(); ?></p>
                            </div>
                            <div class="post-info single">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="post-category">
                                            <?php _e('Categories:','krystal') ?><?php the_category(); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="post-tags single">
                                            <?php the_tags(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                    else{
                        ?>
                            <div class="blog-excerpt">
                                <p><?php the_excerpt(); ?></p>
                            </div>
                        <?php
                    }
                ?>                
            </div>
            <?php
                if(!is_single()){
                    ?>
                        <div class="read-more">
                            <a href="<?php the_permalink() ?>"><?php _e('READ MORE ','krystal'); ?></a>
                        </div>
                    <?php
                }
            ?>    
            <?php
                wp_link_pages( array(
                    'before'      => '<div class="page-links">' . __( 'Pages:', 'krystal' ),
                    'after'       => '</div>',
                    'link_before' => '<span class="page-number">',
                    'link_after'  => '</span>',
                ) );
            ?>        
        </div>
    </article>