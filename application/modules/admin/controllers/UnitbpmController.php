<?php 

class Admin_UnitbpmController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$this->_redirect('/admin/unitbpm/list');
	}
	
	public function listAction()
	{
		
		///////
		
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
		$arr_col = array('m.bpm_id' => 'Id','m.bpm_name' => 'Unit', 'u.usr_fullname' => 'Ketua');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('m.bpm_id' => 'Id','m.bpm_name' => 'Unit', 'u.usr_fullname' => 'Ketua');
		
		$xtvt_id = 'm.bpm_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Unit BPM");
		$grid = $this->grid ( 'table' );
		$grid->from('ea_bpm m LEFT OUTER JOIN sys_user u ON m.pegawai_id = u.usr_id');
		$grid->table( array ( 'm' => 'ea_bpm','u'=>'sys_user' ) );
		$grid->activityId ( $xtvt_id );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order($xtvt_id.' ASC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		$grid->setTemplate ( 'work', 'table' );
		$grid->activityId ( $xtvt_id );
		//////
		$grid->editButton ( true, $this->translate()->_("Kemaskini Unit"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/unitbpm/edit' );
		$grid->deleteButton ( true, $this->translate()->_("Hapus Unit"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/unitbpm/delete' );
        
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
		
		$form = new Spt_Form_Admin_Bpm_Add;

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
        $data = array(
            'bpm_name' => Zend_Filter::filterStatic($values['txt_bpm_name'], 'HtmlEntities'),
            'pegawai_id' => Zend_Filter::filterStatic($values['sel_pegawai'], 'HtmlEntities'),
			'unit_id' => Zend_Filter::filterStatic($values['sel_unit'], 'HtmlEntities')
        );
		$db->insert('ea_bpm', $data);
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
	public function editAction()
    {
    	$form = new Spt_Form_Admin_Bpm_Edit;
		
		$this->view->translate = Zend_Registry::get ( 'translate' );
		
    	$db = Zend_Registry::get ( 'db' );
    	
    	if (!$this->getRequest()->isPost()) {
            $rowset = $db->fetchRow(
					$db->select()
							->from(array('m' => 'ea_bpm'),
								array('bpm_name','pegawai_id','unit_id'))
							->where('bpm_id = ?', $this->_getParam('id'))
													
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
		
		$data = array(
            'bpm_name' => Zend_Filter::filterStatic($values['txt_bpm_name'], 'HtmlEntities'),
            'pegawai_id' => Zend_Filter::filterStatic($values['sel_pegawai'], 'HtmlEntities'),
            'unit_id' => Zend_Filter::filterStatic($values['sel_unit'], 'HtmlEntities')
        );
        $where[] = "bpm_id = '".$this->_getParam('id')."'";
		$db->update('ea_bpm', $data, $where );
		
		$data2 = array(
            'usr_bpm' => Zend_Filter::filterStatic($this->_getParam('id'), 'HtmlEntities')
        );
        $where2[] = "usr_id = '".$this->_getParam('id')."'";
		$db->update('sys_user_detail', $data2, $where2 );
        
        $this->view->entrySaved = true;

    }
    
	public function deleteAction()
    {
    	$db = Zend_Registry::get ( 'db' );
		$id = $this->_request->getParam('id');
    	$where = 'bpm_id = "' . $id . '"';
		$db->delete ( 'ea_bpm', $where );
		$this->view->entrySaved = true;
		$this->_redirect('/admin/unitbpm/list');
    }
    
	protected function _repopulateForm($form, $item)
    {
    	$date = new Spt_Includes_Date;
    	
    	$values = array(
        	'txt_bpm_name' => $this->_reverseAutoFormat($item['bpm_name']),
        	'sel_pegawai' => $this->_reverseAutoFormat($item['pegawai_id']),
        	'sel_unit' => $this->_reverseAutoFormat($item['unit_id'])
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
	
	function staffAction()
	{
		$db=Zend_Registry::get('db');
		$sql = 'SELECT * FROM sys_user WHERE role_id = "13"';
		$result = $db->fetchAll($sql);
		$dojoData= new Zend_Dojo_Data('usr_id',$result,'usr_id');
		echo $dojoData->toJson();
		exit;
	}
	
	function unitAction()
	{
		$db=Zend_Registry::get('db');
		$sql = 'SELECT * FROM ea_unit WHERE dept_id = "1"';
		$result = $db->fetchAll($sql);
		$dojoData= new Zend_Dojo_Data('unit_id',$result,'unit_id');
		echo $dojoData->toJson();
		exit;
	}
}

?>