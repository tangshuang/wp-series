<?php

/*
Plugin Name: WP Series
Plugin URI: http://www.tangshuang.net/wp-series
Description: 为你的wordpress创建专题
Version: 0.1.0
Author: Tison
Author URI: http://www.tangshuang.net
Origin: https://github.com/tangshuang/wp-series
*/

define('WP_SERIES',__FILE__); // 插件名称

// 增加一种文章type,名字叫series,作为系列类型,每一篇series代表一个专题,在该专题下,可以有多篇文章.
require 'series-post-type.php';

// 在专题编辑中增加文章选择列表
require 'series-metabox.php';

// 模板文件
require 'series-template.php';

// 短代码
require 'series-shortcode.php';

// 添加普通文章中的选择器
require 'series-post-metabox.php';



