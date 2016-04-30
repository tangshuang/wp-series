<?php

// 添加区域
add_action('admin_init','add_series_metabox_init');
function add_series_metabox_init(){
    add_meta_box(
        'series_posts',
        '专题文章',
        'add_series_metabox_view',
        'series',
        'normal',
        'high'
    );
    add_action('save_post','add_series_metabox_save');
    add_series_commomd_query_posts();
}

// 区域视图
function add_series_metabox_view($post){
    ?>
    <link rel="stylesheet" href="<?php echo plugins_url('css/style.css',WP_SERIES) ?>">
    <div class="series-posts" id="series-posts">
        <div class="series-posts-container" id="series-posts-container"></div>
        <div class="series-posts-list" id="series-posts-list"></div>
        <div class="series-posts-bar">
            <input type="text" id="series-posts-key" class="regular-text" placeholder="通过搜索来获取文章列表">
            <button type="button" class="button" id="series-search">搜索</button>
        </div>
    </div>
    <script src="<?php echo plugins_url('js/javascript.js',WP_SERIES) ?>"></script>
<?php
}

// 保存数据
function add_series_metabox_save($post_id){
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    $post_ids = $_POST['_contain_post_id'];
    $posts_exists = get_post_meta($post_id,'_contain_post_id');

    // 先对已有的更新或删除
    if(!empty($posts_exists)) foreach($posts_exists as $id) {
        if(!in_array($id,$post_ids)) {//该值存在于数据库中，但是却没有在提交的数据中，说明应该被删除
            delete_post_meta($post_id,'_contain_post_id',$id);
        }// 其他数据保持不变
        $key = array_search($id,$post_ids);
        unset($post_ids[$key]);
    }
    // 对新增的数据进行保存
    if(!empty($post_ids)) foreach($post_ids as $id) add_post_meta($post_id,'_contain_post_id',$id);
}

// 查询文章列表
function add_series_commomd_query_posts() {

    $_type = isset($_GET['commond']) ? $_GET['commond'] : false;
    $_value = isset($_GET['key']) ? $_GET['key'] : false;
    $_series = isset($_GET['series']) ? $_GET['series'] : false;
    $_paged = isset($_GET['paged']) && is_numeric($_GET['paged']) ? $_GET['paged'] : 1;
    $posts = array();
    $args = array();
    $post_ids = false;

    if($_series) {
        global $wpdb;
        $series_id = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE ID=%d LIMIT 1", $_series ) ); // 即使是草稿，也可以使用
        if(!$series_id) exit;
        $post_ids = get_post_meta($series_id,'_contain_post_id');
    }

    if($_type == 'query_posts') {
        $args = array(
            'posts_per_page' => 10,
            'paged' => $_paged,
            'post_type' => 'post',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1
        );
        if($post_ids) $args['post__not_in'] =$post_ids;
        if($_value) $args['s'] = $_value;
    }
    elseif($_type == 'query_series_posts') {
        if(!$post_ids) exit;
        $args = array(
            'post__in' => $post_ids,
            'post_type' => 'post',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1
        );
    }

    if($_type) {
        $query = new WP_Query($args);
        while ( $query->have_posts() ) {
            $query->the_post();
            $posts[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title() ? get_the_title() : '[无题]'.get_the_time('Y-m-d H:i'),
                'link' => get_the_permalink()
            );
        }
        wp_reset_postdata();

        header('Content-Type: application/json');
        echo json_encode($posts);
        exit;
    }

}