<?php
/**
 * Krystal: Dynamic CSS Stylesheet
 * 
 */

function krystal_dynamic_css_stylesheet() {    
 
    $link_color= sanitize_hex_color(get_theme_mod( 'kr_link_color','#444444' ));
    $link_hover_color= sanitize_hex_color(get_theme_mod( 'kr_link_hover_color','#000000' ));    

    $heading_color= sanitize_hex_color(get_theme_mod( 'kr_heading_color','#444444' ));
    $heading_hover_color= sanitize_hex_color(get_theme_mod( 'kr_heading_hover_color','#000000' ));    
    
    $trans_button_hover_color= sanitize_hex_color(get_theme_mod( 'kr_trans_button_hover_color','#000000'));

    $button_color= sanitize_hex_color(get_theme_mod( 'kr_button_color','#444444' ));
    $button_hover_color= sanitize_hex_color(get_theme_mod( 'kr_button_hover_color','#444444' ));

    $port_image_hover_color= sanitize_hex_color(get_theme_mod( 'kr_port_image_hover_color','#444444' ));   

    $footer_bg_color= sanitize_hex_color(get_theme_mod( 'kr_footer_bg_color','#000000' ));   
    $footer_content_color= sanitize_hex_color(get_theme_mod( 'kr_footer_content_color','#ffffff' ));   
    $footer_links_color= sanitize_hex_color(get_theme_mod( 'kr_footer_links_color','#b3b3b3' ));  

    $top_menu_color= sanitize_hex_color(get_theme_mod( 'kr_top_menu_color','#ffffff' ));    
    $top_menu_button_color= sanitize_hex_color(get_theme_mod( 'kr_top_menu_button_color','#5b9dd9' ));
    $top_menu_button_text_color= sanitize_hex_color(get_theme_mod( 'kr_top_menu_button_text_color','#fff' ));
    $top_menu_dd_color= sanitize_hex_color(get_theme_mod( 'kr_top_menu_dd_color','#dd3333' ));


    $home_bg_image_text_color= sanitize_hex_color(get_theme_mod( 'kr_home_bg_image_text_color','#ffffff' ));      
    $page_bg_image_text_color= sanitize_hex_color(get_theme_mod( 'kr_page_bg_image_text_color','#ffffff' ));      

    $pagetitle_hft= absint(get_theme_mod( 'kr_pagetitle_hft','150' ));       
    $pagetitle_hfb= absint(get_theme_mod( 'kr_pagetitle_hfb','125' ));       

    $preloader_image=esc_url(get_theme_mod( 'kr_preloader_image' )); 

    //contact form color
    $cf_text_color= sanitize_hex_color(get_theme_mod( 'kr_cf_text_color','#555555'));       
    $cf_button_bg_color= sanitize_hex_color(get_theme_mod( 'kr_cf_button_bg_color','#555555'));     
    
 
    


    $css = '


    a{        
        color: ' . $link_color . '; 
        transition: all 0.3s ease-in-out; 
        vertical-align: top;
    }

    a:hover,a:focus{
        color: ' . $link_hover_color . '; 
        transition: all 0.3s ease-in-out;   
        
    }  

    h1,h2,h3,h4,h5,h6{        
        color: ' . $heading_color . '; 
    }

    h1:hover,
    h2:hover,
    h3:hover,
    h4:hover,
    h5:hover,
    h6:hover{
        color: ' . $heading_hover_color . ';    
    }

    button.trans:hover, 
    button.trans:focus, 
    button.trans:active{
        background: ' . $trans_button_hover_color . ' !important;    
        color: #fff !important;    
    }  

    #commentform input[type=submit]:hover{
        background: ' . $trans_button_hover_color . ' !important;
        border: 1px solid ' . $trans_button_hover_color . ' !important;
        color: #fff !important;
        transition: all 0.3s ease-in-out; 
    }

    a.trans:hover{
        background: ' . $trans_button_hover_color . ' !important;
        border: 1px solid ' . $trans_button_hover_color . ' !important;
        color: #fff !important;
        transition: all 0.3s ease-in-out;
    }

    .slide-bg-section .read-more a:hover,
    .slider-buttons a:hover{
        background: ' . $trans_button_hover_color . ' !important;
        border: 1px solid ' . $trans_button_hover_color . ' !important;
        color: #fff !important;
        transition: all 0.3s ease-in-out;
    }

    .btn-default{
        background: ' . $button_color . ' !important;
        border: 1px solid ' . $button_color . ' !important;
    }

    .btn-default:hover{
        background: ' . $button_hover_color . ' !important;
    }

    .slider-buttons a .btn-default{
        background:none !important;
    }

    .dropdown-menu > li > a:hover, 
    .dropdown-menu > li > a:focus{
        background: ' . $top_menu_dd_color . ' !important;
    }

    .dropdown-menu > .active > a, 
    .dropdown-menu > .active > a:hover, 
    .dropdown-menu > .active > a:focus{
        background: ' . $top_menu_dd_color . ' !important;   
    }

    .pagination .nav-links .current{
        background: ' . $link_color . ' !important;
    }

    .isotope #filter li.selected a, 
    .isotope #filter li a:hover {
        color: ' . $link_color . ' !important;
    }

    [class^=\'imghvr-fold\']:after, 
    [class^=\'imghvr-fold\']:before, 
    [class*=\' imghvr-fold\']:after, 
    [class*=\' imghvr-fold\']:before{
        background-color: ' . $port_image_hover_color . ' !important;
    }

    [class^=\'imghvr-\'] figcaption, [class*=\' imghvr-\'] figcaption {    
        background-color: ' . $port_image_hover_color . ' !important;
    }

    footer#footer {        
        background: ' . $footer_bg_color . ';
        color: ' . $footer_content_color . ';
    }

    footer h4{
        color: ' . $footer_content_color . ';   
    }

    footer#footer a,
    footer#footer a:hover{
        color: ' . $footer_links_color . ';      
    }

    .section-title.page-title{
        padding-top: ' . $pagetitle_hft . 'px;
        padding-bottom: ' . $pagetitle_hfb . 'px;
    }

    header.menu-wrapper nav ul li a,
    header.menu-wrapper.style-2 nav ul li a,
    .site-title a, .site-title a:hover, .site-title a:focus, .site-title a:visited,
    p.site-description,
    .navbar-toggle{
        color: ' . $top_menu_color . ';      
    }

    header.menu-wrapper.fixed nav ul li a,
    header.menu-wrapper.style-2.fixed nav ul li a{
        color: #555;
    }

    .main-menu li.menu-button > a {
        background-color: ' . $top_menu_button_color . ';
        color: ' . $top_menu_button_text_color . ' !important;        
    }

    .main-menu li.menu-button > a:active,
    .main-menu li.menu-button > a:hover {
        background-color: ' . $top_menu_button_color . ';
        color: ' . $top_menu_button_text_color . ' !important;
    }

    header.menu-wrapper.fixed nav ul li.menu-button a, 
    header.menu-wrapper.style-2.fixed nav ul li.menu-button a{
        color: ' . $top_menu_button_text_color . ' !important;   
        background: ' . $top_menu_button_color . ';
    }

    .slide-bg-section h1,
    .slide-bg-section,
    .slide-bg-section .read-more a{
        color: ' . $home_bg_image_text_color . ' !important;         
    }

    .slide-bg-section .read-more a,
    .scroll-down .mouse{
        border: 1px solid ' . $home_bg_image_text_color . ' !important;         
    }

    .scroll-down .mouse > *{
        background: ' . $home_bg_image_text_color . ' !important;         
    }

    .section-title h1,
    .bread-crumb, .bread-crumb span{
        color: ' . $page_bg_image_text_color . ';            
    }

    form.wpcf7-form input,
    form.wpcf7-form textarea,
    form.wpcf7-form radio,
    form.wpcf7-form checkbox,
    form.wpcf7-form select{
        background: transparent;
        border: none;
        border-bottom: 1px solid ' . $cf_text_color .';
        color: ' . $cf_text_color .';
    }

    form.wpcf7-form select{
        padding-left: 20px;
    }

    form.wpcf7-form input::placeholder,
    form.wpcf7-form textarea::placeholder{
        color: ' . $cf_text_color .';   
    }

    form input[type="submit"]{
        color: ' . $cf_text_color .';
        border: 1px solid ' . $cf_text_color . ' !important;
    }

    form input[type="submit"]:hover{
        background: ' . $cf_button_bg_color . ' !important;
        color: #fff;
        border: 1px solid ' . $cf_button_bg_color . ' !important;
    }

    form.wpcf7-form label{
        color: ' . $cf_text_color . ';               
    }

';

if("" != esc_url(get_theme_mod( 'kr_preloader_image' ))) {
    $css .='        
        #pre-loader{
            background: url(' . $preloader_image . ') no-repeat !important;
        }
    ';  
}


