<?php

add_action('init','register_post_type_series');
function register_post_type_series(){
    $labels = array(
        'name'               => _x( '专题','专题'),
        'singular_name'      => _x( '专题','专题'),
        'menu_name'          => _x( '专题','专题'),
        'name_admin_bar'     => _x( '专题','专题'),
        'add_new'            => _x( '添加','专题'),
        'add_new_item'       => __( '添加专题'),
        'new_item'           => __( '添加'),
        'edit_item'          => __( '编辑'),
        'view_item'          => __( '查看'),
        'all_items'          => __( '专题列表'),
        'search_items'       => __( '搜索'),
        'parent_item_colon'  => __( '父级专题: '),
        'not_found'          => __( '没有找到专题.'),
        'not_found_in_trash' => __( '回收站中没有专题.')
    );

    $args = array(
        'labels'             => $labels,
        'description'        => '把一系列文章组合在一起',
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'series' ),
        'capability_type'    => 'page',
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail','comments','excerpt','page-attributes' )
    );

    register_post_type( 'series', $args );
}