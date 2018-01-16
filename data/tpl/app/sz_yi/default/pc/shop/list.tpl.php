<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<title><?php  if(empty($current_category)) { ?>全部商品<?php  } else { ?><?php  echo $current_category['name'];?><?php  } ?></title>
<style type="text/css">

body { background:#fff;}
.crumb { margin-bottom:10px;}
.crumb span, .crumb a { display: inline-block; color:#666; vertical-align: middle; }
.crumb .c { white-space: nowrap; overflow: hidden; display: block;  display: inline-block; }
.crumb .divide { font-family: Simsun; margin: 0 5px; }
.list_main { width:1200px; margin:0 auto;}
.list_main .listl_rc { float:right; width:990px;}
.list_main .listl_lc { width:210px; padding-right:10px; float:left;}
.goods-side-warp  {width: 120px;padding-left:40px; border-left:#ededed 1px solid; margin-bottom:20px; }
.goods-side {  width: 120px; text-align: center; }
.goods-side-tit { position: relative; line-height: 30px; }
.goods-side-tit span { position: relative; display: inline-block; padding: 0 10px; background: #fff; color: #999; }
.goods-side-tit s { position: absolute; top: 15px; width: 100%; right: 0; height: 0; overflow: hidden; border-top: 1px dotted #999; }
.goods-side-bd { padding-bottom: 4px; }
.goods-side-slides-wrap { position: relative; height: 450px; overflow: hidden; }
.goods-side-bd ul { width: 100%; left: 0; }
.goods-side-bd li { position: relative; width: 120px; height: 140px; margin: 0 auto 10px; }
.goods-side-bd .slidepic { width: 120px; height: 120px; background: #fff; position: relative; }
.goods-side-bd .slidepic img { max-width: 100%; max-height: 100%; margin: auto; position: absolute; left: 0; right: 0; top: 0; bottom: 0; }
.goods-side-bd .slideprice { position: relative; width:120px; margin-top: -20px; height: 20px; text-align: center; overflow: hidden; white-space: nowrap; -ms-text-overflow: ellipsis; text-overflow: ellipsis; font-family: Arial; font-size: 12px; line-height: 20px; color: #000; background: #fff; opacity: 0.8; filter: alpha(opacity=80);  }
.goods-side-bd .slideprice span { padding-left: 4px; }
.goods-side-bd .slidename { height: 20px; text-align: center; overflow: hidden; white-space: nowrap; -ms-text-overflow: ellipsis; text-overflow: ellipsis; font-size: 12px; line-height: 24px; }
.goods-side-slides-nav { margin: auto; font-size: 0; }
.goods-side-slides-nav .prev, .goods-side-slides-nav .next { width: 50%; height: 25px; display: inline-block; *display: inline; *zoom: 1; background: url("../images/hdside-nav.gif") no-repeat 50% 0; cursor: pointer; }
.goods-side-slides-nav .next { background-position: 50% -25px; }
.detail_hd { height:32px; line-height:32px; padding:0 10px; background-color:#333; color:#fff; border:#ededed 1px solid;}
.hot_goods_list { border:#ededed 1px solid; margin-top:-1px; margin-bottom:10px; padding:8px;}
.hot_goods_list .item_pic img { width:100%; }
.hot_goods_list .item_price { line-height:26px;}
.hot_goods_list .item_price em { color:#ec0405; font-size:12px;}
.hot_goods_list .item_price .price { float:left;}
.hot_goods_list .item_price .sales { float:right;}
.hot_goods_list .item_title { max-height:32px; overflow:hidden; margin-bottom:10px; }
.category_warp { border:#ededed 1px solid; margin-top:-1px; margin-bottom:10px; }
.category_warp .level1 a { display:block; height:34px; line-height:34px; background-color:#f4f4f4; padding:0 12px; color:#333;}
.category_warp .level2 { padding:3px 8px 3px 12px;  }
.category_warp .level2 a { display:block; height:28px; line-height:28px; background-color:#fff; color:#666;}
.category_warp .level2 .divide { font-family: Simsun; margin: 0 5px; }
.cat-list { border: 1px solid #e7e7e7; margin-bottom: 10px; position: relative; }
.cat-list-hidemore { margin-bottom: 10px; }
.cat-list dl { line-height: 26px; padding: 5px 0; overflow: hidden; *zoom: 1; }
.cat-list .odd { background-color: #fafafa; }
.cat-list dt { float: left; padding-left: 18px; width:100px; font-weight: bold; margin-right: -65px; }
.cat-list dd { margin-left: 65px; }
.cat-list dd a { color: #7a7a7a; float: left; padding: 0 10px; line-height: 20px; margin: 3px 5px 3px 0; }
.cat-list dd a.selected { background-color: #ff7200; color: #fff; -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px; }
</style>
<!--导航调用-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/navigation', TEMPLATE_INCLUDEPATH)) : (include template('common/navigation', TEMPLATE_INCLUDEPATH));?>

<div class="list_main clearfix">
    <div class="listl_lc">
        
        <div class="left-list">
            
        </div>

        <script id='tpl_category_list' type='text/html'>
            
        
    <div class="detail_hd">
     商品分类
    </div>
    
    

    

<div class="category_warp"> 



<dl>
        <dd class="level1"><a class="category_item" href="<?php  echo $this->createMobileUrl('shop/list')?>" style="background-color:#fff;color:#333;">全部商品</a></dd>
    </dl>


    <%each category as value%> 
    <dl>
        <dd class="level1"><a href="<?php  echo $this->createMobileUrl('shop/list')?>&pcate=<%value.id%>"><%value.name%></a></dd>
    </dl>
         <div>
                
            <%each value.children as value1%>   
                  <dl >  
                    <dd class="level2"><a href="<?php  echo $this->createMobileUrl('shop/list')?>&ccate=<%value1.id%>&pcate=<%value.id%>"><span class="divide">&gt;</span><%value1.name%></a>
                    
                    </dd>
                   </dl>           
            <%/each%>    
                
        </div>
    <%/each%>
  

</div>  
        
    
    <div class="detail_hd">
     热销商品
    </div>
     <ul class="hot_goods_list">
        
        <!--循环-->
        <?php  if(is_array($ishot)) { foreach($ishot as $item) { ?>                         
        <li>
            <a href="<?php  echo $this->createMobileUrl('shop/detail',array('id' => $item['id']))?>">                                  
                <div class="item_pic">
                    <img src="<?php  echo $item['thumb'];?>">
                </div>
                <div class="item_price clearfix">
                    <span class="price"><?php  echo $item['marketprice'];?></span> <span class="sales">已售:<em><?php  echo $item['sales'];?></em></span>
                </div>
                <div class="item_title"><?php  echo $item['title'];?></div>
            </a>
        </li>
        <?php  } } ?>
        
                                    
       </ul>
            
        </script> 
    </div>


<div class="listl_rc">
            
            <div class="crumb">
    <span class="t">您的位置：</span>
    <a class="c" href="<?php  echo $this->createMobileUrl('shop')?>">首页</a>
    <?php  if($pcatename) { ?>
        <span class="divide">&gt;</span>
        <a class="c" href="<?php  echo $this->createMobileUrl('shop/list',array('pcate'=>$pcatename['id']))?>"><?php  echo $pcatename['name'];?></a>
    <?php  } else if($pcate1name) { ?>
        <span class="divide">&gt;</span>
        <a class="c" href="<?php  echo $this->createMobileUrl('shop/list',array('pcate1'=>$pcate1name['id']))?>"><?php  echo $pcate1name['name'];?></a>
    <?php  } else { ?>
        <span class="divide">&gt;</span>
        <a class="c" href="<?php  echo $this->createMobileUrl('shop/list')?>">全部商品</a>
    <?php  } ?>
    <?php  if($ccatename) { ?>
        <span class="divide">&gt;</span>
        <a class="c" href="<?php  echo $this->createMobileUrl('shop/list',array('ccate'=>$ccatename['id']))?>"><?php  echo $ccatename['name'];?></a>
    <?php  } else if($ccate1name) { ?>
        <span class="divide">&gt;</span>
        <a class="c" href="<?php  echo $this->createMobileUrl('shop/list',array('ccate1'=>$ccate1name['id']))?>"><?php  echo $ccate1name['name'];?></a>
    <?php  } ?>
    <?php  if($tcatename) { ?>
        <span class="divide">&gt;</span>
        <a class="c" href="<?php  echo $this->createMobileUrl('shop/list',array('tcate'=>$tcatename['id']))?>"><?php  echo $tcatename['name'];?></a>
    <?php  } else if($tcate1name) { ?>
        <span class="divide">&gt;</span>
        <a class="c" href="<?php  echo $this->createMobileUrl('shop/list',array('tcate1'=>$tcate1name['id']))?>"><?php  echo $tcate1name['name'];?></a>
    <?php  } ?>
<span class="divide">&gt;</span>
<span style="color:#666;font-size:12px;"><?php  echo $goods['title'];?></span>
</div>
         <div class="cat-list cat-list-hidemore">
            
            <div class="level-list">
            </div>
            <script id='tpl_level_list' type='text/html'>
                
                <?php  if(intval($shopset['catlevel'])==3 && $third_category) { ?>
                <dl class="even">
                    <dt>三级分类：</dt>
                    <dd id="sec_category" style="margin-left: 90px;">
                        <?php  if(is_array($third_category)) { foreach($third_category as $value) { ?>
                         <a  class="category_sub category_child" href="<?php  echo $this->createMobileUrl('shop/list',array('pcate'=>$_GPC['pcate'],'ccate'=>$_GPC['ccate'],'tcate' => $value['id']))?>" ><?php  echo $value['name'];?></a>                        
                        <?php  } } ?>
                      </div>      
                    </dd>
                </dl>
                <?php  } ?>
                 </script>
                 
    <dl class="odd">
        <dt>价格：</dt>
        <dd>
            <a href="javascript:;" >全部</a>

                <a href="<?php  echo $this->createMobileUrl('shop/list',array('pcate'=>$_GPC['pcate'],'ccate'=>$_GPC['ccate'],'tcate'=>$_GPC['tcate'],'minprice' => '0','maxprice' => '100'))?>" >
                        0 - 100元
                </a>

                <a href="<?php  echo $this->createMobileUrl('shop/list',array('pcate'=>$_GPC['pcate'],'ccate'=>$_GPC['ccate'],'tcate'=>$_GPC['tcate'],'minprice' => '100','maxprice' => '200'))?>" >
                        100 - 200元
                </a>

                <a href="<?php  echo $this->createMobileUrl('shop/list',array('pcate'=>$_GPC['pcate'],'ccate'=>$_GPC['ccate'],'tcate'=>$_GPC['tcate'],'minprice' => '200','maxprice' => '500'))?>" >
                        200 - 500元
                </a>

                <a href="<?php  echo $this->createMobileUrl('shop/list',array('pcate'=>$_GPC['pcate'],'ccate'=>$_GPC['ccate'],'tcate'=>$_GPC['tcate'],'minprice' => '500'))?>" >
                        500元以上
                </a>
        </dd>
    </dl>
    
    <div class="brand-list">
            </div>
    <script id='tpl_brand_list' type='text/html'>
    <?php  if($shopset['category2'] == 1) { ?>
    <dl class="odd">
        <dt>品牌：</dt>
        <dd>
             <?php  if(is_array($category2)) { foreach($category2 as $value) { ?>
                <a href="<?php  echo $this->createMobileUrl('shop/list',array('pcate1' => $value['id']))?>">
                    <?php  echo $value['name'];?>
                </a>
             <?php  } } ?>
        </dd>
    </dl>
    <?php  } ?>
    </script>
</div>


            
            
            <div class="list_filter filter">
            </div>
            <div class="detail-info">
            </div>
            
        </div>
        
        <script id='tpl_filter' type='text/html'> 
            
            <div class="rankitem">
                    <!--<span class="fl label ml20">默认排序</span> -->
                    <span style="float:left;padding:9px 0px 0px 15px;;">排序：</span>                  
                    <span class="orderCell" data-order='sales' data-by='desc'>
                        <a class="item itemDefault" href="javascript:void(0)"><span>销量从高到低</span></a>
                    </span>
                    <span class="orderCell" data-order='marketprice' data-by='asc'>
                        <a class="item itemDefault" href="javascript:void(0)"><span>价格从低到高</span></a>
                    </span>
                    <span class="orderCell" data-order='marketprice' data-by='desc'>
                        <a class="item itemDefault" href="javascript:void(0)"><span>价格从高到低</span></a>
                    </span>
                    <span class="orderCell" data-order='score' data-by='asc'>
                        <a class="item itemDefault" href="javascript:void(0)"><span>评价从高到低</span></a>
                    </span>
                </div>
            </script>
            <script id='tpl_goods_list' type='text/html'>
            <div class="allsortgood">
                <form action="" method="get" id="goodsform">
                    <input type="hidden" name="i" value="<?php  echo $_W['uniacid'];?>">
                    <input type="hidden" name="c" value="<?php  echo $_GPC['c'];?>">
                    <input type="hidden" name="do" value="<?php  echo $_GPC['do'];?>">
                    <input type="hidden" name="m" value="<?php  echo $_GPC['m'];?>">
                    <input type="hidden" name="p" value="<?php  echo $_GPC['p'];?>">


                    <input type="hidden" id="isnew" name="isnew" value="<?php  echo $_GPC['isnew'];?>">
                    <input type="hidden" id="ishot" name="ishot" value="<?php  echo $_GPC['ishot'];?>">
                    <input type="hidden" id="isrecommand" name="isrecommand" value="<?php  echo $_GPC['isrecommand'];?>">
                    <input type="hidden" id="isdiscount" name="isdiscount" value="<?php  echo $_GPC['isdiscount'];?>">
                    <input type="hidden" id="istime" name="istime" value="<?php  echo $_GPC['istime'];?>">
                    <input type="hidden" id="pcate" name="pcate" value="<?php  echo $_GPC['pcate'];?>">
                    <input type="hidden" id="ccate" name="ccate" value="<?php  echo $_GPC['ccate'];?>">
                    <input type="hidden" id="tcate" name="tcate" value="<?php  echo $_GPC['tcate'];?>">
                    <input type="hidden" id="order" name="order" value="<?php  echo $_GPC['order'];?>">
                    <input type="hidden" id="by" name="by" value="<?php  echo $_GPC['by'];?>">
                </form>
                <ul>
                    <?php  if(is_array($goods)) { foreach($goods as $g) { ?>
                    <li>
                        <div class="bor-sort">
                            <a class="img-pos" href="<?php  echo $this->createMobileUrl('shop/detail', array('my' => $_GPC['my'], 'id' => $g['id']))?>">
                            <img src="<?php  echo $g['thumb'];?>"></a>
                            <a class="sort-tit" href="#"><?php  echo $g['title'];?></a>
                            <p><em>￥<?php  echo $g['marketprice'];?></em><i>总销量<b><?php  echo $g['sales'];?></b></i>
                             <?php  if($g['productprice']>0 && $g['marketprice']!=$g['productprice']) { ?><span>￥<?php  echo $g['productprice'];?></span><?php  } ?>
                            <?php  if($discount&&$discount>0) { ?><span class="label-waring"><?php  echo $discount;?>折</span><?php  } ?>
                            </p>
                        </div>
                    </li>
                    <?php  } } ?>
                    
                </ul>
            </div>
            <div class="catepro_pageNav pageNav tc">
                <?php  echo $pager;?>
                <!--<a class="pre preDisable" href="#"><span>上一页</span></a>
                <a class="curr" href="#"><span>1</span></a>
                <a href="#"><span>2</span></a>
                <em>...</em> 
                <a href="#"><span>8</span></a>
                <a class="next " href="#"><span>下一页</span></a> </div>-->
            </script>

</div>

</div>
<script id='tpl_empty' type='text/html'>
    <div class="list_no">
        <i class="fa fa-shopping-cart" style="font-size:100px;"></i>
        <br>
        <span style="line-height:18px; font-size:16px;">暂时没有相关商品</span>
        <br>主人快去给我找点其他东西吧
    </div>
    <div class="list_no_menu">
        <div class="list_no_nav" onclick="location.href='<?php  echo $this->createMobileUrl('shop/list')?>'">看看其他的</div>
    </div>
</script>

<script language='javascript'>
    var loaded = false;
    var stop = true;
    var category = null;
    var def_args = args  = {
           page:"<?php  echo $_GPC['page'];?>",
           isnew: "<?php  echo $_GPC['isnew'];?>",
           ishot: "<?php  echo $_GPC['ishot'];?>",
           isrecommand:"<?php  echo $_GPC['isrecommand'];?>",
           isdiscount:"<?php  echo $_GPC['isdiscount'];?>",
           keywords:"<?php  echo $_GPC['keywords'];?>",
           istime:"<?php  echo $_GPC['istime'];?>",
           pcate:"<?php  echo $_GPC['pcate'];?>",
           ccate:"<?php  echo $_GPC['ccate'];?>",
           tcate:"<?php  echo $_GPC['tcate'];?>",
           pcate1:"<?php  echo $_GPC['pcate1'];?>",
           ccate1:"<?php  echo $_GPC['ccate1'];?>",
           tcate1:"<?php  echo $_GPC['tcate1'];?>",
           order:"<?php  echo $_GPC['order'];?>",
           by:"<?php  echo $_GPC['by'];?>",
           shopid:"<?php  echo $_GPC['shopid'];?>",
           key:$("#keyword").val()
    };

    require(['tpl', 'core'], function (tpl, core) {
      function getGoods() {
          $(".orderCell[data-order='<?php  echo $_GPC['order'];?>'][data-by='<?php  echo $_GPC['by'];?>']").addClass('orderActive');
          $('.detail-info').append(tpl('tpl_goods_list'));
          bindEvents();
      }


       
        function getGoodsMore() {
     
            core.json('shop/list', args, function (json) {
                var result = json.result;
                $('.detail-info').append(tpl('tpl_goods_list',result));
                bindEvents();
                $('#list_loading').remove();
                if (result.goods.length < result.pagesize) {
                        $('#goods_container').append('<div id="list_loading">已经加载全部商品</div>');
                        loaded = true;
                        $(window).scroll = null;
                        return;
                }
                stop=true;
                bindMore(); 
                
            });
        }

        /*function bindEvents() {
            $('.good img').each(function(){
               $(this).height($(this).width()); 
            });
            $('.good').unbind('click').click(function () {
                        location.href = core.getUrl('shop/detail', {id: $(this).data('goodsid'),my:'<?php  echo $_GPC['my'];?>'});
            });
        }*/
        
        /*function bindMore() {
     
            $(window).scroll(function () {
  
                if (loaded) {
                    return;
                }
                totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());
                if ($(document).height() <= totalheight) {
                
                    if (stop == true) {
                        stop = false;
                        $('#goods_container').append('<div id="list_loading"><i class="fa fa-spinner fa-spin"></i> 正在加载更多商品</div>');
                  
                        if(args.page=='' || args.page=='undefined'){
                            args.page = 1;
                        }
                        args.page++;
                        getGoodsMore();
                    }
                }
            });
        }*/
 
        function reset() {
            $('#form')[0].reset();
        }
        function bindCategoryEvents(){
            
             $(".category .close").unbind('click').click(function(){
                        $(".category").animate({left:"-60%"},200);
             });
             $(".category_item").unbind('click').click(function(){
                 var item = $(this);
                     $('#keywords').val(""); $('#search_container').html('');
                     $(".category").animate({left:"-60%"},200);
                      
                      $("#isnew").val(item.data('isnew'));
                      $("#ishot").val(item.data('ishot'));
                      $("#isrecommand").val(item.data('isrecommand'));
                      $("#isdiscount").val(item.data('isdiscount'));
                      $("#istime").val(item.data('istime'));
                      $("#ccate").val(item.data('ccate'));
                      $("#tcate").val(item.data('tcate'));
                      $("#pcate").val(item.data('pcate'));
                      $("#order").val('');
                      $("#by").val('');
                      $("#goodsform").submit();
                      /*args  = {
                            page:1,
                            isnew: item.data('isnew'),
                            ishot:item.data('ishot'),
                            isrecommand:item.data('isrecommand'),
                            isdiscount:item.data('isdiscount'),
                            keywords:"",
                            istime: item.data('istime:'),
                            pcate: item.data('pcate'),
                            ccate: item.data('ccate'),
                            tcate: item.data('tcate'),
                            order:"",
                            by:"",
                            shopid:"<?php  echo $_GPC['shopid'];?>"
                     };
                     $('.topbar .name').html( item.data('name'));
                     document.title = item.data('name');
                     getGoods();*/
             });
             
        }
        
        $('.list_filter').html(tpl('tpl_filter'));
        $('.sort').click(function () {
                var display = $(".sort_list").css('display');
                if (display == 'none') {
                    $(".sort_list").fadeIn(200);
                } else {
                    $(".sort_list").fadeOut(100);
                }

        });

        

        $('.orderCell').click(function () {

              
                
                if ($(this).data('order') ==args.order && $(this).data('by') == args.by) {
                    return;
                }
             $('.orderCell').removeClass('orderActive');
                
              $(this).addClass('orderActive');
              $("#order").val($(this).data('order'));
              $("#by").val($(this).data('by'));
              $("#goodsform").submit();

                   /*args  = {
                            page:1,
                            isnew: args.isnew,
                            ishot: args.ishot,
                            isrecommand:args.isrecommand,
                            isdiscount:args.isdiscount,
                            keywords:args.keywords,
                            istime: args.istime,
                            pcate:args.pcate,
                            ccate: args.ccate,
                            tcate: args.tcate,
                            order:$(this).data('order'),
                            by:$(this).data('by'),
                            shopid:args.shopid
                     };
               
                $(".sort_list").fadeOut(200);
                getGoods();*/
        });
         $(".sort_list").fadeOut(100);
         if(category!=null){
              $(".category").animate({left:"0px"},200);
              bindCategoryEvents();
              return;
         }
         
         core.json('shop/util',{op:'category'}, function (json) {
             category = json.result;
             $('.left-list').html(tpl('tpl_category_list',category));
             $(".category").animate({left:"0px"},200);
             bindCategoryEvents();
          }, true);       
          
          $('.level-list').html(tpl('tpl_level_list'));
          $('.brand-list').html(tpl('tpl_brand_list'));
        
     getGoods();
        

    });
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer', TEMPLATE_INCLUDEPATH)) : (include template('common/footer', TEMPLATE_INCLUDEPATH));?>