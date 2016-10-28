<?php 

class Admin_GroupController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/admin/group/list');
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
		$arr_col = array('r.acl_role_id' => 'ID Kump','r.acl_role_name' => 'Nama','r.acl_role_desc' => 'Keterangan','g.type_group_name'=>'Jenis Pengguna', 'a.active_name' => 'Status');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('r.acl_role_name' => 'Nama','r.acl_role_desc' => 'Keterangan','g.type_group_name'=>'Jenis Pengguna', 'a.active_name' => 'Status');
		
		$xtvt_id = 'r.acl_role_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Pengguna");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from( "(acl_role r INNER JOIN sys_user_active a ON r.acl_role_status = a.active_id) LEFT JOIN sys_user_type_group g ON r.type_group_id=g.type_group_id");
		$grid->where('r.acl_role_status = 1');
		$grid->table(array('r'=>'acl_role','a'=>'sys_user_active','g'=>'sys_user_type_group'));
		$grid->activityId ( 'r.acl_role_id' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('r.acl_role_id ASC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$filters = new Bvb_Grid_Filters ( );
        $filters->addFilter ( 'r.acl_role_id' )
        ->addFilter ( 'r.acl_role_name')
        ->addFilter ( 'r.acl_role_desc')
        ->addFilter ( 'g.type_group_name')
        ->addFilter ( 'a.active_name');
        
        $grid->addFilters ( $filters ); 
		$grid->setTemplate ( 'work', 'table' );
		$grid->viewButton ( true, $this->translate()->_("Papar Kumpulan Pengguna"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/group/view' );
		$grid->editButton ( true, $this->translate()->_("Kemaskini Kumpulan Pengguna"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/group/edit' );
		$grid->deleteButton ( true, $this->translate()->_("Hapus Kumpulan Pengguna"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/group/delete' );
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
		$this->view->translate = $this->translate();
		
		$form = new Spt_Form_Admin_Group_Add;
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$this->view->modules = $db->fetchAll("SELECT acl_module_id, acl_module_desc FROM acl_module WHERE acl_module_show = 1");
		$this->view->resources = $db->fetchAll("SELECT acl_resource_id, acl_resource_desc, acl_module_id FROM acl_resource WHERE acl_resource_show = 1");
		$this->view->privileges = $db->fetchAll("SELECT acl_privilege_id, acl_privilege_desc, acl_resource_id FROM acl_privilege WHERE acl_privilege_show = 1");
		
		if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
        
        $values = $form->getValues();
        $data = array(
            'acl_role_name' => Zend_Filter::filterStatic($values['groupname'], 'HtmlEntities'),
            'acl_role_desc' => Zend_Filter::filterStatic($values['groupdesc'], 'HtmlEntities'),
        	'acl_inherit_id' => '1',
        	'acl_role_status' => '1',
			'type_group_id' => Zend_Filter::filterStatic($values['typegroup'], 'HtmlEntities')
        );
        //print_r($data);
        $db->insert('acl_role',$data);
        $nextID = $db->lastInsertId(); 
        //die($nextID);
        foreach($_POST['chk_right'] as $privilege) {
	        $data = array(
	            'acl_role_id' => $nextID,
	            'acl_privilege_id' => $privilege
	        );
	        $db->insert('acl_role_privilege',$data);
        }
        
        //die();
        
        $this->view->entrySaved = true;
	}
	
	public function editAction()
	{
		$this->view->translate = $this->translate();
		
		/**********import form**************/
		$form = new Spt_Form_Admin_Group_Edit;
		
		/*************get base url**************/
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		/*************get db config************/
		$db = Zend_Registry::get ( 'db' );
    	$this->view->modules = $db->fetchAll("SELECT acl_module_id, acl_module_desc FROM acl_module WHERE acl_module_show = 1");
		$this->view->resources = $db->fetchAll("SELECT acl_resource_id, acl_resource_desc, acl_module_id FROM acl_resource WHERE acl_resource_show = 1");
		$this->view->privileges = $db->fetchAll("SELECT acl_privilege_id, acl_privilege_desc, acl_resource_id FROM acl_privilege WHERE acl_privilege_show = 1");
											
		if (!$this->getRequest()->isPost()) {
            $this->view->groupid = $this->_getParam('id');
			$rowset = $db->fetchRow(
					$db->select()
							->from(array('r' => 'acl_role'),
								array('acl_role_id','acl_role_name','acl_role_desc','type_group_id'))
							->join(array('a' => 'sys_user_active'),
									'r.acl_role_status = a.active_id',
									array('active_name'))
							->where( 'r.acl_role_id = ?', $this->_getParam('id') )
													
			);
			$this->view->role_privileges = $db->fetchCol("SELECT acl_privilege_id FROM acl_role_privilege WHERE acl_role_id = ".$this->_getParam('id'));
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
			$this->view->role_privileges = $db->fetchCol("SELECT acl_privilege_id FROM acl_role_privilege WHERE acl_role_id = ".$this->_getParam('id'));
            $this->view->form = $form;
            return;
        }

        $values = $form->getValues();
		
		/**************update table acl_role*************/
		$table = new AclRole;
		$data = array(
            'acl_role_name' => Zend_Filter::filterStatic($values['groupname'], 'HtmlEntities'),
            'acl_role_desc' => Zend_Filter::filterStatic($values['groupdesc'], 'HtmlEntities'),
			'type_group_id' => Zend_Filter::filterStatic($values['typegroup'], 'HtmlEntities')
        );
        $table->update($data,
            $table->getAdapter()->quoteInto('acl_role_id = ?', $_POST['groupid'])
        );

		$tbl_rp = new AclRolePrivilege;
		//$tbl_rp->delete('acl_privilege_id = 8','acl_role_id = 3');
		$x = $db->fetchAll("SELECT acl_privilege.acl_privilege_id 
							FROM acl_privilege
							LEFT OUTER JOIN acl_role_privilege
							ON acl_privilege.acl_privilege_id = acl_role_privilege.acl_privilege_id
							WHERE acl_privilege.acl_privilege_show = 1
							AND acl_role_privilege.acl_role_id = ".$_POST['groupid']
		);
		/**************delete data tbl acl_role_privilege*************/
		foreach($x as $privilege)
		{
			//print_r($privilege);
			$where1 = $tbl_rp->getAdapter()->quoteInto('acl_role_id = ?', $_POST['groupid']);
			$where2 = $tbl_rp->getAdapter()->quoteInto('acl_privilege_id = ?', $privilege['acl_privilege_id']);
			$tbl_rp->delete($where1,$where2);
		}
		
		//die();
		
		
		
		/*************insert to acl_role_privilege***********/
		foreach($_POST['chk_right'] as $privilege) {
	        $data = array(
	            'acl_role_id' => $_POST['groupid'],
	            'acl_privilege_id' => $privilege
	        );
	        $tbl_rp->insert($data);
        }
		$this->view->entrySaved = true;
	}
	
	public function viewAction()
	{
		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
		$this->view->modules = $db->fetchAll("SELECT acl_module_id, acl_module_desc FROM acl_module WHERE acl_module_show = 1");
		$this->view->resources = $db->fetchAll("SELECT acl_resource_id, acl_resource_desc, acl_module_id FROM acl_resource WHERE acl_resource_show = 1");
		$this->view->privileges = $db->fetchAll("SELECT acl_privilege_id, acl_privilege_desc, acl_resource_id FROM acl_privilege WHERE acl_privilege_show = 1");
    	
    	if (!$this->getRequest()->isPost()) {
            $rowset = $db->fetchRow(
					$db->select()
							->from(array('r' => 'acl_role'),
								array('acl_role_id','acl_role_name','acl_role_desc'))
							->join(array('a' => 'sys_user_active'),
									'r.acl_role_status = a.active_id',
									array('active_name'))
							->join(array('g' => 'sys_user_type_group'),
									'r.type_group_id = g.type_group_id',
									array('type_group_name'))
							->where( 'r.acl_role_id = ?', $this->_getParam('id') )
			);
			
			$this->view->role_privileges = $db->fetchCol("SELECT acl_privilege_id FROM acl_role_privilege WHERE acl_role_id = ".$this->_getParam('id'));
            if (count($rowset) == 0) {
                $this->view->failedFind = true;
                return;
            }
            $this->view->rowset = $rowset;
        }
	}
	
	public function deleteAction()
    {
    	$db = Zend_Registry::get ( 'db' );
		//$table = new SysUser;
    	$id = $this->_request->getParam('id');
    	$where = 'acl_role_id = "' . $id . '"';
		$db->delete ('acl_role', $where );
		$this->view->entrySaved = true;
		$this->_redirect('/admin/group/list');
    }
	
	protected function _repopulateForm($form, $item)
    {
    	$values = array(
        	'group_id' => $item['acl_role_id'],
			'groupname' => $this->_reverseAutoFormat($item['acl_role_name']),
        	'groupdesc' => $this->_reverseAutoFormat($item['acl_role_desc'])
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