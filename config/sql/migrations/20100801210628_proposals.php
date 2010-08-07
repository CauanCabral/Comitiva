<?php
/**
 * Proposals Migration
 *
 * @since 08/01/2010 21:06:28
 */
class Proposals extends AppMigration {

/**
 * Up Method
 *
 * @return void
 * @access public
 */
	function up() {
		$this->addColumn('proposals', 'approved', array('type' => 'boolean'));
		$this->addColumn('proposals', 'rating', array('type' => 'integer'));
		$this->addColumn('proposals', 'avaliator', array('type' => 'string', 'length' => 45));
	}

/**
 * Down Method
 *
 * @return void
 * @access public
 */
	function down() {
		$this->removeColumn('proposals', 'approved');
		$this->removeColumn('proposals', 'rating');
		$this->removeColumn('proposals', 'avaliator');
	}
}

?>