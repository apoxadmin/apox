<?php

/**
 * Load SiteOrigin Widgets.
 */
if ( class_exists( 'SiteOrigin_Widget' ) ) {

    if ( ! function_exists( 'boka_add_tab_in_builer_widgets_panel' ) ) :

        /**
         * Add tab in builder widgets section.
         *
         * @param array $tabs Tabs.
         * @return array Modified tabs.
         */
        function boka_add_tab_in_builer_widgets_panel( $tabs ) {
            $tabs['boka'] = array(
                'title'  => __( 'Boka Widgets', 'boka' ),
                'filter' => array(
                    'groups' => array( 'boka' ),
                ),
            );
            return $tabs;
        }

    endif;
    add_filter( 'siteorigin_panels_widget_dialog_tabs', 'boka_add_tab_in_builer_widgets_panel' );

    if ( ! function_exists( 'boka_group_theme_widgets_in_builder' ) ) :

        /**
         * Grouping theme widgets in builder.
         *
         * @since 1.0.0
         *
         * @param array $widgets Widgets array.
         * @return array Modified widgets array.
         */
        function boka_group_theme_widgets_in_builder( $widgets ) {

            if ( isset( $GLOBALS['wp_widget_factory'] ) && ! empty( $GLOBALS['wp_widget_factory']->widgets ) ) {
                $all_widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets );
                foreach ( $all_widgets as $widget ) {
                    if ( false !== strpos( $widget, 'Boka_' ) ) {
                        $widgets[ $widget ]['groups'] = array( 'boka' );
                        $widgets[ $widget ]['icon']   = 'dashicons dashicons-align-none';
                    }
                }
            }
            return $widgets;

        }
    endif;
    add_filter( 'siteorigin_panels_widgets', 'boka_group_theme_widgets_in_builder' );

   // require get_template_directory() . '/inc/widget/testimonial/testimonial.php';
    //require get_template_directory() . '/inc/widget/brand/brand.php';
    //require get_template_directory() . '/inc/widget/fact/fact.php';
    //require get_template_directory() . '/inc/widget/service/service.php';
    //require get_template_directory() . '/inc/widget/editor/editor.php';
    //require get_template_directory() . '/inc/widget/social/social.php';
    //require get_template_directory() . '/inc/widget/newsletter/newsletter.php';
    //require get_template_directory() . '/inc/widget/recent-blog/recent-blog.php';
    //require get_template_directory() . '/inc/widget/portfolio/portfolio.php';



    require get_template_directory() . '/inc/widget/testimonial/testimonial.php';

    require get_template_directory() . '/inc/widget/camera-slider/camera-slider.php';
    require get_template_directory() . '/inc/widget/pricing/pricing.php';
    require get_template_directory() . '/inc/widget/heading/heading.php';
    require get_template_directory() . '/inc/widget/content-box/content-box.php';
    require get_template_directory() . '/inc/widget/featured-list/featured-list.php';
    require get_template_directory() . '/inc/widget/list-items/list-items.php';
    require get_template_directory() . '/inc/widget/button/button.php';
    require get_template_directory() . '/inc/widget/team/team.php';
}