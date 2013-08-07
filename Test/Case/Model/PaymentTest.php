<?php
App::uses('Payment', 'Model');

/**
 * Payment Test Case
 *
 */
class PaymentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.payment',
		'app.subscription',
		'app.user',
		'app.event',
		'app.certified_model',
		'app.event_date',
		'app.event_price'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Payment = ClassRegistry::init('Payment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Payment);

		parent::tearDown();
	}

/**
 * testReceive method
 *
 * @return void
 */
	public function testReceive() {

		$id= 1;

		$result = $this->Payment->receive($id);

		$expected = false;

		$this->assertEqual($result, $expected);
		
	}

/**
 * testUpdateSituations method
 *
 * @return void
 */
	public function testUpdateSituations() {
	}

/**
 * testUpdate method
 *
 * @return void
 */
	public function testUpdate() {
	}

/**
 * testFixDuplicates method
 *
 * @return void
 */
	public function testFixDuplicates() {
	}

/**
 * testToDisplay method
 *
 * @return void
 */
	public function testToDisplay() {
	}

}
