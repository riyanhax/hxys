<?php defined('IN_IA') or exit('Access Denied');?><div class="ulleft-nav">
<ul class="nav nav-tabs">
<div class="addtit-name"> 财务</div>
    <?php  if($_GPC['p'] == 'recharge' && $_GPC['op']=='credit1') { ?>
    <li class="active"><a href="<?php  echo $this->createWebUrl('finance/recharge',array('id'=>$id,'op'=>'credit1'))?>">充值积分</a></li>
    <?php  } ?>
    
    <?php  if($_GPC['p'] == 'recharge' && $_GPC['op']=='credit2') { ?>
    <li class="active"><a href="<?php  echo $this->createWebUrl('finance/recharge',array('id'=>$id,'op'=>'credit2'))?>">充值余额</a></li>
    <?php  } ?>
    <?php if(cv('finance.recharge.view')) { ?><li <?php  if(empty($_GPC['p']) || ( $_GPC['p'] == 'log' && $_GPC['type']==0)) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('finance/log',array('type'=>0))?>">充值记录</a></li><?php  } ?>
    <?php if(cv('finance.recharge.view')) { ?><?php  if(p('love')) { ?><li <?php  if(empty($_GPC['p']) || ( $_GPC['p'] == 'aging_log' && $_GPC['type']==0)) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('finance/aging_log',array('type'=>0))?>">分期管理</a></li><?php  } ?><?php  } ?>
    <?php if(cv('finance.withdraw.view')) { ?><li <?php  if($_GPC['p'] == 'log' && $_GPC['type']==1) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('finance/log',array('type'=>1))?>">提现申请</a></li><?php  } ?>
    <?php if(cv('finance.downloadbill')) { ?><li <?php  if($_GPC['p'] == 'downloadbill' ) { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('finance/downloadbill')?>">下载对账单</a></li><?php  } ?>
    <li <?php  if($_GPC['p'] == 'transfer') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('finance/transfer')?>">转让记录</a></li>
    <li <?php  if($_GPC['p'] == 'banklist' || $_GPC['p'] == 'adds') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('finance/banklist')?>">提现银行</a></li>
</ul> 
</div>
<!--  CREATE TABLE `ims_sz_yi_member_transfer_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uniacid` int(11) NOT NULL,
  `openid` varchar(255) NOT NULL,
  `tosell_id` int(11) DEFAULT NULL COMMENT '出让人id',
  `assigns_id` int(11) DEFAULT NULL COMMENT '受让人id',
  `createtime` int(11) NOT NULL,
  `status` tinyint(3) NOT NULL COMMENT '-1 失败 0 进行中 1 成功',
  `money` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ; -->
