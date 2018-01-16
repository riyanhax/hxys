<?php
// 唐上美联佳网络科技有限公司(技术支持)
class LeanQueryTest extends PHPUnit_Framework_TestCase
{
	static public function setUpBeforeClass()
	{
		\LeanCloud\LeanClient::initialize(getenv('LC_APP_ID'), getenv('LC_APP_KEY'), getenv('LC_APP_MASTER_KEY'));
		\LeanCloud\LeanClient::useRegion(getenv('LC_API_REGION'));
	}

	public function testInitializeWithString()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$this->assertEquals('TestObject', $query->getClassName());
	}

	public function testEmptyQuery()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$out = $query->encode();
		$this->assertEmpty($out);
	}

	public function testCount()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$cnt = $query->count();
		$this->assertGreaterThanOrEqual(0, $cnt);
		$obj = new \LeanCloud\LeanObject('TestObject');
		$id = microtime();
		$obj->set('testid', $id);
		$obj->save();
		$query->equalTo('testid', $id);
		$cnt = $query->count();
		$this->assertEquals(1, $cnt);
		$obj->destroy();
	}

	public function testGetById()
	{
		$obj = new \LeanCloud\LeanObject('TestObject');
		$id = microtime();
		$obj->set('testid', $id);
		$obj->save();
		$query = new \LeanCloud\LeanQuery('TestObject');
		$obj2 = $query->get($obj->getObjectId());
		$this->assertEquals($obj->get('testid'), $obj2->get('testid'));
		$obj->destroy();
	}

	public function testFind()
	{
		$obj = new \LeanCloud\LeanObject('TestObject');
		$id = microtime();
		$obj->set('testid', $id);
		$obj->save();
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->equalTo('testid', $id);
		$objects = $query->find();
		$this->assertEquals(1, count($objects));
		$this->assertEquals($id, $objects[0]->get('testid'));
		$obj->destroy();
	}

	public function testAddExtraOption()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->equalTo('testid', microtime());
		$query->addOption('redirectClassNameForKey', 'relationKey');
		$out = $query->encode();
		$this->assertEquals('relationKey', $out['redirectClassNameForKey']);
	}

	public function testAddExtraOptionCannotOverwitePreservedOption()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->skip(100);
		$query->addOption('skip', 50);
		$out = $query->encode();
		$this->assertEquals(100, $out['skip']);
	}

	public function testEqualTo()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->equalTo('age', 24);
		$out = $query->encode();
		$this->assertEquals(json_encode(array('age' => 24)), $out['where']);
		$query->equalTo('age', 37);
		$out = $query->encode();
		$this->assertEquals(json_encode(array('age' => 37)), $out['where']);
	}

	public function testNotEqualTo()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->notEqualTo('age', 24);
		$out = $query->encode();
		$expect = json_encode(array(
	'age' => array('$ne' => 24)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testRepeatNotEqualTo()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->notEqualTo('age', 24);
		$query->notEqualTo('age', 20);
		$query->notEqualTo('age', 22);
		$out = $query->encode();
		$expect = json_encode(array(
	'age' => array('$ne' => 22)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testLessThan()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->lessThan('age', 24);
		$out = $query->encode();
		$expect = json_encode(array(
	'age' => array('$lt' => 24)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testLessThanOrEqualTo()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->lessThanOrEqualTo('age', 24);
		$out = $query->encode();
		$expect = json_encode(array(
	'age' => array('$lte' => 24)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testGreaterThan()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->greaterThan('age', 24);
		$out = $query->encode();
		$expect = json_encode(array(
	'age' => array('$gt' => 24)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testGreaterThanOrEqualTo()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->greaterThanOrEqualTo('age', 24);
		$out = $query->encode();
		$expect = json_encode(array(
	'age' => array('$gte' => 24)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testContainedIn()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->containedIn('category', array('foo', 'bar'));
		$out = $query->encode();
		$expect = json_encode(array(
	'category' => array(
		'$in' => array('foo', 'bar')
		)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testNotContainedIn()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->notContainedIn('category', array('foo', 'bar'));
		$out = $query->encode();
		$expect = json_encode(array(
	'category' => array(
		'$nin' => array('foo', 'bar')
		)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testContainsAll()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->containsAll('tags', array('foo', 'bar'));
		$out = $query->encode();
		$expect = json_encode(array(
	'tags' => array(
		'$all' => array('foo', 'bar')
		)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testSizeEqualTo()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->sizeEqualTo('tags', 2);
		$out = $query->encode();
		$expect = json_encode(array(
	'tags' => array('$size' => 2)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testFieldExists()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->exists('tags');
		$out = $query->encode();
		$expect = json_encode(array(
	'tags' => array('$exists' => true)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testFieldNotExists()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->notExists('tags');
		$out = $query->encode();
		$expect = json_encode(array(
	'tags' => array('$exists' => false)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testFieldContains()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->contains('title', 'clojure');
		$out = $query->encode();
		$expect = json_encode(array(
	'title' => array('$regex' => 'clojure')
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testStartsWith()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->startsWith('title', 'clojure');
		$out = $query->encode();
		$expect = json_encode(array(
	'title' => array('$regex' => '^clojure')
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testEndsWith()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->endsWith('title', 'clojure');
		$out = $query->encode();
		$expect = json_encode(array(
	'title' => array('$regex' => 'clojure$')
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testRegexMatches()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->matches('title', '(cl.?jre)[0-9]', 'im');
		$out = $query->encode();
		$expect = json_encode(array(
	'title' => array('$regex' => '(cl.?jre)[0-9]', '$options' => 'im')
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testMatchesInQuery()
	{
		$q1 = new \LeanCloud\LeanQuery('Post');
		$q1->exists('image');
		$out1 = $q1->encode();
		$where1 = array(
			'image' => array('$exists' => true)
			);
		$this->assertEquals(json_encode($where1), $out1['where']);
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->matchesInQuery('post', $q1);
		$out = $query->encode();
		$where = array(
			'post' => array(
				'$inQuery' => array('where' => $where1, 'className' => 'Post')
				)
			);
		$this->assertEquals(json_encode($where), $out['where']);
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->notMatchInQuery('post', $q1);
		$out = $query->encode();
		$where = array(
			'post' => array(
				'$notInQuery' => array('where' => $where1, 'className' => 'Post')
				)
			);
		$this->assertEquals(json_encode($where), $out['where']);
	}

	public function testMatchesFieldInQuery()
	{
		$q1 = new \LeanCloud\LeanQuery('Post');
		$q1->contains('title', 'clojure');
		$out1 = $q1->encode();
		$where1 = array(
			'title' => array('$regex' => 'clojure')
			);
		$this->assertEquals(json_encode($where1), $out1['where']);
		$query = new \LeanCloud\LeanQuery('Comment');
		$query->matchesFieldInQuery('author', 'author', $q1);
		$out = $query->encode();
		$where = array(
			'author' => array(
				'$select' => array(
					'key'   => 'author',
					'query' => array('where' => $where1, 'className' => 'Post')
					)
				)
			);
		$this->assertEquals(json_encode($where), $out['where']);
		$query = new \LeanCloud\LeanQuery('Comment');
		$query->notMatchFieldInQuery('author', 'author', $q1);
		$out = $query->encode();
		$where = array(
			'author' => array(
				'$dontSelect' => array(
					'key'   => 'author',
					'query' => array('where' => $where1, 'className' => 'Post')
					)
				)
			);
		$this->assertEquals(json_encode($where), $out['where']);
	}

	public function testRelatedTo()
	{
		$obj = new \LeanCloud\LeanObject('TestObject', 'id123');
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->relatedTo('relField', $obj);
		$out = $query->encode();
		$expect = json_encode(array(
	'$relatedTo' => array('key' => 'relField', 'object' => $obj->getPointer())
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testNearGeoPoint()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->near('location', new \LeanCloud\GeoPoint(39.899999999999999, 116.40000000000001));
		$out = $query->encode();
		$expect = json_encode(array(
	'location' => array(
		'$nearSphere' => array('__type' => 'GeoPoint', 'latitude' => 39.899999999999999, 'longitude' => 116.40000000000001)
		)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testWithinRadians()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->withinRadians('location', new \LeanCloud\GeoPoint(39.899999999999999, 116.40000000000001), 0.5);
		$out = $query->encode();
		$expect = json_encode(array(
	'location' => array(
		'$nearSphere'           => array('__type' => 'GeoPoint', 'latitude' => 39.899999999999999, 'longitude' => 116.40000000000001),
		'$maxDistanceInRadians' => 0.5
		)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testWithinKilometers()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->withinKilometers('location', new \LeanCloud\GeoPoint(39.899999999999999, 116.40000000000001), 0.5);
		$out = $query->encode();
		$expect = json_encode(array(
	'location' => array(
		'$nearSphere'              => array('__type' => 'GeoPoint', 'latitude' => 39.899999999999999, 'longitude' => 116.40000000000001),
		'$maxDistanceInKilometers' => 0.5
		)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testWithinMiles()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->withinMiles('location', new \LeanCloud\GeoPoint(39.899999999999999, 116.40000000000001), 0.5);
		$out = $query->encode();
		$expect = json_encode(array(
	'location' => array(
		'$nearSphere'         => array('__type' => 'GeoPoint', 'latitude' => 39.899999999999999, 'longitude' => 116.40000000000001),
		'$maxDistanceInMiles' => 0.5
		)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testWithinBox()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->withinBox('location', new \LeanCloud\GeoPoint(39.899999999999999, 116.40000000000001), new \LeanCloud\GeoPoint(40, 118));
		$out = $query->encode();
		$expect = json_encode(array(
	'location' => array(
		'$within' => array(
			'$box' => array(
				array('__type' => 'GeoPoint', 'latitude' => 39.899999999999999, 'longitude' => 116.40000000000001),
				array('__type' => 'GeoPoint', 'latitude' => 40, 'longitude' => 118)
				)
			)
		)
	));
		$this->assertEquals($expect, $out['where']);
	}

	public function testSelectFields()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->select('name', 'color', 'foo', 'bar');
		$out = $query->encode();
		$this->assertEquals('name,color,foo,bar', $out['keys']);
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->select('name');
		$query->select('color');
		$query->select('foo', 'bar');
		$out = $query->encode();
		$this->assertEquals('name,color,foo,bar', $out['keys']);
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->select(array('name', 'color', 'foo', 'bar'));
		$out = $query->encode();
		$this->assertEquals('name,color,foo,bar', $out['keys']);
		$query->select('-image');
		$out = $query->encode();
		$this->assertEquals('name,color,foo,bar,-image', $out['keys']);
	}

	public function testIncludeNestObjects()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->_include('creator');
		$query->_include('object.creator');
		$out = $query->encode();
		$this->assertEquals('creator,object.creator', $out['include']);
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->_include('creator');
		$query->_include('object.creator', 'foo');
		$out = $query->encode();
		$this->assertEquals('creator,object.creator,foo', $out['include']);
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->_include('creator');
		$query->_include(array('object.creator', 'foo'));
		$out = $query->encode();
		$this->assertEquals('creator,object.creator,foo', $out['include']);
	}

	public function testSkipAndLimit()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->limit(100);
		$out = $query->encode();
		$this->assertEquals(100, $out['limit']);
		$query->limit(87);
		$out = $query->encode();
		$this->assertEquals(87, $out['limit']);
		$query->skip(25);
		$out = $query->encode();
		$this->assertEquals(25, $out['skip']);
		$query->skip(42);
		$out = $query->encode();
		$this->assertEquals(42, $out['skip']);
	}

	public function testOrdering()
	{
		$query = new \LeanCloud\LeanQuery('TestObject');
		$query->addAscend('number');
		$out = $query->encode();
		$this->assertEquals('number', $out['order']);
		$query->addDescend('updatedAt');
		$out = $query->encode();
		$this->assertEquals('number,-updatedAt', $out['order']);
		$query->descend('createdAt');
		$out = $query->encode();
		$this->assertEquals('-createdAt', $out['order']);
		$query->addDescend('updatedAt');
		$out = $query->encode();
		$this->assertEquals('-createdAt,-updatedAt', $out['order']);
	}

	public function testComposeSimpleAndQuery()
	{
		$q1 = new \LeanCloud\LeanQuery('TestObject');
		$q1->lessThan('number', 42);
		$q2 = new \LeanCloud\LeanQuery('TestObject');
		$q2->greaterThanOrEqualTo('number', 24);
		$q3 = new \LeanCloud\LeanQuery('TestObject');
		$q3->contains('title', 'clojure');
		$q = \LeanCloud\LeanQuery::andQuery($q1, $q2);
		$out = $q->encode();
		$where = array(
			'$and' => array(
				array(
					'number' => array('$lt' => 42)
					),
				array(
					'number' => array('$gte' => 24)
					)
				)
			);
		$this->assertEquals(json_encode($where), $out['where']);
		$q = \LeanCloud\LeanQuery::andQuery($q1, $q2, $q3);
		$out = $q->encode();
		$where = array(
			'$and' => array(
				array(
					'number' => array('$lt' => 42)
					),
				array(
					'number' => array('$gte' => 24)
					),
				array(
					'title' => array('$regex' => 'clojure')
					)
				)
			);
		$this->assertEquals(json_encode($where), $out['where']);
	}

	public function testComposeSimpleOrQuery()
	{
		$q1 = new \LeanCloud\LeanQuery('TestObject');
		$q1->greaterThanOrEqualTo('number', 42);
		$q2 = new \LeanCloud\LeanQuery('TestObject');
		$q2->lessThan('number', 24);
		$q3 = new \LeanCloud\LeanQuery('TestObject');
		$q3->contains('title', 'clojure');
		$q = \LeanCloud\LeanQuery::orQuery($q1, $q2);
		$out = $q->encode();
		$where = array(
			'$or' => array(
				array(
					'number' => array('$gte' => 42)
					),
				array(
					'number' => array('$lt' => 24)
					)
				)
			);
		$this->assertEquals(json_encode($where), $out['where']);
		$q = \LeanCloud\LeanQuery::orQuery($q1, $q2, $q3);
		$out = $q->encode();
		$where = array(
			'$or' => array(
				array(
					'number' => array('$gte' => 42)
					),
				array(
					'number' => array('$lt' => 24)
					),
				array(
					'title' => array('$regex' => 'clojure')
					)
				)
			);
		$this->assertEquals(json_encode($where), $out['where']);
	}

	public function testComposeCompexLogicalQuery()
	{
		$q1 = new \LeanCloud\LeanQuery('TestObject');
		$q1->greaterThanOrEqualTo('number', 42);
		$q2 = new \LeanCloud\LeanQuery('TestObject');
		$q2->lessThan('number', 24);
		$q3 = new \LeanCloud\LeanQuery('TestObject');
		$q3->contains('title', 'clojure');
		$q = \LeanCloud\LeanQuery::orQuery($q1, $q2);
		$out = $q->encode();
		$where = array(
			'$or' => array(
				array(
					'number' => array('$gte' => 42)
					),
				array(
					'number' => array('$lt' => 24)
					)
				)
			);
		$this->assertEquals(json_encode($where), $out['where']);
		$q = \LeanCloud\LeanQuery::andQuery($q, $q3);
		$out = $q->encode();
		$where = array(
			'$and' => array(
				array(
					'$or' => array(
						array(
							'number' => array('$gte' => 42)
							),
						array(
							'number' => array('$lt' => 24)
							)
						)
					),
				array(
					'title' => array('$regex' => 'clojure')
					)
				)
			);
		$this->assertEquals(json_encode($where), $out['where']);
	}

	public function testDoCloudQueryCount()
	{
		$obj = new \LeanCloud\LeanObject('TestObject');
		$obj->set('name', 'alice');
		$obj->save();
		$resp = \LeanCloud\LeanQuery::doCloudQuery('SELECT count(*) FROM TestObject');
		$this->assertTrue(is_int($resp['count']));
		$this->assertEquals('TestObject', $resp['className']);
		$obj->destroy();
	}

	public function testDoCloudQueryWithPvalues()
	{
		$obj = new \LeanCloud\LeanObject('TestObject');
		$obj->set('name', 'alice');
		$obj->save();
		$resp = \LeanCloud\LeanQuery::doCloudQuery('SELECT * FROM TestObject ' . 'WHERE name = ? LIMIT ?', array('alice', 1));
		$this->assertGreaterThan(0, count($resp['results']));
		$obj->destroy();
	}
}

?>
