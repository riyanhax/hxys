<?php
// 唐上美联佳网络科技有限公司(技术支持)
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class DesignerMobile extends Plugin
{
	public function __construct()
	{
		parent::__construct('designer');
	}

	public function index()
	{
		$this->_exec_plugin('index', false);
	}

	public function api()
	{
		$this->_exec_plugin('api', false);
	}

	public function date()
	{
		$this->_exec_plugin('date', false);
	}
}

?>
