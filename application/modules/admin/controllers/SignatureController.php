<?php 

class Admin_SignatureController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/admin/signature/list');
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
		$arr_col = array('s.signature_id' => 'Id Tandatangan','u.usr_fullname' => 'Nama Pengguna','t.type_name' => 'Unit', 'a.aktif_name'=>'Status');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('u.usr_fullname' => 'Nama Pengguna','t.type_name' => 'Unit', 'a.aktif_name'=>'Status');
			
		$xtvt_id = 's.signature_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Tandatangan");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('((tbl_signature s INNER JOIN sys_user u ON s.usr_id=u.usr_id) INNER JOIN sys_type t ON s.type_id=t.type_id) INNER JOIN tbl_aktif a ON s.aktif_id=a.aktif_id');
		$grid->table( array ( 's' => 'tbl_signature', 'u' => 'sys_user', 't' => 'sys_type', 'a' => 'tbl_aktif' ) );
		$grid->activityId ( 's.signature_id' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('u.usr_fullname ASC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$filters = new Bvb_Grid_Filters ( );
        $filters->addFilter ( 'u.usr_fullname' )
        ->addFilter ( 't.type_name')
        ->addFilter ( 'a.aktif_name');
        
        $grid->addFilters ( $filters ); 
		
        $grid->setTemplate ( 'work', 'table' );
        //$grid->activityId ( 'p.penganjur_id' );
		$grid->editButton ( true, $this->translate()->_("Kemaskini Tandatangan"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/signature/edit' );
		$grid->deleteButton ( true, $this->translate()->_("Hapus Tandatangan"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/signature/delete' );

		$grid->export = array('pdf','print');
		
        $this->view->pages = $grid->deploy ();
        $this->render ( 'list' );
	}
	
	public function addAction()
	{
		$db = Zend_Registry::get ( 'db' );
		
		$form = new Spt_Form_Admin_Signature_SignatureAdd;
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
		print_r($values);
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
        
        $table = new Signature;
        $data = array(
			'usr_id' => Zend_Filter::get($values['user'], 'HtmlEntities'),
            'type_id' => Zend_Filter::get($values['unit'], 'HtmlEntities'),
            'aktif_id' => $values['status']
        );
		$db->insert('tbl_signature', $data);
        $this->view->entrySaved = true;
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
	
	protected function _getSearchForm()
    {
        $form = new Zend_Form(array(
            'method'   => 'post',
            'action'   => $this->_helper->url->url(array('action'=>'grid')),
            'elements' => array(
                'query' => array('text', array(
                    'required' => true,
                    'label' => $this->translate()->_('Carian:'),
                )),
                'submit' => array('submit', array(
                    'label' => $this->translate()->_('Cari'),
                ))
            ),
        ));
 
        return $form;
    }
  
	public function editAction()
    {
		$form = new Spt_Form_Admin_Signature_SignatureEdit;
		//$date = new Spt_Includes_Date;
		
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		$translate = Zend_Registry::get ( 'translate' );
		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
    	
    	if (!$this->getRequest()->isPost()) {
            $rowset = $db->fetchRow(
					$db->select()
							->from(array('s' => 'tbl_signature'),
								array('signature_id', 'usr_id', 'type_id', 'aktif_id'))
							->where( 'signature_id = ?', $this->_getParam('id') )
													
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
        $table = new Signature;
        $data = array(
			'usr_id' => Zend_Filter::get($values['user'], 'HtmlEntities'),
            'type_id' => Zend_Filter::get($values['unit'], 'HtmlEntities'),
        	'aktif_id' => $values['status']
        );
        $table->update($data,
            $table->getAdapter()->quoteInto('signature_id = ?', $values['sig_id'])
        );
        
        $this->view->entrySaved = true;
    }
    
	public function deleteAction()
    {
    	$table = new Signature;
    	$id = $this->_request->getParam('id');
    	$where = 'signature_id = "' . $id . '"';
		$table->delete ( $where );
		$this->view->entrySaved = true;
		$this->_redirect('/admin/signature/list');
    }
    
	protected function _repopulateForm($form, $item)
    {
    	$date = new Spt_Includes_Date;
    	
    	$values = array(
			'sig_id' => $this->_reverseAutoFormat($item['signature_id']),
			'user' => $this->_reverseAutoFormat($item['usr_id']),
			'unit' => $this->_reverseAutoFormat($item['type_id']),
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