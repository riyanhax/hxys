<?php defined('IN_IA') or exit('Access Denied');?><?php  if($operation != 'black') { ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title>会员登录</title>
<style type="text/css">
    body {margin:0px; background:#efefef; font-family:'微软雅黑'; -moz-appearance:none;}
    .info_main {height:auto;  background:#fff; margin-top:14px; border-bottom:1px solid #e8e8e8; border-top:1px solid #e8e8e8;}
    .info_main .line {margin:0 10px; height:40px; border-bottom:1px solid #e8e8e8; line-height:40px; color:#999;}
    .info_main .line .title {height:40px; width:80px; line-height:40px; color:#444; float:left; font-size:16px;}
    .info_main .line .info { width:100%;float:right;margin-left:-80px; }
    .info_main .line .inner { margin-left:80px; }
    .info_main .line .inner input {height:40px; width:100%;display:block; padding:0px; margin:0px; border:0px; float:left; font-size:16px;}
    .info_main .line .inner .user_sex {line-height:40px;}
    .info_sub {height:44px; margin:14px 5px; background:#f15353; border-radius:2px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
    .register {height:44px; margin:14px 5px; background:#ccc; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#292929;}
    .select { border:1px solid #ccc;height:25px;}
    .forget {color: #999;padding: 10px 20px 0 0;float: right;};
</style>
<script src="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.core-2.5.2.js" type="text/javascript"></script>
<script src="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.core-2.5.2-zh.js" type="text/javascript"></script>
<link href="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.core-2.5.2.css" rel="stylesheet" type="text/css" />
<link href="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.animation-2.5.2.css" rel="stylesheet" type="text/css" />
<script src="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.datetime-2.5.1.js" type="text/javascript"></script>
<script src="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.datetime-2.5.1-zh.js" type="text/javascript"></script>
<script src="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.android-ics-2.5.2.js" type="text/javascript"></script>
<link href="../addons/sz_yi/static/js/dist/mobiscroll/mobiscroll.android-ics-2.5.2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../addons/sz_yi/static/js/dist/area/cascade.js"></script>
<div id="container"></div>
<script id="member_info" type="text/html">
    <div class="page_topbar">
    <a href="javascript:;" class="back" onclick="history.back()"><i class="fa fa-angle-left"></i></a>
    <div class="title">会员登录</div>
</div>
    <div class="info_main">
        <div class="line"><div class="title">手机号码</div><div class='info'><div class='inner'><input type="text" id='mobile' placeholder="请输入您的手机号码"  value="" /></div></div></div>
        <div class="line"><div class="title">密码</div><div class='info'><div class='inner'><input type="password" id='password' placeholder="请输入您的密码"  value="" /></div></div></div>
        
    </div>
    
    <div class="info_sub">登录</div>
    <div class="register">注册</div>
    <div class="forget">忘记密码</div>
</script>
<script language="javascript">

    require(['tpl', 'core'], function(tpl, core) {
        $('#container').html(tpl('member_info'));
            $('.register').click(function(){
                location.href = "<?php  echo $this->createMobileUrl('member/register')?>";
            });

            $('.forget').click(function(){
              location.href = "<?php  echo $this->createMobileUrl('member/forget')?>";
            });
            
            $('.info_sub').click(function() {
                  if(!$('#mobile').isMobile()){
                       core.tip.show('请输入正确手机号码!');
                       return;
                  }
                  if( $('#password').isEmpty()){
                       core.tip.show('请输入密码!');
                       return;
                  }
                  
                    core.json('member/login', {
                       'memberdata':{
                            'mobile': $('#mobile').val(),
                            'password': $('#password').val()
                           } 
                       }, function(json) {
                        if(json.status==1){
                            open_id = json.result.open_id;
                            if (typeof PINGPP_IOS_SDK !== 'undefined') {
                                PINGPP_IOS_SDK.appLogin(open_id);
                            } else if (typeof PINGPP_ANDROID_SDK !== 'undefined') {
                                PINGPP_ANDROID_SDK.appLogin(open_id);
                            }

                             core.tip.show('登录成功');
                             //console.log(json.result.preurl);
                             location.href=json.result.preurl;
                        }
                        else{
                            core.tip.show('用户不存在或密码错误!');
                        }

                    },true,true);
                });


    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
<?php  if($operation == 'black') { ?>

<style type="text/css">
.ok {height:200px; padding-top:65px;}
.ok .ico {height:65px; width:65px; margin:auto; border:3px solid #32cd32; border-radius:55px; color:#32cd32; font-size:50px; text-align:center; line-height:65px;}
.ok .text {height:20px; margin-top:30px; font-size:16px; color:#666; line-height:20px; text-align:center;}
.ok .sub {height:32px; width:145px; background:#e53c39; margin:20px auto; border-radius:20px; color:#fff; line-height:32px; text-align:center; font-size:16px;}
</style>
<title>禁止访问</title>
<div id='container'></div>
  <div class="ok">
    <div class="ico"><i class="fa fa-check"></i></div>
          <div class="text">禁止访问，请联系客服！</div>
    </div>
<?php  } ?>