if(false===get_theme_mod( 'kr_sticky_menu',true)) {
    $css .='        
         header.menu-wrapper.fixed{ 
            display:none !important;
        }           
    ';  
}

if(false===get_theme_mod( 'kr_home_dark_overlay',true)) {
    $css .='        
         #parallax-bg #slider-inner:before{            
            background: none !important;    
            opacity: 0.8;            
        }           
    ';  
}

if(true===get_theme_mod( 'kr_home_disable_section',false)) {
    $css .='        
        #parallax-bg,
        .home-color-section{            
            display: none;            
        } 

        .page .page-content-area{
            margin: 0;
        }      

        .woocommerce .page-content-area,
        .woocommerce-page .page-content-area{
            margin: 70px 0;
        }          

        .elementor-editor-active header.menu-wrapper{
            z-index: 0;
        }

        .home .page-content-area{
            margin: 0;
        }
    ';  
}

if(true===get_theme_mod( 'kr_page_dark_overlay',false)) {
    $css .='        
         .page-title .img-overlay{
            background: rgba(0,0,0,.5);
            color: #fff;
        }          
    ';  
}

if(true===get_theme_mod( 'kr_blog_homepage',false)) {
    $css .='        
         #parallax-bg #slider-inner{
           height: 70vh;
        }

        section.home-color-section{
            height: 70vh;
        }

        .slide-bg-section{
            height: calc(70vh - 5px);
        } 

        body{
            background: #fbfbfb;
        }

        article{
            margin: 70px 0;
            background: #fff;
            padding: 1px 30px;            
            box-shadow: 0px 0px 3px 0px #c5c5c5;
            -moz-box-shadow: 0px 0px 3px 0px #c5c5c5;
            -webkit-box-shadow: 0px 0px 3px 0px #c5c5c5;
        }

        article .blog-wrapper{
            margin: 0;
            padding-top: 30px;
            padding-right: 0;
        }

        .widget-area .widget{
            margin: 5px 0;
            background: #fff;
            padding: 20px 20px;            
            box-shadow: 0px 0px 3px 0px #c5c5c5;
            -moz-box-shadow: 0px 0px 3px 0px #c5c5c5;
            -webkit-box-shadow: 0px 0px 3px 0px #c5c5c5;
        }

        aside h4.widget-title{
            font-size: 15px;
        }

        .widget li a{
            color: #555;
        }

        .widget-area{
            margin:70px 0;
        }

        body.page{
            background: #fff;
        }

        .page-content-area article{
            box-shadow: none;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
        }
    ';  
}

if(is_active_sidebar('footer-column1') || is_active_sidebar('footer-column2') || is_active_sidebar('footer-column3') || is_active_sidebar('footer-column4')){
    $css .='        
        footer#footer{
            padding-top: 50px;
        }
    ';
}


return apply_filters( 'krystal_dynamic_css_stylesheet', $css);
}


?>


