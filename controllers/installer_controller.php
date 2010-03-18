<?php
App::import('model', 'ConnectionManager');

class InstallerController extends AppController
{
	public $uses = array();

	public function isAuthorized()
	{		
		if($this->userLogged === TRUE && $this->params['prefix'] == User::get('type'))
		{
			return true;
		}
		
		return false;
	}

	public function admin_configure()
	{
		$db = ConnectionManager::getDataSource('default');

		if(!$db->isConnected())
		{
			echo 'Could not connect to database. Please check the settings in app/config/database.php and try again';
			exit();
		}

		/* Building basic database structure */
		//$this->__dbStructure(array('fileName' => 'comitiva.sql'));

		/* Inserting needed application data into database */
		$this->__dbBasics();

		/* Inserting application data for testing functionalities */
		$this->__dbTesting();

		$this->__thanks();
	}

	private function __dbStructure($options = array())
	{
		if(is_string($options) || isset($options['useSchema']))
		{
			$version = new MigrationVersion();
			$versions = $version->getMapping('rcms');
			
			if(!isset($options['targetVersion']))
			{
				$options['targetVersion'] = array_pop($versions);
			}
			
			if(!isset($options['initVersion']))
			{
				$options['initVersion'] = array_pop($versions); 
			}
			
			$version->run(array('version' => array($options['initVersion'], $options['targetVersion']), 'type' => 'rcms', 'direction' => 'up'));
		}
		else if(isset($options['fileName']))
		{
			$db = ConnectionManager::getDataSource('default');
			
			$statements = file_get_contents(CONFIGS . 'sql/' . $options['fileName']);
			/* Replacing the block comments */
			$statements = preg_replace('/\/\*[^\*]*\*\//','',$statements);
			/* Replacing the line comments */
			$statements = preg_replace('/.*\-\-.*\n/','',$statements);

			$statements = explode(';', $statements);

			foreach ($statements as $statement) {
				if (trim($statement) != '') {
					$db->query($statement);
				}
			}
			return true;
		}
	}

	/**
	 * Populates database with needed data
	 */
	private function __dbBasics()
	{
		/** Inserindo dados mínimos no BD **/
		$user = array(
			'name' => 'PHPMS',
			'username' => 'admin',
			'password' => $this->Auth->password('capivara'),
			'email' => 'admin.phpms@gmail.com',
			'type' => 'admin',
			'active' => 1
			);

		$this->loadModel('User');
		$this->User->create();
		$this->User->save($user, false); // save without validate
	}

	/**
	 * Populates database with data needed by application
	 */
	private function __dbTesting()
	{
	}
	
	private function __thanks()
	{
		$this->render(NULL, NULL, '/pages/index');
	}
}
?>