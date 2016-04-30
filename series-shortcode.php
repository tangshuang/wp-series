<?php

add_shortcode('series','add_series_shortcode_in_post');
function add_series_shortcode_in_post($atts){
    extract(shortcode_atts(array(
        'name' => '',
        'number' => 10
    ),$atts));

    global $wpdb;
    $series_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name=%s AND post_type=%s AND post_status=%s LIMIT 1", $name,'series','publish' ) );
    if(!$series_id) return;

    $post_ids = get_post_meta($series_id,'_contain_post_id');
    if(!$post_ids) return;

    $html = '';

    query_posts(array(
        'post__in' => $post_ids,
        'posts_per_page' => $number,
        'post_type' => 'post',
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1
    ));
    while(have_posts()) {
        the_post();
        $html .= '<li><a href="'.get_the_permalink().'">'.(get_the_title() ? get_the_title() : '[无题]'.get_the_time('Y-m-d H:i')).'</a></li>';
    }
    wp_reset_query();

    return $html;
}