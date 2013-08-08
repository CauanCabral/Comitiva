<?php
App::uses('CertifiedModel', 'Model');

/**
 * CertifiedModel Test Case
 *
 */
class CertifiedModelTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.certified_model'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CertifiedModel = ClassRegistry::init('CertifiedModel');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CertifiedModel);

		parent::tearDown();
	}

	public function testAdd() {
		$data = array(
			'title'=>''
		);

		$this->CertifiedModel->create();
		$this->assertFalse($this->CertifiedModel->save($data));

		$expected = array('title' => array('Preencha este campo'));
		$result = $this->CertifiedModel->validationErrors;
		$this->assertEquals($expected, $result);
		
	}

}
