<?php
// 唐上美联佳网络科技有限公司(技术支持)
class PHPExcel_Autoloader
{
	static public function Register()
	{
		if (function_exists('__autoload')) {
			spl_autoload_register('__autoload');
		}

		return spl_autoload_register(array('PHPExcel_Autoloader', 'Load'));
	}

	static public function Load($pClassName)
	{
		if (class_exists($pClassName, false) || (strpos($pClassName, 'PHPExcel') !== 0)) {
			return false;
		}

		$pClassFilePath = PHPEXCEL_ROOT . str_replace('_', DIRECTORY_SEPARATOR, $pClassName) . '.php';
		if ((file_exists($pClassFilePath) === false) || (is_readable($pClassFilePath) === false)) {
			return false;
		}

		require $pClassFilePath;
	}
}

PHPExcel_Autoloader::Register();

if (ini_get('mbstring.func_overload') & 2) {
	throw new PHPExcel_Exception('Multibyte function overloading in PHP must be disabled for string functions (2).');
}

PHPExcel_Shared_String::buildCharacterSets();

?>
