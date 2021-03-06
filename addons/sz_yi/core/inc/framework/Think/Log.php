<?php
// 唐上美联佳网络科技有限公司(技术支持)
namespace Think;

class Log
{
	const EMERG = 'EMERG';
	const ALERT = 'ALERT';
	const CRIT = 'CRIT';
	const ERR = 'ERR';
	const WARN = 'WARN';
	const NOTICE = 'NOTIC';
	const INFO = 'INFO';
	const DEBUG = 'DEBUG';
	const SQL = 'SQL';

	static protected $log = array();
	static protected $storage;

	static public function init($config = array())
	{
		$type = (isset($config['type']) ? $config['type'] : 'File');
		$class = (strpos($type, '\\') ? $type : 'Think\\Log\\Driver\\' . ucwords(strtolower($type)));
		unset($config['type']);
		self::$storage = new $class($config);
	}

	static public function record($message, $level = self::ERR, $record = false)
	{
		if ($record || (false !== strpos(C('LOG_LEVEL'), $level))) {
			self::$log[] = $level . ': ' . $message . "\r\n";
		}
	}

	static public function save($type = '', $destination = '')
	{
		if (empty($log)) {
			return NULL;
		}

		if (empty($destination)) {
			$destination = C('LOG_PATH') . date('y_m_d') . '.log';
		}

		if (!self::$storage) {
			$type = $type ?: C('LOG_TYPE');
			$class = 'Think\\Log\\Driver\\' . ucwords($type);
			self::$storage = new $class();
		}

		$message = implode('', self::$log);
		self::$storage->write($message, $destination);
		self::$log = array();
	}

	static public function write($message, $level = self::ERR, $type = '', $destination = '')
	{
		if (!self::$storage) {
			$type = $type ?: C('LOG_TYPE');
			$class = 'Think\\Log\\Driver\\' . ucwords($type);
			$config['log_path'] = C('LOG_PATH');
			self::$storage = new $class($config);
		}

		if (empty($destination)) {
			$destination = C('LOG_PATH') . date('y_m_d') . '.log';
		}

		self::$storage->write($level . ': ' . $message, $destination);
	}
}


?>
