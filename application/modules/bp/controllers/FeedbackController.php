<?php 

class Bp_FeedbackController extends Spt_Controller_Action
{

	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/bp/feedback/list');
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
		
		//title head
		$title = new Spt_Includes_Title;
		$title_label = "Senarai Maklumbalas";
		$title_head = "head-customer";
		$this->view->title = $title->func_createTitle($title_label,$title_head);
		
		//column
		$arr_col = array('u.usr_fullname' => 'Nama','m.msg_feedback' => 'Maklumbalas','m.msg_datetime' => 'Tarikh');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('u.usr_fullname' => 'Nama','m.msg_feedback' => 'Maklumbalas','m.msg_datetime' => 'Tarikh');
		
		//legend
		$legend = new Spt_Includes_Legend;
		$legend_id = 'm.msg_datetime'; //legend key
		$arr_legend = array('field'=>$legend_id,
			'item'=>array(
				1 => array('label'=>'Permohonan 1-2 hari','class'=>'contents_warning_1','min'=>'0','max'=>'172800'),
				2 => array('label'=>'Permohonan 3-4 hari','class'=>'contents_warning_3','min'=>'172801','max'=>'345600'),
				3 => array('label'=>'Permohonan 5 hari','class'=>'contents_warning_4','min'=>'345601','max'=>'432000'),
				4 => array('label'=>'Permohonan Melebihi 5 hari','class'=>'contents_warning_2','min'=>'432001','max'=>'')
			)
		);
		$this->view->legend = $legend->func_createLegend($arr_legend);
		
		$xtvt_id = 't.tiket_id'; //aktiviti key
		$status_id = 't.tiket_status'; //status key
		//$this->title = $this->translate()->_("Senarai Permohonan Tempahan Bilik Mesyuarat / Perbincangan");
		//$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		
		$grid->from('tbl_maklumbalas_tiket t LEFT OUTER JOIN tbl_maklumbalas_msg m ON t.tiket_id=m.tiket_id
					LEFT OUTER JOIN sys_user u ON t.tiket_user_id=u.usr_id'
					);
		$grid->table( array ( 
				't' => 'tbl_maklumbalas_tiket', 
				'm' => 'tbl_maklumbalas_msg', 
				'u' => 'sys_user'
			));
		//$grid->where('t.tiket_status=2');
		$grid->activityId ( $xtvt_id );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
		 if (!array_key_exists($status_id, $arr_col_1)) {
			$grid->addColumn($status_id,array('hide'=>1));
		} 
		if (!array_key_exists($legend_id, $arr_col_1)) {
			$grid->addColumn($legend_id,array('hide'=>1));
		}
		
		$grid->order('t.tiket_datetime DESC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
        $grid->setTemplate ( 'test', 'table' );
       // $grid->setLegend($arr_legend);
		
		$icon = new Spt_Includes_Icon;
		$icon1 = $icon->func_createIcon('view.png','_self','Papar Maklumbalas',SYSTEM_URL.'/bp/feedback/view');
		$icon2 = $icon->func_createIcon('edit.png','_self','Balas Maklumbalas',SYSTEM_URL.'/bp/feedback/reply','0');
		//$icon3 = $icon->func_createIcon('edit.png','_self','Kemaskini Permohonan',SYSTEM_URL.'/tempahan/new/kelulusan','2');
		$icon = array($icon1,$icon2);
		$grid->otherIcons($icon);
		$grid->setIconController($status_id);

		$grid->export = array('pdf','print');
		
        $this->view->pages = $grid->deploy ();
        $this->render ( 'list' );
	}
	
	public function listuserAction()
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
		
		//title head
		$title = new Spt_Includes_Title;
		$title_label = "Senarai Maklumbalas";
		$title_head = "head-customer";
		$this->view->title = $title->func_createTitle($title_label,$title_head);
		
		//column
		$arr_col = array('u.usr_fullname' => 'Nama','m.msg_feedback' => 'Maklumbalas','m.msg_datetime' => 'Tarikh');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('u.usr_fullname' => 'Nama','m.msg_feedback' => 'Maklumbalas','m.msg_datetime' => 'Tarikh');
		
		//legend
		$legend = new Spt_Includes_Legend;
		$legend_id = 'm.msg_datetime'; //legend key
		$arr_legend = array('field'=>$legend_id,
			'item'=>array(
				1 => array('label'=>'Permohonan 1-2 hari','class'=>'contents_warning_1','min'=>'0','max'=>'172800'),
				2 => array('label'=>'Permohonan 3-4 hari','class'=>'contents_warning_3','min'=>'172801','max'=>'345600'),
				3 => array('label'=>'Permohonan 5 hari','class'=>'contents_warning_4','min'=>'345601','max'=>'432000'),
				4 => array('label'=>'Permohonan Melebihi 5 hari','class'=>'contents_warning_2','min'=>'432001','max'=>'')
			)
		);
		$this->view->legend = $legend->func_createLegend($arr_legend);
		
