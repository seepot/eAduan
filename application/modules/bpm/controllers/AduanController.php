<?php 

class Bpm_AduanController extends Spt_Controller_Action
{

	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		
		if ($defSession->role == 5 || $defSession->role == 6){
			$this->_redirect('/bp/penyata/carian');
		} else if ($defSession->role == 2 || $defSession->role == 3){
			$this->view->translate = $this->translate();
			$this->view->func = new Pesara;
			
			$db = Zend_Registry::get ( 'db' );
			$db->setFetchMode(Zend_Db::FETCH_OBJ);
			
			$this->view->rowset = $db->fetchRow(
				$db->select()
					->from(array('u' => 'sys_user'),
						array('usr_fullname', 'usr_email', 'usr_identno'))
					->join(array('d' => 'sys_user_detail'),
						'd.usr_id = u.usr_id')
					->joinLeft(array('p' => 'sys_user_pesara'),
						'p.pesara_userid = u.usr_id')	
					->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
			);
		}
	}
	
	public function transactionAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		
		$this->view->translate = $this->translate();
		
		$pagingNo = Zend_Controller_Front::getInstance()->getRequest()->getParam('paging');
		if($pagingNo <> '')
			$pagingNo = $defSession->paging = Zend_Controller_Front::getInstance()->getRequest()->getParam('paging');
		elseif(isset($defSession->paging))
			$pagingNo = $defSession->paging;
		else
			$pagingNo = 15;
		$this->view->pagingNo = $pagingNo;
		
		//column
		$arr_col = array('p.aduan_id' => 'ID Aduan','u.usr_fullname' => 'Nama Pengadu','p.insert_date' => 'Tarikh Aduan',
		'p.aduan_ringkasan' => 'Ringkasan Aduan', 's.status_desc' => 'Status');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('p.aduan_id' => 'ID Aduan','u.usr_fullname' => 'Nama Pengadu','p.insert_date' => 'Tarikh Aduan',
			'p.aduan_ringkasan' => 'Ringkasan Aduan', 's.status_desc' => 'Status');
			
		$xtvt_id = 'p.aduan_id'; //aktiviti key
		$status_id = 'p.aduan_status'; //status key
		$this->title = $this->view->title = $this->translate()->_("Senarai Aduan");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('ea_aduan p INNER JOIN sys_user u ON p.insert_by=u.usr_id INNER JOIN ea_status s ON p.status = s.status_id ');
		
		//if ($defSession->role == 2 || $defSession->role == 13 || $defSession->role == 14):
		//if ($defSession->role == 2 || $defSession->role == 13 || $defSession->role == 14):
		if ($defSession->role == 1 ):
			$grid->where('p.insert_by LIKE "'.Zend_Auth::getInstance()->getIdentity()->usr_id.'"');
		endif;
		
		$grid->table( array ( 'p' => 'ea_aduan', 'u' => 'sys_user', 's' => 'ea_status') );
		$grid->activityId ( 'p.aduan_id' );
		foreach($arr_col_1 as $col=>$name){
			$grid->addColumn($col,array('title'=>$this->translate()->_($name)));
		}
		//hide aktiviti id jika tidak dipilih
		if (!array_key_exists($xtvt_id, $arr_col_1)) {
			$grid->addColumn($xtvt_id,array('hide'=>1));
		}
			
		$grid->order('p.aduan_id DESC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$grid->setTemplate ( 'test', 'table' );
		
		$icon = new Spt_Includes_Icon;
		$icon1 = $icon->func_createIcon('view.png','_self','Papar',SYSTEM_URL.'/bpm/aduan/view');
		$icon2 = $icon->func_createIcon('edit.png','_self','Kemaskini',SYSTEM_URL.'/bpm/aduan/edit','15');
		//$icon3 = $icon->func_createIcon('edit.png','_self','Kelulusan',SYSTEM_URL.'/bpm/aduan/penyelia','10');
		$icon = array($icon1,$icon2);
		$grid->otherIcons($icon);
		$grid->setIconController($status_id);
		
		$grid->export = array('pdf','print','csv');
		
        $this->view->pages = $grid->deploy ();
        $this->render ( 'transaction' );
	}
	
	public function sendAction()
	{
		$destination = "60126579487";
		$message = "Aduan telah dihantar untuk pengesahan dalam Sistem eAduan. Mohon tindakan selanjutnya.";
		$message = html_entity_decode($message, ENT_QUOTES, 'utf-8'); 
		$message = rawurlencode($message);
	   
		$username = rawurlencode("achik_amiez");
		$password = rawurlencode("@miez850722");
		$sender_id = rawurlencode("66300");
		//$type = (int)$_POST['type'];
		$type = '2';

		$fp = "https://www.isms.com.my/isms_send.php";
		$fp .= "?un=$username&pwd=$password&dstno=$destination&msg=$message&type=$type&sendid=$sender_id";
		//echo $fp;
		//die();
		//Hantar sms
		//$result = $this->ismscURL($fp);
		    
		//Sample Response 
		/*if($result) { //Message Success 
			echo 'Berjaya'; 
		} else { //Message Failed 
			echo 'Gagal'.'<br />'; 
			 
		} */
	}
	
	public function addAction()
	{
		$db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		$this->view->title = 'Borang Aduan Bahagian Pengurusan Maklumat JHEV';
					
		$form = new Spt_Form_Aduan_Baru;
		//$this->view->aduan = $aduan = $this->getAduan($this->_getParam('id'));
		$this->view->function = new Spt_Includes_Function();
		$this->view->id = $this->_getParam('id');
		
		//print_r(Zend_Auth::getInstance()->getIdentity());
		$unit = new Unit();
		
		$this->view->unit =  $unit->getUnitOptions();
		
		
		if (!$this->getRequest()->isPost()) {
            if($this->_getParam('id') <> 0 || $this->_getParam('id') <> ''){
				//$this->_repopulateForm($form, $pesara, 'pemohon');
			}
			$this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
			
			$this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
		
		//$values = $_POST;
		$values = $form->getValues();
		//echo $_POST['file_upload'];
		//die();
		$filename = NULL;
		if(isset($_POST['file_upload'])){
			if ($_FILES["file"]["error"] > 0)
			  {
			  //echo "Error: " . $_FILES["file"]["error"] . "<br />";
			  }
			else
			  {
			  $_FILES["file"]["name"] = Zend_Auth::getInstance()->getIdentity()->usr_id.$this->_findexts($_FILES["file"]["name"]);
			  /* echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			  echo "Type: " . $_FILES["file"]["type"] . "<br />";
			  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			  echo "Stored in: " . $_FILES["file"]["tmp_name"]; */
			  
			  $filename = date('Ymd').'-'.$this->_findexts($_FILES["file"]["name"]);
			  
			  if (file_exists(UPLOAD_PATH."aduan/" . $_FILES["file"]["name"]))
				  {
				  echo $_FILES["file"]["name"] . " already exists. ";
				  }
				else
				  {
				  
				  move_uploaded_file($_FILES["file"]["tmp_name"],
				  UPLOAD_PATH."aduan/" . $filename);
				  //echo "Stored in: " . UPLOAD_PATH."aduan/" . $_FILES["file"]["name"];
				  }
				}
			//echo 'xx';

		}
		//die();
		$penyelia = $this->view->function->getPenyeliaByUserId(Zend_Auth::getInstance()->getIdentity()->usr_id);
		//die();
		$data = array(
			'aduan_bpm'	=> Zend_Filter::filterStatic($values['sel_unit'], 'HtmlEntities'), 
			'aduan_kategorimasalah'	=> Zend_Filter::filterStatic($values['sel_katmasalah'], 'HtmlEntities'), 
			'aduan_lokasi'	=> Zend_Filter::filterStatic($values['sel_lokasimasalah'], 'HtmlEntities'), 
			'aduan_ringkasan'	=> Zend_Filter::filterStatic($values['txt_ringkasan'], 'HtmlEntities'), 
			'aduan_hadpelulus'	=> Zend_Filter::filterStatic($values['txt_hadpelulus'], 'HtmlEntities'), 
			'aduan_lampiran'	=> Zend_Filter::filterStatic($filename, 'HtmlEntities'), 
			'aduan_tarikh'	=> Zend_Filter::filterStatic($values['date_tarikhmasalah'], 'HtmlEntities'), 
			'penyelia_user'	=> Zend_Filter::filterStatic($penyelia, 'HtmlEntities'), 
			'insert_by'	=> Zend_Auth::getInstance()->getIdentity()->usr_id, 
			'insert_date'	=> date('Y-m-d H:i:s'), 
			'status'	=> '10'
			);
		
		$destination = "6".$this->view->function->getMobileNoById($penyelia);
		//die();
		//ISMS.com.my
		//$destination = "60125374226";
		//$destination = "60126579487";
		$message = "Aduan telah dihantar untuk pengesahan dalam Sistem eAduan. Mohon tindakan selanjutnya.";
		$message = html_entity_decode($message, ENT_QUOTES, 'utf-8'); 
		$message = urlencode($message);
	   
		$username = urlencode("achik_amiez");
		$password = urlencode("@miez850722");
		$sender_id = urlencode("66300");
		//$type = (int)$_POST['type'];
		$type = '2';

		$fp = "https://www.isms.com.my/isms_send.php";
		$fp .= "?un=$username&pwd=$password&dstno=$destination&msg=$message&type=$type&sendid=$sender_id";
		//echo $fp;
		//die();
		$result = $this->ismscURL($fp);
		//echo $result;
		
		
		$db->insert('ea_aduan', $data);
		$id = $db->lastInsertId();
		
		$table = new AudiTrail;
		$data = array(
			'usr_id' => Zend_Filter::filterStatic(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
			'audit_trail_module' => Zend_Filter::filterStatic('Aduan', 'HtmlEntities'),
			'audit_trail_task' => Zend_Filter::filterStatic('Aduan Baru ID : '.$id.' - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
			'audit_trail_datetime' => date('Y-m-d H:i:s'),
			'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
		);
		$table->insert($data);
		
		$this->view->entrySaved = true;
		
		echo '<script language="Javascript">';
		echo 'location.href="'.SYSTEM_URL.'/bpm/aduan/transaction';
		echo '</script>';
		
		//echo '<pre>';
		//print_r($values);
		//echo '</pre>';
		//die();
	}
	
	public function viewAction()
	{
		$db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		$this->view->title = 'Borang Aduan Bahagian Pengurusan Maklumat JHEV';
					
		$this->view->func_tab = $this->func_tab(0);
		$this->view->aduan = $aduan = $this->getAduan($this->_getParam('id'));
		$this->view->function = new Spt_Includes_Function();
		$this->view->cronology = $this->func_cronology($aduan);
		
	}
	public function penyelialistAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		$function = new Spt_Includes_Function;
		$this->view->translate = $this->translate();
		
		$pagingNo = Zend_Controller_Front::getInstance()->getRequest()->getParam('paging');
		if($pagingNo <> '')
			$pagingNo = $defSession->paging = Zend_Controller_Front::getInstance()->getRequest()->getParam('paging');
		elseif(isset($defSession->paging))
			$pagingNo = $defSession->paging;
		else
			$pagingNo = 15;
		$this->view->pagingNo = $pagingNo;
		
		//column
		$arr_col = array('p.aduan_id' => 'ID Aduan','u.usr_fullname' => 'Nama Pengadu','p.insert_date' => 'Tarikh Aduan','p.aduan_ringkasan' => 'Ringkasan Aduan');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('p.aduan_id' => 'ID Aduan','u.usr_fullname' => 'Nama Pengadu','p.insert_date' => 'Tarikh Aduan','p.aduan_ringkasan' => 'Ringkasan Aduan');
		
		//legend
		$legend = new Spt_Includes_Legend;
		$legend_id = 'p.insert_date'; //legend key
		$arr_legend = array('field'=>$legend_id,
			'item'=>array(
				1 => array('label'=>'Permohonan 1-2 hari','class'=>'contents_warning_1','min'=>'0','max'=>'172800'),
				2 => array('label'=>'Permohonan 3-4 hari','class'=>'contents_warning_3','min'=>'172801','max'=>'345600'),
				3 => array('label'=>'Permohonan 5 hari','class'=>'contents_warning_4','min'=>'345601','max'=>'432000'),
				4 => array('label'=>'Permohonan Melebihi 5 hari','class'=>'contents_warning_2','min'=>'432001','max'=>'')
			)
		);
		$this->view->legend = $legend->func_createLegend($arr_legend);
		
		$xtvt_id = 'p.aduan_id'; //aktiviti key
		$status_id = 'p.status'; //status key
		$this->title = $this->view->title = $this->translate()->_("Senarai Aduan");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('ea_aduan p INNER JOIN sys_user u ON p.insert_by=u.usr_id INNER JOIN sys_user_detail d ON p.insert_by=d.usr_id ');
		$grid->where('p.status LIKE "10"');
		
		if ($defSession->role <> 2):
			$grid->where('p.penyelia_user LIKE "'.Zend_Auth::getInstance()->getIdentity()->usr_id.'"');
		endif;
		
		//$grid->Or('p.pangkat LIKE "0"');
		//$grid->Or('p.band LIKE "0"');
		//$grid->Or('p.ttp LIKE ""');
		$grid->table( array ( 'p' => 'ea_aduan', 'u' => 'sys_user') );
		$grid->activityId ( 'p.aduan_id' );
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
		$grid->order('p.aduan_id DESC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$grid->setLegend($arr_legend);
		$grid->setTemplate ( 'test', 'table' );
		
		$icon = new Spt_Includes_Icon;
		$icon1 = $icon->func_createIcon('view.png','_self','Papar',SYSTEM_URL.'/bpm/aduan/view');
		$icon2 = $icon->func_createIcon('edit.png','_self','Kelulusan',SYSTEM_URL.'/bpm/aduan/penyelia','10');
		$icon = array($icon1,$icon2);
		$grid->otherIcons($icon);
		$grid->setIconController($status_id);
		
		$grid->export = array('pdf','print','csv');
		
        $this->view->pages = $grid->deploy ();
        $this->render ( 'penyelialist' );
	}
	
	public function penyeliaAction()
	{
		$db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		$this->view->title = 'Borang Aduan Bahagian Pengurusan Maklumat JHEV';
					
		$this->view->func_tab = $this->func_tab(0);
		$form = new Spt_Form_Aduan_Penyelia;
		$this->view->aduan = $aduan = $this->getAduan($this->_getParam('id'));
		$this->view->function = $function = new Spt_Includes_Function();
		//print_r($aduan->aduan_bpm);
		if (!$this->getRequest()->isPost()) {
            if($this->_getParam('id') <> 0 || $this->_getParam('id') <> ''){
				//$this->_repopulateForm($form, $aduan, 'pemohon');
			}
			$this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
			
			$this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
		
		//$values = $_POST;
		$values = $form->getValues();
		
		$pegawai = $function->getPegawaiById($aduan->aduan_bpm);
		//die();
		if ($values['chk_pengesahan'] == 1){
			$status = '20';
		} else {
			$status = '15';
			$pegawai = '';
		}
		$data = array(
			'penyelia_pengesahan'	=> Zend_Filter::filterStatic($values['chk_pengesahan'], 'HtmlEntities'), 
			'penyelia_catatan'	=> Zend_Filter::filterStatic($values['txt_catatan'], 'HtmlEntities'), 
			'pegawai_user'	=> Zend_Filter::filterStatic($pegawai, 'HtmlEntities'), 
			'penyelia_user'	=> Zend_Auth::getInstance()->getIdentity()->usr_id,  
			'penyelia_date'	=> date('Y-m-d H:i:s'),
			'status'	=> $status
			);
		//print_r($data);
		//die();
		if($status == '20'){
			$destination = "6".$this->view->function->getMobileNoById($pegawai);
			//$destination = "60125374226";
			//$destination = "60126579487";
			$message = "Aduan telah dihantar untuk seliaan dalam Sistem eAduan. Mohon tindakan selanjutnya.";
			$message = html_entity_decode($message, ENT_QUOTES, 'utf-8'); 
			$message = urlencode($message);
		   
			$username = urlencode("achik_amiez");
			$password = urlencode("@miez850722");
			$sender_id = urlencode("66300");
			//$type = (int)$_POST['type'];
			$type = '2';

			$fp = "https://www.isms.com.my/isms_send.php";
			$fp .= "?un=$username&pwd=$password&dstno=$destination&msg=$message&type=$type&sendid=$sender_id";
			//echo $fp;
			//die();
			$result = $this->ismscURL($fp);
			//echo $result;
		}
		$where[] = "aduan_id = '".$this->_getParam('id')."'";
		$db->update('ea_aduan', $data, $where);
		$id = $this->_getParam('id');
		
		$table = new AudiTrail;
		$data = array(
			'usr_id' => Zend_Filter::filterStatic(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
			'audit_trail_module' => Zend_Filter::filterStatic('Aduan', 'HtmlEntities'),
			'audit_trail_task' => Zend_Filter::filterStatic('Pengesahan Aduan ID : '.$id.' - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
			'audit_trail_datetime' => date('Y-m-d H:i:s'),
			'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
		);
		$table->insert($data);
		
		$this->view->entrySaved = true;
		/*
		echo '<script language="Javascript">';
		echo 'location.href="'.SYSTEM_URL.'/bpm/aduan/penyelialist';
		echo '</script>';
		*/
		/*echo '<pre>';
		print_r($data);
		echo '</pre>';*/
	}
	
	public function pegawailistAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		
		$this->view->translate = $this->translate();
		
		$pagingNo = Zend_Controller_Front::getInstance()->getRequest()->getParam('paging');
		if($pagingNo <> '')
			$pagingNo = $defSession->paging = Zend_Controller_Front::getInstance()->getRequest()->getParam('paging');
		elseif(isset($defSession->paging))
			$pagingNo = $defSession->paging;
		else
			$pagingNo = 15;
		$this->view->pagingNo = $pagingNo;
		
		//column
		$arr_col = array('p.aduan_id' => 'ID Aduan','u.usr_fullname' => 'Nama Pengadu','p.insert_date' => 'Tarikh Aduan','p.aduan_ringkasan' => 'Ringkasan Aduan');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('p.aduan_id' => 'ID Aduan','u.usr_fullname' => 'Nama Pengadu','p.insert_date' => 'Tarikh Aduan','p.aduan_ringkasan' => 'Ringkasan Aduan');
		
		//legend
		$legend = new Spt_Includes_Legend;
		$legend_id = 'p.penyelia_date'; //legend key
		$arr_legend = array('field'=>$legend_id,
			'item'=>array(
				1 => array('label'=>'Permohonan 1-2 hari','class'=>'contents_warning_1','min'=>'0','max'=>'172800'),
				2 => array('label'=>'Permohonan 3-4 hari','class'=>'contents_warning_3','min'=>'172801','max'=>'345600'),
				3 => array('label'=>'Permohonan 5 hari','class'=>'contents_warning_4','min'=>'345601','max'=>'432000'),
				4 => array('label'=>'Permohonan Melebihi 5 hari','class'=>'contents_warning_2','min'=>'432001','max'=>'')
			)
		);
		$this->view->legend = $legend->func_createLegend($arr_legend);
		
		$xtvt_id = 'p.aduan_id'; //aktiviti key
		$status_id = 'p.status'; //status key
		$this->title = $this->view->title = $this->translate()->_("Senarai Aduan");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('ea_aduan p INNER JOIN sys_user u ON p.insert_by=u.usr_id ');
		$grid->where('p.status = "20"');
		
		$function = new Spt_Includes_Function;
		//echo $function->getUnitBpmByUserId(Zend_Auth::getInstance()->getIdentity()->usr_id);
		//die();
		if ($defSession->role <> 2):
			//$grid->where('p.aduan_bpm LIKE "1"');
			//$grid->where('p.aduan_bpm = "'.$function->getUnitBpmByUserId(Zend_Auth::getInstance()->getIdentity()->usr_id).'"');
			$grid->where('p.pegawai_user = "'.Zend_Auth::getInstance()->getIdentity()->usr_id.'"');
		endif;
		
		$grid->table( array ( 'p' => 'ea_aduan', 'u' => 'sys_user') );
		$grid->activityId ( 'p.aduan_id' );
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
			
		$grid->order('p.aduan_id DESC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$grid->setLegend($arr_legend);
		$grid->setTemplate ( 'test', 'table' );
		
		$icon = new Spt_Includes_Icon;
		$icon1 = $icon->func_createIcon('view.png','_self','Papar',SYSTEM_URL.'/bpm/aduan/view');
		$icon2 = $icon->func_createIcon('edit.png','_self','Kelulusan',SYSTEM_URL.'/bpm/aduan/pegawai','20');
		$icon = array($icon1,$icon2);
		$grid->otherIcons($icon);
		$grid->setIconController($status_id);
		
		$grid->export = array('pdf','print','csv');
		
        $this->view->pages = $grid->deploy ();
        $this->render ( 'penyelialist' );
	}
	
	public function pegawaiAction()
	{
		$db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		$this->view->title = 'Borang Aduan Bahagian Pengurusan Maklumat JHEV';
					
		//$this->view->func_tab = $this->func_tab(0);
		$form = new Spt_Form_Aduan_Pegawai;
		$this->view->aduan = $aduan = $this->getAduan($this->_getParam('id'));
		$this->view->function = new Spt_Includes_Function();	
		
		if (!$this->getRequest()->isPost()) {
            if($this->_getParam('id') <> 0 || $this->_getParam('id') <> ''){
				//$this->_repopulateForm($form, $aduan, 'pemohon');
			}
			$this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
			
			$this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
		
		$values = $form->getValues();
		
		$data = array(
			'pegawai_kelulusan'	=> Zend_Filter::filterStatic($values['chk_kelulusan'], 'HtmlEntities'), 
			'pegawai_tahap'	=> Zend_Filter::filterStatic($values['chk_tahap'], 'HtmlEntities'), 
			'pegawai_unit'	=> Zend_Filter::filterStatic($values['sel_unit'], 'HtmlEntities'), 
			'pegawai_staf'	=> Zend_Filter::filterStatic($values['sel_staf'], 'HtmlEntities'), 
			'pegawai_catatan'	=> Zend_Filter::filterStatic($values['txt_catatan'], 'HtmlEntities'), 
			'pegawai_user'	=> Zend_Auth::getInstance()->getIdentity()->usr_id,  
			'pegawai_date'	=> date('Y-m-d H:i:s'),
			'status'	=> '30'
			);
		
		$destination = "6".$this->view->function->getMobileNoById($values['sel_staf']);
		//die();
		//$destination = "60125374226";
		//$destination = "60126579487";
		$message = "Aduan telah dihantar untuk tindakan dalam Sistem eAduan. Mohon tindakan selanjutnya.";
		$message = html_entity_decode($message, ENT_QUOTES, 'utf-8'); 
		$message = urlencode($message);
	   
		$username = urlencode("achik_amiez");
		$password = urlencode("@miez850722");
		$sender_id = urlencode("66300");
		//$type = (int)$_POST['type'];
		$type = '2';

		$fp = "https://www.isms.com.my/isms_send.php";
		$fp .= "?un=$username&pwd=$password&dstno=$destination&msg=$message&type=$type&sendid=$sender_id";
		//echo $fp;
		//die();
		//$result = $this->ismscURL($fp);
		//echo $result;
		
		$where[] = "aduan_id = '".$this->_getParam('id')."'";
		$db->update('ea_aduan', $data, $where);
		$id = $this->_getParam('id');
		
		$table = new AudiTrail;
		$data = array(
			'usr_id' => Zend_Filter::filterStatic(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
			'audit_trail_module' => Zend_Filter::filterStatic('Aduan', 'HtmlEntities'),
			'audit_trail_task' => Zend_Filter::filterStatic('Kelulusan Aduan ID : '.$id.' - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
			'audit_trail_datetime' => date('Y-m-d H:i:s'),
			'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
		);
		$table->insert($data);
		
		$this->view->entrySaved = true;
		
		echo '<script language="Javascript">';
		echo 'location.href="'.SYSTEM_URL.'/bpm/aduan/pegawailist';
		echo '</script>';
	}
	
	public function staflistAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		
		$this->view->translate = $this->translate();
		
		$pagingNo = Zend_Controller_Front::getInstance()->getRequest()->getParam('paging');
		if($pagingNo <> '')
			$pagingNo = $defSession->paging = Zend_Controller_Front::getInstance()->getRequest()->getParam('paging');
		elseif(isset($defSession->paging))
			$pagingNo = $defSession->paging;
		else
			$pagingNo = 15;
		$this->view->pagingNo = $pagingNo;
		
		//column
		$arr_col = array('p.aduan_id' => 'ID Aduan','u.usr_fullname' => 'Nama Pengadu','p.insert_date' => 'Tarikh Aduan','p.aduan_ringkasan' => 'Ringkasan Aduan');
		if(isset($_POST['sel_column']))
			$arr_col_1 = $this->func_column($arr_col,$_POST['sel_column']);
		elseif(isset($defSession->col))
			$arr_col_1 = $defSession->col;
		else
			$arr_col_1 = array('p.aduan_id' => 'ID Aduan','u.usr_fullname' => 'Nama Pengadu','p.insert_date' => 'Tarikh Aduan','p.aduan_ringkasan' => 'Ringkasan Aduan');
		
		//legend
		$legend = new Spt_Includes_Legend;
		$legend_id = 'p.pegawai_date'; //legend key
		$arr_legend = array('field'=>$legend_id,
			'item'=>array(
				1 => array('label'=>'Permohonan 1-2 hari','class'=>'contents_warning_1','min'=>'0','max'=>'172800'),
				2 => array('label'=>'Permohonan 3-4 hari','class'=>'contents_warning_3','min'=>'172801','max'=>'345600'),
				3 => array('label'=>'Permohonan 5 hari','class'=>'contents_warning_4','min'=>'345601','max'=>'432000'),
				4 => array('label'=>'Permohonan Melebihi 5 hari','class'=>'contents_warning_2','min'=>'432001','max'=>'')
			)
		);
		$this->view->legend = $legend->func_createLegend($arr_legend);
		
		$xtvt_id = 'p.aduan_id'; //aktiviti key
		$status_id = 'p.status'; //status key
		$this->title = $this->view->title = $this->translate()->_("Senarai Aduan");
		$this->view->url = $this->getUrl();
		$grid = $this->grid ( 'table' );
		$grid->from('ea_aduan p INNER JOIN sys_user u ON p.insert_by=u.usr_id ');
		$grid->where('p.status IN ("30","33","35")');
		
		if ($defSession->role <> 2):
			$grid->where('p.pegawai_staf = "'.Zend_Auth::getInstance()->getIdentity()->usr_id.'"');
		endif;
		
		$grid->table( array ( 'p' => 'ea_aduan', 'u' => 'sys_user') );
		$grid->activityId ( 'p.aduan_id' );
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
		$grid->order('p.aduan_id DESC')
			->setPagination ( $pagingNo )
			->listColumn($arr_col, $arr_col_1);
		
		$grid->setLegend($arr_legend);
		$grid->setTemplate ( 'test', 'table' );
		
		$icon = new Spt_Includes_Icon;
		$icon1 = $icon->func_createIcon('view.png','_self','Papar',SYSTEM_URL.'/bpm/aduan/view');
		$icon2 = $icon->func_createIcon('edit.png','_self','Tindakan',SYSTEM_URL.'/bpm/aduan/staf','30');
		$icon3 = $icon->func_createIcon('edit.png','_self','Tindakan',SYSTEM_URL.'/bpm/aduan/staf','33');
		$icon4 = $icon->func_createIcon('edit.png','_self','Tindakan',SYSTEM_URL.'/bpm/aduan/staf','35');
		$icon = array($icon1,$icon2,$icon3,$icon4);
		$grid->otherIcons($icon);
		$grid->setIconController($status_id);
		
		$grid->export = array('pdf','print','csv');
		
        $this->view->pages = $grid->deploy ();
        $this->render ( 'penyelialist' );
	}
	
	public function stafAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		//$defSession->newuser = true;
		//echo '<pre>';
		//print_r($defSession->newuser);
		//echo '<pre>';
		
		$db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		$this->view->title = 'Borang Aduan Bahagian Pengurusan Maklumat JHEV';
					
		$this->view->func_tab = $this->func_tab(0);
		$form = new Spt_Form_Aduan_Staf;
		$this->view->aduan = $aduan = $this->getAduan($this->_getParam('id'));
		$this->view->function = new Spt_Includes_Function();	
				
		if (!$this->getRequest()->isPost()) {
            if($this->_getParam('id') <> 0 || $this->_getParam('id') <> ''){
				$this->_repopulateForm($form, $aduan, 'staf');
			}
			$this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
			
			$this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
		
		//$values = $_POST;
		$values = $form->getValues();
		$filename = '';
		if(isset($_POST['file_upload'])){
			if ($_FILES["file"]["error"] > 0)
			  {
			  //echo "Error: " . $_FILES["file"]["error"] . "<br />";
			  }
			else
			  {
			  $_FILES["file"]["name"] = Zend_Auth::getInstance()->getIdentity()->usr_id.$this->_findexts($_FILES["file"]["name"]);
			  
			  $filename = date('Ymd').'-'.$this->_findexts($_FILES["file"]["name"]);
			  
			  if (file_exists(UPLOAD_PATH."aduan/" . $_FILES["file"]["name"]))
				  {
				  echo $_FILES["file"]["name"] . " already exists. ";
				  }
				else
				  {
				  
				  move_uploaded_file($_FILES["file"]["tmp_name"],
				  UPLOAD_PATH."aduan/" . $filename);
				  //echo "Stored in: " . UPLOAD_PATH."aduan/" . $_FILES["file"]["name"];
				  }
				}
			//echo 'xx';

		}
		//die();
		$data = array(
			'staf_status'	=> Zend_Filter::filterStatic($values['sel_status'], 'HtmlEntities'), 
			'staf_tindakan'	=> Zend_Filter::filterStatic($values['txt_tindakan'], 'HtmlEntities'), 
			'staf_lampiran'	=> Zend_Filter::filterStatic($filename, 'HtmlEntities'), 
			'staf_user'	=> Zend_Auth::getInstance()->getIdentity()->usr_id,  
			'staf_date'	=> date('Y-m-d H:i:s')
			);
		if ($values['sel_status'] == '1') {
			$data += array('status'	=> '80');
		} else if ($values['sel_status'] == '2') {
			$data += array('status'	=> '35');
		} else if ($values['sel_status'] == '3') {
			$data += array('status'	=> '33');
		}
		//echo '<pre>';
		//print_r($data);
		//echo '<pre>';
		//die();
		if ($values['sel_status'] == '1') {
			$destination = "6".$this->view->function->getMobileNoById($aduan->insert_by);
			//$destination = "60125374226";
			//$destination = "60126579487";
			$message = "Aduan ID [".$aduan->aduan_id."] telah berjaya diselesaikan.";
			$message = html_entity_decode($message, ENT_QUOTES, 'utf-8'); 
			$message = urlencode($message);
		   
			$username = urlencode("achik_amiez");
			$password = urlencode("@miez850722");
			$sender_id = urlencode("66300");
			//$type = (int)$_POST['type'];
			$type = '2';

			$fp = "https://www.isms.com.my/isms_send.php";
			$fp .= "?un=$username&pwd=$password&dstno=$destination&msg=$message&type=$type&sendid=$sender_id";
			//echo $fp;
			//die();
			$result = $this->ismscURL($fp);
			//echo $result;
		}
		$where[] = "aduan_id = '".$this->_getParam('id')."'";
		$db->update('ea_aduan', $data, $where);
		$id = $this->_getParam('id');
		
		$table = new AudiTrail;
		$data = array(
			'usr_id' => Zend_Filter::filterStatic(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
			'audit_trail_module' => Zend_Filter::filterStatic('Aduan', 'HtmlEntities'),
			'audit_trail_task' => Zend_Filter::filterStatic('Tindakan Aduan ID : '.$id.' - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
			'audit_trail_datetime' => date('Y-m-d H:i:s'),
			'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
		);
		$table->insert($data);
		
		$this->view->entrySaved = true;
		
		
	}
	
	public function kronologiAction()
	{
	}
	
	public function taskAction()
	{
		$db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		$this->view->title = 'Borang Aduan Bahagian Pengurusan Maklumat JHEV';
		$this->view->usr_id = $usr_id = $this->_getParam('id');
		$this->view->function = new Spt_Includes_Function();
		
	}
	
	protected function func_cronology($item = array())
	{
		$translate = $this->translate();
		//print_r($item);
		/********** start kronologi ***************/
		$cro = new Spt_Includes_Cronology;
		
		$label[0] = $translate->_('Aduan Baru');
		$detail[0] = $item->insert_date;
		$no_cro[0] = 0;
		
		$label[1] = $translate->_('Semakan Aduan');
		$detail[1] = $item->penyelia_date;
		$no_cro[1] = 1;

		$label[2] = $translate->_('Kelulusan Aduan');
		$detail[2] = $item->pegawai_date;
		$no_cro[2] = 2;
		
		$label[3] = $translate->_('Tindakan Aduan');
		$detail[3] = $item->staf_date;
		$no_cro[3] = 3;
		
		return $cro->func_createCronology($label, $detail, $no_cro);
		/********** end kronologi ***************/
	}
	
	public function getAduan($id = 0)
	{
		$db = Zend_Registry::get ( 'db' );
		
		$row = $db->fetchRow("SELECT *
							FROM ea_aduan
							WHERE aduan_id = ?",$id);
					
		return $row;
	}
	
	protected function func_tab($tab_selected = 0)
	{
		$db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$tab = new Spt_Includes_Tab;
		
		$this->tab_label[0]		=	'Maklumat Aduan';
		$this->tab_url[0]		= 	SYSTEM_URL.'/bpm/aduan/view/id/'.$this->_getParam('id') ;
		$this->tab_no_tab[0]	=	0;
		$this->tab_dis[0]		=	0;
		
		$this->tab_label[1]		=	'Maklumat Perkhidmatan';
		$this->tab_url[1]		= 	SYSTEM_URL.'/pesara/xpencen/service/id/'.$this->_getParam('id') ;
		$this->tab_no_tab[1]	=	1;
		$this->tab_dis[1]		=	($this->_getParam('id') == '') ? 1 : 0;
		//$this->tab_dis[1]		=	1;
		
		$this->tab_label[2]		=	'Kegunaan Pejabat';
		$this->tab_url[2]		= 	SYSTEM_URL.'/pesara/xpencen/office/id/'.$this->_getParam('id') ;
		$this->tab_no_tab[2]	=	2;
		$this->tab_dis[2]		=	($this->_getParam('id') == '') ? 1 : 0;
		
		$this->tab_label[3]		=	'Kelulusan';
		$this->tab_url[3]		= 	SYSTEM_URL.'/pesara/xpencen/result/id/'.$this->_getParam('id') ;
		$this->tab_no_tab[3]	=	3;
		$this->tab_dis[3]		=	($this->_getParam('id') == '') ? 1 : 0;
		
		return $tab->func_createTab(
			$this->tab_label, $this->tab_url, $this->tab_no_tab, $tab_selected, $this->tab_dis
		);
	}

	protected function ismscURL($link)
	{
		$http = curl_init();
		curl_setopt($http, CURLOPT_URL, $link);
		curl_setopt($http, CURLOPT_HEADER, 0);
		curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($http, CURLOPT_SSL_VERIFYPEER, false);
		$http_result = curl_exec($http);
		$curlerrno = curl_errno($http);
		$http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
		curl_close($http);
		//print $curlerrno;
		return $http_result;
	}

	function bpmAction()
	{
		$db=Zend_Registry::get('db');

		$sql = 'SELECT * FROM ea_bpm';

		$result = $db->fetchAll($sql);

		$dojoData= new Zend_Dojo_Data('unit_id',$result,'unit_id');

		echo $dojoData->toJson();

		exit;
	}
	
	function bpm2Action()
	{
		$db=Zend_Registry::get('db');

		$sql = 'SELECT * FROM ea_bpm';

		$result = $db->fetchAll($sql);

		$dojoData= new Zend_Dojo_Data('bpm_id',$result,'bpm_id');

		echo $dojoData->toJson();

		exit;
	}
	
	function masalahAction()
	{
		$db=Zend_Registry::get('db');

		$sql = 'SELECT * FROM ea_kategoriMasalah';

		$result = $db->fetchAll($sql);

		$dojoData= new Zend_Dojo_Data('km_id',$result,'km_id');

		echo $dojoData->toJson();

		exit;
	}
	
	function stafbpmAction()
	{
		$db=Zend_Registry::get('db');

		$sql = 'SELECT sys_user.usr_id, usr_bpm, jhev_unit 
				FROM sys_user_detail, ea_bpm, sys_user
				WHERE sys_user_detail.jhev_unit = ea_bpm.unit_id
				AND sys_user.usr_id = sys_user_detail.usr_id
				AND sys_user.role_id = "14"';

		$result = $db->fetchAll($sql);

		$dojoData= new Zend_Dojo_Data('usr_id',$result,'usr_id');

		echo $dojoData->toJson();

		exit;
	}
	
	function unitAction()
	{
		$db=Zend_Registry::get('db');

		$sql = 'SELECT * FROM ea_unit';

		$result = $db->fetchAll($sql);

		$dojoData= new Zend_Dojo_Data('unit_id',$result,'unit_id');

		echo $dojoData->toJson();

		exit;
	}
	
	function statusAction()
	{
		$db=Zend_Registry::get('db');

		$sql = 'SELECT * FROM ea_statusmasalah';

		$result = $db->fetchAll($sql);

		$dojoData= new Zend_Dojo_Data('status_id',$result,'status_id');

		echo $dojoData->toJson();

		exit;
	}

	protected function _repopulateForm($form, $item, $type)
    {
		$date = new Spt_Includes_Date;
			
		if($type == 'staf'){
			$values = array(
				'sel_status' 	=> $this->_reverseAutoFormat($item->staf_status),
				'txt_tindakan' 	=> $this->_reverseAutoFormat($item->staf_tindakan)
			);
		} 
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
	
	protected function _findexts($filename)
	{
		$filename = strtolower($filename) ;
		$exts = str_replace(" ", "_", $filename) ;
		return $exts;
	}
}

?>