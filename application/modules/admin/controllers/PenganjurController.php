<?php 

class Admin_PenganjurController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/admin/penganjur/list');
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
		$arr_col = array('p.penganjur_id' => 'Id Penganjur','p.penganjur_name' => 'Nama Penganjur','p.penganjur_address' => 'Alamat Penganjur', 'a.aktif_name'=>'Status');
		//$arr_col = array('p.penganjur_id' => 'Id Penganjur','p.penganjur_name' => 'Nama Penganjur','p.penganjur_address' => 'Alamat Penganjur', 'p.penganjur_registered_ilp' => 'ILP' ,'a.aktif_name'=>'Status');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('p.penganjur_name' => 'Nama Penganjur','p.penganjur_address' => 'Alamat Penganjur', 'a.aktif_name'=>'Status');
			//$arr_col_1 = array('p.penganjur_name' => 'Nama Penganjur','p.penganjur_address' => 'Alamat Penganjur', 'p.penganjur_registered_ilp' => 'ILP' ,'a.aktif_name'=>'Status');
		
		$xtvt_id = 'p.penganjur_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Penganjur");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('sys_penganjur p INNER JOIN tbl_aktif a ON p.aktif_id=a.aktif_id');
		$grid->table( array ( 'p' => 'sys_penganjur', 'a' => 'tbl_aktif' ) );
		$grid->activityId ( 'p.penganjur_id' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('p.penganjur_name ASC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$filters = new Bvb_Grid_Filters ( );
        $filters->addFilter ( 'p.penganjur_name' )
        ->addFilter ( 'p.penganjur_address')
        ->addFilter ( 'a.aktif_name');
        
        $grid->addFilters ( $filters ); 
		
        $grid->setTemplate ( 'work', 'table' );
        $grid->editButton ( true, $this->translate()->_("Kemaskini Penganjur"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/penganjur/edit' );
		$grid->deleteButton ( true, $this->translate()->_("Hapus Penganjur"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/penganjur/delete' );

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
		$db = Zend_Registry::get ( 'db' );
		
		$form = new Spt_Form_Admin_Penganjur_PenganjurAdd;
		//$check = new Spt_Includes_State;
	
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		$translate = Zend_Registry::get ( 'translate' );
		$this->view->translate = $translate;
		
		if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
        
        $values = $form->getValues();
		//print_r($values);
		//check duplicate
		/*
		if ($check->checkStateCode($values['kodnegeri']) == true) {
            $this->view->stateCodeError = true;
			$this->view->form = $form;
            return;
        }
		if ($check->checkState($values['negeri']) == true) {
            $this->view->stateError = true;
			$this->view->form = $form;
            return;
        }
		*/
        
        $table = new Penganjur;
        $data = array(
			'penganjur_name' => Zend_Filter::get($values['namapenganjur'], 'HtmlEntities'),
            'penganjur_address' => Zend_Filter::get($values['alamatpenganjur'], 'HtmlEntities'),
            'aktif_id' => $values['status']
        );
		$db->insert('sys_penganjur', $data);
        $this->view->entrySaved = true;
	}
	
	public function editAction()
    {
		$form = new Spt_Form_Admin_Penganjur_PenganjurEdit;
		//$date = new Spt_Includes_Date;
		
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		$translate = Zend_Registry::get ( 'translate' );
		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
    	
    	if (!$this->getRequest()->isPost()) {
            $rowset = $db->fetchRow(
					$db->select()
							->from(array('p' => 'sys_penganjur'),
								array('penganjur_id', 'penganjur_name', 'penganjur_address', 'aktif_id'))
							->where( 'penganjur_id = ?', $this->_getParam('id') )
													
			);
            if (count($rowset) == 0) {
                $this->view->failedFind = true;
                return;
            }
            $this->view->rowset = $rowset;
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
		//print_r($values);
        $table = new Penganjur;
        $data = array(
			'penganjur_name' => Zend_Filter::get($values['namapenganjur'], 'HtmlEntities'),
            'penganjur_address' => Zend_Filter::get($values['alamatpenganjur'], 'HtmlEntities'),
        	'aktif_id' => $values['status']
        );
        $table->update($data,
            $table->getAdapter()->quoteInto('penganjur_id = ?', $values['p_id'])
        );
        
        $this->view->entrySaved = true;
    }
    
	public function deleteAction()
    {
    	$table = new Penganjur;
    	$id = $this->_request->getParam('id');
    	$where = 'penganjur_id = "' . $id . '"';
		$table->delete ( $where );
		$this->view->entrySaved = true;
		$this->_redirect('/admin/penganjur');
    }
    
	protected function _repopulateForm($form, $item)
    {
    	$date = new Spt_Includes_Date;
    	
    	$values = array(
			'p_id' => $this->_reverseAutoFormat($item['penganjur_id']),
			'namapenganjur' => $this->_reverseAutoFormat($item['penganjur_name']),
			'alamatpenganjur' => $this->_reverseAutoFormat($item['penganjur_address']),
        	'status' => $this->_reverseAutoFormat($item['aktif_id'])
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
}

?>