<?php defined('IN_IA') or exit('Access Denied');?><style type="text/css">
    footer#footer-nav .menu-list li { width:20%}
</style>
<link href="../addons/sz_yi/static/font/iconfont.css" rel="stylesheet">
<?php  if($show_footer) { ?>
<?php  if($this->footer['diymenu']) { ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('designer/menu', TEMPLATE_INCLUDEPATH)) : (include template('designer/menu', TEMPLATE_INCLUDEPATH));?>
<?php  } else { ?>
<div style='height:80px;width:100%'></div>
<footer id="footer-nav">
    <ul class="menu-list">
        <li <?php  if($footer_current=='first') { ?>class='active'<?php  } ?>><a href="<?php  echo $this->createPluginMobileUrl('commission/myshop')?>"><i class="iconfont icon-heart"></i><span>小店</span></a></li>
        <li <?php  if($footer_current=='second') { ?>class='active'<?php  } ?>><a href="<?php  echo $this->createMobileUrl('shop/category')?>"><i class="iconfont icon-list"></i><span>分类</span></a></li>
        <li <?php  if($footer_current=='bonus') { ?>class='active'<?php  } ?>><a href="<?php  echo $this->createPluginMobileUrl('bonus')?>"><i class="iconfont icon-fh"></i><span><?php  echo $this->set['texts']['center']?></span></a></li>
        <li <?php  if($footer_current=='cart') { ?>class='active'<?php  } ?>><a href="<?php  echo $this->createMobileUrl('shop/cart')?>"><i class="iconfont icon-cart"></i><span>购物车</span></a></li>
        <li <?php  if($footer_current=='member') { ?>class='active'<?php  } ?>><a href="<?php  echo $this->createMobileUrl('member')?>"><i class="iconfont icon-user"></i><span>会员中心</span></a></li>
    </ul> 
</footer>
<?php  } ?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('common/footer_base', TEMPLATE_INCLUDEPATH)) : (include template('common/footer_base', TEMPLATE_INCLUDEPATH));?>