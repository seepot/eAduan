<?php 

class Pelarasan_SemakanController extends Spt_Controller_Action
{

	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/pelarasan/semakan/list');
	}
	
	public function carianAction()
	{
		$date = new Spt_Includes_Date;
		
		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
    	
		if(isset($_POST['txt_no_tentera'])){
			//echo $_POST['txt_no_tentera'];
			$sql = 'SELECT * FROM tbl_pelarasan WHERE pelarasan_no_tentera = "'.$_POST['txt_no_tentera'].'"';
			$rowset = $db->fetchRow($sql);

			if (count($rowset) == 0) {
				//$this->view->failedFind = true;
				return;
			}
			$this->view->row = $rowset;
			//$this->view->date = $date;
		}
	}
	
	public function listAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		
		$this->view->translate = $this->translate();
		
		$pagingNo = Zend_Controller_Front::getInstance()->getRequest()->getParam('paging');
		if($pagingNo <> '')
			$pagingNo = $defSession->paging = Zend_Controller_Front::getInstance()->getRequest()->getParam('paging');
		elseif(isset($defSession->paging))
			$pagingNo = $defSession->paging;
		else
			$pagingNo = 10;
		$this->view->pagingNo = $pagingNo;
		
		//column
		$arr_col = array('p.pelarasan_id' => 'ID Pelarasan','p.pelarasan_no_tentera' => 'No Tentera','p.pelarasan_nama' => 'Nama Tentera');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('p.pelarasan_id' => 'ID Pelarasan','p.pelarasan_no_tentera' => 'No Tentera','p.pelarasan_nama' => 'Nama Tentera');
		
		$xtvt_id = 'p.pelarasan_no_tentera'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Pelarasan");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('tbl_pelarasan p');
		//$grid->where('u.type_id=1');
		$grid->table( array ( 'p' => 'tbl_pelarasan') );
		$grid->activityId ( 'p.pelarasan_no_tentera' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('p.pelarasan_id ASC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$grid->setTemplate ( 'work', 'table' );
		$grid->viewButton ( true, $this->translate()->_("Papar"), Zend_Controller_Front::getInstance()->getBaseUrl().'/pelarasan/semakan/view' );
		$grid->export = array('pdf','print');
		
        $this->view->pages = $grid->deploy ();
        $this->render ( 'list' );
	}
		
	protected function func_column($col = array(), $new = array())
	{
		$arr_newCol = array();
		$defSession = Zend_Registry::get ( 'defSession' );
		
		foreach($new as $newCol){
			foreach($col as $key=>$value){
				if($newCol==$key)
					$arr_newCol = $arr_newCol + array($key=>$value);
			}
		}
		$defSession->col = $arr_newCol;
		return $arr_newCol;
	}
	
	public function viewAction()
	{
		$date = new Spt_Includes_Date;
		
		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
    	
		$sql = 'SELECT * FROM tbl_pelarasan WHERE pelarasan_no_tentera = "'.$this->_getParam('id').'"';
		$rowset = $db->fetchRow($sql);
		
		$sql2 = 'SELECT pelarasan_tarikh_mula,pelarasan_pencen_terkini,pelarasan_tunggakan,pelarasan_status_bayaran,bulan,tahun,pelarasan_status_bayaran FROM tbl_pelarasan WHERE pelarasan_no_tentera = "'.$this->_getParam('id').'"';
		$rowset2 = $db->fetchAll($sql2);

		if (count($rowset) == 0) {
			return;
		}
		$this->view->row = $rowset;
		$this->view->row2 = $rowset2;
	}
	
	public function uploadAction()
	{
		$db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		if(isset($_POST['file_upload'])){
			echo "aa";
			if ($_FILES["file"]["error"] > 0)
			  {
			  echo "Error: " . $_FILES["file"]["error"] . "<br />";
			  }
			else
			  {
			  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			  echo "Type: " . $_FILES["file"]["type"] . "<br />";
			  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			  echo "Stored in: " . $_FILES["file"]["tmp_name"];
			  
			  if (file_exists("upload/" . $_FILES["file"]["name"]))
				  {
				  echo $_FILES["file"]["name"] . " already exists. ";
				  }
				else
				  {
				  move_uploaded_file($_FILES["file"]["tmp_name"],
				  "upload/" . $_FILES["file"]["name"]);
				  echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
				  }
				}
			$filename = $_FILES["file"]["name"];

			$file=fopen("upload/".$filename,"r") or exit("Unable to open file!");

			while(!feof($file))
			{
				$line_of_text =  fgets($file);
				$parts = explode(',', $line_of_text);
				
				echo "<pre>";
				print_r($parts);
				echo "</pre>";
				
				$data = array(
					'pelarasan_no_tentera' => Zend_Filter::get($parts[0], 'HtmlEntities'),
					'pelarasan_nama' => Zend_Filter::get($parts[1], 'HtmlEntities'),
					'pelarasan_waris_nama' => Zend_Filter::get($parts[2], 'HtmlEntities'),
					'pelarasan_waris_kp' => Zend_Filter::get($parts[3], 'HtmlEntities'),
					'pelarasan_pangkat' => Zend_Filter::get($parts[4], 'HtmlEntities'),
					'pelarasan_bulan' => Zend_Filter::get($parts[5], 'HtmlEntities'),
					'pelarasan_pencen_terkini' => Zend_Filter::get($parts[6], 'HtmlEntities'),
					'pelarasan_tarikh_mula' => Zend_Filter::get($parts[7], 'HtmlEntities'),
					'pelarasan_tunggakan' => Zend_Filter::get($parts[8], 'HtmlEntities'),
					'pelarasan_status_bayaran' => Zend_Filter::get($parts[9], 'HtmlEntities'),
					'record_datetime' => date('Y-m-d H:i:s'),
					'record_by' => trim(Zend_Auth::getInstance()->getIdentity()->usr_id),
					'bulan' => Zend_Filter::get($_POST['bulan'], 'HtmlEntities'),
					'tahun' => Zend_Filter::get($_POST['tahun'], 'HtmlEntities')
				);
				$db->insert('tbl_pelarasan', $data);
				echo "<pre>";
				print_r($data);
				echo "</pre>";
			}
			fclose($file);

			
		}
	}
}

?>