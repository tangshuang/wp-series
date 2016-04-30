<?php

//http://code.tutsplus.com/tutorials/a-guide-to-wordpress-custom-post-types-creation-display-and-meta-boxes--wp-27645

add_filter( 'template_include', 'wp_series_include_template_function', 1 );
function wp_series_include_template_function( $template_path ) {
    if ( get_post_type() == 'series' ) {
        if ( is_single() ) {
            if ( $theme_file = locate_template( array ( 'single-series.php' ) ) ) {
                $template_path = $theme_file;
            }
            else {
                $template_path = plugin_dir_path( WP_SERIES ) . '/template/single-series.php' || $template_path = plugin_dir_path( WP_SERIES ) . '/template/single.php';
            }
        }
        elseif(is_archive()) {
            if ( $theme_file = locate_template( array ( 'archive-series.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( WP_SERIES ) . '/template/archive-series.php' || $template_path = plugin_dir_path( WP_SERIES ) . '/template/archive.php';
            }
        }
    }
    return $template_path;
}