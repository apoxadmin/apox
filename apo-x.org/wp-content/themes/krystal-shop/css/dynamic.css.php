<?php
/**
 * Krystal-Shop: Dynamic CSS Stylesheet
 * 
 */

function krystal_shop_dynamic_css_stylesheet() {    
 
    $link_color= esc_attr(get_theme_mod( 'kr_link_color','#444444' ));
    $link_hover_color= esc_attr(get_theme_mod( 'kr_link_hover_color','#000000' ));
    $button_color= esc_attr(get_theme_mod( 'kr_button_color','#444444' ));
    $button_hover_color= esc_attr(get_theme_mod( 'kr_button_hover_color','#444444' ));
    $top_menu_color= esc_attr(get_theme_mod( 'kr_top_menu_color','#ffffff' ));      

    $css = '

    header.menu-wrapper .nav li .fa,
    header.menu-wrapper.style-2 .nav li .fa,
    .site-title a, .site-title a:hover, .site-title a:focus, .site-title a:visited,
    p.site-description,
    .navbar-toggle{
        color: ' . $top_menu_color . ';      
    }
    
    header.menu-wrapper.fixed .nav li .fa,
    header.menu-wrapper.style-2.fixed .nav li .fa{
        color: #555;
    }

    .woocommerce ul.products li.product .button:hover,
    .woocommerce .widget_price_filter .price_slider_amount .button:hover,
    .single_add_to_cart_button:hover,
    .woocommerce a.button:hover,
    .woocommerce button.button:hover{
        color: #fff !important;
        background: ' . $button_hover_color . '!important;
    }

    .woocommerce-cart-form input[type="submit"]{
        color: #555 !important;
        border: none !important;
        border: none !important;
    }

    .woocommerce-cart-form input[type="submit"]:hover{
        color: #fff !important;
        background: ' . $button_hover_color . '!important;
        border: none !important;   
    }

    .wc-proceed-to-checkout a:hover{
        background: ' . $button_hover_color . '!important;
    }

    .woocommerce nav.woocommerce-pagination ul li span.current,
    .woocommerce nav.woocommerce-pagination ul li a:hover{
        background: ' . $button_color . '!important;
    }

    #commentform input[type=submit]:hover{
        background: ' . $button_hover_color . '!important;   
    }

    #woocat-show .description h5 a {
        color: ' . $link_color . ';
    }

    #woocat-show .description h5 a:hover {
        color: ' . $link_hover_color . ';
    }
}

';

if('solid'===esc_attr(get_theme_mod( 'kr_shop_button_styles',__('solid','krystal-shop')))) {
    $css .='        

        .woocommerce ul.products li.product .button{
            color: #fff !important;
            background: ' . $button_color . '!important;
        }
        
        .woocommerce ul.products li.product .button,
        .woocommerce .widget_price_filter .price_slider_amount .button,
        .single_add_to_cart_button,
        .woocommerce a.button,
        .woocommerce button.button{
            color: #fff !important;
            background: ' . $button_color . '!important;
        }

        .woocommerce-cart-form input[type="submit"]{
            background: ' . $button_color . '!important;
            color: #fff !important;
            border: none !important;
            border: none !important;
        } 

        .woocommerce nav.woocommerce-pagination ul li a:focus, 
        .woocommerce nav.woocommerce-pagination ul li a:hover, 
        .woocommerce nav.woocommerce-pagination ul li span.current{
            background: ' . $button_color . '!important;
        }    

        .woocommerce #respond input#submit.alt,
        .woocommerce a.button.alt, 
        .woocommerce button.button.alt, 
        .woocommerce input.button.alt,
        .woocommerce .cart .button{
            color: #fff !important;
        }

        .woocommerce #review_form #respond .form-submit input{
            background: ' . $button_color . '!important;
            color: #fff !important;
            border: none !important;
            border: none !important;
        }
    ';  
}

return apply_filters( 'krystal_shop_dynamic_css_stylesheet', $css);

}

?>


