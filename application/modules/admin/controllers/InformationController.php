<?php 

class Admin_InformationController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/admin/information/list');
	}
	
	public function listAction()
	{
		$this->view->translate = $this->translate();
		$pagingNo = Zend_Controller_Front::getInstance()->getRequest()->getParam('paging');
		if($pagingNo <> '')
			$pagingNo = Zend_Controller_Front::getInstance()->getRequest()->getParam('paging');
		else
			$pagingNo = 10;
		
		//column
		$arr_col = array('ipage_id' => 'ID','ipage_name' => 'Nama','ipage_desc' => 'Keterangan');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('ipage_name' => 'Nama','ipage_desc' => 'Keterangan');
		
		$xtvt_id = 'ipage_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Informasi");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('sys_information_page');
		$grid->activityId ( 'ipage_id' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('ipage_id ASC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$filters = new Bvb_Grid_Filters ( );
        $filters->addFilter ( 'ipage_name' )
        ->addFilter ( 'ipage_desc');
        
        $grid->addFilters ( $filters ); 
		
        $grid->setTemplate ( 'work', 'table' );
        $grid->viewButton ( true, $this->translate()->_("Papar Pengguna"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/information/view' );
		$grid->editButton ( true, $this->translate()->_("Kemaskini Pengguna"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/information/edit' );
		
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
	/*
	public function addAction()
	{
		$db = Zend_Registry::get ( 'db' );
		
		$form = new Spt_Form_Page_Add;
		
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
		
        $table = new SysInformationPage;
        $data = array(
			'ipage_name' => Zend_Filter::get($values['namapenganjur'], 'HtmlEntities'),
            'ipage_desc' => $values['alamatpenganjur'],
            'aktif_id' => $values['status']
        );
		$db->insert('sys_penganjur', $data);
        $this->view->entrySaved = true;
	}
	*/
	public function editAction()
	{
		$form = new Spt_Form_Admin_Page_Edit;

		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
    	
    	if (!$this->getRequest()->isPost()) {
            $rowset = $db->fetchRow(
					$db->select()
							->from(array('i' => 'sys_information_page'),
								array('ipage_id', 'ipage_name', 'ipage_desc', 'ipage_content'))
							->where( 'ipage_id = ?', $this->_getParam('id') )
													
			);
            if (count($rowset) == 0) {
                $this->view->failedFind = true;
                return;
            }
            $this->view->rowset = $rowset;
            $form->setElementFilters(array()); // disable all element filters
            $this->_repopulateForm($form, $rowset);
			$this->view->page_content = $this->_reverseAutoFormat($rowset['ipage_content']);
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
        //die($_POST['page_content']);
		$table = new SysInformationPage;
        $data = array(
            'ipage_name' => $values['page_name'],
        	'ipage_desc' => $values['page_desc'],
        	'ipage_content' => $_POST['page_content']
        );
        $table->update($data,
            $table->getAdapter()->quoteInto('ipage_id = ?', $this->_getParam('id'))
        );
        
        $this->view->entrySaved = true;
	}
	
	public function viewAction()
    {
		$this->view->translate = $this->translate();
		
    	$db = Zend_Registry::get ( 'db' );
    	
    	if (!$this->getRequest()->isPost()) {
            $rowset = $db->fetchRow(
					$db->select()
							->from(array('p' => 'sys_information_page'),
								array('ipage_id', 'ipage_name', 'ipage_desc', 'ipage_content'))
							->where( 'ipage_id = ?', $this->_getParam('id') )
			);

            if (count($rowset) == 0) {
                $this->view->failedFind = true;
                return;
            }
            $this->view->rowset = $rowset;
        }
    }
	
	protected function _repopulateForm($form, $item)
    {
    	$values = array(
        	'page_name' => $this->_reverseAutoFormat($item['ipage_name']),
        	'page_desc' => $this->_reverseAutoFormat($item['ipage_desc']),
    		'page_content' => $this->_reverseAutoFormat($item['ipage_content'])
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