<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title>确认订单</title>
<?php  if(!empty($order_formInfo)) { ?>
     <script src="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.core-2.5.2.js" type="text/javascript"></script>
<script src="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.core-2.5.2-zh.js" type="text/javascript"></script>
<link href="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.core-2.5.2.css" rel="stylesheet" type="text/css" />
<link href="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.animation-2.5.2.css" rel="stylesheet" type="text/css" />
<script src="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.datetime-2.5.1.js" type="text/javascript"></script>
<script src="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.datetime-2.5.1-zh.js" type="text/javascript"></script>
<script src="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.android-ics-2.5.2.js" type="text/javascript"></script>
<link href="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.android-ics-2.5.2.css" rel="stylesheet" type="text/css" />

<link href="../addons/sz_yi/template/mobile/default/static/js/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
<script src="../addons/sz_yi/template/mobile/default/static/js/star-rating.js" type="text/javascript"></script>
<script src="../addons/sz_yi/static/js/dist/ajaxfileupload.js" type="text/javascript"></script>
<?php  } ?>
<?php  if($trade['is_street'] == 1) { ?>
<script type="text/javascript" src="../addons/sz_yi/static/js/dist/area/cascade_street.js"></script>
<?php  } else { ?>
<script type="text/javascript" src="../addons/sz_yi/static/js/dist/area/cascade.js"></script>
<?php  } ?>
<style type="text/css">
    body {margin:0px; background:#efefef;}
    .addorder_topbar {height:34px; background:#5f6e8b; padding:15px;}
    .addorder_topbar .ico {height:34px; width:30px; line-height:34px; float:left; font-size:26px; text-align:center; color:#fff;}
    .addorder_topbar .tips {height:34px;  margin-left:10px; font-size:13px; color:#fff; line-height:17px;}
    .addorder_nav { height:30px; padding:10px;}
    .addorder_nav .nav { padding:2px 5px 2px 5px;; border:1px solid #5f6e8b; color:#5f6e8b; background:#fff; float:left; margin-left:10px;}
    .addorder_nav .selected { border:1px solid #f15353; color:#f15353; }
    .addorder_user {height:54px;  background:#fff; padding:5px; border-bottom:1px solid #eaeaea;}
    .addorder_user .info .ico { float:left;  height:50px; width:30px; line-height:50px; font-size:26px; text-align:center; color:#666}
    .addorder_user .info .info1 {height:54px; width:100%; float:left;margin-left:-30px;margin-right:-30px;}
    .addorder_user .info .info1 .inner { margin-left:30px;margin-right:30px;overflow:hidden;}
    .addorder_user .info .info1 .inner .user {height:30px; width:100%; font-size:16px; color:#333; line-height:35px;overflow:hidden;}
    .addorder_user .info .info1 .inner .address {height:20px; width:100%; font-size:14px; color:#999; line-height:20px;overflow:hidden;}
    .addorder_user .info .ico2 {height:50px;  width:30px; line-height:65px; float:right; font-size:16px; text-align:right; color:#999;}
    .addorder_exp {height:42px;  background:#fff; padding:5px; border-bottom:1px solid #eaeaea; line-height:42px; font-size:16px; color:#333;}
    .addorder_exp .t1 {height:42px; width:auto; float:left;padding-left:10px;}
    .addorder_exp .t2 {height:42px; width:auto; float:right;}
    .addorder_exp .ico {height:42px; width:30px;  float:right;text-align:right;color:#999; font-size:16px;margin-top:5px; }
    .addorder_good {height:auto;padding:10px;background:#fff;  margin:10px 0; border-bottom:1px solid #eaeaea; border-top:1px solid #eaeaea;}
    .addorder_good .ico {height:6px; width:10%; line-height:36px; float:left; text-align:center;}
    .addorder_good .shop {height:36px; width:90%; padding-left:10%; border-bottom:1px solid #eaeaea; line-height:36px; font-size:14px; color:#333;}
    .addorder_good .good {height:50px; width:100%; padding:10px 0px; border-bottom:1px solid #eaeaea;}
    .addorder_good .img {height:50px; width:50px; float:left;}
    .addorder_good .img img {height:100%; width:100%;}
    .addorder_good .info {width:100%;float:left; margin-left:-50px;margin-right:-60px;}
    .addorder_good .info .inner { margin-left:60px;margin-right:60px; }
    .addorder_good .info .inner .name {height:32px; width:100%; float:left; font-size:12px; color:#555;overflow:hidden;}
    .addorder_good .info .inner .option {height:18px; width:100%; float:left; font-size:12px; color:#888;overflow:hidden;word-break: break-all}
    .addorder_good span { color:#666;}
    .addorder_good .price { float:right;height:54px;margin-left:-60px;;}
    .addorder_good .price .pnum { height:20px;width:100%;text-align:right;font-size:14px; }
    .addorder_good .price .num { height:20px;width:100%;text-align:right;}
    .addorder_good input {height:34px; width:97%; padding: 0 5px; background:#f7f7f7;  border:1px solid #e9e9e9; margin:14px 0px 0; -webkit-appearance: none; }
    .addorder_good .text {height:34px; width:100%; line-height:34px; text-align:right; font-size:14px; color:#999;}
    .addorder_price {height:auto;  background:#fff; padding:0 10px;}
    .addorder_price .price {border-bottom: 1px solid #eaeaea;height:auto;padding:5px 0; width:100%; border-bottom:1px solid #eaeaea;}
    .addorder_price .price .line {height:33px; width:100%; font-size:14px; color:#666;}
    .addorder_price .price .line span {height:33px; width:auto; float:right;}
    .addorder_price .all {height:47px; width:100%; line-height:47px; font-size:16px; color:#666;}
    .addorder_price .all span {height:47px; width:auto; float:right; color:#f15353;}
    .addorder_pay {height:54px; width:96%; background:#fff; padding:0px 2%; margin-top:30px; border-top:1px solid #eaeaea;position: fixed;bottom: 0;left: 0}
    .addorder_pay span {height:54px; width:auto; margin-right:16px; float:right; line-height:54px; color:#f15353; font-size:16px;}
    .addorder_pay .paysub {height:40px; width:auto; background:#f15353; padding:0px 10px; margin-top:7px; border-radius:5px; color:#fff; line-height:40px; float:right;font-size: 14px}
    .chooser {overflow: auto; width: 100%; background:#efefef; position: fixed; top: 0px; right: -100%; z-index: 1;}
    .chooser .address {height:50px; background:#fff; padding:10px;; border-bottom:1px solid #eaeaea;}
    .chooser .address .ico {float:left; height:50px; width:30px; line-height:50px; float:left; font-size:20px; text-align:center; color:#999;}
    .chooser .address .info {height:50px; width:100%;float:left;margin-left:-30px;margin-right:-30px;}
    .chooser .address .info .inner { margin-left:35px;margin-right:30px;}
    .chooser .address .info .inner .name {height:28px; width:100%; font-size:16px; color:#666; line-height:28px;overflow:hidden;}
    .chooser .address .info .inner .addr {height:22px; width:100%; font-size:14px; color:#999; line-height:22px;overflow: hidden;}
    .chooser .address .edit {height:50px; width:30px; float:right;margin-left:-30px;text-align:center;line-height:50px;color:#666;}
    .chooser .add_address {height:44px; padding:5px; background:#fff; border-bottom:1px solid #eaeaea; line-height:44px; font-size:16px; color:#666;}
    .address_main {height:100%; width:100%; background:#fff;  position: fixed; top: 0px; right: -100%; z-index: 1;}
    .address_main .line {height:44px; margin: 0 5px; border-bottom:1px solid #f0f0f0; line-height:44px;}
    .address_main .line input {float:left; height:44px; width:100%; padding:0px; margin:0px; border:0px; outline:none; font-size:16px; color:#666;padding-left:5px;}
    .address_main .line select  { border:none;height:25px;width:100%;color:#666;font-size:16px;}
    .address_main .address_sub1 {height:44px; margin:14px 5px; background:#ff4f4f; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
    .address_main .address_sub2 {height:44px; margin:14px  5px; background:#ddd; border-radius:4px; text-align:center; font-size:18px; line-height:44px; color:#666; border:1px solid #d4d4d4;}
    .select { -webkit-appearance: none }
    .carrier_input_info {height:auto;width:100%; background:#fff; margin-top:14px; border-bottom:1px solid #e8e8e8; border-top:1px solid #e8e8e8;}
    .carrier_input_info .row { padding:0 10px; height:40px; background:#fff; border-bottom:1px solid #e8e8e8; line-height:40px; color:#999;}
    .carrier_input_info .row .title {height:40px; width:85px; line-height:40px; color:#444; float:left; font-size:16px;}
    .carrier_input_info .row .info { width:100%;float:right;margin-left:-85px; }
    .carrier_input_info .row .inner { margin-left:85px; }
    .carrier_input_info .row .inner input {height:30px; color:#666;background:transparent;margin-top:0px; width:100%;border-radius:0;padding:0px; margin:0px; border:0px; float:left; font-size:16px;}
    .addorder_price .line .nav {height:22px; width:40px; background:#ccc; margin:5px 0px; float:right; border-radius:40px;}
    .addorder_price .line .on {background:#4ad966;}
    .addorder_price .line .nav nav {height:20px; width:20px; background:#fff; margin:1px; border-radius:20px;}
    .addorder_price .line .nav .on {margin-left:19px;}
    .cnum {height:20px; width:81px; border:1px solid #e2e2e2; }
    .cnum .leftnav {height:20px; width:19px; float:left; border-right:1px solid #e2e2e2; background:#eee; color:#6b6b6b; text-align:center; line-height:20px; font-size:18px; font-weight:bold;}
    .cnum .shownum {height:20px; width:40px; float:left;  border:0px; margin:0px; padding:0px; text-align:center;}
    .cnum .rightnav {height:20px; width:19px; float:right; border-left:1px solid #e2e2e2; background:#eee; color:#6b6b6b; text-align:center; line-height:20px; font-size:18px; font-weight:bold;}
    .couponcount {float:right; margin-top:8px;  margin-right: 5px; height:16px; width:16px; background:#f30; border-radius:8px; font-size:12px; color:#fff; line-height:16px; text-align: center;}

</style>

<div id='carrier_container'></div>
<div id='dispatch_container'></div>
<div id='address_container'></div>
<div id='confirm_container'  style="padding-bottom:65px"></div>

<script id='tpl_address_list' type='text/html'>
    <div class="chooser choose_address" >
        <%each list as address%>
        <div class="address" 
             data-addressid='<%address.id%>'
             data-realname='<%address.realname%>'
             data-mobile='<%address.mobile%>'
             data-address='<%address.province%>.<%address.city%>.<%address.area%>.<%address.address%>'
             >
            <div class="ico" ><%if selectedAdressID==address.id%><i class="iconfont icon-check-circle-o" style="color:#f15353;font-size: 20px"></i><%/if%></div>
            <div class="info">
                <div class='inner'>
                    <div class="name"><%address.realname%>(<%address.mobile%>)</div>
                    <div class="addr"><%address.province%>.<%address.city%>.<%address.area%>.<%address.address%></div>
                </div>
            </div>
            <div class="edit"><i class='iconfont icon-pencil'></i></div>
        </div>
        <%/each%>
        <div class="add_address"><i class="iconfont icon-plus-circle" style="margin-left:3%; margin-right:10px; line-height:44px; font-size:20px;"></i>新增收货地址</div>
    </div>
</script>

<script id='tpl_address_new' type='text/html'>
    <input type='hidden' id='edit_addressid' value="<%address.id%>" />
    <div class="address_main" >
        <div class="line"><input type="text" placeholder="收件人" id="realname" value="<?php  if(address.realname) { ?><%address.realname%><?php  } ?>" /></div>
        <div class="line"><input type="text" placeholder="联系电话"  id="mobile" value="<?php  if(address.mobile) { ?><%address.mobile%><?php  } ?>"/></div>
        
        <div class="line"><select id="sel-provance" onchange="selectCity();" class="select"><option value="" selected="true">所在省份</option></select></div>
        <div class="line"><select id="sel-city" onchange="selectcounty()" class="select"><option value="" selected="true">所在城市</option></select></div>
        <div class="line"><select id="sel-area" <?php  if($trade['is_street'] == 1) { ?>onchange="selectstreet()"<?php  } ?>class="select"><option value="" selected="true">所在地区</option></select></div>
        <?php  if($trade['is_street'] == 1) { ?>
        <div class="line"><select id="sel-street"  class="select"><option value="" selected="true">所在街道</option></select></div>
        <?php  } ?>
        <div class="line"><input type="text" placeholder="详细地址(不包含省份城市区域)"  id="address" value="<?php  if(address.address) { ?><%address.address%><?php  } ?>"/></div>
<!--        <div class="line"><input type="text" placeholder="邮政编码"  id="zipcode" value="<?php  if(address.zipcode) { ?><%address.zipcode%><?php  } ?>"/></div>-->

        <div class="address_sub1">确认</div>
        <div class="address_sub2">取消</div>
    </div>
</script>

<script id='tpl_carrier_list' type='text/html'>
    <div class="chooser choose_carrier">
        <%each carrier_list as carrier index%>
        <div class="address carrier"
             data-index='<%index%>'
             data-id='<%carrier.id%>'
             data-realname='<%carrier.storename%>'
             data-mobile='<%carrier.tel%>'
             data-address='<%carrier.province%>.<%carrier.city%>.<%carrier.area%>.<%carrier.address%>' 
             >
            <div class="ico" ><%if selectedCarrierIndex==index%><i class="iconfont icon-check" style="color:#f15353;font-size: 20px"></i><%/if%></div>
            <div class="info">
                <div class='inner'>
                    <div class="name"><%carrier.storename%>(<%carrier.tel%>)</div>
                    <div class="addr"><%carrier.province%>.<%carrier.city%>.<%carrier.area%>.<%carrier.address%></div>
                </div>
            </div>
        </div>
        <%/each%>
    </div>
</script>

<script id='tpl_carrier_list_send' type='text/html'>
    <div class="chooser choose_carrier">
        <%each carrier_list_send as carrier index%>
        <div class="address carrier"
             data-index='<%index%>'
             data-id='<%carrier.id%>'
             data-realname='<%carrier.storename%>'
             data-mobile='<%carrier.tel%>'
             data-address='<%carrier.province%>.<%carrier.city%>.<%carrier.area%>.<%carrier.address%>'
        >
            <div class="ico" ><%if selectedCarrierIndex==index%><i class="iconfont icon-check" style="color:#f15353;font-size: 20px"></i><%/if%></div>
            <div class="info">
                <div class='inner'>
                    <div class="name"><%carrier.storename%>(<%carrier.tel%>)</div>
                    <div class="addr"><%carrier.province%>.<%carrier.city%>.<%carrier.area%>.<%carrier.address%></div>
                </div>
            </div>
        </div>
        <%/each%>
    </div>
</script>

<script id='tpl_confirm_info' type='text/html'>
    <?php  if(is_app()) { ?>
    <div class="page_topbar">
        <a href="javascript:history.back()" class="back"><i class="fa fa-angle-left"></i></a>
        <div class="title">订单详情</div>
    </div>
    <?php  } ?>
    <div class="addorder_topbar">
        <div class="ico"><i class="fa fa-file-text-o"></i></div>
        <div class="tips">确认订单后请尽快付款，<br>过时订单将自动取消。</div>
    </div>
    <input type="hidden"  id="isverify" value="<%if isverify || isvirtual || goods.type==2%>true<%else%>false<%/if%>" />
    
     <?php  if($show==1) { ?>
      <%if isverify%>
          
        
        <%if isverifysend || dispatchsend%>
          <input type="hidden"  id="dispatchtype" <%if carrier_list.length>0%>value="1"<%else if isverifysend%>value="0"<%else if dispatchsend%>value="2"<%/if%> />
          <div class="addorder_nav">
            <%if carrier_list.length>0%>
            <div class="nav <%if carrier_list.length>0%>selected<%/if%>" data-nav='1'>上门自提</div>
            <%/if%>
            <%if isverifysend && carrier_send%>
            <div class="nav <%if carrier_list.length<=0%>selected<%/if%>"  data-nav='0'>配送核销</div>
            <%/if%>
            <%if dispatchsend && carrier_send%>
            <div class="nav <%if carrier_list.length<=0 && !isverifysend%>selected<%/if%>"  data-nav='2'>快递配送</div>
            <%/if%>
          </div>
        
          <div class="addorder_user addorder_user_0" <%if (isverifysend || diapatchsend) && carrier_list.length>0%>style='display:none'<%/if%>>
            <input type='hidden' id='addressid' value='<%address.id%>' />
            <div class="info" id='address_select' <%if !address %>style='display:none'<%/if%>>
               <div class="ico"><i class="iconfont icon-map-marker"></i></div>
               <div class='info1'>
                 <div class='inner'>
                    <div class="user">收件人：<span id='address_realname'><%address.realname%></span>(<span id='address_mobile'><%address.mobile%></span>)</div>
                    <div class="address"><span id='address_address'><%address.province%>.<%address.city%>.<%address.area%>.<%address.address%></span></div>
                 </div>
               </div>
               <div class="ico2"><i class='fa fa-angle-right fa-2x'></i></div>
            </div>
            <div class='info' id='address_new'  <%if address %>style='display:none'<%/if%>>
              <div class="ico"><i class="fa fa-plus-circle"></i></div>
              <div class='info1'>
                 <div class='inner'>
                   <div class="user" style='padding-top:9px;'>新增地址</div>  
                 </div>
              </div>
              <div class="ico2"><i class='fa fa-angle-right fa-2x'></i></div>
            </div>
          </div>
          <div id='address_container'></div>
            <%if carrier_send%>
            <div class="addorder_user addorder_user_0" <%if carrier_list.length>0%>style="display:none;"<%/if%> >
                <input type='hidden' id='carrierindex_send' value='0' />
                <input type='hidden' id='carrierid_send' value='<%carrier_send.id%>' />
                <div class="info" id='carrier_select_send'>
                    <div class="ico"><i class="iconfont icon-map-marker"></i></div>
                    <div class='info1'>
                        <div class='inner'>
                            <div class="user">请选择发货门店：<span id='carrier_realname_send'><%carrier_send.storename%></span>(<span id='carrier_mobile_send'><%carrier_send.tel%></span>)</div>
                            <div class="address"><span id='carrier_address_send'><%carrier_send.province%>.<%carrier_send.city%>.<%carrier_send.area%>.<%carrier_send.address%></span></div>
                        </div>
                    </div>
                    <div class="ico2"><i class='fa fa-angle-right fa-2x'></i></div>
                </div>
            </div>
            <div id='address_container'></div>
            <%/if%>
        <%/if%>
           <%if carrier%>
              <div class="addorder_user addorder_user_1" >
                <input type="hidden" id="dispatchtype" value="1" />
                <input type='hidden' id='carrierindex' value='0' />
                <input type='hidden' id='carrierid' value='<%carrier.id%>' />
                <div class="info" id='carrier_select' >
                  <div class="ico"><i class="iconfont icon-map-marker"></i></div>
                  <div class='info1'>
                     <div class='inner'>
                       <div class="user">自提地点：<span id='carrier_realname'><%carrier.storename%></span>(<span id='carrier_mobile'><%carrier.tel%></span>)</div>
                       <div class="address"><span id='carrier_address'><%carrier.province%>.<%carrier.city%>.<%carrier.area%>.<%carrier.address%></span></div>
                     </div>
                  </div>
                  <div class="ico2"><i class='fa fa-angle-right fa-2x'></i></div>
                </div>
              </div>
              <div id='address_container'></div>
              <div class="carrier_input_info" >
                  <div class="row">
                    <div class='title'>提货人姓名</div>
                    <div class='info'>
                        <div class='inner'><input type="text" placeholder="提货人姓名" id="carrier_input_realname" value="<%member.realname%>" style='height:35px;'/></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class='title'>提货人手机</div>
                    <div class='info'>
                        <div class='inner'><input type="text" placeholder="提货人手机"  id="carrier_input_mobile" value="<%member.membermobile%>" style='height:35px;'/></div>
                    </div>
                  </div>
              </div>
           <%/if%>

           <%if dispatch%>
              <div class="addorder_exp" id='dispatch_select' style="display: none;">
                <input type='hidden' id='dispatchid' value='<%dispatch.id%>' />
                <div class="t1">配送方式</div>
                <div class="ico"><i class='fa fa-angle-right fa-2x'></i></div>
                <div class="t2"><span class='dispatchname'><%dispatch.dispatchname%></span> <span class='dispatchprice'><%dispatch.price%></span>元</div>
              </div>
           <%/if%>

      

      <%else%>
        <%if isvirtual || goods.type==2%>
          <input type="hidden"  id="dispatchtype" value="0" />
          <div class="carrier_input_info" >
          <div class="row">
            <div class='title'>联系人姓名</div>
            <div class='info'>
                <div class='inner'><input type="text" placeholder="联系人姓名" id="carrier_input_realname" value="<%member.realname%>" style='height:35px;'/></div>
            </div>
          </div>
          <div class="row">
            <div class='title'>联系人手机</div>
            <div class='info'>
                <div class='inner'><input type="text" placeholder="联系人手机"  id="carrier_input_mobile" value="<%member.membermobile%>" style='height:35px;'/></div>
            </div>
          </div>
          </div> 
        <%else%>
          <input type="hidden"  id="dispatchtype" value="0" />
        <div class="addorder_user addorder_user_0">
          <input type='hidden' id='addressid' value='<%address.id%>' />
          <div class="info" id='address_select' <%if !address %>style='display:none'<%/if%>>
             <div class="ico"><i class="iconfont icon-map-marker"></i></div>
             <div class='info1'>
               <div class='inner'>
                  <div class="user">：<span id='address_realname'><%address.realname%></span>(<span id='address_mobile'><%address.mobile%></span>)</div>
                  <div class="address"><span id='address_address'><%address.province%>.<%address.city%>.<%address.area%>.<%address.address%></span></div>
               </div>
             </div>
             <div class="ico2"><i class='fa fa-angle-right fa-2x'></i></div>
          </div>

          <div class='info' id='address_new'  <%if address %>style='display:none'<%/if%>>
            <div class="ico"><i class="fa fa-plus-circle"></i></div>
            <div class='info1'>
               <div class='inner'>
                 <div class="user" style='padding-top:9px;'>新增地址</div>  
               </div>
            </div>
            <div class="ico2"><i class='fa fa-angle-right fa-2x'></i></div>
          </div>
        </div>
      <div id='address_container'></div>
             <%if dispatch%>
                <div class="addorder_exp" id='dispatch_select' style="display: none;">
                  <input type='hidden' id='dispatchid' value='<%dispatch.id%>' />
                  <div class="t1">配送方式</div>
                  <div class="ico"><i class='fa fa-angle-right fa-2x'></i></div>
                  <div class="t2"><span class='dispatchname'><%dispatch.dispatchname%></span> <span class='dispatchprice'><%dispatch.price%></span>元</div>
                </div>
             <%/if%>
       
        <%/if%>
      <%/if%>

    <?php  } ?>
<input type="hidden" id="supplierids" value="<%supplierids%>">
<!--订单区分开始-->
      <%each order_all as order%>
    
    <div class="addorder_good">
        <div class="ico"><i class="iconfont icon-heart" style="color:#666; font-size:16px;"></i></div>
        <div class="shop"><%order.supplier_name%></div>
        <%each order.goods as g%>
        <div class="good" data-totalmaxbuy="<%g.totalmaxbuy%>">
            
            <div class="img"  onclick="location.href='<?php  echo $this->createMobileUrl('shop/detail')?>&id=<%g.goodsid%>'"><img src="<%g.thumb%>"/></div>
            <div class='info' onclick="location.href='<?php  echo $this->createMobileUrl('shop/detail')?>&id=<%g.goodsid%>'">
                <div class='inner'>
                       <div class="name">
                           <%if g.isnodiscount=='0' && haslevel%><span style='color:red'><%if g.discountway == 1%>[折扣]<%else%>[立减]<%/if%></span><%/if%>
                           <%g.title%></div>     
                       <div class='option' data-id="<%g.optionid%>"><%if g.optionid!='0'%>规格:  <%g.optiontitle%><%/if%></div>
                </div>
            </div>
            <div class="price">
                <div class='pnum'>￥<span class='marketprice'><%g.marketprice%></span></div>
                <%if changenum%>
                <div class="cnum"><div class="leftnav">-</div><input type="text" class="shownum" value="<%g.total%>" /><div class="rightnav">+</div></div>
                <%else%>
                <div class='pnum'><span class='total'>×<%g.total%></span></div>
                <%/if%>
            </div>
        </div>

        <input type="hidden" data-id="discountway<%order.supplier_uid%>" value="<%g.discountway%>" />
        <input type="hidden" data-id="discounttype<%order.supplier_uid%>" value="<%g.discounttype%>" />
        <input type="hidden" data-id="discount<%order.supplier_uid%>" value="<%g.discount%>" />

        <%/each%>
        <input type="hidden"  data-id="<%order.supplier_uid%>" data-name="goods" value="<%each order.goods as g%><%g.goodsid%>,<%g.optionid%>,<%g.total%>|<%/each%>"/>
        <input type="text" data-id="<%order.supplier_uid%>" data-name="remark" placeholder="给卖家留言" />
        <div class="text">共 <span class="goodscount" data-id="<%order.supplier_uid%>"><%order.total%></span> 件商品 合计：<span style="color:#f15353;">￥<span class='goodsprice' data-id="<%order.supplier_uid%>" style="color:#f15353;"><%order.goodsprice%></span></span></div>
    </div>
    <?php  if(!empty($order_formInfo)) { ?>
         <div class="carrier_input_info" >
             <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('diyform/formcss', TEMPLATE_INCLUDEPATH)) : (include template('diyform/formcss', TEMPLATE_INCLUDEPATH));?>
              <style type='text/css'>
                         .diyform_main .dline { margin:0 10px;}
                         .diyform_main .dline .dtitle { color:#666;}
                 </style>
        <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('diyform/formfields', TEMPLATE_INCLUDEPATH)) : (include template('diyform/formfields', TEMPLATE_INCLUDEPATH));?>
         </div>
    <?php  } ?>

    <div class="addorder_price" >
        <input type="hidden" data-id="<%order.supplier_uid%>" data-name="weight" value="<%weight%>" />
        <div class="price">
            <%if order.dispatch_price>=0%>
            <div class="line" style="line-height:26px;">+运费<span>￥<span class='dispatchprice' data-id="<%order.supplier_uid%>"><%order.dispatch_price%></span></span></div>
            <%/if%>
            <%if order.discountprice!=0%>
            <div class="line" style="line-height:26px;">
              优惠 
              <span>-￥<span class='discountprice' data-id="<%order.supplier_uid%>"><%order.discountprice%></span></span></div>

            <%/if%>
              <%if order.saleset%>
            <div class="deductenough"  data-id='<%order.supplier_uid%>' class="line" style="line-height:26px;<%if !order.saleset.showenough %>display:none<%/if%>"  >-单笔满 <d style='color:#f15353' class="deductenough_enough" data-id='<%order.supplier_uid%>'><%saleset.enoughmoney%></d> 元立减  <span>-￥<span class="deductenough_money"  data-id='<%order.supplier_uid%>'><%saleset.enoughdeduct%></span><span></div>
            <%/if%>
                   <?php  if($hascouponplugin) { ?>
                   <div class="coupondeduct_div"  data-id='<%order.supplier_uid%>' class="line" style="line-height:26px;display:none"><d class='coupondeduct_text' data-id='<%order.supplier_uid%>'></d><span>-￥<span class="coupondeduct_money"  data-id='<%order.supplier_uid%>'>0</span><span></div>
                   <?php  } ?>
            
        </div>
    </div>
    <input type="hidden" data-id="<%order.supplier_uid%>" data-name="couponid" value="" />
     <div></div>
    <?php  if(empty($_GPC['ischannelpay']) && $hascouponplugin) { ?>
     <div class="addorder_price coupondiv"  data-id="<%order.supplier_uid%>" >
        <div class="price">
            <div class="line selectcoupon" style="line-height:32px;" data-id="<%order.supplier_uid%>">
                       <d class="couponselect" data-id="<%order.supplier_uid%>"><%if order.couponcount>0%>我要使用优惠券<%else%>没有符合条件的优惠券~<%/if%></d>
                <div class="ico2" style="float:right;color:#999;margin-top:2px;"><i class='fa fa-angle-right fa-2x'></i></div>
                <div class="couponcount"><%order.couponcount%></div>
            </div>
        </div>
    </div>
    <?php  } ?>
   <%if order.deductyunbi>0%>
     <div class="addorder_price">
        <div class="price" >
            <%if order.deductyunbi>0 %>
              <div class="line" style="line-height:26px;"><d class="deductyunbi_info" data-id="<%order.supplier_uid%>"><%order.deductyunbi%></d> <?php  echo $yunbiset['yunbi_title'];?>可抵扣 <d class="deductyunbi_money" data-id="<%order.supplier_uid%>" style='color:#f15353'><%order.deductyunbimoney%></d> 元
                  <?php  if(empty($_GPC['isyunbipay'])) { ?><div class="nav deductyunbi" data-id="<%order.supplier_uid%>" on="0" credit="<%order.deductyunbi%>" money='<%order.deductyunbimoney%>'><nav></nav></div>
                  <?php  } ?>
              </div>
            <%/if%>
        </div>
    </div>
   <%/if%>
    
    <%if order.deductcredit>0 || order.deductcredit2>0  %>
     <div class="addorder_price">
            <div class="price" >
            <%if order.deductcredit>0 %>
            <div class="line" style="line-height:26px;"><d class="deductcredit_info" data-id="<%order.supplier_uid%>"><%order.deductcredit%></d> <?php  if($shopset['credit1']) { ?><?php  echo $shopset['credit1'];?><?php  } else { ?>积分<?php  } ?>可抵扣 <d class="deductcredit_money" data-id="<%order.supplier_uid%>" style='color:#f15353'><%order.deductmoney%></d> 元
                <div class="nav deductcredit" data-id="<%order.supplier_uid%>" on="0" credit="<%order.deductcredit%>" money='<%order.deductmoney%>'><nav></nav></div>
            </div>
            <%/if%>
            
            <%if order.deductcredit2>0 %>
            <div class="line" style="line-height:33px;"><?php  if($shopset['credit']) { ?><?php  echo $shopset['credit'];?><?php  } else { ?>余额<?php  } ?>可抵扣 <d class="deductcredit2_money"  data-id="<%order.supplier_uid%>" style='color:#f15353'><%order.deductcredit2%></d> 元
                <div data-id="<%order.supplier_uid%>" class="nav deductcredit2" on="0" credit2="<%order.deductcredit2%>"><nav></nav></div>
            </div>
            <%/if%>
     
        </div>
      
    </div>
    <%/if%>
    <div class="addorder_price">
            <div class="price">
            <div class="line" style="line-height:26px;">商品小计 <span>￥<span class='goodspricesubtotal' data-id="<%order.supplier_uid%>"><%order.realprice%></span></span>
            </div>
        </div>
      
    </div>
<%/each%>   
    <div class="addorder_pay">
        <div class="paysub">确认订单</div>
        <span>需付：￥<t class='totalprice'><%realprice_total%></t>元</span>
    </div> 
</script>
<script id="tpl_img" type="text/html">
    <div class='img' data-img='<%filename%>'>
        <img src='<%url%>' />
        <div class='minus'><i class='fa fa-minus-circle'></i></div>
    </div>
</script>

<?php  if($hascouponplugin) { ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('coupon/chooser', TEMPLATE_INCLUDEPATH)) : (include template('coupon/chooser', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
<script type="text/javascript">
var fromcart = 0;
    require(['tpl', 'core'], function(tpl, core) {
        core.json('order/confirm', {id:'<?php  echo intval($_GPC['id'])?>', optionid:'<?php  echo intval($_GPC['optionid'])?>', total:'<?php  echo intval($_GPC['total'])?>',cartids:"<?php  echo $_GPC['cartids'];?>",ischannelpay:"<?php  echo $_GPC['ischannelpay'];?>",ischannelpick:"<?php  echo $_GPC['ischannelpick'];?>",isyunbipay:"<?php  echo $_GPC['isyunbipay'];?>"}, function(json){

        if(json.status==-1){
            location.href=json.result.url;
            return;
        }
        $('#confirm_container').html(tpl('tpl_confirm_info', json.result));

            <?php  if(!empty($order_formInfo)) { ?>
                <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('diyform/common_js', TEMPLATE_INCLUDEPATH)) : (include template('diyform/common_js', TEMPLATE_INCLUDEPATH));?>
            <?php  } ?>

            $('.leftnav').click(function(){
                var input =$(this).next();
                if(!input.isInt()){
                    input.val('1');
                }
                var num = parseFloat( input.val() );
                num--;
                if(num<=0){
                    num=1;
                }
                input.val(num);
                    $('.goodscount').html(num);
                marketprice = parseFloat( $(this).closest('.good').find('.marketprice').html().replace(",","") ) * num;
                $('.goodsprice').html( marketprice.toFixed(2) );
                    var supplierids = $("#supplierids").val();
                    var supplierarr = new Array();
                    supplierarr = supplierids.split(",");

                    var discount = '';
                    var discountway = '';
                    var discountprice = 0;

                    for (var i = 0; i < supplierarr.length; i++) {
                        discountprice = 0;
                        discount = $('input[data-id=discount'+supplierarr[i]+']').val();
                        discountway = $('input[data-id=discountway'+supplierarr[i]+']').val();
                        if (discountway == 1) {
                            if( $('input[data-id=discount'+supplierarr[i]+']').length>0){
                                discountprice += marketprice - parseFloat( discount.replace(",","") ) / 10 * marketprice;
                                
                            }
                        } else {
                            if( $('input[data-id=discount'+supplierarr[i]+']').length>0){
                                discountprice += parseFloat( discount.replace(",","") ) * num;
                            }
                        }   
                        $('.discountprice[data-id='+supplierarr[i]+']').html( discountprice.toFixed(2) );  
                    }

                var zt =  $('.addorder_nav .selected').data('nav') =='1';
                getDispatchPrice(zt);
                
            })
            
             $('.rightnav').click(function(){
                var maxbuy = parseInt( $(this).closest('.good').data('totalmaxbuy'));
             
                var input =$(this).prev();
                if(!input.isInt()){
                    input.val('1');
                } 
                var num = parseInt( input.val() );
                num++;
               
                if(num>maxbuy ){
                    num=maxbuy;
                    core.tip.show("您最多购买 " + maxbuy + " 件");
                }
                input.val(num);
                $('.goodscount').html(num);
                var marketprice = parseFloat( $(this).closest('.good').find('.marketprice').html().replace(",","") ) * num;
                $('.goodsprice').html( marketprice.toFixed(2) );
                    var supplierids = $("#supplierids").val();
                    var supplierarr = new Array();
                    supplierarr = supplierids.split(",");

                    var discount = '';
                    var discountway = '';
                    var discountprice = 0;

                    for (var i = 0; i < supplierarr.length; i++) {
                        discountprice = 0;
                        discount = $('input[data-id=discount'+supplierarr[i]+']').val();
                        discountway = $('input[data-id=discountway'+supplierarr[i]+']').val();
                        if (discountway == 1) {
                            if( $('input[data-id=discount'+supplierarr[i]+']').length>0){
                                discountprice += marketprice - parseFloat( discount.replace(",","") ) / 10 * marketprice;
                                
                            }
                        } else {
                            if( $('input[data-id=discount'+supplierarr[i]+']').length>0){
                                discountprice += parseFloat( discount.replace(",","") ) * num;
                            }
                        } 
                        $('.discountprice[data-id='+supplierarr[i]+']').html( discountprice.toFixed(2) );  
                    }

                

               var zt =  $('.addorder_nav .selected').data('nav') =='1';
                getDispatchPrice(zt);

            });
            
     $('.shownum').blur(function(){
               
               var maxbuy = parseInt( $(this).closest('.good').data('totalmaxbuy'));
           
                var input =$(this);
                if(!input.isInt()){
                    input.val('1');
                    return;
                }
                if(parseInt(input.val())<0){
                    input.val('1');
                    return;
                }
                var num = parseInt( input.val() );
            
               
               if(num>maxbuy ){
                    num=maxbuy;
                    core.tip.show("您最多购买 " + maxbuy + " 件");
                }
                input.val(num);
                $('#goodscount').html(num);
                   marketprice = parseFloat( $(this).closest('.good').find('.marketprice').html().replace(",","") ) * num;
                $('.goodsprice').html( marketprice.toFixed(2) );
                    var supplierids = $("#supplierids").val();
                    var supplierarr = new Array();
                    supplierarr = supplierids.split(",");

                    var discount = '';
                    var discountway = '';
                    var discountprice = 0;

                    for (var i = 0; i < supplierarr.length; i++) {
                        discountprice = 0;
                        discount = $('input[data-id=discount'+supplierarr[i]+']').val();
                        discountway = $('input[data-id=discountway'+supplierarr[i]+']').val();
                        if (discountway == 1) {
                            if( $('input[data-id=discount'+supplierarr[i]+']').length>0){
                                discountprice += marketprice - parseFloat( discount.replace(",","") ) / 10 * marketprice;
                                
                            }
                        } else {
                            if( $('input[data-id=discount'+supplierarr[i]+']').length>0){
                                discountprice += parseFloat( discount.replace(",","") ) * num;
                            }
                        }   
                        $('.discountprice[data-id='+supplierarr[i]+']').html( discountprice.toFixed(2) );  
                    }

          
               var zt =  $('.addorder_nav .selected').data('nav') =='1';
                getDispatchPrice(zt);
               
           })
        fromcart = json.result.fromcart;
        
 


        //选择快递或字提
        $('.addorder_nav .nav').click(function () {
            var nav = $(this).data('nav');
            $('.addorder_nav .nav').removeClass('selected');
            $(this).addClass('selected');
            $('.addorder_user').hide();
            if (nav == '2') {
                $('.addorder_user_0').show();
            } else {
                $('.addorder_user_' + nav).show();
            }

            if (nav == '1') {
                $('.carrier_input_info').show();
                $('.addorder_user addorder_user_0').hide();
                $('.addorder_exp').hide();
                getDispatchPrice(true);
            } else if (nav == '0') {
                $('.carrier_input_info').hide();
                $('.addorder_user addorder_user_0').show();
                $('.addorder_exp').show();
                $('#carrierid').val('');
                getDispatchPrice();
            } else if (nav == '2') {
                $('.carrier_input_info').hide();
                $('.addorder_user addorder_user_0').show();
                $('.addorder_exp').show();
                $('#carrierid').val('');
                getDispatchPrice();
            }
            $('#dispatchtype').val(nav);
        });
        if (json.result.carrier_list.length > 0) {
            //选择自提
            $('#carrier_select').click(function () {
                json.result.selectedCarrierIndex = $("#carrierindex").val();

                $('#carrier_container').html(tpl('tpl_carrier_list', json.result));
                $(".chooser").height($(document.body).height());
                $(".choose_carrier").animate({right: "0px"}, 200);
                $('.carrier').click(function () {
                    var obj = $(this);
                    $("#carrierindex").val(obj.data('index'));
                    $("#carrierid").val(obj.data('id'));
                    $("#carrier_realname").html(obj.data('realname'));
                    $("#carrier_mobile").html(obj.data('mobile'));
                    $("#carrier_address").html(obj.data('address'));
                    $(".choose_carrier").animate({right: "-100%"}, 100);
                    getDispatchPrice(true);


                })
            })
        }
        if (json.result.carrier_list_send.length > 0){
            $('#carrier_select_send').click(function() {
                json.result.selectedCarrierIndex = $("#carrierindex_send").val();

                $('#carrier_container').html(tpl('tpl_carrier_list_send', json.result));
                $(".chooser").height($(document.body).height());
                $(".choose_carrier").animate({right: "0px"}, 200);
                $('.carrier').click(function() {
                    var obj = $(this);
                    $("#carrierindex_send").val(obj.data('index'));
                    $("#carrierid_send").val(obj.data('id'));
                    $("#carrier_realname_send").html(obj.data('realname'));
                    $("#carrier_mobile_send").html(obj.data('mobile'));
                    $("#carrier_address_send").html(obj.data('address'));
                    $(".choose_carrier").animate({right: "-100%"}, 100);


                })
            })
        }

        //选择地址 
        $('#address_select').click(function() {

            core.json('shop/address', {}, function(addresslist_json) {
                //默认地址
                addresslist_json.result.selectedAdressID = $("#addressid").val();

                $('#address_container').html(tpl('tpl_address_list', addresslist_json.result));
                $('.address .ico,.address .info').click(function() {
                    var $this = $(this).parent();
                    $("#addressid").val($this.data('addressid'));
                    $("#address_realname").html($this.data('realname'));
                    $("#address_mobile").html($this.data('mobile'));
                    $("#address_address").html($this.data('address'));
                    $(".choose_address").animate({right: "-100%"}, 200);
                    //重新获取运费
                    getDispatchPrice();
                });
                //地址编辑
                $('.address .edit').click(function() {
                    var addressid = $(this).parent().data('addressid');
                    core.json('shop/address', {op: 'get', id: addressid}, function(getaddress_json) {
                        $('#address_container').html(tpl('tpl_address_new', getaddress_json.result));
                        $(".chooser").height($(document.body).height());
                        $(".address_main").animate({right: "0px"}, 200);
                        var address = getaddress_json.result.address;
                        <?php  if($trade['is_street'] == '1') { ?>
                        cascdeInit(address.province, address.city, address.area, address.street);
                        <?php  } else { ?>
                        cascdeInit(address.province, address.city, address.area);
                        <?php  } ?>
                        $('.address_sub2').click(function() {
                            $(".address_main").animate({right: "-100%"}, 200);
                        });
                        $('.address_sub1').click(function() {
                            saveAddress($(this));
                        });

                    }, true);
                })
                        $(".chooser").height($(document.body).height());
                    $(".choose_address").animate({right: "0px"}, 200);
                    $('.add_address').click(function() {
                        addAddress($(this));
                    })
                }, true);

        });


        //保存地址
        function saveAddress(obj) {
            if (obj.attr('saving') == '1') {
                return;
            }

            if ($('#realname').isEmpty()) {
                core.tip.show('请输入收件人!');
                return;
            }
            if (!$('#mobile').isMobile()) {
                core.tip.show('请输入正确的联系电话!');
                return;
            }
       if($('#sel-provance').val()=='请选择省份'){
                    core.tip.show('请选择省份!');
                    return;
                }
           if($('#sel-city').val()=='请选择城市'){
                    core.tip.show('请选择城市!');
                    return;
                }
          if($('#sel-area').val()=='请选择地区'){
                    core.tip.show('请选择地区!');
                    return;
                }
            if ($('#address').isEmpty()) {
                core.tip.show('请输入详细地址!');
                return;
            }
            $('.address_sub1').html('正在处理...').attr('disabled', true);
            obj.attr('saving', '1');
            if ($('#sel-street').val()) {
                var street = $('#sel-street').val();
            } else {
                var street = '';
            }
            core.json('shop/address', {
                op: 'submit',
                id: $('#edit_addressid').val(),
                addressdata: {
                    realname: $('#realname').val(),
                    mobile: $('#mobile').val(),
                    address: $('#address').val(),
                    province: $('#sel-provance').val(),
                    city: $('#sel-city').val(),
                    area: $('#sel-area').val(),
                    street : street
                 //   zipcode: $('#zipcode').val(),
                }
            }, function(saveaddress_json) {
                if (saveaddress_json.status == 1) {
                    $("#addressid").val(saveaddress_json.result.addressid);
                    $("#address_realname").html($('#realname').val());
                    $("#address_mobile").html($('#mobile').val());
                    $("#address_address").html($('#address').val());
                    $("#address_select").show();
                    $(".address_main").animate({right: "-100%"}, 200);
                    $('#address_new').hide();
                    getDispatchPrice();
                }
                else {
                    core.tip.show('保存失败,请重试');
                }
                obj.removeAttr('saving');
            }, true, true);

        }
        function getDispatchPrice(zt) {
            var supplierids = $("#supplierids").val();
            var supplierarr = new Array();
            supplierarr = supplierids.split(",");
            for (var i = 0; i < supplierarr.length; i++) {
              var goodsprice = parseFloat($('.goodsprice[data-id='+supplierarr[i]+']').html().replace(',',''));
              var discountprice =0;
              if($('.discountprice[data-id='+supplierarr[i]+']').length>0){
                   discountprice = parseFloat($('.discountprice[data-id='+supplierarr[i]+']').html().replace(',',''));
              }
              totalprice = goodsprice - discountprice;
              //重新获取运费
              if( $('.shownum').length>0){
                  totalprice = parseFloat( $('.marketprice').html() ) * parseInt($('.shownum').val());
                  var goodsinfo = $("input[data-name='goods'][data-id="+supplierarr[i]+"]").val().split('|')[0];
                  var goods = goodsinfo.split(',');
                  var goodsid = goods[0];
                  var optionid = goods[1];
                  var num = parseInt( $('.shownum').val());
                  $("input[data-name='goods'][data-id="+supplierarr[i]+"]").val(goodsid + "," + optionid +"," + num + '|');
              }
              var supplier_uid =  supplierarr[i];
              core.json('order/confirm', {
                  op: 'getdispatchprice',
                  totalprice:totalprice,
                  addressid: $('#addressid').val(),
                  dispatchid: $('#dispatchid').val(),
                  carrierid: $('#carrierid').val(),
                  supplier_uid: supplierarr[i],
                  dflag: zt,
                  id:"<?php  echo $_GPC['id'];?>",
                  cartids:"<?php  echo $_GPC['cartids'];?>",
                  optionid:$('.option').data('id'),
                  goods: $("input[data-name='goods'][data-id="+supplierarr[i]+"]").val(),
                  total:$('.shownum').val()
              }, function(getjson) {
                  if (getjson.status == 1) {

                      if(zt){
                          $('.dispatchprice[data-id='+getjson.result.supplier_uid+']').html('0.00');
                      } else {
                          $('.dispatchprice[data-id='+getjson.result.supplier_uid+']').html(getjson.result.price);
                      }

                      if(getjson.result.deductcredit){
                          $('.deductcredit_money[data-id='+getjson.result.supplier_uid+']').html( getjson.result.deductmoney);
                          $('.deductcredit_info[data-id='+getjson.result.supplier_uid+']').html( getjson.result.deductcredit);
                          $('.deductcredit[data-id='+getjson.result.supplier_uid+']').attr('credit',getjson.result.deductcredit);
                          $('.deductcredit[data-id='+getjson.result.supplier_uid+']').attr('money',getjson.result.deductmoney);
                      }
                      if(getjson.result.deductyunbi){
                          $('.deductyunbi_money[data-id='+getjson.result.supplier_uid+']').html( getjson.result.deductyunbimoney);
                          $('.deductyunbi_info[data-id='+getjson.result.supplier_uid+']').html( getjson.result.deductyunbi);
                          $('.deductyunbi[data-id='+getjson.result.supplier_uid+']').attr('credit',getjson.result.deductyunbi);
                          $('.deductyunbi[data-id='+getjson.result.supplier_uid+']').attr('money',getjson.result.deductyunbimoney);
                      }
                      if(getjson.result.deductcredit2){
                          $('.deductcredit2_money[data-id='+getjson.result.supplier_uid+']').html( getjson.result.deductcredit2);
                          $('.deductcredit2[data-id='+getjson.result.supplier_uid+']').attr('credit2',getjson.result.deductcredit2);
                      }

                      if(getjson.result.hascoupon){
                        $('.coupondiv[data-id='+supplier_uid+']').show();
                          $('.couponselect[data-id='+supplier_uid+']').html('我要使用优惠券');
                          $('.coupondiv[data-id='+supplier_uid+'] .couponcount').html(getjson.result.couponcount);
                        bindCouponEvents();
                      }else{
                        $("input[data-name='couponid'][data-id="+supplier_uid+"]").val('');
                        $('.couponselect[data-id='+supplier_uid+']').html('没有符合条件的优惠券~');
                        $('.coupondiv[data-id='+supplier_uid+'] .couponcount').html('0');
                        //$('.coupondiv[data-id='+supplier_uid+']').hide();
                      }

                      if(getjson.result.deductenough_money>0){
                          $('.deductenough[data-id='+getjson.result.supplier_uid+']').show();
                          $('.deductenough_money[data-id='+getjson.result.supplier_uid+']').html( getjson.result.deductenough_money);
                          $('.deductenough_enough[data-id='+getjson.result.supplier_uid+']').html( getjson.result.deductenough_enough);
                      } else{
                          $('.deductenough[data-id='+getjson.result.supplier_uid+']').hide();
                          $('.deductenough_money[data-id='+getjson.result.supplier_uid+']').html( '0');
                          $('.deductenough_enough[data-id='+supplier_uid+']').html( '0');
                      }
                      calctotalprice(getjson.result.supplier_uid);
                      if( $('.shownum').length>0){
                          var goodsinfo = $("input[data-name='goods'][data-id="+getjson.result.supplier_uid+"]").val().split('|')[0];
                          var goods = goodsinfo.split(',');
                          var goodsid = goods[0];
                          var optionid = goods[1];
                          var num = parseInt( $('.shownum').val());
                          $("input[data-name='goods'][data-id="+getjson.result.supplier_uid+"]").val(goodsid + "," + optionid +"," + num + '|');
                      }

                  }
              }, true);
            };

        }
        //新增地址
        function addAddress(obj) {

            core.json('shop/address', {'op': 'new'}, function(addaddress_json) {

                var result = addaddress_json.result;
                $('#address_container').html(tpl('tpl_address_new', result));
                cascdeInit(result.address.province,result.address.city);
                <?php  if($trade['shareaddress']=='1' && is_weixin() && $trade['is_street'] != '1') { ?>
                    var shareAddress = <?php  echo json_encode($shareAddress)?>;
                    WeixinJSBridge.invoke('editAddress',shareAddress,function(res){
                        if(res.err_msg=='edit_address:ok'){
                            $("#realname").val( res.userName  );
                            $('#mobile').val( res.telNumber );
                            $('#address').val( res.addressDetailInfo );
                            cascdeInit(res.proviceFirstStageName,res.addressCitySecondStageName,res.addressCountiesThirdStageName);
                        }
                    });
                <?php  } ?>
                $(".chooser").height($(document.body).height());
                $(".address_main").animate({right: "0px"}, 200);
                $('.address_sub2').click(function() {
                    $(".address_main").animate({right: "-100%"}, 200);
                });
                $('.address_sub1').click(function() {
                    saveAddress($(this));
                });

            }, true);
        }
        if ($('#dispatchtype').val() == 1 && json.result.carrier_list.length>0) {
            getDispatchPrice(true);
        }
        $('#address_new').click(function() {
            addAddress($(this));
        });

        //计算总价
        function calctotalprice(supplier_uid) {
            var dispatchprice = 0;
            var goodsprice = parseFloat($('.goodsprice[data-id='+supplier_uid+']').html().replace(',',''));
            var dispatchpricehtml = $('.dispatchprice[data-id='+supplier_uid+']').html();
            if(dispatchpricehtml){
              dispatchprice = parseFloat(dispatchpricehtml.replace(',',''));
            }
            var discountprice =0;
            if($('.discountprice[data-id='+supplier_uid+']').length>0){
                   discountprice = parseFloat($('.discountprice[data-id='+supplier_uid+']').html().replace(',',''));
              }
              var totalprice = goodsprice - discountprice;
            var enoughprice =0;
            var isdeductenough = $('.deductenough[data-id='+supplier_uid+']').css("display");
            if(isdeductenough != 'none'){
                if($('.deductenough_money[data-id='+supplier_uid+']').length>0 && $('.deductenough_money[data-id='+supplier_uid+']').html()!=''){
                     enoughprice = parseFloat($('.deductenough_money[data-id='+supplier_uid+']').html().replace(',',''));
                }
            }
              <?php  if($hascouponplugin) { ?>
                   totalprice = calcCouponPrice(totalprice, supplier_uid);
              <?php  } ?>
            totalprice = totalprice - enoughprice + dispatchprice;

            var deductprice = 0;
            if($('.deductcredit[data-id='+supplier_uid+']').length>0){
                if($('.deductcredit[data-id='+supplier_uid+']').attr('on')=='1'){
                    deductprice = parseFloat( $('.deductcredit[data-id='+supplier_uid+']').attr('money').replace(',','') )

                           if($('.deductcredit2[data-id='+supplier_uid+']').length>0){
                              var td1 = parseFloat( $('.deductcredit2[data-id='+supplier_uid+']').attr('credit2').replace(',','') );

                              if(totalprice-deductprice>=0){
                                  var td = totalprice - deductprice;
                                  if(td>td1){
                                      td = td1;
                                  }
                                  $('.deductcredit2_money[data-id='+supplier_uid+']').html( td.toFixed(2) );
                              }else{
                                   $('.deductcredit2[data-id='+supplier_uid+']').attr('on','0').removeClass('on');
                              }
                           }

                } else{
                     if($('.deductcredit2[data-id='+supplier_uid+']').length>0){
                        var td = parseFloat( $('.deductcredit2[data-id='+supplier_uid+']').attr('credit2').replace(',','') );
                        $('.deductcredit2_money[data-id='+supplier_uid+']').html( td.toFixed(2) );
                     }

                }
            }
            var deductyunbi = 0;
            if($('.deductyunbi[data-id='+supplier_uid+']').length>0){
                if($('.deductyunbi[data-id='+supplier_uid+']').attr('on')=='1'){
                    deductyunbi = parseFloat( $('.deductyunbi[data-id='+supplier_uid+']').attr('money').replace(',','') )
                }
            }
            var deductprice2 = 0;
            if($('.deductcredit2[data-id='+supplier_uid+']').length>0){
                     if($('.deductcredit2[data-id='+supplier_uid+']').attr('on')=='1'){
                          deductprice2 = parseFloat( $('.deductcredit2_money[data-id='+supplier_uid+']').html().replace(',','') );
                     }
             }

            totalprice = totalprice - deductprice - deductprice2 - deductyunbi;
            if(totalprice<=0){
                totalprice = 0;
            }
            $('.goodspricesubtotal[data-id='+supplier_uid+']').html(totalprice.toFixed(2));
            var order_realprice = 0;
            $(".goodspricesubtotal").each(function(){
                order_realprice += parseFloat($(this).html().replace(',',''));
            });

            $('.totalprice').html(order_realprice.toFixed(2));
            return totalprice;
        }
        //选择快递
        $('#dispatch_select').click(function() {
            json.result.selectedDispatchID = $("#dispatchid").val();
            $('#dispatch_container').html(tpl('tpl_dispatch_list', json.result));
                  $(".chooser").height($(document.body).height());
            $(".choose_dispatch").animate({right: "0px"}, 200);
            $('.dispatch').click(function() {
                var obj = $(this);
                $("#dispatchid").val(obj.data('dispatchid'));
                $(".dispatchname").html(obj.data('dispatchname'));
                $(".chooser").animate({right: "-100%"}, 100);
                //重新获取运费
                getDispatchPrice();

            })
        });

        //订单
        $('.paysub').click(function() {
          var supplierids = $("#supplierids").val();
          var supplierarr = new Array();
          var data = new Array();
          var order = new Array();
          supplier_str = supplierids.split(",");
          if($.isArray(supplierarr) == false){
            supplierarr[0] = supplier_str;
          }else{
            supplierarr = supplier_str;
          }
          for (var i = 0; i < supplierarr.length; i++) {
            if ($(this).attr('submitting') == '1') {
                return;
            }

            var dispatchid = $("#dispatchid").val();
            var carrierid = $("#carrierid").val();
            var carrierid_send = $('#carrierid_send').val(); 
            
            
            var addressid = $("#addressid").val();
            var goods = $("input[data-name='goods'][data-id="+supplierarr[i]+"]").val();
            var carrier_realname = $.trim( $('#carrier_input_realname').val() );
            var carrier_mobile = $.trim( $('#carrier_input_mobile').val() );
            if (goods == '') {
                core.tip.show("没有任何商品");
                return;
            }
            <?php  if($show==1) { ?>
                    if( $("#dispatchtype").val()=='0' || $("#dispatchtype").val()=='2'){
                if (addressid == '') {
                            core.tip.show("请选择地址");
                            return;
                        }
                        if (dispatchid == '') {
                            core.tip.show("请选择配送方式");
                            return;
                        }
                    }
                /*if($('#isverify').val()=='true'){
                    if (carrier_realname== '') {
                        core.tip.show("请填写联系人姓名");
                        return;
                    }
                    if (!$.isMobile(carrier_mobile)) {
                        core.tip.show("请填写正确手机号");
                        return;
                    }
                }*/
              if( $("#dispatchtype").val()=='1'){
                  if (carrier_realname== '') {
                      core.tip.show("请填写姓名");
                      return;
                  }
                  if (!$.isMobile(carrier_mobile)) {
                      core.tip.show("请填写正确手机号");
                      return;
                  }
              }
                      <?php  } ?>
                  var diydata = '';
                  var gdid = <?php  echo intval($goods_data_id)?>;
            <?php  if(!empty($order_formInfo)) { ?>
                     <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('diyform/common_js_data', TEMPLATE_INCLUDEPATH)) : (include template('diyform/common_js_data', TEMPLATE_INCLUDEPATH));?>
                <?php  } ?>


            order[i] ={
                'supplier_uid': supplierarr[i],
                'goods': goods,
                        'id':'<?php  echo $id;?>',
                        gdid:gdid,
                        diydata:diydata,
                'dispatchtype': $("#dispatchtype").val(),
                'fromcart':fromcart,
                'cartids':"<?php  echo $_GPC['cartids'];?>",
                'remark': $("input[data-name='remark'][data-id="+supplierarr[i]+"]").val(),
                'deduct':0,
                'yunbi':0,
                'deduct2':0
            };

            if( $("#dispatchtype").val()=='0' || $("#dispatchtype").val()=='2'){
               order[i].addressid = addressid;
               order[i].dispatchid = dispatchid;
            }

            if($('#isverify').val()=='true'){
                if ($('#dispatchtype').val() != 1) {
                    order[i].carrierid = carrierid_send;
                } else {
                    order[i].carrierid = carrierid;
                }
                order[i].carrier = {
                    'carrier_realname': carrier_realname,
                    'carrier_mobile':carrier_mobile,
                    'realname': $('#carrier_realname').html(),
                    'mobile': $('#carrier_mobile').html(),
                    'address': $('#carrier_address').html()
                };
            }

            if($('.deductcredit[data-id='+supplierarr[i]+']').length>0){
                if($('.deductcredit[data-id='+supplierarr[i]+']').attr('on')=='1'){
                      order[i].deduct = 1;
                }
            }
            if($('.deductyunbi[data-id='+supplierarr[i]+']').length>0){
                if($('.deductyunbi[data-id='+supplierarr[i]+']').attr('on')=='1'){
                      order[i].yunbi = 1;
                }
            }
            if($('.deductcredit2[data-id='+supplierarr[i]+']').length>0){
                if($('.deductcredit2[data-id='+supplierarr[i]+']').attr('on')=='1'){
                      order[i].deduct2 = 1;       
                }
            }
              <?php  if($hascouponplugin) { ?>
                  order[i].couponid = $("input[data-name='couponid'][data-id="+supplierarr[i]+"]").val();
              <?php  } ?>

          }
           data = {op:'create', order:order, ischannelpay:"<?php  echo $_GPC['ischannelpay'];?>", ischannelpick:"<?php  echo $_GPC['ischannelpick'];?>",isyunbipay:"<?php  echo $_GPC['isyunbipay'];?>"};
          $(this).attr('submitting', '1').html('提交中...');
            core.json('order/confirm', data, function(create_json) {

                if (create_json.status == 1) {
                    if (create_json.result.ischannelpick) {
                        location.href = "<?php  echo $this->createMobileUrl('order/list')?>";
                    } else {
                        location.href = "<?php  echo $this->createMobileUrl('order/pay')?>&orderid=" + create_json.result.orderid +"&openid=<?php  echo $openid;?>&ischannelpay=" + create_json.result.ischannelpay;
                    }
                } else if (create_json.status == -1) {
                    $('.paysub').html('确认订单').removeAttr('submitting');
                    core.tip.show(create_json.result);
                } else if (create_json.status == -2) {
                    $('.paysub').html('确认订单').removeAttr('submitting');
                    core.tip.show(create_json.result);
                } else {
                    $('.paysub').html('确认订单').removeAttr('submitting');
                    core.tip.show("生成订单失败!")
                }

            }, true, true);
          
        })
        
        //积分抵扣
        $('.deductcredit').click(function(){
               var on = $(this).attr('on')=='0'?'1':'0';
               var supplier_uid = $(this).attr('data-id');
               $(this).attr('on',on);
               if(on=='1'){
                     $(this).addClass('on').find('nav').addClass('on');
               }
               else{
                     $(this).removeClass('on').find('nav').removeClass('on');
               } 
               calctotalprice(supplier_uid);
        });

        //虚拟币抵扣
        $('.deductyunbi').click(function(){
               var on = $(this).attr('on')=='0'?'1':'0';
               var supplier_uid = $(this).attr('data-id');
               $(this).attr('on',on);
               if(on=='1'){
                     $(this).addClass('on').find('nav').addClass('on');
               }
               else{
                     $(this).removeClass('on').find('nav').removeClass('on');
               } 
               calctotalprice(supplier_uid);
        });

        //余额抵扣
        $('.deductcredit2').click(function(){
               var on = $(this).attr('on')=='0'?'1':'0';
               var supplier_uid = $(this).attr('data-id');
               $(this).attr('on',on);
               if(on=='1'){
                     $(this).addClass('on').find('nav').addClass('on');
               }
               else{
                     $(this).removeClass('on').find('nav').removeClass('on');
               } 
               calctotalprice(supplier_uid);
        });
       <?php  if($hascouponplugin) { ?>
        bindCouponEvents();
        function calcCouponPrice(totalprice, supplier_uid){
           $('.coupondeduct_div[data-id='+supplier_uid+']').hide();
           $('.coupondeduct_text[data-id='+supplier_uid+']').html('');
           $('.coupondeduct_money[data-id='+supplier_uid+']').html('0');
           if($("input[data-name='couponid'][data-id="+supplier_uid+"]").val()=='' ||  $("input[data-name='couponid'][data-id="+supplier_uid+"]").val()=='0')   {
                 return totalprice;
           }
             var deduct   = parseFloat( $('.couponselect[data-id='+supplier_uid+']').data('deduct') );
           var discount = parseFloat( $('.couponselect[data-id='+supplier_uid+']').data('discount') );
           var backtype = parseFloat( $('.couponselect[data-id='+supplier_uid+']').data('backtype') );
             var deductprice = 0;
             if(deduct>0 && backtype==0){ //抵扣
               if(deduct>totalprice){
                   deduct=totalprice;
               }
               if(deduct<=0){
                   deduct = 0;
               }
               deductprice = deduct;
               totalprice-=deduct;
               $('.coupondeduct_text[data-id='+supplier_uid+']').html('优惠券优惠');
             }else if(discount>0 && backtype==1){//打折
               deductprice = totalprice *  (1 - discount/10 );
               if(deductprice>totalprice){
                   deductprice=totalprice;
               }
                 if(deductprice<=0){
                       deductprice = 0;
                 }
                 totalprice-=deductprice;       
                 $('.coupondeduct_text[data-id='+supplier_uid+']').html('优惠券折扣(' + discount + '折)');
             }
             if(deductprice>0){
                $('.coupondeduct_div[data-id='+supplier_uid+']').show();
              $('.coupondeduct_money[data-id='+supplier_uid+']').html(deductprice.toFixed(2));  
             }
             return totalprice;
                
        }

        function bindCouponEvents(){
                  $('.selectcoupon').click( function(){
             var money =parseFloat( $('.goodsprice').html().replace(",","") ) ;
             var supplier_uid = $(this).attr('data-id');
                   var carrierid = $('#carrierid').val();
                     core.pjson('coupon/util', {op: 'query', money: money, type:0, supplier_uid: supplier_uid, goodsid: "<?php  echo $goodid;?>", cartids: "<?php  echo $cartid;?>", carrierid: carrierid}, function (rjson) {
                            if (rjson.status != 1) {
                                core.tip.show(rjson.result);
                                $("input[data-name='couponid'][data-id="+supplier_uid+"]").val('');
                                calctotalprice(supplier_uid); 
                                return;
                            }
                            if(rjson.result.coupons.length>0 || $.makeArray(rjson.result.coupons).length>0){
                                CouponChooser.cancelCallback = function(){
                                    $('.coupondeduct_div[data-id='+supplier_uid+']').hide();
                                    $('.coupondeduct_text[data-id='+supplier_uid+']').html('');
                                    $('.coupondeduct_money[data-id='+supplier_uid+']').html('0');
                                    calctotalprice(supplier_uid); 
                                }
                                CouponChooser.confirmCallback = function(){
                                    calctotalprice(supplier_uid);
                                }
                                CouponChooser.open( rjson.result, supplier_uid);
                            }
                     }, true, true);
                });
          }
      <?php  } ?>
  }, true,true);
});
</script>

