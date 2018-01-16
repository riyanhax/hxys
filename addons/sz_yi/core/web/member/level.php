<?php
// 唐上美联佳网络科技有限公司(技术支持)
if (!defined('IN_IA')) {
	exit('Access Denied');
}

global $_W;
global $_GPC;
$operation = (!empty($_GPC['op']) ? $_GPC['op'] : 'display');
$shopset = m('common')->getSysset('shop');

if ($operation == 'display') {
	ca('member.level.view');
	$list = pdo_fetchall('SELECT * FROM ' . tablename('sz_yi_member_level') . ' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY level asc');
}
else if ($operation == 'post') {
	$id = intval($_GPC['id']);

	if (empty($id)) {
		ca('member.level.add');
	}
	else {
		ca('member.level.edit|member.level.view');
	}

	$level = pdo_fetch('SELECT * FROM ' . tablename('sz_yi_member_level') . ' WHERE id = \'' . $id . '\'');

	if ($level['goodsid']) {
		$goods = pdo_fetch('SELECT id, title FROM ' . tablename('sz_yi_goods') . ' WHERE id = \'' . $level['goodsid'] . '\'');
	}

	if (checksubmit('submit')) {
		if (empty($_GPC['levelname'])) {
			message('抱歉，请输入分类名称！');
		}

		$data = array('uniacid' => $_W['uniacid'], 'level' => intval($_GPC['level']), 'levelname' => trim($_GPC['levelname']), 'ordercount' => intval($_GPC['ordercount']), 'ordermoney' => $_GPC['ordermoney'], 'discount' => $_GPC['discount'], 'goodsid' => $_GPC['goods_id']);

		if (!empty($id)) {
			pdo_update('sz_yi_member_level', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
			plog('member.level.edit', '修改会员等级 ID: ' . $id);
		}
		else {
			pdo_insert('sz_yi_member_level', $data);
			$id = pdo_insertid();
			plog('member.level.add', '添加会员等级 ID: ' . $id);
		}

		message('更新等级成功！', $this->createWebUrl('member/level', array('op' => 'display')), 'success');
	}
}
else {
	if ($operation == 'delete') {
		ca('member.level.delete');
		$id = intval($_GPC['id']);
		$level = pdo_fetch('SELECT id,levelname FROM ' . tablename('sz_yi_member_level') . ' WHERE id = \'' . $id . '\'');

		if (empty($level)) {
			message('抱歉，等级不存在或是已经被删除！', $this->createWebUrl('member/level', array('op' => 'display')), 'error');
		}

		pdo_delete('sz_yi_member_level', array('id' => $id, 'uniacid' => $_W['uniacid']));
		plog('member.level.delete', '删除会员等级 ID: ' . $id . ' 等级名称: ' . $level['levelname']);
		message('等级删除成功！', $this->createWebUrl('member/level', array('op' => 'display')), 'success');
	}
}

load()->func('tpl');
include $this->template('web/member/level');

?>
