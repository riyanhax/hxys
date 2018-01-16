<?php
// 唐上美联佳网络科技有限公司(技术支持)
class StorageTest extends PHPUnit_Framework_TestCase
{
	public function testSessionStorage()
	{
		$storage = new \LeanCloud\Storage\SessionStorage();
		$storage->set('null', NULL);
		$this->assertNull($storage->get('null'));
		$storage->set('bool', true);
		$this->assertTrue(true === $storage->get('bool'));
		$storage->set('int', 42);
		$this->assertEquals(42, $storage->get('int'));
		$storage->set('string', 'bar');
		$this->assertEquals('bar', $storage->get('string'));
		$date = new DateTime();
		$storage->set('date', $date);
		$this->assertEquals($date, $storage->get('date'));
		$arr = array('a', 'b');
		$storage->set('array', $arr);
		$this->assertEquals($arr, $storage->get('array'));
	}
}

?>
