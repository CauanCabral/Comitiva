<?php
/* Proposal Test cases generated on: 2010-07-30 19:07:34 : 1280533474*/
App::import('Model', 'Proposal');

class ProposalTest extends CakeTestCase {
	var $fixtures = array('app.proposal', 'app.user', 'app.subscription', 'app.event', 'app.event_date', 'app.event_price', 'app.payment');

	function startTest() {
		$this->Proposal =& ClassRegistry::init('Proposal');
	}

	function endTest() {
		unset($this->Proposal);
		ClassRegistry::flush();
	}

}
?>