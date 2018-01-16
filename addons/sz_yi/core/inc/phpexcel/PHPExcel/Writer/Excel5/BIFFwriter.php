<?php
// 唐上美联佳网络科技有限公司(技术支持)
class PHPExcel_Writer_Excel5_BIFFwriter
{
	static private $_byte_order;
	public $_data;
	public $_datasize;
	public $_limit = 8224;

	public function __construct()
	{
		$this->_data = '';
		$this->_datasize = 0;
	}

	static public function getByteOrder()
	{
		if (!isset($_byte_order)) {
			$teststr = pack('d', 1.2344999999999999);
			$number = pack('C8', 141, 151, 110, 18, 131, 192, 243, 63);

			if ($number == $teststr) {
				$byte_order = 0;
			}
			else if ($number == strrev($teststr)) {
				$byte_order = 1;
			}
			else {
				throw new PHPExcel_Writer_Exception('Required floating point format not supported on this platform.');
			}

			self::$_byte_order = $byte_order;
		}

		return self::$_byte_order;
	}

	public function _append($data)
	{
		if ($this->_limit < (strlen($data) - 4)) {
			$data = $this->_addContinue($data);
		}

		$this->_data .= $data;
		$this->_datasize += strlen($data);
	}

	public function writeData($data)
	{
		if ($this->_limit < (strlen($data) - 4)) {
			$data = $this->_addContinue($data);
		}

		$this->_datasize += strlen($data);
		return $data;
	}

	public function _storeBof($type)
	{
		$record = 2057;
		$length = 16;
		$unknown = pack('VV', 65745, 1030);
		$build = 3515;
		$year = 1996;
		$version = 1536;
		$header = pack('vv', $record, $length);
		$data = pack('vvvv', $version, $type, $build, $year);
		$this->_append($header . $data . $unknown);
	}

	public function _storeEof()
	{
		$record = 10;
		$length = 0;
		$header = pack('vv', $record, $length);
		$this->_append($header);
	}

	public function writeEof()
	{
		$record = 10;
		$length = 0;
		$header = pack('vv', $record, $length);
		return $this->writeData($header);
	}

	public function _addContinue($data)
	{
		$limit = $this->_limit;
		$record = 60;
		$tmp = substr($data, 0, 2) . pack('v', $limit) . substr($data, 4, $limit);
		$header = pack('vv', $record, $limit);
		$data_length = strlen($data);
		$i = $limit + 4;

		while ($i < ($data_length - $limit)) {
			$tmp .= $header;
			$tmp .= substr($data, $i, $limit);
			$i += $limit;
		}

		$header = pack('vv', $record, strlen($data) - $i);
		$tmp .= $header;
		$tmp .= substr($data, $i, strlen($data) - $i);
		return $tmp;
	}
}


?>
