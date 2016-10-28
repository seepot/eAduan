<?php 

class Admin_DistrictController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/admin/district/list');
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
		$arr_col = array('d.district_id' => 'Id Daerah','d.district_name' => 'Daerah','s.sta_name' => 'Negeri','a.aktif_name'=>'Status');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('d.district_name' => 'Daerah','s.sta_name' => 'Negeri','a.aktif_name'=>'Status');
		
		
		$xtvt_id = 'd.district_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Pengguna");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('((sys_district d INNER JOIN sys_state s ON d.sta_id=s.sta_id) INNER JOIN tbl_aktif a on d.district_status=a.aktif_id)');
		$grid->table( array ( 'd' => 'sys_district', 's' => 'sys_state', 'a' => 'tbl_aktif' ) );
		$grid->activityId ( 'd.district_id' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('d.district_name ASC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$filters = new Bvb_Grid_Filters ( );
        $filters->addFilter ( 'd.district_name' )
        ->addFilter ( 's.sta_name')
        ->addFilter ( 'a.aktif_name');
        
        $grid->addFilters ( $filters ); 
		
		$grid->setTemplate ( 'work', 'table' );
        $grid->activityId ( 'd.district_id' );
		//$grid->viewButton ( true, $this->translate()->_("Papar Pengguna"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/district/view' );
		$grid->editButton ( true, $this->translate()->_("Kemaskini Daerah"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/district/edit' );
		$grid->deleteButton ( true, $this->translate()->_("Hapus Daerah"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/district/delete' );
 		
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
		/* echo "<pre>";
		print_r($arr_newCol);
		echo "</pre>";
		die(); */
		return $arr_newCol;
	}
	
	public function addAction()
	{
		$db = Zend_Registry::get ( 'db' );
		
		$form = new Spt_Form_Admin_District_DistrictAdd;
		$check = new Spt_Includes_District;

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
		
		//check duplicate
		if ($check->checkDistrict($values['daerah']) == true) {
            $this->view->districtError = true;
			$this->view->form = $form;
            return;
        }
          		
        $data = array(
            'sta_id' => $values['negeri'],
            'district_name' => Zend_Filter::get($values['daerah'], 'HtmlEntities'),
        	'district_status' => $values['status']
        );
		$db->insert('sys_district', $data);
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
    	$form = new Spt_Form_Admin_District_DistrictEdit;
		$date = new Spt_Includes_Date;
		
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		$translate = Zend_Registry::get ( 'translate' );
		$this->view->translate = $translate;
		
    	$db = Zend_Registry::get ( 'db' );
    	
    	if (!$this->getRequest()->isPost()) {
            $rowset = $db->fetchRow(
					$db->select()
							->from(array('d' => 'sys_district'),
								array('district_id', 'district_name', 'sta_id', 'district_status'))
							->where( 'district_id = ?', $this->_getParam('id') )
													
			);
			//print_r($rowset);
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
		$table = new District;
		$data = array(
            'sta_id' => $values['negeri'],
            'district_name' => Zend_Filter::get($values['daerah'], 'HtmlEntities'),
        	'district_status' => $values['status']
        );
        $table->update($data,
            $table->getAdapter()->quoteInto('district_id = ?', $values['district_id'])
        );
        
        $this->view->entrySaved = true;

    }
    
	public function deleteAction()
    {
    	$table = new District;
    	$id = $this->_request->getParam('id');
    	$where = 'district_id = "' . $id . '"';
		$table->delete ( $where );
		$this->view->entrySaved = true;
		$this->_redirect('/admin/district/list');
    }
    
	protected function _repopulateForm($form, $item)
    {
    	$date = new Spt_Includes_Date;
    	
    	$values = array(
        	'district_id' => $this->_reverseAutoFormat($item['district_id']),
			'daerah' => $this->_reverseAutoFormat($item['district_name']),
        	'negeri' => $this->_reverseAutoFormat($item['sta_id']),
    		'status' => $this->_reverseAutoFormat($item['district_status'])
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