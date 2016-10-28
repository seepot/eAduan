<?php

class Admin_AuditrailController extends Spt_Controller_Action
{
    public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/admin/auditrail/list');
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
		$arr_col = array('a.audit_trail_id' => 'Id Audit','u.usr_fullname' => 'Nama Pengguna','a.audit_trail_module' => 'Modul', 'a.audit_trail_task'=>'Tugasan', 'a.audit_trail_datetime' => 'Tarikh', 'a.audit_trail_ipaddress' => 'Alamat IP');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('u.usr_fullname' => 'Nama Pengguna','a.audit_trail_module' => 'Modul', 'a.audit_trail_task'=>'Tugasan', 'a.audit_trail_datetime' => 'Tarikh', 'a.audit_trail_ipaddress' => 'Alamat IP');
			
		$xtvt_id = 'a.audit_trail_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Audit Trail");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('tbl_audit_trail a INNER JOIN sys_user u ON a.usr_id=u.usr_id');
		$grid->table( array ( 'a' => 'tbl_audit_trail', 'u' => 'sys_user' ) );
		$grid->activityId ( 'a.audit_trail_id' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('a.audit_trail_datetime DESC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$filters = new Bvb_Grid_Filters ( );
        $filters->addFilter ( 'u.usr_fullname' )
        ->addFilter ( 'a.audit_trail_module')
        ->addFilter ( 'a.audit_trail_task')
        ->addFilter ( 'a.audit_trail_datetime')
        ->addFilter ( 'a.audit_trail_ipaddress');
        
        $grid->addFilters ( $filters ); 
		
        $grid->setTemplate ( 'work2', 'table' );
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
	/*
	public function addAction()
	{
		$form = new Spt_Form_Admin_Auditrail_Add;
		$date = new Spt_Includes_Date;
		$this->view->translate = $this->translate();
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
        
        $values = $form->getValues();
		
		$table = new AudiTrail;
        $data = array(
            'usr_id' => Zend_Filter::get($values['username'], 'HtmlEntities'),
            'audit_trail_module' => Zend_Filter::get($values['typename'], 'HtmlEntities'),
            'audit_trail_task' => Zend_Filter::get($values['tugasan'], 'HtmlEntities'),
        	'audit_trail_datetime' => $_POST['date_audit'],
        	'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
        );
        $table->insert($data);
		$this->view->entrySaved = true;
	}
    
	public function editAction()
    {
    	$form = new Spt_Form_Admin_Auditrail_Edit;
		//$date = new Spt_Includes_Date;
		
		//$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		//$this->view->front = $front;
		
		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
    	
    	if (!$this->getRequest()->isPost()) {
            $rowset = $db->fetchRow(
					$db->select()
							->from(array('a' => 'tbl_audit_trail'),
								array('audit_trail_id', 'usr_id', 'audit_trail_module', 'audit_trail_task', 'audit_trail_datetime'))
							->join(array('u' => 'sys_user'),
								'u.usr_id = a.usr_id',
								array('usr_fullname'))
							->where( 'audit_trail_id = ?', $this->_getParam('id') )
													
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
		$table = new AudiTrail;
        $data = array(
            'usr_id' => Zend_Filter::get($values['username'], 'HtmlEntities'),
            'audit_trail_module' => Zend_Filter::get($values['typename'], 'HtmlEntities'),
            'audit_trail_task' => Zend_Filter::get($values['tugasan'], 'HtmlEntities'),
        	'audit_trail_datetime' => $_POST['date_audit'],
        	'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
        );
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $table->update($data,
            $table->getAdapter()->quoteInto('audit_trail_id = ?', $id)
        );
        
        $this->view->entrySaved = true;

    }
    
	public function deleteAction()
    {
    	$table = new AudiTrail;
    	$id = $this->_request->getParam('id');
    	$where = 'audit_trail_id = "' . $id . '"';
		$table->delete ( $where );
		$this->view->entrySaved = true;
		$this->_redirect('/admin/auditrail/list');
    }
    
	protected function _repopulateForm($form, $item)
    {
    	$values = array(
        	'audit_id' => $this->_reverseAutoFormat($item['audit_trail_id']),
        	'username' => $this->_reverseAutoFormat($item['usr_id']),
    		'typename' => $this->_reverseAutoFormat($item['audit_trail_module']),
    		'tugasan' => $this->_reverseAutoFormat($item['audit_trail_task']),    		
			'date_audit' => $item['audit_trail_datetime']
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
	*/
}