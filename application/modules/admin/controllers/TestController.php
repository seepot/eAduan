<?php 

class Admin_TestController extends Spt_Controller_Action
{
	public function test1Action()
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
		$title_label = "Senarai Permohonan Lesen Baru Pemandu Pelancong";
		$title_head = "head-customer";
		$this->view->title = $title->func_createTitle($title_label,$title_head);
		
		//column
		$arr_col = array('a.appl_id' => 'No Permohonan','a.appl_nama_penuh' => 'Nama Pemandu Pelancong','t.tg_type_name' => 'Jenis', 'a.appl_date'=>'Tarikh Permohonan', 's.appl_status_name' => 'Status');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('a.appl_id' => 'No Permohonan','a.appl_nama_penuh' => 'Nama Pemandu Pelancong','t.tg_type_name' => 'Jenis', 'a.appl_date'=>'Tarikh Permohonan', 's.appl_status_name' => 'Status');
		
		//legend
		$legend = new Spt_Includes_Legend;
		$arr_legend = array('field'=>'a.appl_date',
			'item'=>array(
				1 => array('label'=>'Permohonan 1-2 hari','class'=>'contents_warning_1','min'=>'0','max'=>'172800'),
				2 => array('label'=>'Permohonan 3-4 hari','class'=>'contents_warning_3','min'=>'172801','max'=>'345600'),
				3 => array('label'=>'Permohonan 5 hari','class'=>'contents_warning_4','min'=>'345601','max'=>'432000'),
				4 => array('label'=>'Permohonan Melebihi 5 hari','class'=>'contents_warning_2','min'=>'432001','max'=>'')
			)
		);
		$this->view->legend = $legend->func_createLegend($arr_legend);
		
		$xtvt_id = 'a.appl_id'; //aktiviti key
		$status_id = 'a.status_id'; //status key
		$this->title = $this->translate()->_("Senarai Permohonan Lesen Baru Pemandu Pelancong");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		
		$grid->from('(tbl_tg_application a LEFT JOIN sys_tg_type t ON a.tg_type_id=t.tg_type_id) INNER JOIN tbl_tg_application_status s ON a.status_id=s.appl_status_id');
		$grid->table( array ( 'a' => 'tbl_tg_application', 't' => 'sys_tg_type', 's' => 'tbl_tg_application_status' ) );
		$grid->activityId ( 'a.appl_id' );
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
			
		$grid->order('a.appl_date DESC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
        $grid->setTemplate ( 'work', 'table' );
        $grid->setLegend($arr_legend);
		$icon = new Spt_Includes_Icon;
		$icon1 = $icon->func_createIcon('view.png','_self','Papar Permohonan',SYSTEM_URL.'/tg/new/view');
		$icon2 = $icon->func_createIcon('edit.png','_self','Kemaskini Permohonan',SYSTEM_URL.'/tg/new/applyview','1');
		$icon3 = $icon->func_createIcon('edit.png','_self','Semakan',SYSTEM_URL.'/tg/new/semakan','2');
		$icon4 = $icon->func_createIcon('edit.png','_self','Syor/Ulasan',SYSTEM_URL.'/admin/user/view','3');
		$icon5 = $icon->func_createIcon('edit.png','_self','Perakuan',SYSTEM_URL.'/admin/user/view','4');
		$icon6 = $icon->func_createIcon('edit.png','_self','Kelulusan',SYSTEM_URL.'/admin/user/view','5');
		$icon7 = $icon->func_createIcon('print.gif','_self','Cetak Surat Kelulusan',SYSTEM_URL.'/admin/user/view','6');
		$icon8 = $icon->func_createIcon('print.gif','_self','Cetak Sijil',SYSTEM_URL.'/admin/user/view','6');
		$icon9 = $icon->func_createIcon('edit.png','_self','Serahan',SYSTEM_URL.'/admin/user/view','6');
		$icon10 = $icon->func_createIcon('print.gif','_self','Cetak Surat Tidak Lulus',SYSTEM_URL.'/admin/user/view','8');
		$icon = array($icon1,$icon2,$icon3,$icon4,$icon5,$icon6,$icon7,$icon8,$icon9,$icon10);
		$grid->otherIcons($icon);
		$grid->setIconController($status_id);

		$grid->export = array('pdf','print');
		
        $this->view->pages = $grid->deploy ();
        $this->render ( 'test1' );
	}
}

?>