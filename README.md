# wp-series
WordPress Series Plugin, 一个简单的WordPress专题插件

## 安装
将插件上传到你的wordpress插件目录，然后登陆wordpress后台，启动该插件。

## 使用
启用插件后，在菜单中会出现一个“专题”新菜单，可以添加和修改专题。创建专题时，从下方的选项中，把以前写好的文章加入到该专题，发布专题即可。在撰写文章的时候，也可以选择把该文章加入到某个或某些专题。

## 模板
专题的模板使用的是archive-series.php和single-series.php这两个模板，需要你自己开发。其实和其他的文章模板是差不多的，如果你懂怎么开发的话，就很简单了。
如果你的主题目录下不存在这两个模板，就会到插件目录下的template目录中去找，如果还没有，就直接使用single.php和archive.php这两个模板文件。
