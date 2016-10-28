<?php 

class Admin_MenuController extends Spt_Controller_Action
{
	public function indexAction()
	{
		$this->_redirect('/admin/menu/list');
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
		$arr_col = array('m.menu_id' => 'Id Menu','m.menu_name' => 'Menu','mt.menu_type_name' => 'Jenis');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('m.menu_id' => 'Id Menu','m.menu_name' => 'Menu','mt.menu_type_name' => 'Jenis');
		
		$xtvt_id = 'm.menu_id'; //aktiviti key
		$this->title = $this->translate()->_("Senarai Menu");
		$grid = $this->grid ( 'table' );
		$grid->from('tbl_menu m INNER JOIN tbl_menu_type mt ON m.menu_type_id = mt.menu_type_id');
		$grid->table( array ( 'm' => 'tbl_menu', 'mt' => 'tbl_menu_type' ) );
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
		$grid->editButton ( true, $this->translate()->_("Kemaskini Menu"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/menu/edit' );
		$grid->deleteButton ( true, $this->translate()->_("Hapus Menu"), Zend_Controller_Front::getInstance()->getBaseUrl().'/admin/menu/delete' );
        
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
		
		$form = new Spt_Form_Admin_Menu_Add;

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
            'menu_name' => $values['txt_menu_name'],
        	'menu_type_id' => $values['sel_menu_type']
        );
		$db->insert('tbl_menu', $data);
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
    	$form = new Spt_Form_Admin_Menu_Edit;
		
		$this->view->translate = Zend_Registry::get ( 'translate' );
		
    	$db = Zend_Registry::get ( 'db' );
    	
    	if (!$this->getRequest()->isPost()) {
            $rowset = $db->fetchRow(
					$db->select()
							->from(array('m' => 'tbl_menu'),
								array('menu_name', 'menu_type_id'))
							->where('menu_id = ?', $this->_getParam('id'))
													
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
            'menu_name' => Zend_Filter::get($values['txt_menu_name'], 'HtmlEntities'),
        	'menu_type_id' => $values['sel_menu_type']
        );
        $where[] = "menu_id = '".$this->_getParam('id')."'";
		$db->update('tbl_menu', $data, $where );
        
        $this->view->entrySaved = true;

    }
    
	public function deleteAction()
    {
    	$db = Zend_Registry::get ( 'db' );
		$id = $this->_request->getParam('id');
    	$where = 'menu_id = "' . $id . '"';
		$db->delete ( 'tbl_menu', $where );
		$this->view->entrySaved = true;
		$this->_redirect('/admin/menu/list');
    }
    
	protected function _repopulateForm($form, $item)
    {
    	$date = new Spt_Includes_Date;
    	
    	$values = array(
        	'txt_menu_name' => $this->_reverseAutoFormat($item['menu_name']),
			'sel_menu_type' => $this->_reverseAutoFormat($item['menu_type_id'])
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