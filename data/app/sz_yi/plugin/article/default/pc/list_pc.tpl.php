<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/header', TEMPLATE_INCLUDEPATH)) : (include template('common/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/navigation', TEMPLATE_INCLUDEPATH)) : (include template('common/navigation', TEMPLATE_INCLUDEPATH));?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php  if(empty($article_sys['article_title'])) { ?>全部文章<?php  } else { ?><?php  echo $article_sys['article_title'];?><?php  } ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" id="viewport" name="viewport">
<meta name="format-detection" content="telephone=no" />
<link href="../addons/sz_yi/plugin/article/template/imgsrc/pc.css" rel="stylesheet">
<script type="text/javascript" src="../addons/sz_yi/static/js/dist/jquery-1.11.1.min.js"></script>
<script>
    $(function(){
        var page = 2;
        var temp ="<?php  echo $article_sys['article_temp'];?>";
        var lock = 0;
        $("#add-more").click(function(){
            if(lock==0){
                if(temp==2){
                    cate = $(".add-more").attr("cid");
                }
                $(this).text("加载中...");
                lock = 1;
                $.post("<?php  echo $this->createPluginMobileUrl('article',array('method'=>'api','apido'=>'addmore'))?>", {page:page<?php  if($article_sys['article_temp']==2) { ?>,cate:cate<?php  } ?>} ,function(result){
                    if(result){
                        page++;
                        if(temp==0 || temp==2){
                            $(".list").append(result);
                        }
                        else if (temp==1){
                            $(".append").append(result);
                        }
                        $("#add-more").text('加载更多');
                    }else{
                        $("#add-more").text('没有更多了...');
                    }
                    lock = 0;
                });
            }
        });

<?php  if($article_sys['article_temp']==2) { ?>
        var _height = $(window).height();
        var _height = parseInt(_height)-100;
        add(0,_height);
        $("nav").click(function(){
            var thiscid = $(this).attr("cid");
            if(temp==2){
                $(".add-more").attr("cid",thiscid);
                page = 2;
                $("#add-more").text('加载更多');
            }
            add(thiscid,_height);
        });
 <?php  } ?>

    });
<?php  if($article_sys['article_temp']==2) { ?>
    function add(thiscid,_height){
            $(".add-more").attr("cid",thiscid)
            $("nav[cid="+thiscid+"]").addClass("on").siblings().removeClass("on");
            $(".list").html("<p style='line-height:"+_height+"px; text-align:center;'>正在载入...</p>");
            $(".add-more").hide();
            $.post("<?php  echo $this->createPluginMobileUrl('article',array('method'=>'api','apido'=>'selectarticle'))?>", {cid:thiscid} ,function(result){
                if(result){
                    $(".list").html(result);
                    $(".add-more").show();
                }else{
                     $(".list").html("<p style='line-height:"+_height+"px; text-align:center;'>该分类还没有添加文章...</p>");
                }
            });
    }
 <?php  } ?>
</script>

</head>

<body class="<?php  if($article_sys['article_temp']==0) { ?>t1<?php  } else if($article_sys['article_temp']==1) { ?>t2<?php  } else if($article_sys['article_temp']==2) { ?>t3<?php  } ?>">

    <div class="help-tabs">

        <ul class="tab-list">
                <?php  if(is_array($helper_category)) { foreach($helper_category as $row) { ?>
                <li class="list-item" data-id="<?php  echo $row['id'];?>" style="overflow: hidden">
                    <?php  echo $row['category_name'];?>
                </li>
                <?php  } } ?>
        </ul>
        <div class="tabcons"></div>
        <script type="text/html" id="tpl_helper">
            <ul>
                <%each helpers as value%>
                <li><a class="bg-icon" href="<?php  echo $this->createPluginMobileUrl('article', array('is_helper' => 1))?>&aid=<%value.id%>"><%value.article_title%></a></li>
                <%/each%>
            </ul>
        </script>
    </div>



<div class="all-divbox">


</div>


<script type="text/javascript">

    require(['tpl', 'core'], function (tpl, core) {


        var id = $('.list-item:first').data('id');
        $('.list-item:first').addClass('current').siblings().removeClass('current');
        setgood(id);




        $('.list-item').mouseover(function(){
            $(this).addClass('current').siblings().removeClass('current');
            var id = $(this).data('id');
            setgood(id);
        });


        function setgood (id){
            core.pjson('article/article_pc' , {id:id} , function(json){
                var helpers = json.result;
                if(json.status == 1){

                    $('.tabcons').html(tpl('tpl_helper',helpers));


                } else {
                    $('.tabcons').html('抱歉，此分类暂时没有文章！');
                }
            },true)
        }


    });
</script>

</body>
</html>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/bottom', TEMPLATE_INCLUDEPATH)) : (include template('common/bottom', TEMPLATE_INCLUDEPATH));?>
