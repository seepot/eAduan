<?php 

class Admin_UnitController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$this->_redirect('/admin/unit/list');
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
		$arr_col = array('p.unit_id' => 'Id','p.unit_desc' => 'Unit', 'r.desc' => 'Bahagian', 'u.usr_fullname' => 'Penyelia');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('p.unit_id' => 'Id','p.unit_desc' => 'Unit', 'r.desc' => 'Bahagian', 'u.usr_fullname' => 'Penyelia');
		
		$xtvt_id = 'p.unit_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Unit JHEV");
		$grid = $this->grid ( 'table' );
		$grid->from('ea_unit p INNER JOIN ea_bahagian r ON p.dept_id = r.id LEFT OUTER JOIN sys_user u ON p.penyelia_id = u.usr_id');
		$grid->table( array( 'p'=>'ea_unit','r'=>'ea_bahagian','u'=>'sys_user' ) );
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
		$grid->editButton ( true, $this->translate()->_("Kemaskini Unit"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/unit/edit' );
		$grid->deleteButton ( true, $this->translate()->_("Hapus Unit"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/unit/delete' );
        
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
		
		$form = new Spt_Form_Admin_Unit_Add;

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
            'unit_desc' => Zend_Filter::filterStatic($values['txt_unit_name'], 'HtmlEntities'),
            'dept_id' => Zend_Filter::filterStatic($values['sel_bahagian'], 'HtmlEntities'),
            'penyelia_id' => Zend_Filter::filterStatic($values['sel_penyelia'], 'HtmlEntities')
        );
		$db->insert('ea_unit', $data);
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
    	$form = new Spt_Form_Admin_Unit_Edit;
		
		$this->view->translate = Zend_Registry::get ( 'translate' );
		
    	$db = Zend_Registry::get ( 'db' );
    	
    	if (!$this->getRequest()->isPost()) {
            $rowset = $db->fetchRow(
					$db->select()
							->from(array('m' => 'ea_unit'),
								array('unit_desc', 'dept_id', 'penyelia_id'))
							->where('unit_id = ?', $this->_getParam('id'))
													
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
            'unit_desc' => Zend_Filter::filterStatic($values['txt_unit_name'], 'HtmlEntities'),
            'dept_id' => Zend_Filter::filterStatic($values['sel_bahagian'], 'HtmlEntities'),
            'penyelia_id' => Zend_Filter::filterStatic($values['sel_penyelia'], 'HtmlEntities')
        );
        $where[] = "unit_id = '".$this->_getParam('id')."'";
		$db->update('ea_unit', $data, $where );
        
        $this->view->entrySaved = true;

    }
    
	public function deleteAction()
    {
    	$db = Zend_Registry::get ( 'db' );
		$id = $this->_request->getParam('id');
    	$where = 'unit_id = "' . $id . '"';
		$db->delete ( 'ea_unit', $where );
		$this->view->entrySaved = true;
		$this->_redirect('/admin/unit/list');
    }
    
	protected function _repopulateForm($form, $item)
    {
    	$date = new Spt_Includes_Date;
    	
    	$values = array(
        	'txt_unit_name' => $this->_reverseAutoFormat($item['unit_desc']),
        	'sel_bahagian' => $this->_reverseAutoFormat($item['dept_id']),
        	'sel_penyelia' => $this->_reverseAutoFormat($item['penyelia_id'])
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
		$sql = 'SELECT * FROM sys_user WHERE role_id = "12"';
		$result = $db->fetchAll($sql);
		$dojoData= new Zend_Dojo_Data('usr_id',$result,'usr_id');
		echo $dojoData->toJson();
		exit;
	}
}

?>