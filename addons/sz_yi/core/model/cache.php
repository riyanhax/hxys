<?php
// 唐上美联佳网络科技有限公司(技术支持)
class Sz_DYi_Cache
{
	public function get_key($key = '', $uniacid = '')
	{
		global $_W;

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		return SZ_YI_PREFIX . '_' . $GLOBALS['_W']['config']['setting']['authkey'] . '_' . $uniacid . '_' . $key;
	}

	public function getArray($key = '', $uniacid = '')
	{
		return $this->get($key, true, $uniacid);
	}

	public function getString($key = '', $uniacid = '')
	{
		return $this->get($key, false, $uniacid);
	}

	public function get($key = '', $isArray = true, $uniacid = '')
	{
		global $_W;

		if (empty($key)) {
			return false;
		}

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		$value = false;

		if ($_W['config']['setting']['cache'] == 'memcache') {
			if (extension_loaded('memcache')) {
				$value = $this->memcache_read($key, $uniacid);
			}
		}

		if (empty($value)) {
			return $this->file_read($key, $isArray, $uniacid);
		}

		return $value;
	}

	public function set($key = '', $value = NULL, $uniacid = '')
	{
		global $_W;

		if (empty($key)) {
			return false;
		}

		if (empty($uniacid)) {
			$uniacid = $_W['uniacid'];
		}

		$result = false;

		if ($_W['config']['setting']['cache'] == 'memcache') {
			if (extension_loaded('memcache')) {
				$result = $this->memcache_write($key, $value, $uniacid);
			}
		}

		if (empty($result)) {
			$this->file_set($key, $value, $uniacid);
		}
	}

	public function file_read($key = '', $isArray = true, $uniacid = '')
	{
		global $_W;

		if (empty($key)) {
			return false;
		}

		$content = @file_get_contents(IA_ROOT . '/addons/sz_yi/data/cache/' . $uniacid . '/' . $key);

		if (empty($content)) {
			return false;
		}

		return $isArray ? iunserializer($content) : $content;
	}

	public function file_set($key = '', $value = NULL, $uniacid = '')
	{
		global $_W;

		if (empty($key)) {
			return false;
		}

		$content = (is_array($value) ? iserializer($value) : $value);
		$path = IA_ROOT . '/addons/sz_yi/data/cache/' . $uniacid;

		if (!is_dir($path)) {
			load()->func('file');
			@mkdirs($path);
		}

		file_put_contents($path . '/' . $key, $content);
	}

	public function get_memcache()
	{
		global $_W;
		static $memcacheobj;

		if (!extension_loaded('memcache')) {
			return error(1, 'Class Memcache is not found');
		}

		if (empty($memcacheobj)) {
			$config = $_W['config']['setting']['memcache'];
			$memcacheobj = new Memcache();

			if ($config['pconnect']) {
				$connect = $memcacheobj->pconnect($config['server'], $config['port']);
			}
			else {
				$connect = $memcacheobj->connect($config['server'], $config['port']);
			}

			if (!$connect) {
				return error(-1, 'Memcache is not in work');
			}
		}

		return $memcacheobj;
	}

	public function memcache_read($key, $uniacid)
	{
		$memcache = $this->get_memcache();

		if (is_error($memcache)) {
			return false;
		}

		return $memcache->get($this->get_key($key, $uniacid));
	}

	public function memcache_write($key, $value, $uniacid = 0, $ttl = 0)
	{
		$memcache = $this->get_memcache();

		if (is_error($memcache)) {
			return false;
		}

		return $memcache->set($this->get_key($key, $uniacid), $value, MEMCACHE_COMPRESSED, $ttl);
	}

	public function memcache_delete($key, $uniacid = 0)
	{
		$memcache = $this->get_memcache();

		if (is_error($memcache)) {
			return false;
		}

		return $memcache->delete($this->get_key($key, $uniacid));
	}
}

if (!defined('IN_IA')) {
	exit('Access Denied');
}

?>
