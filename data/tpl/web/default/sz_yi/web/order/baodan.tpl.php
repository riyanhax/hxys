<?php defined('IN_IA') or exit('Access Denied');?>﻿<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_header', TEMPLATE_INCLUDEPATH)) : (include template('web/_header', TEMPLATE_INCLUDEPATH));?>
<div class="w1200 m0a">
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/order/tabs', TEMPLATE_INCLUDEPATH)) : (include template('web/order/tabs', TEMPLATE_INCLUDEPATH));?>
<link href="../addons/sz_yi/static/js/dist/select2/select2.css" rel="stylesheet">
<link href="../addons/sz_yi/static/js/dist/select2/select2-bootstrap.css" rel="stylesheet">
<script language="javascript" src="../addons/sz_yi/static/js/dist/select2/select2.min.js"></script>
<script language="javascript" src="../addons/sz_yi/static/js/dist/select2/select2_locale_zh-CN.js"></script>
<style type='text/css'>
.trhead td {  background:#f8f8f8;text-align: center}
.trbody td {  text-align: center; vertical-align:top;border-left:1px solid #DEDEDE;overflow: hidden;}
.goods_info{position:relative;width:60px;}
.goods_info img {width:50px;background:#fff;border:1px solid #DEDEDE;padding:1px;}
.goods_info:hover {z-index:1;position:absolute;width:auto;}
.goods_info:hover img{width:320px; height:320px;}
.form-control .select2-choice {
        border: 0 none;
        border-radius: 2px;
        height: 32px;    line-height: 32px;
    }
</style>
<div class="rightlist">
<div class="panel panel-default" style='margin-top:60px'>
    <div class="panel-body sx-border">
        <form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
            <input type="hidden" name="c" value="site" />
            <input type="hidden" name="a" value="entry" />
            <input type="hidden" name="m" value="sz_yi" />
            <input type="hidden" name="op" value="baodan_c" />
            <input type="hidden" name="do" value="order" />
            <input type="hidden" name="openid" value="order" id="openid" />
            <div class='form-group'>
                <div class="col-sm-8 col-lg-5 col-xs-12">
                    <div class="input-group">
                        <div class='input-group-addon'>选择用户</div>
                        <input type="text" name="uid" maxlength="30" value="" id="saler" class="form-control" readonly="">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus-notice').modal();" data-original-title="" title="">选择角色</button>
                            <button class="btn btn-danger" type="button" onclick="$('#noticeopenid').val('');$('#saler').val('');$('#saleravatar').hide()" data-original-title="" title="">清除选择</button>
                        </div>
                    </div> 
                </div>
            </div>         
            <div class='form-group'>
                <div class="col-sm-8 col-lg-5 col-xs-12">
                    <div class='input-group'>
                        <div class='input-group-addon'>输入金额</div>
                        <input type="text" class="form-control" name="money" id="money" placeholder="请输入订单金额/元">

                    </div>
                </div>
            </div>
        
            <div id="modal-module-menus-notice" class="modal fade in" tabindex="-1" style="display: none;">
                <div class="modal-dialog" style="width: 920px;">
                    <div class="modal-content">
                        <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择角色</h3></div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="keyword" value="" id="search-kwd-notice" placeholder="请输入昵称/姓名/手机号">
                                        <span class="input-group-btn"><button type="button" class="btn btn-default" onclick="search_members();" data-original-title="" title="">搜索</button></span>
                                    </div>
                                </div>
                            <div id="module-menus-notice" style="padding-top:5px;"></div>
                        </div>
                        <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true" data-original-title="" title="">关闭</a></div>
                    </div>
                </div>
            </div>
      
            <div class="form-group">

                <div class="col-sm-7 col-lg-9 col-xs-12">
                    <button type="button" name="export" value="1" id="export" class="btn btn-primary">申请报单</button>
                </div>

            </div>
     
        </form>
    </div>
</div>
            
  

</div>
</div>                                                      
<script type="text/javascript">
    $(function(){
        $('#export').click(function(){
            var ordersn = $('#ordersn').val();
            //alert(ordersn);
            if( ordersn == ''){
                return;
            }else{
                $('#form1').submit();
            }
        });
    });
    function search_members() {
        if( $.trim($('#search-kwd-notice').val())==''){
            $('#search-kwd-notice').attr('placeholder','请输入关键词');
             return;
        }
        $("#module-menus-notice").html("正在搜索....");
        $.get("<?php  echo $this->createWebUrl('member/query')?>", {
            keyword: $.trim($('#search-kwd-notice').val())
        }, function(dat){
            $('#module-menus-notice').html(dat);
        });
    }
    function select_member(o) {
        $("#openid").val(o.openid);
        $("#saler").val( o.nickname+ "/" + o.realname + "/" + o.mobile );
        $("#modal-module-menus-notice .close").click();
    }

</script>
                    

        <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/_footer', TEMPLATE_INCLUDEPATH)) : (include template('web/_footer', TEMPLATE_INCLUDEPATH));?>
