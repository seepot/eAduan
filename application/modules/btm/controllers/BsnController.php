<?php 

class Btm_BsnController extends Spt_Controller_Action
{

	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/btm/bsn/list');
	}
	
	public function carianAction()
	{
		$this->view->db = $db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		 
		
		if(isset($_POST['txt_carian']) OR isset($_POST['txt_kp']) ){
			$this->view->carianSuccess = true;
			/* echo '<pre>';
			print_r($_POST);
			echo '</pre>'; */
			//no bayaran bsn
			$sql = 'SELECT * FROM bsn 
					WHERE AKAUNMO LIKE "%'.$_POST['txt_carian'].'%" 
					AND IC LIKE "%'.$_POST['txt_kp'].'%" 
					';
			$db->setFetchMode(Zend_Db::FETCH_OBJ);
			$rowset = $db->fetchAll($sql);
			/* if (count($rowset) == 0) {
				return;
			} */
			$this->view->row = $rowset;
			
			//reject bank
			$sql2 = 'SELECT * FROM rejectbank 
					WHERE PENERIMAID LIKE "%'.$_POST['txt_kp'].'%" 
					';
			$db->setFetchMode(Zend_Db::FETCH_OBJ);
			$rowset2 = $db->fetchAll($sql2);
			if ($_POST['txt_kp'] == '') {
				return;
			}
			$this->view->row2 = $rowset2;
			
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