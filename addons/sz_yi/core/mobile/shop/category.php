<?php
// 唐上美联佳网络科技有限公司(技术支持)
if (!defined('IN_IA')) {
	exit('Access Denied');
}

global $_W;
global $_GPC;
$operation = (!empty($_GPC['op']) ? $_GPC['op'] : 'index');
$openid = m('user')->getOpenid();
$uniacid = $_W['uniacid'];
$shopset = set_medias(m('common')->getSysset('shop'), 'catadvimg');
$commission = p('commission');

if ($commission) {
	$shopid = intval($_GPC['shopid']);
	$shop = set_medias($commission->getShop($openid), array('img', 'logo'));
}

$this->setHeader();
include $this->template('shop/category');

?>
