<?php 

class Bp_PenyataController extends Spt_Controller_Action
{

	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/btm/paper/g_list');
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
		
		if (!$link || !mssql_select_db($db, $link)) {
			die('Unable to connect or select database!');
		}
		
		if(isset($_POST['txt_carian'])){
			$this->view->carianSuccess = true;
		}
	}
	
}

?>