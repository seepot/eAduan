<?php 

class Admin_StaffController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/admin/staff/list');
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
		$arr_col = array('u.usr_id' => 'Id Pengguna','u.usr_fullname' => 'Nama Penuh','u.usr_identno' => 'No KP','u.usr_email'=>'Email');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('u.usr_id' => 'Id Pengguna','u.usr_fullname' => 'Nama Penuh','u.usr_identno' => 'No KP','u.usr_email'=>'Email');
		
		$xtvt_id = 'u.usr_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Pengguna");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('sys_user u LEFT OUTER JOIN acl_role r ON u.role_id=r.acl_role_id LEFT OUTER JOIN sys_user_type_group g ON r.type_group_id=g.type_group_id');
		$grid->where('g.type_group_id=1');
		$grid->table( array ( 'u' => 'sys_user', 'r' => 'acl_role', 'g' => 'sys_user_type_group' ) );
		$grid->activityId ( 'u.usr_id' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('u.usr_id ASC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$filters = new Bvb_Grid_Filters ( );
        $filters->addFilter ( 'u.usr_id' )
        ->addFilter ( 'u.usr_fullname')
        ->addFilter ( 'u.usr_identno')
        ->addFilter ( 'u.usr_email');
        
        $grid->addFilters ( $filters ); 
		$grid->setTemplate ( 'work', 'table' );
		$grid->activityId ( 'u.usr_id' );
		$grid->viewButton ( true, $this->translate()->_("Papar Pengguna"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/staff/view' );
		$grid->editButton ( true, $this->translate()->_("Kemaskini Pengguna"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/staff/edit' );
		$grid->deleteButton ( true, $this->translate()->_("Hapus Pengguna"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/staff/delete' );
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
		$form = new Spt_Form_Admin_Staff_Add;
		//$check = new Spt_Includes_User;
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
		
		/***********  Semak duplicate ada kat dbase ke x *****************/
		$v_usrID = new Zend_Validate_Db_RecordExists('sys_user', 'usr_id');
		$v_noKP = new Zend_Validate_Db_RecordExists('sys_user', 'usr_identno');
		$v_email = new Zend_Validate_Db_RecordExists('sys_user', 'usr_email');
		if ($v_usrID->isValid($values['username'])) {
			$this->view->userError = true;
			$this->view->form = $form;
            return;
		} elseif ($v_noKP->isValid($values['nokp'])) {
			$this->view->nokpError = true;
			$this->view->form = $form;
            return;
		} elseif ($v_email->isValid($values['email'])) {
			$this->view->emailError = true;
			$this->view->form = $form;
            return;
		} 
		//check duplicate
		/* if ($check->checkUser($values['username']) == true) {
            $this->view->userError = true;
			$this->view->form = $form;
            return;
        }	elseif ($check->checkNokp($values['nokp']) == true) {
            $this->view->nokpError = true;
			$this->view->form = $form;
            return;
        }	elseif ($check->checkEmail($values['email']) == true) {
            $this->view->emailError = true;
			$this->view->form = $form;
            return;
        } */
        
        if($values['password'] != $values['password2']){
        	$this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        }
  		
        $table = new SysUser;
        $data = array(
            'usr_id' => Zend_Filter::get($values['username'], 'HtmlEntities'),
            'usr_fullname' => Zend_Filter::get($values['realname'], 'HtmlEntities'),
        	'usr_identno' => $values['nokp'],
        	'usr_bday' => $_POST['date_bday'],
        	'usr_password' => hash('SHA256', $values['password']),
        	'usr_email' => Zend_Filter::get($values['email'], 'HtmlEntities'),
			'role_id' => $values['roledalaman'],
			'usr_active' => 1,
			'usr_lastlogin' => '0000-00-00 00:00:00',
			'level_id' => 0,
			'usr_active' => 1
        );
        $table->insert($data);
		//$db->insert('sys_user', $data);
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
                    'label' => 'Carian:',
                )),
                'submit' => array('submit', array(
                    'label' => 'Cari',
                ))
            ),
        ));
 
        return $form;
    }
    
    public function viewAction()
    {
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
			$this->view->date = $date;
        }
    }
    
	public function editAction()
    {
    	$form = new Spt_Form_Admin_Staff_Edit;
		$date = new Spt_Includes_Date;
		
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
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
							->where( 'usr_id = ?', $this->_getParam('id') )
													
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
        //die();
		$table = new SysUser;
        $data = array(
            'usr_fullname' => $values['realname'],
        	'usr_identno' => $values['nokp'],
        	'usr_email' => $values['email'],
        	'usr_bday' => (isset($values['date_bday']) && $values['date_bday'] <> '')? $values['date_bday'] : NULL,
        	'role_id' => $values['roledalaman'],
        	'usr_active' => $values['status']
        );
        $table->update($data,
            $table->getAdapter()->quoteInto('usr_id = ?', $values['username'])
        );
        
        $this->view->entrySaved = true;

    }
    
	public function deleteAction()
    {
    	$table = new SysUser;
    	$id = $this->_request->getParam('id');
    	$where = 'usr_id = "' . $id . '"';
		$table->delete ( $where );
		$table2 = new SysUserDetail;
    	$where2 = 'usr_id = "' . $id . '"';
		$table2->delete ( $where2 );
		$this->view->entrySaved = true;
		$this->_redirect('/admin/staff/list');
    }
    
	protected function _repopulateForm($form, $item)
    {
    	$date = new Spt_Includes_Date;
    	
    	$values = array(
        	'realname' => $this->_reverseAutoFormat($item['usr_fullname']),
        	'username' => $this->_reverseAutoFormat($item['usr_id']),
    		'email' => $this->_reverseAutoFormat($item['usr_email']),
    		'date_bday' => $item['usr_bday'],
    		'nokp' => $this->_reverseAutoFormat($item['usr_identno']),
    		'role' => $item['role_id'],
    		'status' => $item['usr_active']
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