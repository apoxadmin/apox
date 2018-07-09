<?php
/**
 * Hero Section for our theme
 * @subpackage Parallel
 * @since Parallel 1.0
 */
?>
<section id="welcome" class="hero default">

    <div class="blacklayer"></div>

    <div class="container">
        
        <div class="row">
            
            <div class="col-md-12">
                
                <div class="title text-center">

                    <h1><?php echo esc_html(get_theme_mod( 'parallel_default_header_title1', __( 'One-page Business Theme', 'parallel' ) ) ); ?></h1>

                    <h2><?php echo esc_html(get_theme_mod( 'parallel_default_header_title2', '' ) ); ?></h2>

                </div>
                                
                <div class="lead text-center">
                    <p><?php echo wp_kses_post(get_theme_mod( 'parallel_default_header_tagline', __( 'A professional WordPress theme for freelancers, agencies and businesses.<br />Create a stunning website in minutes.', 'parallel' ) ) ); ?></p>
                </div>              
                
                <?php if ( get_theme_mod( 'parallel_default_header_btn1_toggle' ) == '' && get_theme_mod( 'parallel_default_header_btn2_toggle' ) == '1' ) { ?>
                <div class="col-md-12 text-center">
                    <a href="<?php echo esc_url(get_theme_mod( 'parallel_default_header_btn1url', '#' )); ?>" class="btn btn-lg btn-secondary"><?php echo esc_html(get_theme_mod( 'parallel_default_header_btn1', __( 'View Features', 'parallel' ) ) ); ?></a>
                </div>
                <?php } else if ( get_theme_mod( 'parallel_default_header_btn1_toggle', '1' ) == '') { ?>
                <div class="col-md-6 text-right">
                    <a href="<?php echo esc_url(get_theme_mod( 'parallel_default_header_btn1url', '#' )); ?>" class="btn btn-lg btn-secondary"><?php echo esc_html(get_theme_mod( 'parallel_default_header_btn1', __( 'View Features', 'parallel' ) ) ); ?></a>
                </div>
                <?php } ?>
                
                <?php if ( get_theme_mod( 'parallel_default_header_btn2_toggle' ) == '' && get_theme_mod( 'parallel_default_header_btn1_toggle', '1' ) == '1' ) { ?>
                <div class="col-md-12 text-center">
                    <a href="<?php echo esc_url(get_theme_mod( 'parallel_default_header_btn2url', '#' )); ?>" class="btn btn-lg btn-primary"><?php echo esc_html(get_theme_mod( 'parallel_default_header_btn2', __( 'Download Now', 'parallel' ) ) ); ?></a>
                </div>
                <?php } else if ( get_theme_mod( 'parallel_default_header_btn2_toggle' ) == '') { ?>
                <div class="col-md-6 text-left">
                    <a href="<?php echo esc_url(get_theme_mod( 'parallel_default_header_btn2url', '#' )); ?>" class="btn btn-lg btn-primary"><?php echo esc_html(get_theme_mod( 'parallel_default_header_btn2', __( 'Download Now', 'parallel' ) ) ); ?></a>
                </div>
                <?php } ?>
            
            </div>
        
        </div>
    
    </div>

</section><!--hero-->