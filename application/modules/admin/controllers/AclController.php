<?php

class Admin_AclController extends Spt_Controller_Action
{
	
    public function moduleAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/admin/acl/modulelist');
	}
	
	public function modulelistAction()
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
		$arr_col = array('acl_module_id' => 'ID Module','acl_module_name' => 'Nama Module','acl_module_desc' => 'Keterangan');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('acl_module_name' => 'Nama Module','acl_module_desc' => 'Keterangan');
			
		$xtvt_id = 'acl_module_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Module");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('acl_module');
		$grid->activityId ( 'acl_module_id' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('acl_module_id ASC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$filters = new Bvb_Grid_Filters ( );
        $filters->addFilter ( 'acl_module_name' )
        ->addFilter ( 'acl_module_desc');
        
        $grid->addFilters ( $filters ); 
		
        $grid->setTemplate ( 'work', 'table' );
        $grid->editButton ( true, $this->translate()->_("Kemaskini Module"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/acl/module_edit' );
		$grid->deleteButton ( true, $this->translate()->_("Hapus Module"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/acl/module_delete' );
 		$grid->export = array('pdf','print');
		
        $this->view->pages = $grid->deploy ();
        $this->render ( 'module' );
    }
	
    public function resourcesAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/admin/acl/resourceslist');
	}
    
	public function resourceslistAction()
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
		$arr_col = array('r.acl_resource_id' => 'ID Resource','r.acl_resource_name' => 'Nama Resource','m.acl_module_name' => 'Nama Module', 'r.acl_resource_desc' => 'Keterangan');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('r.acl_resource_name' => 'Nama Resource','m.acl_module_name' => 'Nama Module', 'r.acl_resource_desc' => 'Keterangan');
			
		$xtvt_id = 'r.acl_resource_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Module");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('acl_resource r INNER JOIN acl_module m ON r.acl_module_id = m.acl_module_id');
		$grid->table( array( 'r'=>'acl_resource','m'=>'acl_module' ) );
		$grid->activityId ( 'r.acl_resource_id' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('m.acl_module_name ASC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$filters = new Bvb_Grid_Filters ( );
        $filters->addFilter ( 'm.acl_module_name' )
        ->addFilter ( 'm.acl_module_name')
        ->addFilter ( 'r.acl_resource_desc');
        
        $grid->addFilters ( $filters ); 
		
        $grid->setTemplate ( 'work', 'table' );
        $grid->editButton ( true, $this->translate()->_("Kemaskini Resource"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/acl/resource_edit' );
		$grid->deleteButton ( true, $this->translate()->_("Hapus Resource"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/acl/resource_delete' );
		$grid->export = array('pdf','print');
		
        $this->view->pages = $grid->deploy ();
        $this->render ( 'resources' );
    }
	
    public function privilegesAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/admin/acl/privilegeslist');
	}
	
	public function privilegeslistAction()
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
		$arr_col = array('p.acl_privilege_id' => 'ID Privilege','p.acl_privilege_name' => 'Nama Privilege','r.acl_resource_name' => 'Nama Resource', 'm.acl_module_name' => 'Nama Module');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('p.acl_privilege_name' => 'Nama Privilege','r.acl_resource_name' => 'Nama Resource', 'm.acl_module_name' => 'Nama Module');
			
		$xtvt_id = 'p.acl_privilege_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Privilege");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('acl_privilege p INNER JOIN acl_resource r ON p.acl_resource_id = r.acl_resource_id INNER JOIN acl_module m ON r.acl_module_id = m.acl_module_id');
		$grid->table( array( 'p'=>'acl_privilege','r'=>'acl_resource','m'=>'acl_module' ) );
		$grid->activityId ( 'p.acl_privilege_id' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('m.acl_module_name ASC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$filters = new Bvb_Grid_Filters ( );
        $filters->addFilter ( 'p.acl_privilege_name' )
        ->addFilter ( 'r.acl_resource_name')
        ->addFilter ( 'm.acl_module_name');
        
        $grid->addFilters ( $filters ); 
		
        $grid->setTemplate ( 'work', 'table' );
        $grid->deleteButton ( true, $this->translate()->_("Hapus Privilege"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/acl/privilege_delete' );
		$grid->export = array('pdf','print');
		
        $this->view->pages = $grid->deploy ();
        $this->render ( 'privileges' );
    }
	
	public function moduleaddAction()
    {
		$form = new Spt_Form_Admin_Acl_ModuleAdd;
		
		$this->view->translate = $this->translate();
		
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
				
		if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
			
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
			print_r($_POST);
            return;
        } 
		
		$values = $form->getValues();
		
		$table = new Module;
        $data = array(
            'acl_module_name' => $values['module'],
        	'acl_module_desc' => $values['desc'],
        	'acl_module_show' => $values['show']
        );
        $table->insert($data);
        $this->view->entrySaved = true;
	}
	
	public function resourceaddAction()
    {
		$form = new Spt_Form_Admin_Acl_ResourceAdd;
		
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
		
		$table = new Resources;
        $data = array(
            'acl_module_id' => $values['module'],
            'acl_resource_name' => $values['resources'],
        	'acl_resource_desc' => $values['desc'],
        	'acl_resource_show' => $values['show']
        );
        $table->insert($data);
        $this->view->entrySaved = true;
	}
	
	public function privilegeaddAction()
    {
		$form = new Spt_Form_Admin_Acl_PrivilegeAdd;
		
		$this->view->translate = $this->translate();
		
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		//module
		$module = new Module();
        $moduleOptions = $module->getModulexOptions();
		$this->view->moduleOptions = $moduleOptions;
		
		//resource
		$resource = new Resources();
        $resourceOptions = $resource->getResourceOptions();
		$this->view->resourceOptions = $resourceOptions;
		
		if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
		
		$values = $form->getValues();
		
		$table = new Privilege;
        $data = array(
            'acl_resource_id' => $_POST['resource'],
            'acl_privilege_name' => $values['privilege'],
        	'acl_privilege_desc' => $values['desc'],
        	'acl_privilege_show' => $values['show']
        );
        //print_r($data);
        //die();
        $table->insert($data);
        $this->view->entrySaved = true;
		
	}
	
	public function moduleeditAction()
    {
		$form = new Spt_Form_Admin_Acl_ModuleEdit;
		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
    	
    	if (!$this->getRequest()->isPost()) {
			$rowset = $db->fetchRow("SELECT * FROM acl_module WHERE acl_module_id = ".$this->_getParam('id'));
            
            if (count($rowset) == 0) {
                $this->view->failedFind = true;
                return;
            }
            $this->view->rowset = $rowset;
            $form->setElementFilters(array()); // disable all element filters
            $this->_repopulateModule($form, $rowset);
            $this->view->id = $this->_getParam('id');
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        }
        
        $values = $form->getValues();
		$table = new Module;
        $data = array(
            'acl_module_desc' => $values['desc'],
        	'acl_module_show' => $values['show']
        );
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $table->update($data,
            $table->getAdapter()->quoteInto('acl_module_id = ?', $id)
        );
        
        $this->view->entrySaved = true;
	}
	
	public function resourceeditAction()
    {
		$form = new Spt_Form_Admin_Acl_ResourceEdit;
		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
    	
    	if (!$this->getRequest()->isPost()) {
			$rowset = $db->fetchRow("SELECT * FROM acl_resource WHERE acl_resource_id = ".$this->_getParam('id'));
            
            if (count($rowset) == 0) {
                $this->view->failedFind = true;
                return;
            }
            $this->view->rowset = $rowset;
            $form->setElementFilters(array()); // disable all element filters
            $this->_repopulateResource($form, $rowset);
            $this->view->id = $this->_getParam('id');
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        }
        
        $values = $form->getValues();
		$table = new Resources;
        $data = array(
            'acl_module_id' => $values['module'],
            'acl_resource_desc' => $values['desc'],
        	'acl_resource_show' => $values['show']
        );
		$id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $table->update($data,
            $table->getAdapter()->quoteInto('acl_resource_id = ?', $id)
        );
        
        $this->view->entrySaved = true;
	}
	
	protected function _repopulateModule($form, $item)
    {
    	$values = array(
        	'module' => $this->_reverseAutoFormat($item['acl_module_name']),
        	'desc' => $this->_reverseAutoFormat($item['acl_module_desc']),
    		'id' => $item['acl_module_id'],
    		'show' => $item['acl_module_show']
        );
        $form->populate($values);
    }
	
	protected function _repopulateResource($form, $item)
    {
    	$values = array(
        	'resources' => $this->_reverseAutoFormat($item['acl_resource_name']),
        	'desc' => $this->_reverseAutoFormat($item['acl_resource_desc']),
    		'module' => $item['acl_module_id'],
    		'show' => $item['acl_resource_show']
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
	
	public function moduledeleteAction()
    {
		$table = new Module;
    	$id = $this->_request->getParam('id');
    	$where = 'acl_module_id = "' . $id . '"';
		$table->delete ( $where );
		$this->view->entrySaved = true;
		$this->_redirect('/admin/acl/module');
	}
	
	public function resourcedeleteAction()
    {
		$table = new Resources;
    	$id = $this->_request->getParam('id');
    	$where = 'acl_resource_id = "' . $id . '"';
		$table->delete ( $where );
		$this->view->entrySaved = true;
		$this->_redirect('/admin/acl/resources');
	}
	
	public function privilegedeleteAction()
    {
		$table = new Privilege;
    	$id = $this->_request->getParam('id');
    	$where = 'acl_privilege_id = "' . $id . '"';
		$table->delete ( $where );
		$this->view->entrySaved = true;
		$this->_redirect('/admin/acl/privileges');
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
	
	function modulexAction()
	{
		$db=Zend_Registry::get('db');
		$sql = 'SELECT * FROM acl_module';
		$result = $db->fetchAll($sql);
		$dojoData= new Zend_Dojo_Data('acl_module_id',$result,'acl_module_id');
		echo $dojoData->toJson();
		exit;
	}
	
	function resourcexAction()
	{
		$db=Zend_Registry::get('db');
		$sql = 'SELECT * FROM acl_resource';
		$result = $db->fetchAll($sql);
		$dojoData= new Zend_Dojo_Data('acl_resource_id',$result,'acl_resource_id');
		echo $dojoData->toJson();
		exit;
	}
} 