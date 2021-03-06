<?php
// 唐上美联佳网络科技有限公司(技术支持)
class Sz_DYi_Qrcode
{
	public function createShopQrcode($mid = 0, $posterid = 0)
	{
		global $_W;
		global $_GPC;
		$path = IA_ROOT . '/addons/sz_yi/data/qrcode/' . $_W['uniacid'] . '/';

		if (!is_dir($path)) {
			load()->func('file');
			mkdirs($path);
		}

		$url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=sz_yi&do=shop&mid=' . $mid;

		if (!empty($posterid)) {
			$url .= '&posterid=' . $posterid;
		}

		$file = 'shop_qrcode_' . $posterid . '_' . $mid . '.png';
		$qrcode_file = $path . $file;

		if (!is_file($qrcode_file)) {
			require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
			QRcode::png($url, $qrcode_file, QR_ECLEVEL_L, 4);
		}

		return $_W['siteroot'] . 'addons/sz_yi/data/qrcode/' . $_W['uniacid'] . '/' . $file;
	}

	public function createGoodsQrcode($mid = 0, $goodsid = 0, $posterid = 0)
	{
		global $_W;
		global $_GPC;
		$path = IA_ROOT . '/addons/sz_yi/data/qrcode/' . $_W['uniacid'];

		if (!is_dir($path)) {
			load()->func('file');
			mkdirs($path);
		}

		$url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=sz_yi&do=shop&p=detail&id=' . $goodsid . '&mid=' . $mid;

		if (!empty($posterid)) {
			$url .= '&posterid=' . $posterid;
		}

		$file = 'goods_qrcode_' . $posterid . '_' . $mid . '_' . $goodsid . '.png';
		$qrcode_file = $path . '/' . $file;

		if (!is_file($qrcode_file)) {
			require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
			QRcode::png($url, $qrcode_file, QR_ECLEVEL_L, 4);
		}

		return $_W['siteroot'] . 'addons/sz_yi/data/qrcode/' . $_W['uniacid'] . '/' . $file;
	}

	public function createWechatQrcode($data)
	{
		global $_W;
		global $_GPC;
		$url = urldecode($data);
		$path = IA_ROOT . '/addons/sz_yi/data/qrcode/' . $_W['uniacid'];

		if (!is_dir($path)) {
			load()->func('file');
			mkdirs($path);
		}

		$file = 'wechat_qrcode_' . time() . '.png';
		$qrcode_file = $path . '/' . $file;

		if (!is_file($qrcode_file)) {
			require IA_ROOT . '/framework/library/qrcode/phpqrcode.php';
			QRcode::png($url, $qrcode_file, QR_ECLEVEL_L, 4);
		}

		return $_W['siteroot'] . 'addons/sz_yi/data/qrcode/' . $_W['uniacid'] . '/' . $file;
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
