<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
body { background:#fff;}

/* tab */
.tab_goods_warp { width:1200px; margin:0 auto; overflow:hidden; *zoom:1;}
.tab_left { width:300px; height:680px; float:left; position: relative;}
.tab_goods{ width: 900px; height:680px; overflow:hidden; float:left;}
.tab_goods .tab_menu{width:900px; height:40px; text-align:right; margin-bottom:10px; border-bottom:#333 1px solid;}
.tab_goods .tab_menu li{width:92px; display:inline-block;* display:inline; *zoom:1;height:40px;line-height:40px;border:1px solid #333;border-bottom:0px;cursor:pointer;text-align:center;}
.tab_goods .tab_menu li a { display:block; width:92px; height:40px; line-height:40px; color:#333;}
.tab_goods .tab_box{width:900px;}
.tab_goods .tab_menu .selected{background-color:#333; color:#fff; cursor:pointer;}
.tab_goods .tab_menu .selected a { color:#fff;}
.tab_goods .tab_menu a.more { padding: 0 10px;}
.tab_goods .tab_menu a.more span { font-family:SimSun; display: inline-block; *display: inline; *zoom:1; background: #333; border-radius: 50%; color: #fff; width: 12px; height: 12px; line-height: 12px; font-size: 10px; text-align: center;}
.tab_goods_warp .tab-third-warp  { position: absolute; bottom: 0; left: 0; width: 300px; max-height: 200px; overflow: hidden; background: #fff; filter:alpha(Opacity=80);-moz-opacity:0.8;opacity: 0.8; vertical-align: bottom;}
.tab_goods_warp .tab-third-warp  a { display: inline-block; *display: inline; *zoom:1; padding: 10px;}
/*goods_tab list*/
.tab_title span { display:block; width:100%; height:40px; background:#333; color:#fff; text-align:left; padding:0 15px; line-height:40px; font-size:16px; font-weight:bold;}
.goods_tab_list .items-li {
    float: left;
    width: 225px;
  padding-left:10px;
    background-color: #fff;
  padding-bottom:10px;
  position: relative;
}
.goods_tab_list .items-li .activity-tag {
    position: absolute;
    left: 10px;
    top: 0px;
    width: 82px;
    height: 93px;
    z-index: 2;
}
.goods_tab_list .items-li .activity-tag-80 {
  width: 105px;
    height: 110px;
    background: url('../images/activity_tag_80_little.png') no-repeat 0 0;
}
.goods_tab_list .items-li .activity-tag-75 {
    background: url('../images/activity_tag_75.png') no-repeat 0 0;
}
.goods_tab_list .items-li .activity-tag-60 {
    width: 100px;
    height: 100px;
    background: url('../images/activity_tag_60.png') no-repeat 0 0;
}
.goods_tab_list .items-li .activity-tag-50 {
    width: 100px;
    height: 100px;
    background: url('../images/activity_tag_50.png') no-repeat 0 0;
}
.no-activity .goods_tab_list .items-li .activity-tag {
    display: none;
}
.goods_tab_list .active {
    box-shadow:0 0 10px rgba(0,0,0,.2);
}
.goods_tab_list .items-li .wrap_div {
  width:225px;
    height:54px;
    position:relative;
    z-index: 2;
    background:white;
}
.goods_tab_list .items-li .wrap_div p {
    height:20px;
    overflow:hidden;
    text-align:center;
    font-size: 12px;
    color: #71cd9c;
}
.goods_tab_list .items-li .wrap_div div {
    position:absolute;
    left:0;
    bottom:0;
    z-index:100;
    width: 100%;
    background:white; 
}
.goods_tab_list .items-li .wrap_div p {
    text-align: center;
    margin-top: 5px;
    height: 0px;
    overflow: hidden;
    _line-height:0;
}
.goods_tab_list .items-li>a {
    display: block;
    width: 225px;
    height: 225px;
    text-align: center;
    line-height: 225px;
}
.goods_tab_list .items-li img {
    max-width: 225px;
    max-height: 225px;
}
.goods_tab_list .items-li .title {
    width: 225px;
    font-weight: normal;
    line-height: 22px;
    text-align: center;
    margin: 0;
    padding: 10px 10px 5px 10px;
}
.goods_tab_list .items-li .title a {
    color: #333;
}
.goods_tab_list .items-li .title a:hover {
    color: #EF353D;
}
.goods_tab_list .items-li .description {
    display: block;
    font-size: 12px;
    color: #919191;
    text-align: center;
}
.goods_tab_list .items-li .description a {
    color: #919191;
}
.goods_tab_list .items-li .price-attente {
    margin-top: 5px;
}
.goods_tab_list .items-li .price-attente .price {
    float: left;
    margin-left: 10px;
    font-size: 12px;
    color: #ef353d;
}
.goods_tab_list .items-li .price-attente .attente {
    float: right;
    margin-right: 10px;
    padding-left: 15px;
    font-size: 12px;
    color: #71cd9c;
    background-image: url(../images/cover-page-attente.png);
    background-repeat: no-repeat;
    background-position: left center;
    cursor: pointer;
}


</style>
<title><?php  echo $this->yzShopSet['pctitle']?></title>
<meta content='<?php  echo $this->yzShopSet['pckeywords']?>' name='Keywords'>
<meta content='<?php  echo $this->yzShopSet['pcdesc']?>' name='Description'>
<!--navigation--> 
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/navigation', TEMPLATE_INCLUDEPATH)) : (include template('common/navigation', TEMPLATE_INCLUDEPATH));?>
<div class="cover-page-index-slide j-index-slide fl wfs">
  <div class="border">
    <div class="center">
      <div class="relative"> 
        <!--幻灯片-->
        <div class="location">
          <div id="wrap" class="wrap">
            <div class="slide"  id='banner'>
              <ul class="slide_ul">
                <?php  if($advs_pc) { ?>
                <?php  if(is_array($advs_pc)) { foreach($advs_pc as $row) { ?>
                <li><a target="_blank" href="<?php  echo $row['link'];?>"><img src="<?php  echo $row['thumb_pc'];?>" style="width:1920px;height:513px;" alt="<?php  echo $row['advname'];?>"></a></li>
                <?php  } } ?>
                <?php  } else { ?>
                <li><a href="<?php  echo $row['link'];?>"><img src="../addons/sz_yi/template/pc/default/static/images/banner.jpg" style="width:1920px;height:513px;" alt="默认效果图片"></a></li>
                <?php  } ?>
              </ul>
            </div>
          </div>
        </div>
        <!-- <a href="javascript:void(0);" class="show_pre j-slide-btn">左边</a>
      <a href="javascript:void(0);" class="show_next j-slide-btn">右边</a> --> 
      </div>
    </div>
  </div>
  <!-- <div class="icons fl wfs">
  <ul id="tips">
    <?php  if($advs) { ?>
    <?php  if(is_array($advs)) { foreach($advs as $row) { ?>
    <li><span class= "<?php  echo $row['advname'];?>"></span></li>
    <?php  } } ?>
    <?php  } else { ?>
    <li><span class= "<?php  echo $row['advname'];?>"></span></li>
    <li><span class= "<?php  echo $row['advname'];?>"></span></li>
    <?php  } ?>
  </ul>
</div> --> 
  <!-- 删除原JS --> 
</div>
<div class="cover-page-index fl wfs">
  <div class="cover-page-wrapper"> <?php  if(is_array($index_name)) { foreach($index_name as $key => $val) { ?>
    <?php  if(in_array($key, $this->yzShopSet['index'])) { ?>
    <?php  if($ads_pc[$key]) { ?>
    <?php  if(is_array($ads_pc[$key])) { foreach($ads_pc[$key] as $adkey => $adval) { ?>
    <div class="mt20"> <a href="<?php echo $adval['link'] ? $adval['link'] : '#'?>" target="_blank"><img src="<?php  echo $adval['thumb'];?>" style="width:100%"></a> </div>
    <?php  } } ?>
    <?php  } ?>
    <div class="boutique boutique-index mt20 fl wfs">
      <h3><?php  echo $val;?></h3>
      <div class="canvas">
        <ul class="items" style="width: 1200px;margin:0">
          <?php  if($goods_pc[$key]) { ?>
          <?php  if(is_array($goods_pc[$key])) { foreach($goods_pc[$key] as $row) { ?>
          <li class="items-li j-items-li"> <a target="_blank" href="<?php  echo $this->createMobileUrl('shop/detail')?>&id=<?php  echo $row['id'];?>" style="position:relative;"><img src="<?php  echo $row['thumb'];?>" title=""></a>
            <div class="wrap_div">
              <b class="title"><a target="_blank" href="<?php  echo $this->createMobileUrl('shop/detail')?>&id=<?php  echo $row['id'];?>" title="<?php  echo $row['title'];?>"><?php  echo $row['title'];?></a></b>
            </div>
            <p class="price-attente"> <span class="price">￥<?php  echo $row['marketprice'];?>元</span> <span class="attente" title="库存">库存:<?php  echo $row['total'];?><?php  echo $row['unit'];?></span> </p>
          </li>
          <?php  } } ?>
          <?php  } else { ?>
          <?php  for($i=0; $i<4; $i++){?>
          <li class="items-li j-items-li"> <a href="#" style="position:relative;"> <img src="../addons/sz_yi/template/pc/default/static/images/default.jpg" title="" alt="商城"> </a>
            <div class="wrap_div">
              <div> <b class="title"><a href="" title="商城">默认商品效果</a></b> <span class="description"> <a href="#" target="_blank">默认效果</a>- <a href="#" title="">效果展示</a> </span>
                <p class="price-attente">商城</p>
              </div>
            </div>
            <p class="price-attente"> <span class="price">￥2999.00元</span> <span class="attente" title="库存">888</span> </p>
          </li>
          <?php  }?>
          <?php  } ?>
        </ul>
      </div>
    </div>
    <?php  } ?>
    <?php  } } ?>
    <?php  if($ads_pc['bottom_ad']) { ?>
    <div> <a href="<?php echo $ads_pc['bottom_ad']['link'] ? $ads_pc['bottom_ad']['link'] : '#'?>" target="_blank"><img src="<?php  echo $ads_pc['bottom_ad']['thumb'];?>" style="width:100%"></a> </div>
    <?php  } ?> </div>
</div>


<!--商品推荐-->
<div id="category_recommend"></div>
<script id="tpl_category_recommend" type="text/html">
<%each category as value%>
<div class="tab_goods_warp" style="margin-bottom:20px;">
  <div class="tab_left">
    <div class="tab_title"><span><%value.name%></span></div>
    <a href="<%value.advurl_pc%>"><img src="<%value.advimg_pc%>"/></a> 
    <div class="tab-third-warp">
       <%each value.third as t%>
        <a target="_blank" href="<?php  echo $this->createMobileUrl('shop/list')?>&tcate=<%t.id%>"><%t.name%></a>
       <%/each%> 
    </div>
  </div>
  <div class="tab_goods">
    <ul class="tab_menu">        
      <%each value.children as value1%>
        <li class="tab_li" data-cid="<%value1.id%>" data-id="<%value.id%>" ><a href="javascript:;"><%value1.name%></a></li>
      <%/each%>
      <a class="more" href="<?php  echo $this->createMobileUrl('shop/list')?>&pcate=<%value.id%>">更多 <span>></span></a>
    </ul>
    
    <div class="tab_box<%value.id%>">
        <div class="goods_tab_list" style="display:block;">
            <ul class="items" style="margin:0">
    <%each value.goods as g%>
          
              <li class="items-li"> <a target="_blank" href="<?php  echo $this->createMobileUrl('shop/detail')?>&id=<%g.id%>" style="position:relative;"><img src="<%g.thumb%>" title=""></a>
                <div class="wrap_div">
                  <b class="title"><a target="_blank" href="<?php  echo $this->createMobileUrl('shop/detail')?>&id=<%g.id%>" title="<%g.thumb%>"><%g.title%></a></b>
                </div>
                <p class="price-attente"> <span class="price">￥<%g.marketprice%>元</span> <span class="attente" title="销量">销量
                :<%g.sales%></span> </p>
              </li>
             
           
        <%/each%>  
     </ul>
          </div>
    </div>
    
  </div>
</div>
<%/each%>
</script>

<script id="tpl_children_list" type="text/html" >
        <div class="goods_tab_list" style="display:block;">
            <ul class="items"  style="margin:0">
    <%each goods as g%>
          
              <li class="items-li"> <a target="_blank" href="<?php  echo $this->createMobileUrl('shop/detail')?>&id=<%g.id%>" style="position:relative;"><img src="<%g.thumb%>" title=""></a>
                <div class="wrap_div">
                  <b class="title"><a target="_blank" href="<?php  echo $this->createMobileUrl('shop/detail')?>&id=<%g.id%>" title="<%g.thumb%>"><%g.title%></a></b>
                </div>
                <p class="price-attente"> <span class="price">￥<%g.marketprice%>元</span> <span class="attente" title="销量">销量:<%g.sales%></span> </p>
              </li>
        <%/each%>
            </ul>
          </div>
</script>
<script id="tpl_third_list" type="text/html" >
        
          
            
           
         
</script>
<script src="../addons/sz_yi/static/js/jquery.easing.1.3.js"></script> 
<script src="../addons/sz_yi/static/js/Animation.js"></script> 
<script>
                      
        //插件点击隐藏或者展示按钮
        $(".j-cover-page-plug-in div").bind("mouseenter mouseleave",function(e){
            if(e.type == "mouseenter"){
                $(this).find(".btn").show();
            }else{
                $(this).find(".btn").hide();
            }

        });
    // 商品动画
      var move=function(wrap,cname){
           
            $("."+wrap).each(function(){
                var obj=$(this).find("."+cname);
                var p=obj.find("p");
                $(this).hover(function(){
                    p.stop().animate({height:20},200);
                    $(this).addClass("active");
                },function(){
                    p.stop().animate({height:0},200);
                    $(this).removeClass("active");
                });
            });
        }
        move("j-items-li","wrap_div");
        // 插件动画
        var run = function() {
            var obj = $(".j-cover-page-plug-in");
            obj.addClass("clearfix");
            obj.find(".fl").css("height", 260);
            obj.find("img").css({
                position: "absolute",
                left: 0,
                top: 0
            });
            obj.find("img").hover(function() {
                // $(this).stop().animate({
                //     left: '-10px'
                // },200);
            }, function() {
                $(this).stop().animate({
                    left: 0
                },200);
            });
        }
        run();


        require(['jquery','jquery.touchslider','swipe'], function ($) {
            new Swipe($('#banner')[0], {
        speed:300,
        auto:4000,
        callback: function(){
          $(".flicking_con  .inner  a").removeClass("on").eq(this.index).addClass("on");
        }
        });         
        });
    
        require(['tpl', 'core'], function (tpl, core) {
            core.json('shop' , {op:'category_recommend'} , function(json){
                var category = json.result;
                if(json.status == 1){
                    $('#category_recommend').html(tpl('tpl_category_recommend',category)); 

                    var cid = $('.tab_menu li:first').data('cid');
                    var id = $('.tab_menu li:first').data('id');
                    $('.tab_menu li:first').addClass('selected').siblings().removeClass('selected');
                    //setgood(cid,id);
                }
            },true);



            $(document).on('mouseover','.tab_li',function(){
              $(this).addClass('selected').siblings().removeClass('selected');
              // var index = $(this).index(this);
              // $('div.tab_box > div').eq(index).show().siblings().hide();
                var cid = $(this).data('cid');
                var id = $(this).data('id');
                setgood(cid,id);
            }); 


            function setgood (cid,id){
                  core.json('shop' , {op:'children_goods',id:cid} , function(json){
                  var goods = json.result;
                  var third = json.result;
                  if(json.status == 1){
                    
                    $('.tab_box'+id).html(tpl('tpl_children_list',goods));
                    
                    $('.tab_third'+id).html(tpl('tpl_third_list',third)); 
                  }
                },true)
            }

            
        });   
    </script> 

<!-- foot --> 
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?> 