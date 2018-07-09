<?php

/**
 *  Social
 */
function boka_header_social_action() { ?>

    <ul class="list-inline text-right margin-null">
        <?php
        if( get_theme_mod('header_fb') ) {
            echo '<li><a href="'.esc_url( get_theme_mod('header_fb') ).'"  target="_blank"><i class="fa fa-facebook"></i></a></li>';
        }
        if( get_theme_mod('header_tw') ) {
            echo '<li><a href="'.esc_url( get_theme_mod('header_tw') ).'" target="_blank"><i class="fa fa-twitter"></i></a></li>';
        }
        if( get_theme_mod('header_li') ) {
            echo '<li><a href="'.esc_url( get_theme_mod('header_li') ).'" target="_blank"><i class="fa fa-linkedin"></i></a></li>';
        }
        if( get_theme_mod('header_pint') ) {
            echo '<li><a href="'.esc_url( get_theme_mod('header_pint') ).'" target="_blank"><i class="fa fa-pinterest"></i></a></li>';
        }
        if( get_theme_mod('header_ins') ) {
            echo '<li><a href="'.esc_url( get_theme_mod('header_ins') ).'" target="_blank"><i class="fa fa-instagram"></i></a></li>';
        }
        if( get_theme_mod('header_dri') ) {
            echo '<li><a href="'.esc_url( get_theme_mod('header_dri') ).'" target="_blank"><i class="fa fa-dribbble"></i></a></li>';
        }
        if( get_theme_mod('header_plus') ) {
            echo '<li><a href="'.esc_url( get_theme_mod('header_plus') ).'" target="_blank"><i class="fa fa-google-plus"></i></a></li>';
        }
        if( get_theme_mod('header_you') ) {
            echo '<li><a href="'.esc_url( get_theme_mod('header_you') ).'" target="_blank"><i class="fa fa-youtube"></i></a></li>';
        }
        ?>
    </ul>

    <?php
}
add_action( 'boka_social', 'boka_header_social_action' );

/********************************************************
 * Footer
 ********************************************************/
/**
 * Bottom Footer Copyright
 */
function boka_footer_copyright(){
    ?>
    <div class="col-md-6 col-sm-6 col-xs-12 site-info">
        <a href="<?php echo esc_url( __( 'https://www.themetim.com', 'boka' ) ); ?>">
            <?php
            echo esc_html( get_theme_mod( 'copyright', 'Boka By ThemeTim' ) );
            ?>
        </a>
    </div>
    <?php
}
add_action( 'boka_footer_copyright', 'boka_footer_copyright' );