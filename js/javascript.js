jQuery(function($){
    var url = window.location.href;
    var post_name = $('#post_ID').val();
    // 获取当前专题含有的文章
    if($('#post_name').val() != '') { // 如果编辑专题
        $.get(url + '&commond=query_series_posts&series=' + post_name,function(result){
            if(result == null || result.length <= 0) return;
            var html = '<div class="items">',item;
            for(i = 0;i < result.length;i ++) {
                item = result[i];
                html += '<div class="item">';
                html += '<input type="checkbox" name="_contain_post_id[]" value="' + item.id + '" checked>';
                html += '<a href="' + item.link + '" target="_blank">' + item.title + '</a>';
                html += '</div>';
            }
            html += '</div>';
            $('#series-posts-container').html(html);
        },'json');
    }
    // 填充备选列表
    function _list_(result) {
        if(result == null || result.length <= 0) {
            $('#series-posts-list').html('');
            return;
        }
        var html = '<div class="items">',item;
        for(i = 0;i < result.length;i ++) {
            item = result[i];
            html += '<div class="item">';
            html += '<input type="checkbox" name="_contain_post_id[]" value="' + item.id + '">';
            html += '<a href="' + item.link + '" target="_blank">' + item.title + '</a>';
            html += '</div>';
        }
        html += '</div>';
        $('#series-posts-list').html(html);
    }
    // 获取文章列表
    $.get(url + '&commond=query_posts' + (post_name == '' ? '' : '&series=' + post_name),_list_,'json');
    // 点击搜索按钮
    $('#series-search').on('click',function(){
        var search = $('#series-posts-key').val();
        if(search == '') return;
        $.get(url + '&commond=posts' + (post_name == '' ? '' : '&series=' + post_name) + '&key=' + search,_list_,'json');
    });
    // 输入搜索词回车
    $('#series-posts-key').on('keydown',function(e){
        if(e.which == 13 || e.keyCode == "13") {
            e.preventDefault();
            e.stopImmediatePropagation();
            e.stopPropagation();
            $('#series-search').trigger('click');
            return false;
        }
    });
});