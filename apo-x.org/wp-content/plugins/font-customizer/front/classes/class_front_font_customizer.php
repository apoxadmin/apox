<?php
/**
* Plugin front end functions
* @author Nicolas GUILLAUME
* @since 1.0
*/
class TC_front_font_customizer {
    
    //Access any method or var of the class with classname::$instance -> var or method():
    static $instance;

    public $is_customizing;

    function __construct () {
        //add_action( 'init'                              , array( $this, 'tc_add_style' ) );
        add_action( 'init'                              , array( $this , 'tc_enqueue_plug_resources' ) , 0 );
        add_action( 'wp_head'                           , array($this , 'tc_write_gfonts'), 0 );
        add_action( 'wp_head'                           , array($this , 'tc_write_font_dynstyle'), 0 );
        add_action( 'wp_head'                           , array($this , 'tc_write_other_dynstyle'), 999 );

        //$this -> is_customizing = isset($_REQUEST['wp_customize']) ? 1 : 0;
    }//end of construct



    function tc_write_gfonts() {
        if ( ! get_option('tc_wfc_gfonts') ) {
            TC_utils_wfc::$instance -> tc_update_front_end_gfonts();
        }
        $families   = get_option('tc_wfc_gfonts');
        if ( empty($families) )
            return;

        printf('<link rel="stylesheet" id="tc-front-gfonts" href="%1$s">',
            "//fonts.googleapis.com/css?family={$families}"
        );
    }


    function tc_write_font_dynstyle() {
        ?>
        <style id="dyn-style-fonts" type="text/css">
            <?php do_action( '__dyn_style' , 'fonts' ); ?>
        </style>
        <?php
    }


    function tc_write_other_dynstyle() {
        ?>
        <style id="dyn-style-others" type="text/css">
            <?php do_action( '__dyn_style' , 'other' ); ?>
        </style>
        <?php
    }


    /* PLUGIN FRONT END FUNCTIONS */
    function tc_enqueue_plug_resources() {
        //WFC front scripts
        wp_enqueue_script( 
            'font-customizer-script' ,
            plugins_url( TC_PLUG_DIR_NAME . '/front/assets/js/font-customizer-front.min.js'),
            array(),
            null ,
            true
        );
        wp_enqueue_style( 
          'font-customizer-style' ,
          plugins_url( TC_PLUG_DIR_NAME . '/front/assets/css/font_customizer.min.css' ),
          array(), 
          TC_font_customizer::$instance -> plug_version,
          $media = 'all' 
        );

        //localize font-customizer-script with settings fonts
        wp_localize_script( 
          'font-customizer-script', 
          'FrontParams',
            array(
                'SavedSelectorsSettings'        => TC_font_customizer::$instance -> tc_get_saved_option( null , false ),
                'DefaultSettings'               => TC_font_customizer::$instance -> tc_get_selector_list(),
            )
        );
    }


} //end of class