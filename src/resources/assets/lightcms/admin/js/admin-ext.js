
/** 全局参数 **/
window.GC_XM_SELECT_COLOR = '#1cbbb4';
/** 左侧菜单 **/
/// var isShow = true;  //定义一个标志位
$('.kit-side-fold').click(function(){

    var $this = $(this);
    var isShow = $this.data ('show');
    //选择出所有的span，并判断是不是hidden
    $('.layui-nav-item span').each(function(){
        if($(this).is(':hidden')){
            $(this).show();
        }else{
            $(this).hide();
        }
    });
    //判断isshow的状态
    if(isShow){
        $('.layui-side.layui-bg-black').stop().animate({width:60+'px'}, 300); //设置宽度
        //将footer和body的宽度修改
        $('.layui-body').stop().animate({left:60+'px'}, 300);
        $('.layui-footer').stop().animate({left:60+'px'}, 300);
        //将二级导航栏隐藏
        $('dd span').each(function(){
            $(this).hide();
        });
        //修改标志位
        $this.data ('show', false)
            .find ('i')
            .first()
            .attr ('class', 'layui-icon layui-icon-spread-left');


    }else{
        $('.layui-side.layui-bg-black').stop().animate({width:200+'px'}, 300);
        $('.layui-body').stop().animate({left:200+'px'}, 300);
        $('.layui-footer').stop().animate({left:200+'px'}, 300);
        $('dd span').each(function(){
            $(this).show();
        });
        $this.data ('show', true)
            .find ('i')
            .first()
            .attr ('class', 'layui-icon layui-icon-shrink-right');
    }
});


function showDetail (url, title, width = '90%', height = '90%')
{
    layer.load();
    $.ajax({
        url: url,
        type: 'get',
        dataType: 'html',
        success: function (result) {
            layer.closeAll('loading');
            //页面层
            layer.open({
                type: 1
                ,title: title
                ,skin: 'layui-layer-rim' //加上边框
                ,area: [width, height] //宽高
                ,content: result
                ,btnAlign: 'c' //按钮居中
                ,shade: 0.2 //不显示遮罩
                ,moveType: 1
                ,yes: function (){
                    layer.closeAll ();
                }
            });
        },
        error: function () {
            layer.closeAll('loading');
        }
    });
}

function showAssignment (url, title, width = '50%', height = '90%')
{
    layer.open({
        type: 2
        ,title: title
        ,skin: 'layui-layer-rim'
        ,area: [width, height]
        ,content: url //iframe的url,btn: '关闭'
        ,btnAlign: 'c' //按钮居中
        ,shade: 0.2 //不显示遮罩
        ,moveType: 1
        ,yes: function (){
            layer.closeAll ();
        }
    });
}

function showWidgetDetail (title, content, width = '90%', height = '90%')
{
    layer.open({
        type: 1
        ,title: title
        ,skin: 'layui-layer-rim' //加上边框
        ,area: [width, height] //宽高
        ,content: [
            '<div class="layui-card">',
            '   <div class="layui-card-body">',
            content,
            '   </div>',
            '</div>'
        ].join ('')
        ,btnAlign: 'c' //按钮居中
        ,shade: 0.2 //不显示遮罩
        ,moveType: 1
        ,yes: function (){
            layer.closeAll ();
        }
    });
}
