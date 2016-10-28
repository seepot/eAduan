<?php 

class Btm_PaperController extends Spt_Controller_Action
{

	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/btm/paper/g_list');
	}
	
	public function glistAction()
	{
		
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
		$arr_col = array('p.paper_id' => 'ID','p.paper_name' => 'Tajuk','p.paper_filename' => 'Nama Imej','p.paper_url' => 'Url','g.p_group_name' => 'Surat Khabar');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('p.paper_name' => 'Tajuk','p.paper_filename' => 'Nama Imej','p.paper_url' => 'Url','g.p_group_name' => 'Surat Khabar');
		
		$xtvt_id = 'p.paper_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Keratan Surat Khabar");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('tbl_paper p INNER JOIN tbl_paper_group g ON g.p_group_id=p.paper_group_id');
		//$grid->where('u.type_id=1');
		$grid->table( array ( 'p' => 'tbl_paper', 'g' => 'tbl_paper_group') );
		$grid->activityId ( 'p.paper_id' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('p.record_datetime DESC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$grid->setTemplate ( 'work', 'table' );
		$grid->viewButton ( true, $this->translate()->_("Papar"), Zend_Controller_Front::getInstance()->getBaseUrl().'/btm/paper/view' );
		$grid->editButton ( true, $this->translate()->_("Kemaskini"), Zend_Controller_Front::getInstance()->getBaseUrl().'/btm/paper/edit' );
		$grid->deleteButton ( true, $this->translate()->_("Hapus"), Zend_Controller_Front::getInstance()->getBaseUrl().'/btm/paper/delete' );
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
	
	public function addAction()
	{
		$form = new Spt_Form_Btm_Akhbar_Add;
		$this->view->translate = $this->translate();
		
		$db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$url_akhbar = '';						
		
		if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
		
		$values = $form->getValues();
		
		if(isset($_POST['file_upload'])){
			//echo "aa";
			if ($_FILES["file"]["error"] > 0)
			  {
			  echo "Error: " . $_FILES["file"]["error"] . "<br />";
			  }
			else
			  {
			  $_FILES["file"]["name"] = date('Ymd').'-'.$this->_findexts($_FILES["file"]["name"]);
			  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			  echo "Type: " . $_FILES["file"]["type"] . "<br />";
			  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			  echo "Stored in: " . $_FILES["file"]["tmp_name"];
			  
			  if (file_exists("upload/paper/" . $_FILES["file"]["name"]))
				  {
				  echo $_FILES["file"]["name"] . " already exists. ";
				  }
				else
				  {
				  $filename = $this->_findexts($_FILES["file"]["name"]);
				  move_uploaded_file($_FILES["file"]["tmp_name"],
				  "upload/paper/" . $filename);
				  echo "Stored in: " . "upload/paper/" . $_FILES["file"]["name"];
				  }
				}
			//$filename = $_FILES["file"]["name"];

		}
		//die();
		/* $adapter=new Zend_File_Transfer_Adapter_Http();
		echo $uploadDir=UPLOAD_PATH;
		$adapter->setDestination($uploadDir);

		$urlpath = SYSTEM_URL.'/data/upload/';
		$apptimestamp = date('Ymd');
		foreach ($adapter->getFileInfo() as $info_url => $info) 
		{	
			echo "<pre>";
			print_r($adapter->getFileInfo());
			echo "</pre>";
			$ext = $this->_findexts($info['name']);
			
			//echo $fileName = Zend_Auth::getInstance()->getIdentity()->usr_id.'-'.$values['sel_paper'].$apptimestamp.'_'.$ext;
			echo $fileName = $info['name'];
			
			$adapter->addFilter('Rename', array('target' => $uploadDir.$fileName,'overwrite' => true), $info_url); 
			
			if(!$adapter->receive($info['name']))
				$this->view->msg=$adapter->getMessages();
			
			if($info['name'] != '')
			{	
				
				$url_akhbar = Zend_Filter::get($urlpath.$fileName,'HtmlEntities');
				
			}
		}  */
        //die();
        
		
		$data = array(
			'paper_name'	=> $values['txt_tajuk'], 
			'paper_filename'	=> $filename, 
			'paper_url'		=>'/upload/paper/'.$filename, 
			'paper_desc'		=> $values['txt_keterangan'], 
			'paper_kolum'		=> $values['txt_kolum'], 
			'paper_mukasurat'		=> $values['txt_mukasurat'], 
			'paper_group_id'		=> $values['sel_paper'], 
			'paper_hits'		=> '0', 
			'paper_status'		=> '1', 
			'record_by'		=> trim(Zend_Auth::getInstance()->getIdentity()->usr_id), 
			'record_datetime'				=> date('Y-m-d H:i:s')
			);
		
		//die();
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		//die();
		$db->insert('tbl_paper', $data);
		
		$id = $db->lastInsertId();
		
		$this->view->entrySaved = true;
	}
	
	protected function _findexts($filename)
	{
		$filename = strtolower($filename) ;
		$exts = str_replace(" ", "_", $filename) ;
		return $exts;
	}
	
	public function newAction()
	{
	}
	
	public function viewAction()
	{
		$date = new Spt_Includes_Date;
		
		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
    	
		$sql = 'SELECT tbl_paper.*, tbl_paper_group.p_group_name
				FROM tbl_paper 
				LEFT OUTER JOIN tbl_paper_group
				ON tbl_paper_group.p_group_id = tbl_paper.paper_group_id
				WHERE paper_id = "'.$this->_getParam('id').'"
				';
		$rowset = $db->fetchRow($sql);
		
		if (count($rowset) == 0) {
			return;
		}
		$this->view->row = $rowset;
	}
	
	public function editAction()
    {
    	//die($this->_getParam('id'));
		$form = new Spt_Form_Btm_Akhbar_Edit;
		$date = new Spt_Includes_Date;
		
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
    	if (!$this->getRequest()->isPost()) {
            $rowset = $db->fetchRow('SELECT tbl_paper.*, tbl_paper_group.p_group_name
				FROM tbl_paper 
				LEFT OUTER JOIN tbl_paper_group
				ON tbl_paper_group.p_group_id = tbl_paper.paper_group_id
				WHERE paper_id = "'.$this->_getParam('id').'"');
            if (count($rowset) == 0) {
                $this->view->failedFind = true;
                return;
            }
            $this->view->rowset = $rowset;
            $this->view->fail_gambar = $rowset['paper_filename'];
            $form->setElementFilters(array()); // disable all element filters
            $this->_repopulateForm($form, $rowset);
            $this->view->id = $this->_getParam('id');
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        }
        
        $values = $form->getValues();
		$data = array();
		
		if(isset($_POST['file_upload'])){
			//echo "aa";
			if ($_FILES["file"]["error"] > 0)
			  {
			  echo "Error: " . $_FILES["file"]["error"] . "<br />";
			  }
			else
			  {
			  $_FILES["file"]["name"] = date('Ymd').'-'.$this->_findexts($_FILES["file"]["name"]);
			  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			  echo "Type: " . $_FILES["file"]["type"] . "<br />";
			  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			  echo "Stored in: " . $_FILES["file"]["tmp_name"];
			  
			  if (file_exists("upload/paper/" . $_FILES["file"]["name"]))
				  {
				  echo $_FILES["file"]["name"] . " already exists. ";
				  }
				else
				  {
				  $filename = $this->_findexts($_FILES["file"]["name"]);
				  move_uploaded_file($_FILES["file"]["tmp_name"],
				  "upload/paper/" . $filename);
				  echo "Stored in: " . "upload/paper/" . $_FILES["file"]["name"];
				  }
				
				$data = $data + array(
					'paper_filename'	=> $filename, 
					'paper_url'		=>'/upload/paper/'.$filename
					);
				
				}
			
		}
		
		$data = $data + array(
			'paper_name'	=> $values['txt_tajuk'], 
			'paper_desc'		=> $values['txt_keterangan'], 
			'paper_kolum'		=> $values['txt_kolum'], 
			'paper_mukasurat'		=> $values['txt_mukasurat'], 
			'paper_group_id'		=> $values['sel_paper'], 
			'paper_hits'		=> '0', 
			'paper_status'		=> '1', 
			'edit_by'		=> trim(Zend_Auth::getInstance()->getIdentity()->usr_id), 
			'edit_datetime'				=> date('Y-m-d H:i:s')
			);
		
		$table = new Paper;
        $table->update($data,
            $table->getAdapter()->quoteInto('paper_id = ?', $this->_getParam('id'))
        );
        
        $this->view->entrySaved = true;

    }
	
	protected function _repopulateForm($form, $item)
    {
    	$date = new Spt_Includes_Date;
    	
    	$values = array(
        	'txt_tajuk' => $this->_reverseAutoFormat($item['paper_name']),
        	'sel_paper' => $this->_reverseAutoFormat($item['paper_group_id']),
    		'txt_keterangan' => $this->_reverseAutoFormat($item['paper_desc']),
    		'txt_kolum' => $this->_reverseAutoFormat($item['paper_kolum']),
    		'txt_mukasurat' => $this->_reverseAutoFormat($item['paper_mukasurat'])
        );
        $form->populate($values);
    }
   
    protected function _reverseAutoFormat($string)
    {
        $string = preg_replace("/\<p\>/", '', $string);
        $string = preg_replace("/\<\/p\>/", "\n\n", $string);
        $string = preg_replace("/\<a[^>]*\>/", '', $string);
        $string = preg_replace("/\<\/a\>/", '', $string);
        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        return $string;
    }
	
	public function deleteAction()
    {
    	$table = new Paper;
    	$id = $this->_request->getParam('id');
    	$where = 'paper_id = "' . $id . '"';
		$table->delete ( $where );
		$this->view->entrySaved = true;
		$this->_redirect('/btm/paper/list');
    }
}

?>