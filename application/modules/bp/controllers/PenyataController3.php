<?php 

class Bp_PenyataController extends Spt_Controller_Action
{

	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		
		if ($defSession->role == 5 || $defSession->role == 6){
			$this->_redirect('/bp/penyata/carian');
		} else if ($defSession->role == 2 || $defSession->role == 3){
			$this->view->translate = $this->translate();
			$this->view->func = new Pesara;
			
			$db = Zend_Registry::get ( 'db' );
			$db->setFetchMode(Zend_Db::FETCH_OBJ);
			
			$this->view->rowset = $db->fetchRow(
				$db->select()
					->from(array('u' => 'sys_user'),
						array('usr_fullname', 'usr_email', 'usr_identno'))
					->join(array('d' => 'sys_user_detail'),
						'd.usr_id = u.usr_id')
					->joinLeft(array('p' => 'sys_user_pesara'),
						'p.pesara_userid = u.usr_id')	
					->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
			);
		}
	}
	
	public function carianAction()
	{
	
		$this->view->translate = $this->translate();
		// Server in the this format: <computer>\<instance name> or 
		// <server>,<port> when using a non default port number
		$server = 'JHEVDATABASE';
		$db = '[PenyataOnline]';
		
		
		// Connect to MSSQL
		$link = mssql_connect($server, 'sa', 'JH#V@dm1n');
		
		//mssql_select_db('Pertanyaan Pencen', $link);
		
		
		$db2 = Zend_Registry::get ( 'db' );
		$db2->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		
		
		if(isset($_POST['hide_cari'])){
			$this->view->carianSuccess = true;
			
			/* $this->view->rowset = $db2->fetchRow(
				$db2->select()
					->from(array('u' => 'sys_user'),
						array('usr_fullname', 'usr_email', 'usr_identno'))
					->join(array('d' => 'sys_user_detail'),
						'd.usr_id = u.usr_id')
					->joinLeft(array('p' => 'sys_user_pesara'),
						'p.pesara_userid = u.usr_id')	
					->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
			);
			
			if (!$link || !mssql_select_db($db, $link)) {
				die('Unable to connect or select database!');
			} */
		}
	}
	
	public function carianxAction()
	{
	
		$this->view->translate = $this->translate();
		// Server in the this format: <computer>\<instance name> or 
		// <server>,<port> when using a non default port number
		$server = 'JHEVDATABASE';
		$db = '[PenyataOnline]';
		
		
		// Connect to MSSQL
		$link = mssql_connect($server, 'sa', 'JH#V@dm1n');
		
		//mssql_select_db('Pertanyaan Pencen', $link);
		
		
		$db2 = Zend_Registry::get ( 'db' );
		$db2->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		
		
		if(isset($_POST['hide_cari'])){
			$this->view->carianSuccess = true;
			
			/* $this->view->rowset = $db2->fetchRow(
				$db2->select()
					->from(array('u' => 'sys_user'),
						array('usr_fullname', 'usr_email', 'usr_identno'))
					->join(array('d' => 'sys_user_detail'),
						'd.usr_id = u.usr_id')
					->joinLeft(array('p' => 'sys_user_pesara'),
						'p.pesara_userid = u.usr_id')	
					->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
			);
			
			if (!$link || !mssql_select_db($db, $link)) {
				die('Unable to connect or select database!');
			} */
		}
	}
	
	public function tahun2009Action()
	{
	
		die('Dalam proses kemaskini.');
		$this->view->translate = $this->translate();
		// Server in the this format: <computer>\<instance name> or 
		// <server>,<port> when using a non default port number
		$server = 'JHEVDATABASE';
		$db = '[PenyataOnline]';
		
		
		// Connect to MSSQL
		$link = mssql_connect($server, 'sa', 'JH#V@dm1n');
		
		//mssql_select_db('Pertanyaan Pencen', $link);
		
		
		$db2 = Zend_Registry::get ( 'db' );
		$db2->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		
		$this->view->rowset = $db2->fetchRow(
			$db2->select()
				->from(array('u' => 'sys_user'),
					array('usr_fullname', 'usr_email', 'usr_identno'))
				->join(array('d' => 'sys_user_detail'),
					'd.usr_id = u.usr_id')
				->joinLeft(array('p' => 'sys_user_pesara'),
					'p.pesara_userid = u.usr_id')	
				->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
		);
		
		if (!$link || !mssql_select_db($db, $link)) {
			die('Unable to connect or select database!');
		}
		
		$table = new AudiTrail;
			$data = array(
				'usr_id' => Zend_Filter::get(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_module' => Zend_Filter::get('Semak Penyata', 'HtmlEntities'),
				'audit_trail_task' => Zend_Filter::get('Penyata 2009 - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_datetime' => date('Y-m-d H:i:s'),
				'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
			);
			$table->insert($data);
			
		/* if(isset($_POST['hide_cari'])){
			$this->view->carianSuccess = true;
		} */
	}
	
	public function tahun2010Action()
	{
		//die('Dalam proses kemaskini.');
		$this->view->translate = $this->translate();
		// Server in the this format: <computer>\<instance name> or 
		// <server>,<port> when using a non default port number
		$server = 'JHEVDATABASE';
		$db = '[PenyataOnline]';
		
		
		// Connect to MSSQL
		$link = mssql_connect($server, 'sa', 'JH#V@dm1n');
		
		//mssql_select_db('Pertanyaan Pencen', $link);
		
		
		$db2 = Zend_Registry::get ( 'db' );
		$db2->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		
		$this->view->rowset = $db2->fetchRow(
			$db2->select()
				->from(array('u' => 'sys_user'),
					array('usr_fullname', 'usr_email', 'usr_identno'))
				->join(array('d' => 'sys_user_detail'),
					'd.usr_id = u.usr_id')
				->joinLeft(array('p' => 'sys_user_pesara'),
					'p.pesara_userid = u.usr_id')	
				->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
		);
		
		if (!$link || !mssql_select_db($db, $link)) {
			die('Unable to connect or select database!');
		}
		
		$table = new AudiTrail;
			$data = array(
				'usr_id' => Zend_Filter::get(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_module' => Zend_Filter::get('Semak Penyata', 'HtmlEntities'),
				'audit_trail_task' => Zend_Filter::get('Penyata 2010 - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_datetime' => date('Y-m-d H:i:s'),
				'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
			);
			$table->insert($data);
	}
	
	public function tahun2011Action()
	{
		//die('Dalam proses kemaskini.');
		$this->view->translate = $this->translate();
		// Server in the this format: <computer>\<instance name> or 
		// <server>,<port> when using a non default port number
		$server = 'JHEVDATABASE';
		$db = '[PenyataOnline]';
		
		
		// Connect to MSSQL
		$link = mssql_connect($server, 'sa', 'JH#V@dm1n');
		
		//mssql_select_db('Pertanyaan Pencen', $link);
		
		
		$db2 = Zend_Registry::get ( 'db' );
		$db2->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		
		$this->view->rowset = $db2->fetchRow(
			$db2->select()
				->from(array('u' => 'sys_user'),
					array('usr_fullname', 'usr_email', 'usr_identno'))
				->join(array('d' => 'sys_user_detail'),
					'd.usr_id = u.usr_id')
				->joinLeft(array('p' => 'sys_user_pesara'),
					'p.pesara_userid = u.usr_id')	
				->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
		);
		
		if (!$link || !mssql_select_db($db, $link)) {
			die('Unable to connect or select database!');
		}
		
		$table = new AudiTrail;
			$data = array(
				'usr_id' => Zend_Filter::get(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_module' => Zend_Filter::get('Semak Penyata', 'HtmlEntities'),
				'audit_trail_task' => Zend_Filter::get('Penyata 2010 - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_datetime' => date('Y-m-d H:i:s'),
				'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
			);
			$table->insert($data);
	}
	
	public function tahun2012Action()
	{
		//die('Dalam proses kemaskini.');
		$this->view->translate = $this->translate();
		// Server in the this format: <computer>\<instance name> or 
		// <server>,<port> when using a non default port number
		$server = '192.168.100.205';
		$db = '[VIBES]';
		
		
		// Connect to MSSQL
		$link = mssql_connect($server, 'sa', 'JHEVsvr2010');
		
		//mssql_select_db('Pertanyaan Pencen', $link);
		
		
		$db2 = Zend_Registry::get ( 'db' );
		$db2->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		
		$this->view->rowset = $db2->fetchRow(
			$db2->select()
				->from(array('u' => 'sys_user'),
					array('usr_fullname', 'usr_email', 'usr_identno'))
				->join(array('d' => 'sys_user_detail'),
					'd.usr_id = u.usr_id')
				->joinLeft(array('p' => 'sys_user_pesara'),
					'p.pesara_userid = u.usr_id')	
				->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
		);
		
		if (!$link || !mssql_select_db($db, $link)) {
			die('Unable to connect or select database!');
		}
		
		$table = new AudiTrail;
			$data = array(
				'usr_id' => Zend_Filter::get(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_module' => Zend_Filter::get('Semak Penyata', 'HtmlEntities'),
				'audit_trail_task' => Zend_Filter::get('Penyata 2010 - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_datetime' => date('Y-m-d H:i:s'),
				'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
			);
			$table->insert($data);
	}
	
	
	public function tahun2010xAction()
	{
		$this->view->translate = $this->translate();
		// Server in the this format: <computer>\<instance name> or 
		// <server>,<port> when using a non default port number
		$server = 'JHEVDATABASE';
		$db = '[PenyataOnline]';
		
		
		// Connect to MSSQL
		$link = mssql_connect($server, 'sa', 'JH#V@dm1n');
		
		//mssql_select_db('Pertanyaan Pencen', $link);
		
		
		$db2 = Zend_Registry::get ( 'db' );
		$db2->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		
		$this->view->rowset = $db2->fetchRow(
			$db2->select()
				->from(array('u' => 'sys_user'),
					array('usr_fullname', 'usr_email', 'usr_identno'))
				->join(array('d' => 'sys_user_detail'),
					'd.usr_id = u.usr_id')
				->joinLeft(array('p' => 'sys_user_pesara'),
					'p.pesara_userid = u.usr_id')	
				->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
		);
		
		if (!$link || !mssql_select_db($db, $link)) {
			die('Unable to connect or select database!');
		}
		
		$table = new AudiTrail;
			$data = array(
				'usr_id' => Zend_Filter::get(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_module' => Zend_Filter::get('Semak Penyata', 'HtmlEntities'),
				'audit_trail_task' => Zend_Filter::get('Penyata 2010 - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_datetime' => date('Y-m-d H:i:s'),
				'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
			);
			$table->insert($data);
	}
	
}

?>