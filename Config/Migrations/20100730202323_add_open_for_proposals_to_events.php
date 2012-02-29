<?php
App::uses('Security', 'Utility');
/**
 * AddOpenForProposalsToEvents Migration
 *
 * @since 07/30/2010 20:23:23
 */
class AddOpenForProposalsToEvents extends AppMigrations {

/**
 * Up Method
 *
 * @return void
 * @access public
 */
	function up() {
		$this->addColumn('events', 'open_for_proposals', array('type' => 'integer', 'length' => 1));
	}

/**
 * Down Method
 *
 * @return void
 * @access public
 */
	function down() {
		$this->removeColumn('events', 'open_for_proposals');
	}
}

?>