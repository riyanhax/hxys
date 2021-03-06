<?php
// 唐上美联佳网络科技有限公司(技术支持)
if (!defined('IN_IA')) {
	exit('Access Denied');
}

global $_W;
global $_GPC;
$mc = $_GPC['memberdata'];
$op = (empty($_GPC['op']) ? 'sendcode' : trim($_GPC['op']));
session_start();

if ($op == 'sendcode') {
	$mobile = $_GPC['mobile'];

	if (empty($mobile)) {
		show_json(0, '请填入手机号');
	}

	$info = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where mobile=:mobile and pwd!="" and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':mobile' => $mobile));
	if (!empty($info)) {
		show_json(0, '该手机号已被注册！不能获取验证码。');
	}

	$code = rand(1000, 9999);
	$_SESSION['codetime'] = time();
	$_SESSION['code'] = $code;
	$_SESSION['code_mobile'] = $mobile;
	$issendsms = $this->sendSms($mobile, $code);
	$set = m('common')->getSysset();
	if ($set['sms']['type'] == 1) {
		if ($issendsms['SubmitResult']['code'] == 2) {
			//show_json(1);
			show_json(1,'发送成功');
			return 1;
		}

		show_json(0, $issendsms['SubmitResult']['msg']);
		return 1;
	}

	if ($issendsms['Code'] == 'OK') {
		show_json(1,'发送成功');
		return 1;
	}
	if($issendsms['Code'] == 5){
		show_json(0,'用户欠费停机，请联系管理员');
	}
	/*if($issendsms['code'] == 11){
		show_json(0,'用户权限不足，请联系管理员');
	}*/
	show_json(0, $issendsms['Message']);
	//show_json(0, $issendsms['msg'] . '/' . $issendsms['sub_msg']);
	//show_json(0,$issendsms['sub_msg']);
	return 1;
}

if ($op == 'forgetcode') {
	$mobile = $_GPC['mobile'];

	if (empty($mobile)) {
		show_json(0, '请填入手机号');
	}

	$info = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where mobile=:mobile and pwd!="" and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':mobile' => $mobile));

	if (empty($info)) {
		show_json(0, '该手机号未注册！不能找回密码。');
	}

	$code = rand(1000, 9999);
	$_SESSION['codetime'] = time();
	$_SESSION['code'] = $code;
	$_SESSION['code_mobile'] = $mobile;
	$issendsms = $this->sendSms($mobile, $code, 'forget');
	$set = m('common')->getSysset();

	if ($set['sms']['type'] == 1) {
		if ($issendsms['SubmitResult']['code'] == 2) {
			show_json(1);
			return 1;
		}

		show_json(0, $issendsms['SubmitResult']['msg']);
		return 1;
	}

	if (isset($issendsms['result']['success'])) {
		show_json(1);
		return 1;
	}

	show_json(0, $issendsms['msg']);
	return 1;
}

if ($op == 'bindmobilecode') {
	$mobile = $_GPC['mobile'];

	if (empty($mobile)) {
		show_json(0, '请填入手机号');
	}

	$isbindmobile = pdo_fetchcolumn('select count(*) from ' . tablename('sz_yi_member') . ' where  mobile =:mobile and uniacid=:uniacid and isbindmobile=1', array(':uniacid' => $_W['uniacid'], ':mobile' => $mobile));

	if (!empty($isbindmobile)) {
		show_json(0, '该手机已经绑定其它微信号了!');
	}

	$info = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where mobile=:mobile and pwd!="" and uniacid=:uniacid and isbindmobile=1 limit 1', array(':uniacid' => $_W['uniacid'], ':mobile' => $mobile));
	$code = rand(1000, 9999);
	$_SESSION['codetime'] = time();
	$_SESSION['code'] = $code;
	$_SESSION['code_mobile'] = $mobile;
	$issendsms = $this->sendSms($mobile, $code);
	$set = m('common')->getSysset();

	if ($set['sms']['type'] == 1) {
		if ($issendsms['SubmitResult']['code'] == 2) {
			show_json(1);
			return 1;
		}

		show_json(0, $issendsms['SubmitResult']['msg']);
		return 1;
	}

	if (isset($issendsms['result']['success'])) {
		show_json(1);
		return 1;
	}

	show_json(0, $issendsms['msg']);
	return 1;
}

if ($op == 'checkcode') {
	$code = $_GPC['code'];

	if (($_SESSION['codetime'] + (60 * 5)) < time()) {
		show_json(0, '验证码已过期,请重新获取');
	}

	if ($_SESSION['code'] != $code) {
		show_json(0, '验证码错误,请重新获取');
	}

	show_json(1);
	return 1;
}

if ($op == 'ismobile') {
	$mobile = $_GPC['mobile'];

	if (empty($mobile)) {
		show_json(0, '请填入手机号');
	}

	$info = pdo_fetch('select * from ' . tablename('sz_yi_member') . ' where mobile=:mobile and pwd!="" and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':mobile' => $mobile));

	if (!empty($info)) {
		show_json(0, '该手机号已被注册！');
		return 1;
	}

	show_json(1);
}

?>
