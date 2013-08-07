<?php
App::uses('User', 'Model');

/**
 * User Test Case
 *
 */
class UserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user',
		'app.subscription',
		'app.event',
		'app.certified_model',
		'app.event_date',
		'app.event_price',
		'app.payment'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->User = ClassRegistry::init('User');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->User);

		parent::tearDown();
	}

/**
 * testPasswordIsValid method
 *
 * @return void
 */
	public function testPasswordIsValid() {
	}

/**
 * testGetList method
 *
 * @return void
 */
	public function testGetList() {
	}

/**
 * testSearchFields method
 *
 * @return void
 */
	public function testSearchFields() {
	}

}
