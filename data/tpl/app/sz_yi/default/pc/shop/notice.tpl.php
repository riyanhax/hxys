<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title>店铺公告</title>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/navigation', TEMPLATE_INCLUDEPATH)) : (include template('common/navigation', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    body {margin:0px; background:#efefef; font-family:'微软雅黑'; -moz-appearance:none;overflow-x:hidden}
    a {text-decoration:none;}
    .notice_topbar {height:40px; padding:3px;  background:#f9f9f9; border-bottom:1px solid #e8e8e8; font-size:16px; line-height:40px; text-align:center; color:#666;}
    .notice_topbar a {height:40px;margin-left:10px; width:15px; display:block; float:left; outline:0px; color:#999; font-size:24px;}

    .notice_addnav {height:44px; padding:5px;  border-bottom:1px solid #f0f0f0; border-top:1px solid #f0f0f0; margin-top:14px; line-height:42px; color:#666; background:#fff;}
    .notice_list {box-sizing: content-box;height:50px; /*padding:5px; */border:1px solid #f0f0f0;background:#fff;height:100px;padding-left: 100px;position: relative;margin: 10px 10px 0;}
    .notice_list .ico {height:90px; width:90px;color:#999;position: absolute;left: 5px;top: 5px}
    .notice_list .ico img { width:90px;height:90px;float:left;cursor: pointer;}
    .notice_list .info {height:50px; width:100%; }
    .notice_list .info .inner { }
    .notice_list .info .inner .addr {line-height: 30px;width:100%; color:#232323;font-size:16px; overflow:hidden;cursor: pointer;}
    .notice_list .info .inner .user {text-align: right;height:20px; width:100%; color:#bbb; line-height:20px; font-size:14px; overflow:hidden;}
    .notice_list .info .inner .notice-info{ color: #666;line-height: 22px;}
    .notice_list .info .inner .user span {color:#444; font-size:16px;}
   
    .notice_addnav {height:40px; width:94%; padding:0 3%; border-bottom:1px solid #f0f0f0; border-top:1px solid #f0f0f0; margin-top:14px; line-height:40px; color:#666; }

    .notice_detail { width:100%;/*position:absolute;top:0;right:-100%;*/z-index:99999;display: none}
    .notice_main {height:auto;width:98%; padding:0px 1%; border-bottom:1px solid #f0f0f0; border-top:1px solid #f0f0f0; background:#fff;box-sizing: content-box;padding-bottom: 20px}
    .notice_main .title {height:auto;; width:98%; padding:10px 1% 0;line-height:22px;word-break: break-all;font-size:16px;color:#333;box-sizing: content-box;line-height: 30px;}
    .notice_main .time {height:30px; width:98%; padding:0px 1%; border-bottom:1px solid #f0f0f0; line-height:22px;word-break: break-all;font-size:14px;color:#bbb;box-sizing: content-box;}
    .notice_main .detail { height:100%;width:100%; padding:1%; word-break: break-all;}
    .notice_main .detail img { max-width:300px;}
    .notice_main .detail p{ line-height: 26px;color: #666;}
    .notice_sub1 {height:44px; width:94%; margin:14px 3% 0px; background:#ff4f4f; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
    .notice_sub2 {height:44px; width:94%; margin:14px 3% 0px; background:#ddd; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#666; border:1px solid #d4d4d4;}

    .notice_no {height:100px; width:100%; margin:50px 0px 60px; color:#ccc; font-size:12px; text-align:center;}
    .notice_no_menu {height:40px; width:100%; text-align:center;}
    .notice_no_nav {height:38px;padding:10px; width:100px; background:#eee; border:1px solid #d4d4d4; border-radius:5px; text-align:center; line-height:38px; color:#666;}
    #notice_loading { width:94%;padding:10px;color:#666;text-align: center;}
</style>
<script type="text/javascript" src="../addons/sz_yi/static/js/dist/area/cascade.js"></script>
<div id='container'   style=" width:1200px;margin:120px auto 0;background:#fff;min-height: 400px;overflow: hidden;"></div>

<script id='tpl_notice_main' type='text/html'>

    
    <div id='notices'></div>
    <div id='detail_container'></div>
</script>

<script id='tpl_notice_list' type='text/html'>
   <%each list as value%>
   <div class="notice_list" 
        data-noticeid="<%value.id%>"
        data-noticeurl="<%value.link%>"
        >
        <div class="ico"><%if value.thumb%><img src='<%value.thumb%>' /><%else%><img src='../addons/sz_yi/template/mobile/default/static/images/notice.png' /><%/if%></div>
        <div class="info">
            <div class="inner">
                <div class="addr"><%value.title%></div>
                <div class="notice-info">
                    <%value.desc%>
                </div>
                <div class="user"><%value.createtime%></div>
            </div>
        </div>
    </div>
  <%/each%>
</script>

<script id='tpl_notice_data' type='text/html'>
    <div class="notice_detail">
          <!--<div class="page_topbar">
        <a href="javascript:;" class="back" onclick="history.back()"><i class="fa fa-angle-left"></i></a>
        <div class="title">公告内容</div>
    </div>-->
        <div class="notice_main" >
            <div class="title"><%notice.title%></div>
            <div class="time"><%notice.createtime%></div>
            <div class="detail"></div>
        </div>
    </div>
</script>
<script id='tpl_empty' type='text/html'>
    <div class="notice_no"><i class="fa fa-volume-up" style="font-size:100px;"></i><br><span style="line-height:18px; font-size:16px;">暂时没有任何公告</span><br>可以去看看哪些想买的</div>
    <div class="notice_no_menu">
        <span class="notice_no_nav"  onclick="location.href='<?php  echo $this->getUrl()?>'">随便逛逛</span>
    </div>
</script>
<script language="javascript">
    var page = 1;
    require(['tpl', 'core'], function (tpl, core) {
        $('#container').html(tpl('tpl_notice_main'));
        function bindEvents() {
            $('.notice_list').unbind('click').click(function () {
                var noticeurl = $(this).data('noticeurl');
                if (noticeurl) {
                    location.href = noticeurl;
                    return;
                }
                var id = $(this).data('noticeid');

                core.json('shop/notice', {op: 'get', id: id}, function (json) {
                    $('#detail_container').html(tpl('tpl_notice_data', json.result));
                    $("#notices").hide();
                    $('.notice_detail').show();
                    $('.notice_detail').animate({right: "0px"}, 200);

                    $('.notice_detail .detail').html(json.result.notice.detail);

                    $('#notice_close').click(function () {
                        $("#notices").show();
                        $('.notice_detail').animate({right: "-100%",complete:function(){
                                $("#detail_container").html("");
                                
                        }}, 200);
                        
                    })
                }, true);
            })
        }

        core.json('shop/notice', {}, function (json) {


            if (json.result.list.length <= 0) {
                $("#notices").html(tpl('tpl_empty'));
                return;
            }
            $('#notices').html(tpl('tpl_notice_list', json.result));
            bindEvents();
            
            var loaded = false;
            var stop = true;
            $(window).scroll(function () {
                if (loaded) {
                    return;
                }
                totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
                if ($(document).height() <= totalheight) {

                    if (stop == true) {
                        stop = false;
                        $('#notices').append('<div id="notice_loading"><i class="fa fa-spinner fa-spin"></i> 正在加载...</div>');
                        page++;
                      
                        core.json('shop/notice', {page: page}, function (morejson) {
                            stop = true;
                            $('#notice_loading').remove();
                            $('#notices').append(tpl('tpl_notice_list', morejson.result));
                            bindEvents();
                            if (morejson.result.list.length < morejson.result.pagesize) {
                                $('#notices').append('<div id="notice_loading">已经加载全部公告</div>');
                                loaded = true;
                                return;
                            }
                        }, true);
                    }
                }
            });


        }, true);
    })
</script> 
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
