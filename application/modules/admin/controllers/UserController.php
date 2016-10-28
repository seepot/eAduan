<?php 

class Admin_UserController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/admin/user/list');
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
		$grid->from('(sys_user u INNER JOIN acl_role r ON u.role_id=r.acl_role_id) INNER JOIN sys_user_type_group g ON r.type_group_id=g.type_group_id');
		$grid->where('g.type_group_id=2');
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
		$grid->viewButton ( true, $this->translate()->_("Papar Pengguna"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/user/view' );
		$grid->editButton ( true, $this->translate()->_("Kemaskini Pengguna"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/user/edit' );
		$grid->deleteButton ( true, $this->translate()->_("Hapus Pengguna"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/user/delete' );
		/*
		$icon = new Spt_Includes_Icon;
		$icon1 = $icon->func_createIcon('view.png','_self','Papar',SYSTEM_URL.'/admin/user/view');
		$icon2 = $icon->func_createIcon('edit.png','_self','Kemaskini',SYSTEM_URL.'/admin/user/edit');
		$icon3 = $icon->func_createIcon('delete.gif','_self','Tindakan',SYSTEM_URL.'/admin/user/delete');
		$icon = array($icon1,$icon2,$icon3);
		$grid->otherIcons($icon);
		//$grid->setIconController($status_id);
		*/
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
		$form = new Spt_Form_Admin_User_Add;
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
		
		/***********  Semak duplicatel ada kat dbase ke x *****************/
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
        	'usr_email' => Zend_Filter::get($values['email'], 'HtmlEntities')
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
    	$form = new Spt_Form_Admin_User_Edit;
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
							->join(array('d' => 'sys_user_detail'),
								'u.usr_id = d.usr_id',
								array('jhev_no','jhev_dept','jhev_unit','usr_add_primary','usr_poscode_primary','usr_state_primary','usr_city_primary','usr_phone_no',
								'usr_mobile_no','usr_sex'))
							->join(array('a' => 'sys_user_active'),
								'u.usr_active = a.active_id',
								array('active_name'))
							->where( 'u.usr_id = ?', $this->_getParam('id') )
													
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
		/*
		$table = new SysUser;
        $data = array(
            'usr_fullname' => isset($values['realname']) ? $values['realname'] : '',
        	'usr_identno' => isset($values['nokp']) ? $values['nokp'] : '',
        	'usr_email' => isset($values['email']) ? $values['email'] : '',
        	'usr_bday' => (isset($values['date_bday']) && $values['date_bday'] <> '')? $values['date_bday'] : NULL,
        	'role_id' => isset($values['role']) ? $values['role'] : '',
        	'usr_active' => isset($values['status']) ? $values['status'] : ''
        );
		*/
		$table = new SysUser;
		$data = array(
            'usr_fullname' => Zend_Filter::filterStatic($values['user_name'], 'HtmlEntities'),
        	'usr_identno' => Zend_Filter::filterStatic($values['user_identno'], 'HtmlEntities'), 	
        	'usr_password' => hash('SHA256', $values['user_password1']),
        	'usr_email' => Zend_Filter::filterStatic($values['user_email'], 'HtmlEntities'),
		//	'type_id' => $values['type_id'],
			'role_id' => $values['group_id'],
        );
		//echo '<pre>';
		//print_r($data);
		//echo '</pre>';
		//die();
        //$table->insert($data);
        $table->update($data,
            $table->getAdapter()->quoteInto('usr_id = ?', $values['username'])
        );
		//update table SysUserDetail
		$table4 = new SysUserDetail;
		$data4 = array(
			//'usr_id' => Zend_Filter::filterStatic($values['username'], 'HtmlEntities'),
			'usr_add_primary' => $values['primary_add'],
			'usr_poscode_primary' => $values['poskod_add'],
			'jhev_no' => $values['user_nojabatan'],
			'jhev_dept' => $values['jhev_dept'],
			'jhev_unit' => $values['jhev_unit'],
			'usr_state_primary' => $values['state_add'],
			'usr_city_primary' => $values['district_add'],
			'usr_mobile_no' => $values['mobile_no'],
			'usr_phone_no' => $values['office_no'],
			'usr_date_birth' => $this->_getbirthdate($values['user_identno']),
			'usr_sex' => $values['user_sex']
			);
		//echo '<pre>';
		//print_r($data4);
		//echo '</pre>';
		//die();
		 $table4->update($data4,
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
		$this->_redirect('/admin/user/list');
    }
    
	protected function _repopulateForm($form, $item)
    {
    	$date = new Spt_Includes_Date;
    	
    	$values = array(
        	'user_name' => $this->_reverseAutoFormat($item['usr_fullname']),
        	'username' => $this->_reverseAutoFormat($item['usr_id']),
    		'user_email' => $this->_reverseAutoFormat($item['usr_email']),
    		//'date_bday' => $item['usr_bday'],
    		'user_identno' => $this->_reverseAutoFormat($item['usr_identno']),
    		'user_nojabatan' => $this->_reverseAutoFormat($item['jhev_no']),
    		'jhev_dept' => $this->_reverseAutoFormat($item['jhev_dept']),
    		'jhev_unit' => $this->_reverseAutoFormat($item['jhev_unit']),
    		'primary_add' => $this->_reverseAutoFormat($item['usr_add_primary']),
    		'poskod_add' => $this->_reverseAutoFormat($item['usr_poscode_primary']),
    		'state_add' => $this->_reverseAutoFormat($item['usr_state_primary']),
    		'district_add' => $this->_reverseAutoFormat($item['usr_city_primary']),
    		'office_no' => $this->_reverseAutoFormat($item['usr_phone_no']),
    		'mobile_no' => $this->_reverseAutoFormat($item['usr_mobile_no']),
    		'user_sex' => $this->_reverseAutoFormat($item['usr_sex']),
    		'group_id' => $item['role_id'],
    		'status' => $item['usr_active']
        );
        $form->populate($values);
    }
	protected function _getbirthdate($ic)
	{	$birthyear = substr($ic,0,2);
		$birthmonth = substr($ic,2,2);
		$birthday = substr($ic,4,2);
		
		if($birthyear>40 && $birthyear<100)
			$birthdate = "19".$birthyear."-".$birthmonth."-".$birthday;
		else
			$birthdate = "20".$birthyear."-".$birthmonth."-".$birthday;
			
		return $birthdate;
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