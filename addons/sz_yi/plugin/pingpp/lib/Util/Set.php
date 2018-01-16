<?php
// 唐上美联佳网络科技有限公司(技术支持)
namespace Pingpp\Util;

class Set implements \IteratorAggregate
{
	private $_elts;

	public function __construct($members = array())
	{
		$this->_elts = array();

		foreach ($members as $item) {
			$this->_elts[$item] = true;
		}
	}

	public function includes($elt)
	{
		return isset($this->_elts[$elt]);
	}

	public function add($elt)
	{
		$this->_elts[$elt] = true;
	}

	public function discard($elt)
	{
		unset($this->_elts[$elt]);
	}

	public function toArray()
	{
		return array_keys($this->_elts);
	}

	public function getIterator()
	{
		return new \ArrayIterator($this->toArray());
	}
}

?>
