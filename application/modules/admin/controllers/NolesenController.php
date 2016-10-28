<?php 

class Admin_NolesenController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$this->_redirect('/admin/nolesen/list');
	}
	
	public function listAction()
	{
		$this->view->translate = $this->translate();
		$this->title = $this->translate()->_("Senarai No Lesen");
		$this->view->url = $this->getUrl();
		
		$grid = $this->grid ( 'table' );
		$grid->from('sys_nolesen nl INNER JOIN sys_user u ON nl.usr_id = u.usr_id')
			->table( array ( 'nl' => 'sys_nolesen', 'u' => 'sys_user' ) )
			->addColumn('nl.nolesen_id',array('title'=>$this->translate()->_("No Lesen")))
			->addColumn('u.usr_fullname',array('title'=>$this->translate()->_("Pemohon")))
			->addColumn('nl.nolesen_tarikh',array('title'=>$this->translate()->_("Tarikh")))
			->addColumn('nl.nolesen_status',array('title'=>$this->translate()->_("Status")))
			->order('nolesen_id ASC')
			->setPagination ( 10 );

        $grid->setTemplate ( 'work', 'table' );
        $grid->activityId ( 'nl.nolesen_id' );
		
		$grid->editButton ( true, $this->translate()->_("Daftar No Lesen"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/nolesen/edit' );
		$grid->deleteButton ( true, $this->translate()->_("Batal No Lesen"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/nolesen/batal' );
        $this->view->pages = $grid->deploy ();
        $this->render ( 'list' );
	}
	
	public function addAction()
	{
		$db = Zend_Registry::get ( 'db' );
		
		$form = new Spt_Form_DistrictAdd;
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
            'nolesen_id' => $values['nolesen'],
            //'district_name' => Zend_Filter::get($values['daerah'], 'HtmlEntities'),
        	'district_status' => $values['status']
        );
		$db->insert('sys_nolesen', $data);
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
    	$form = new Spt_Form_DistrictEdit;
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