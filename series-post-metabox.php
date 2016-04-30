<?php

// 添加区域
add_action('admin_init','add_post_series_metabox_init');
function add_post_series_metabox_init(){
    add_meta_box(
        'post_series',
        '所属专题',
        'add_post_series_metabox_view',
        'post',
        'side',
        'high'
    );
    add_action('save_post','add_post_series_metabox_save');
    add_series_commomd_query_posts();
}

// 区域视图
function add_post_series_metabox_view($post){
    global $wpdb;
    $series_ids = $wpdb->get_col($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key=%s AND meta_value=%d",'_contain_post_id',$post->ID));

    $args = array(
        'post_type' => 'series',
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1
    );
    $query = new WP_Query($args);
    ?>
    <div class="tabs-panel" style="display: block;max-height: 150px;overflow-x: hidden;">
        <ul class="form-no-clear">
            <?php  while ( $query->have_posts() ) { $query->the_post(); ?>
            <li><label class="selectit"><input value="<?php the_ID(); ?>" type="checkbox" name="_series_id[]" <?php if(in_array(get_the_ID(),$series_ids)) echo 'checked'; ?>> <?php the_title(); ?></label></li>
            <?php } ?>
        </ul>
    </div>
    <?php
    wp_reset_postdata();
}

// 保存数据
function add_post_series_metabox_save($post_id){
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    global $wpdb;
    $series_exists = $wpdb->get_col($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key=%s AND meta_value=%d",'_contain_post_id',$post_id));
    $series_ids = $_POST['_series_id'];

    // 检查已存在于数据库中的数据是否需要更新
    if(!empty($series_exists)) foreach($series_exists as $series_id) {
        if(!in_array($series_id,$series_ids)) { // 如果数据库中的某值不存在于提交的数据中，说明该数据应该删除
            delete_post_meta($series_id,'_contain_post_id',$post_id);
        }//其他数据保持不变
        $key = array_search($series_id,$series_ids);
        unset($series_ids[$key]);
    }
    // 对新增的数据进行保存
    if(!empty($series_ids)) foreach($series_ids as $series_id) add_post_meta($series_id,'_contain_post_id',$post_id);
}