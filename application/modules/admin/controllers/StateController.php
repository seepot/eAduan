<?php 

class Admin_StateController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/admin/state/list');
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
		$arr_col = array('s.sta_id' => 'Id Negeri','s.sta_code' => 'Kod Negeri','s.sta_name' => 'Negeri','a.aktif_name'=>'Status');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('s.sta_code' => 'Kod Negeri','s.sta_name' => 'Negeri','a.aktif_name'=>'Status');
		
		$xtvt_id = 's.sta_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Pengguna");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('sys_state s INNER JOIN tbl_aktif a ON s.sta_status=a.aktif_id');
		$grid->table( array ( 's' => 'sys_state', 'a' => 'tbl_aktif' ) );
		$grid->activityId ( 's.sta_id' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('s.sta_code ASC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$filters = new Bvb_Grid_Filters ( );
        $filters->addFilter ( 's.sta_code' )
        ->addFilter ( 's.sta_name')
        ->addFilter ( 'a.aktif_name');
        
        $grid->addFilters ( $filters ); 
		$grid->setTemplate ( 'work', 'table' );
        $grid->activityId ( 's.sta_id' );
		//$grid->viewButton ( true, $this->translate()->_("Papar Pengguna"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/user/view' );
		$grid->editButton ( true, $this->translate()->_("Kemaskini Negeri"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/state/edit' );
		$grid->deleteButton ( true, $this->translate()->_("Hapus Negeri"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/state/delete' );

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
		
		$form = new Spt_Form_Admin_State_StateAdd;
		$check = new Spt_Includes_State;
	
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
		
        
        $table = new State;
        $data = array(
			'sta_code' => Zend_Filter::get($values['kodnegeri'], 'HtmlEntities'),
            'sta_name' => Zend_Filter::get($values['negeri'], 'HtmlEntities'),
            'sta_status' => $values['status']
        );
		$db->insert('sys_state', $data);
        $this->view->entrySaved = true;
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
/*
    public function viewAction()
    {
    	$form = new Spt_Form_UserEdit;
		$date = new Spt_Includes_Date;
		
		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
    	
    	if (!$this->getRequest()->isPost()) {
            $rowset = $db->fetchRow(
					$db->select()
							->from(array('u' => 'sys_user'),
								array('usr_id', 'usr_fullname', 'usr_email', 'usr_identno', 'usr_bday', 'usr_password', 'usr_active', 'role_id'))
							->join(array('a' => 'sys_user_active'),
								'u.usr_active = a.active_id',
								array('active_name'))
							->join(array('r' => 'acl_role'),
								'u.role_id = r.acl_role_id',
								array('acl_role_name'))
							->where( 'usr_id = ?', $this->_getParam('id') )
						
													
			);

            if (count($rowset) == 0) {
                $this->view->failedFind = true;
                return;
            }
            $this->view->rowset = $rowset;
			$this->view->usr_bday = $date->func_ymd2dmy($rowset['usr_bday']);
        }
    }
*/   
	public function editAction()
    {
    	$form = new Spt_Form_Admin_State_StateEdit;
		$date = new Spt_Includes_Date;
		
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		$translate = Zend_Registry::get ( 'translate' );
		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
    	
    	if (!$this->getRequest()->isPost()) {
            $rowset = $db->fetchRow(
					$db->select()
							->from(array('s' => 'sys_state'),
								array('sta_id', 'sta_code', 'sta_name', 'sta_status'))
							->where( 'sta_id = ?', $this->_getParam('id') )
													
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
        $table = new State;
        $data = array(
			'sta_code' => Zend_Filter::get($values['kodnegeri'], 'HtmlEntities'),
            'sta_name' => Zend_Filter::get($values['negeri'], 'HtmlEntities'),
        	'sta_status' => $values['status']
        );
        $table->update($data,
            $table->getAdapter()->quoteInto('sta_id = ?', $values['sta_id'])
        );
        
        $this->view->entrySaved = true;

    }
    
	public function deleteAction()
    {
    	$table = new State;
    	$id = $this->_request->getParam('id');
    	$where = 'sta_id = "' . $id . '"';
		$table->delete ( $where );
		$this->view->entrySaved = true;
		$this->_redirect('/admin/state/list');
    }
    
	protected function _repopulateForm($form, $item)
    {
    	$date = new Spt_Includes_Date;
    	
    	$values = array(
			'sta_id' => $this->_reverseAutoFormat($item['sta_id']),
			'kodnegeri' => $this->_reverseAutoFormat($item['sta_code']),
			'negeri' => $this->_reverseAutoFormat($item['sta_name']),
        	'status' => $this->_reverseAutoFormat($item['sta_status'])
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