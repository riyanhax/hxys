<?php
// 唐上美联佳网络科技有限公司(技术支持)
function classLoader($class)
{
	$path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
	$file = __DIR__ . '/' . $path . '.php';

	if (file_exists($file)) {
		require_once $file;
	}
}

spl_autoload_register('classLoader');
require_once __DIR__ . '/Qiniu/functions.php';

?>
