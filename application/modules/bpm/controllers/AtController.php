<?php 

class Bp_AtController extends Spt_Controller_Action
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
		$server = '192.168.100.251\JHEVINTRA2';
		$db = '[Pertanyaan Pencen]';

		// Connect to MSSQL
		$link = mssql_connect($server, 'sa', 'password');

		//mssql_select_db('Pertanyaan Pencen', $link);
		
		if (!$link || !mssql_select_db($db, $link)) {
			die('Unable to connect or select database!');
		}
		
		if(isset($_POST['txt_carian'])){
			$this->view->carianSuccess = true;
			/* $query = mssql_query('SELECT PENIC, PENOLDIC, PENNAME, ACCNOAKAUN
									FROM PENSIONER062004 
									LEFT OUTER JOIN ACCOUNT062004
									ON PENSIONER062004.PENIC = ACCOUNT062004.F101PENIC
									WHERE (PENNAME LIKE "%'.$_POST['txt_carian'].'%")
									OR (PENIC LIKE "%'.$_POST['txt_carian'].'%")
									OR (PENOLDIC LIKE "%'.$_POST['txt_carian'].'%")
								
								');
			
			// Check if there were any records
			if (!mssql_num_rows($query)) {
				echo 'No records found';
			} else {
				// Print a nice list of users in the format of:
				// * name (username)
				
				echo '<ul>';
				echo '<li><i><color="#FF0000">NAMA(NO IC, NO AT )</color></i></li>';
				while ($this->view->row = $row = mssql_fetch_object($query)) {
					echo '<li>' . $row->PENNAME . ' (' . $row->PENIC . ', ' . $row->ACCNOAKAUN . ')</li>';
				}

				echo '</ul>'; 
			}

			// Free the query result
			mssql_free_result($query);*/
		
		}
		
		
		/* 
		
    	$db3 = Zend_Registry::get ( 'db3' );
    	
		//if(isset($_POST['txt_no_tentera'])){
			//echo $_POST['txt_no_tentera'];
			$sql = "SELECT *
FROM         PENSIONER062004";
			$rowset = $db3->fetchAll($sql); */

			/* if (count($rowset) == 0) {
				//$this->view->failedFind = true;
				return;
			} */
			//$this->view->row = $rowset;
			//$this->view->date = $date;
		//}
	}
	
}

?>