		$xtvt_id = 't.tiket_id'; //aktiviti key
		$status_id = 't.tiket_status'; //status key
		//$this->title = $this->translate()->_("Senarai Permohonan Tempahan Bilik Mesyuarat / Perbincangan");
		//$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		
		$grid->from('tbl_maklumbalas_tiket t LEFT OUTER JOIN tbl_maklumbalas_msg m ON t.tiket_id=m.tiket_id
					LEFT OUTER JOIN sys_user u ON t.tiket_user_id=u.usr_id'
					);
		
		$grid->table( array ( 
				't' => 'tbl_maklumbalas_tiket', 
				'm' => 'tbl_maklumbalas_msg', 
				'u' => 'sys_user'
			));
		$grid->where('t.tiket_user_id LIKE "'.Zend_Auth::getInstance()->getIdentity()->usr_id.'"');
		//$grid->where('t.tiket_status=2');
		$grid->activityId ( $xtvt_id );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
		 if (!array_key_exists($status_id, $arr_col_1)) {
			$grid->addColumn($status_id,array('hide'=>1));
		} 
		if (!array_key_exists($legend_id, $arr_col_1)) {
			$grid->addColumn($legend_id,array('hide'=>1));
		}
		
		$grid->order('t.tiket_datetime DESC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
        $grid->setTemplate ( 'test', 'table' );
       // $grid->setLegend($arr_legend);
		
		$icon = new Spt_Includes_Icon;
		$icon1 = $icon->func_createIcon('view.png','_self','Papar Maklumbalas',SYSTEM_URL.'/bp/feedback/view');
		//$icon2 = $icon->func_createIcon('edit.png','_self','Balas Maklumbalas',SYSTEM_URL.'/bp/feedback/reply','1');
		//$icon3 = $icon->func_createIcon('edit.png','_self','Kemaskini Permohonan',SYSTEM_URL.'/tempahan/new/kelulusan','2');
		$icon = array($icon1);
		$grid->otherIcons($icon);
		$grid->setIconController($status_id);

		$grid->export = array('pdf','print');
		
        $this->view->pages = $grid->deploy ();
        $this->render ( 'listuser' );
	}
	
	public function viewAction()
	{
		$db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		$date = new Spt_Includes_Date;
		
		$rowset = $db->fetchRow(
			$db->select()
				->from(array('u' => 'sys_user'),
					array('usr_fullname', 'usr_email', 'usr_identno'))
				->join(array('d' => 'sys_user_detail'),
					'd.usr_id = u.usr_id')
				->joinLeft(array('p' => 'sys_user_pesara'),
					'p.pesara_userid = u.usr_id')	
				->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
		);
		
		$query = 'SELECT t.tiket_id, t.tiket_datetime, m.msg_feedback, m.msg_user_id, u.usr_fullname
					FROM tbl_maklumbalas_tiket AS t
					LEFT OUTER JOIN tbl_maklumbalas_msg AS m 
					ON t.tiket_id=m.tiket_id
					LEFT OUTER JOIN sys_user AS u
					ON m.msg_user_id=u.usr_id
					WHERE t.tiket_id = '.$this->_getParam('id');
					
		$this->view->feedback = $db->fetchAll($query);
		$this->view->tiket_id = $this->_getParam('id');
		/* echo '<pre>';
		print_r($rowset);
		echo '</pre>'; */
		$this->view->func = new Pesara;
		
		$this->view->rowset = $rowset;
		$this->view->date = $date;
	}
	
	public function addAction()
	{
		$db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		
		$date = new Spt_Includes_Date;
		
		$rowset = $db->fetchRow(
			$db->select()
				->from(array('u' => 'sys_user'),
					array('usr_fullname', 'usr_email', 'usr_identno'))
				->join(array('d' => 'sys_user_detail'),
					'd.usr_id = u.usr_id')
				->joinLeft(array('p' => 'sys_user_pesara'),
					'p.pesara_userid = u.usr_id')	
				->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
		);
		//echo Zend_Auth::getInstance()->getIdentity()->usr_id;
		//print_r($rowset);
		$this->view->func = new Pesara;
		
		$this->view->rowset = $rowset;
		$this->view->date = $date;
		
		$form = new Spt_Form_Bp_FeedbackAdd;
		
		if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
		
		$values = $form->getValues();
		
		//print_r($values);
		
		$data = array(
			'tiket_user_id' => Zend_Filter::get(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
			'tiket_datetime' => date('Y-m-d H:i:s')
		);
		$db->insert('tbl_maklumbalas_tiket', $data);
		$id = $db->lastInsertId();
		
		$table = new MaklumbalasMsg;
			$data = array(
				'msg_feedback' => Zend_Filter::get($values['feedback'], 'HtmlEntities'),
				'tiket_id' => $id,
				'msg_user_id' => Zend_Filter::get(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'msg_datetime' => date('Y-m-d H:i:s')
			);
			$table->insert($data);
			
		$this->view->profilSaved = true;
		
		//die();
	}
	
}

?>