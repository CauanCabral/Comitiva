<?php
App::uses('Award', 'Model');

/**
 * Award Test Case
 *
 */
class AwardTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.award',
		'app.event',
		'app.certified_model',
		'app.event_date',
		'app.event_price',
		'app.subscription',
		'app.user',
		'app.payment',
		'app.raffle'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Award = ClassRegistry::init('Award');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Award);

		parent::tearDown();
	}

/**
 * testGetList method
 *
 * @return void
 */
	public function testGetList() {

		$result = $this->Award->getList();
		$expected = array(1 => "caneca - evento do michel") ;

		$this->assertEquals($result,$expected);

	}

}
