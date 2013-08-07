<?php
App::uses('Event', 'Model');

/**
 * Event Test Case
 *
 */
class EventTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.event',
		'app.certified_model',
		'app.event_date',
		'app.event_price',
		'app.subscription',
		'app.user',
		'app.payment'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Event = ClassRegistry::init('Event');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Event);

		parent::tearDown();
	}

	public function testopenToSubscription(){
		$id = 1;
		$result = $this->Event->openToSubscription($id);
		$expected = true;
		$this->assertEquals($expected, $result);

		$id = 2;
		$result = $this->Event->openToSubscription($id);
		$expected = false;
		$this->assertEquals($expected, $result);

		$id = 3;
		$result = $this->Event->openToSubscription($id);
		$expected = false;
		$this->assertEquals($expected, $result);
	
	}
	public function testgetFirstDay(){
		$id = 1;
		$result = $this->Event->getFirstDay($id);
		$expected = '2013-10-05 20:10:51';
		$this->assertEquals($expected,$result);

		$id = 4;
		$result = $this->Event->getFirstDay($id);
		$expected = '0000-00-00 00:00:00' ;
		$this->assertEquals($expected,$result);
	}
	public function testgetLastDay(){
		$id = 1;
		$result = $this->Event->getLastDay($id);
		$expected = '2013-10-05 20:10:51';
		$this->assertEquals($expected,$result);

		$id = 4;
		$result = $this->Event->getLastDay($id);
		$expected = '0000-00-00 00:00:00';
		$this->assertEquals($expected,$result);
	}
	public function testgetList(){

		$result = $this->Event->getList();
		$expected = array();
		$this->assertEquals($expected,$result);
	}
}