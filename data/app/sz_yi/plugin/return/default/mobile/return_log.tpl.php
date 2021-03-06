<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title>返利记录</title>
<style type="text/css">
    body {margin:0px; background:#eee; font-family:'微软雅黑'; -moz-appearance:none;}
    .credit_list {height:auto; width:94%; background:#fff; padding:10px 3%;margin-top:5px;overflow: hidden;}
    
    .credit_list .info {max-height:80px; width:74% !important; float:left;  font-size:16px; color:#666; line-height:20px; text-align:left;    border-right: 1px solid #eaeaea;}
    .credit_list .info p {font-size:14px; color:#545454;max-height: 40px;overflow: hidden;margin: 0;}
    .credit_list .info span {font-size:14px; color:#999;}
    .credit_list .num {max-height:60px; width:25%;line-height:20px; float:right; text-align:center; font-size:16px; color:#666;}
    .credit_list .num span {font-size:14px; color:#999;}

    .credit_tab {height:30px; margin:5px; border:1px solid #f15353; border-radius:5px; overflow:hidden;font-size:13px;background:#fff;padding-right: -2px;}
    .credit_nav {height:30px; width:25%;  background:#fff; color:#666; text-align:center; line-height:30px; float:left;}
    .credit_nav1 {height: 42px;
    width: 50%;
    background: #fff;
    color: #666;
    text-align: center;
    line-height: 44px;
    float: left;}
    .credit_navon {color:#fff; background:#f15353;}
    .credit_no {height:100px; width:100%; margin:50px 0px 60px; color:#ccc; font-size:12px; text-align:center;}
    #credit_loading { padding:10px;color:#666;text-align: center;}

</style>
<div class="page_topbar">
    <a href="javascript:;" class="back" onclick="history.back()"><i class="fa fa-angle-left"></i></a>
    <div class="title">返利记录</div>
</div>


<div class="credit_tab new-returnnav">
    <a href="<?php  echo $this->createPluginMobileUrl('return/return_queue')?>"><div class="credit_nav1  ">返现队列</div></a>
    <div class="credit_nav1 credit_navon return_navon">返现记录</div>
</div>
<div class="credit_tab">
    <div class="credit_nav <?php  if($_GPC['type']==1) { ?>credit_navon<?php  } ?>"  data-type='1'>会员等级</div>
    <div class="credit_nav <?php  if($_GPC['type']==2) { ?>credit_navon<?php  } ?>"  data-type='2'>单笔订单</div>
    <div class="credit_nav <?php  if($_GPC['type']==3) { ?>credit_navon<?php  } ?>"  data-type='3'>累计订单</div>
    <div class="credit_nav <?php  if($_GPC['type']==4) { ?>credit_navon<?php  } ?>"  data-type='4'>队列排列</div>
</div>

<div id='container'></div>
<script id='tpl_log' type='text/html'>
    <%each list as log%>
        <div class="credit_list">
            <div class="info">
                <p>返现金额：<%log.money%> 元</p>
                <span>返现时间：<%log.create_time%></span>
            </div>
            <div class="num">
                <span>已返状态</span><br/>
                <span>
                    <%if log.status==1%>
                        已完成
                    <%else%>
                        失败
                    <%/if%>
                </span>
            </div>
        </div>
    <%/each%>
</script>
<script id='tpl_empty' type='text/html'>
    <div class="credit_no"><i class="fa fa-file-text-o" style="font-size:100px;"></i><br><span style="line-height:18px; font-size:16px;">暂时没有任何记录~</span></div>
</script>

<script language="javascript">
    var page = 1;
    var scrolled = false;
    var current_type = "<?php  echo intval($_GPC['type'])?>";
    require(['tpl', 'core'], function (tpl, core) {

function bindScroller(){
        var loaded = false;
        var stop = true;
        $(window).scroll(function () {
            //console.log(loaded);
            if (loaded) {
                return;
            }
            totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
            if ($(document).height() <= totalheight) {
                if (stop == true) {
                    stop = false; scrolled = true;
                    $('#container').append('<div id="credit_loading"><i class="fa fa-spinner fa-spin"></i> 正在加载...</div>');
                    page++;
   
                    core.pjson('return/return_log', {type: current_type,page: page}, function (json) {
                        stop = true;
                        $('#credit_loading').remove();
                        $("#container").append(tpl('tpl_log', json.result));
                        if (json.result.list.length < json.result.pagesize) {
                            $('#credit_loading').remove();
                            //$('#credit_loading').html('已经加载完全部记录');
                            $("#container").append('<div id="credit_loading">已经加载完全部记录</div>');
                            loaded = true;
                            //console.log('loaded:'+loaded);
                            $(window).scroll = null;
                            return;
                        }
                    }, true);
                }
            }
        });
}
        function getLog(type) {
 
            core.pjson('return/return_log', {type:type,page: page}, function (json) {
                $('.credit_nav').removeClass('credit_navon');
                $('.credit_nav[data-type=' + type + ']').addClass('credit_navon'); 
                if (json.result.list.length <= 0) {
                    $('#container').html(tpl('tpl_empty'));
                    return;
                }
                $('#container').html(tpl('tpl_log', json.result));
                bindScroller();
            }, true);
        }
        $('.credit_nav').unbind('click').click(function () {
            page = 1;
            current_type = $(this).data('type');
            getLog(current_type);

        });
        getLog(current_type);
    })
</script>
<?php  $show_footer=true?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
