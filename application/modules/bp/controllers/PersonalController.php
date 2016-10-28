<?php 

class Bp_PersonalController extends Spt_Controller_Action
{

	public function indexAction()
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession->col);
		unset($defSession->paging);
		$this->_redirect('/bp/personal/profile');
	}
	
	public function profileAction()
	{
		$db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->translate = $this->translate();
		$date = new Spt_Includes_Date;
		
		$rowset = $db->fetchRow(
			$db->select()
				->from(array('u' => 'sys_user'),
					array('usr_fullname', 'usr_email', 'usr_identno'))
				->joinLeft(array('d' => 'sys_user_detail'),
					'd.usr_id = u.usr_id')
			//	->joinLeft(array('p' => 'sys_user_pesara'),
				//	'p.pesara_userid = u.usr_id')	
				->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
		);
		
		$this->view->func = new Pesara;
		$this->view->function = new Spt_Includes_Function;
		
		$this->view->rowset = $rowset;
		$this->view->date = $date;
	}
	
	public function profileeditAction()
	{
		$form = new Spt_Form_Bp_ProfilPersonal;
		$check = new Spt_Includes_User;
		$date = new Spt_Includes_Date;
		$this->view->translate = $this->translate();
		
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		if(Zend_Controller_Front::getInstance()->getRequest()->getParam('tab'))
			$tab = Zend_Controller_Front::getInstance()->getRequest()->getParam('tab');
		else
			$tab = 'personal';
			
		$this->view->tab = $tab;
		
		$db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		$this->view->rowset = $rowset = $db->fetchRow(
			$db->select()
				->from(array('u' => 'sys_user'),
					array('usr_fullname', 'usr_email', 'usr_identno'))
				->joinLeft(array('d' => 'sys_user_detail'),
					'd.usr_id = u.usr_id')
				->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
		);
		//print_r($rowset);	
		if (!$this->getRequest()->isPost()) {
            /*
            if (count($rowset) == 0) {
                $this->view->failedFind = true;
                return;
            }*/
			//print_r($rowset);
			//die();
            $this->view->rowset = $rowset;
            $form->setElementFilters(array()); // disable all element filters
            $this->_repopulateForm($form, $rowset);
            $this->view->id = $this->_getParam('id');
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->rowset = $rowset;
            $form->setElementFilters(array()); // disable all element filters
            $this->_repopulateForm($form, $rowset);
			$this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        }
		
		//get value from form
			$values = $form->getValues();
			
			$table1 = new SysUser;
			$data1 = array(
				'usr_fullname' => ($values['realname'] <> '' ? $values['realname'] : NULL),
				'usr_identno' =>($values['nomykad'] <> '' ? $values['nomykad'] : NULL),
				'usr_email' =>($values['email'] <> '' ? $values['email'] : NULL)
			);
			/*echo '<pre>';
			print_r($values);
			echo '</pre>';
			die();*/
			$table1->update($data1,
				$table1->getAdapter()->quoteInto('usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id)
			);
			
			$table2 = new SysUserDetail;
			$data2 = array(
				'jhev_no' => ($values['jhevno'] <> '' ? $values['jhevno'] : NULL),
				'jhev_dept' => ($values['jhev_dept'] <> '' ? $values['jhev_dept'] : NULL),
				'jhev_unit' => ($values['jhev_unit'] <> '' ? $values['jhev_unit'] : NULL),
				'usr_date_birth' => ($values['nomykad'] <> '' ? $this->_getbirthdate($values['nomykad']) : NULL),
				'usr_sex' => ($values['gender'] <> 0 ? $values['gender'] : 3),
				'usr_add_primary' => ($values['alamat1'] <> '' ? $values['alamat1'] : NULL),
				'usr_poscode_primary' => ($values['poscode'] <> 0 ? $values['poscode'] : NULL),
				'usr_city_primary' => ($values['city'] <> '' ? $values['city'] : NULL),
				'usr_state_primary' => ($values['state'] <> 0 ? $values['state'] : 100),
				'usr_phone_no' => ($values['phone'] <> '' ? $values['phone'] : NULL),
				'usr_mobile_no' => ($values['mobile'] <> '' ? $values['mobile'] : NULL)
			);
			$v_usrID_d = new Zend_Validate_Db_RecordExists('sys_user_detail', 'usr_id');
			if($v_usrID_d->isValid(Zend_Auth::getInstance()->getIdentity()->usr_id)){
				$table2->update($data2,
					$table2->getAdapter()->quoteInto('usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id)
				);
			} else {
				$data2 = array('usr_id' => Zend_Auth::getInstance()->getIdentity()->usr_id) + $data2;
				$table2->insert($data2);
			}
			
			$table = new AudiTrail;
			$data = array(
				'usr_id' => Zend_Filter::filterStatic(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_module' => Zend_Filter::filterStatic('Profil Pengguna', 'HtmlEntities'),
				'audit_trail_task' => Zend_Filter::filterStatic('Kemaskini Profil - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_datetime' => date('Y-m-d H:i:s'),
				'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
			);
			$table->insert($data);
		
        $this->view->profilSaved = true;
		//die();
	}
	
	protected function _getbirthdate($ic)
	{	$birthyear = substr($ic,0,2);
		$birthmonth = substr($ic,2,2);
		$birthday = substr($ic,4,2);
		
		if($birthyear>40 && $birthyear<100)
			$birthdate = "19".$birthyear."-".$birthmonth."-".$birthday;
		else
			$birthdate = "20".$birthyear."-".$birthmonth."-".$birthday;
			
		return $birthdate;
	}
	
	protected function _repopulateForm($form, $item)
    {
    	$date = new Spt_Includes_Date;
    	
    	$values = array(
        	'realname' => $this->_reverseAutoFormat($item->usr_fullname),
    		'date_bday' => $item->usr_date_birth,
    		'jhevno' => $item->jhev_no,
    		'nomykad' => $item->usr_identno,
    		//'age' => ($item->usr_age'] <> NULL ? $item->usr_age : ''),
    		'age' => ($item->usr_date_birth <> NULL ? date('Y') - substr($item->usr_date_birth,0,4) : ''),
    		'jhev_dept' => $item->jhev_dept,
    		'jhev_unit' => $item->jhev_unit,
			'gender' => $item->usr_sex,
			'alamat1' => ($item->usr_add_primary <> NULL ? $this->_reverseAutoFormat($item->usr_add_primary) : ''),
			'poscode' => ($item->usr_poscode_primary <> NULL ? $item->usr_poscode_primary : ''),
			'city' => ($item->usr_city_primary <> NULL ? $this->_reverseAutoFormat($item->usr_city_primary) : ''),
			'state' => $item->usr_state_primary,
			'phone' => ($item->usr_phone_no <> NULL ? $item->usr_phone_no : ''),
			'mobile' => ($item->usr_mobile_no <> NULL ? $item->usr_mobile_no : ''),
			'email' => ($item->usr_email <> NULL ? $item->usr_email : '')
        );
		
		/* echo '<pre>';
		print_r($values);
		echo '</pre>'; */
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
	
	public function fotoeditAction()
	{
		$this->view->translate = $this->translate();
		$form = new Spt_Form_Bp_ProfilFoto;
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		
		$db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$this->view->rowset = $db->fetchRow(
			$db->select('d.usr_foto')
				->from(array('u' => 'sys_user'),
					array('usr_fullname', 'usr_email', 'usr_identno'))
				->joinLeft(array('d' => 'sys_user_detail'),
					'd.usr_id = u.usr_id')
				->joinLeft(array('p' => 'sys_user_pesara'),
					'p.pesara_userid = u.usr_id')	
				->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
		);
		//
		if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
		/* echo '<pre>';
		print_r($_FILES);
		echo '</pre>'; */
		if(isset($_POST['file_upload'])){
			if ($_FILES["file"]["error"] > 0)
			  {
			  echo "Error: " . $_FILES["file"]["error"] . "<br />";
			  }
			else
			  {
			  $_FILES["file"]["name"] = Zend_Auth::getInstance()->getIdentity()->usr_id.$this->_findexts($_FILES["file"]["name"]);
			  /* echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			  echo "Type: " . $_FILES["file"]["type"] . "<br />";
			  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			  echo "Stored in: " . $_FILES["file"]["tmp_name"]; */
			  
			  $filename = date('Ymd').'-'.$this->_findexts($_FILES["file"]["name"]);
			  
			  if (file_exists(UPLOAD_PATH."pesara/" . $_FILES["file"]["name"]))
				  {
				  echo $_FILES["file"]["name"] . " already exists. ";
				  }
				else
				  {
				  
				  move_uploaded_file($_FILES["file"]["tmp_name"],
				  UPLOAD_PATH."pesara/" . $filename);
				  //echo "Stored in: " . UPLOAD_PATH."pesara/" . $_FILES["file"]["name"];
				  }
				}
			//echo 'xx';

		}
		//die();
		$data = array(
			'usr_foto'	=> $filename, 
			'record_by'		=> trim(Zend_Auth::getInstance()->getIdentity()->usr_id), 
			'record_date'				=> date('Y-m-d H:i:s')
			);
		
		//die();
		/* echo "<pre>";
		print_r($data);
		echo "</pre>"; */
		//die();
		
		$table = new SysUserDetail;
		
		$update = $table->update($data,
				$table->getAdapter()->quoteInto('usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id)
			);
		
		$id = $db->lastInsertId();
		
		$table = new AudiTrail;
			$data = array(
				'usr_id' => Zend_Filter::filterStatic(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_module' => Zend_Filter::filterStatic('Profil Pengguna', 'HtmlEntities'),
				'audit_trail_task' => Zend_Filter::filterStatic('Kemaskini Foto - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_datetime' => date('Y-m-d H:i:s'),
				'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
			);
			$table->insert($data);
			
		$this->view->profilSaved = true;
	}
	
	protected function _findexts($filename)
	{
		$filename = strtolower($filename) ;
		$exts = str_replace(" ", "_", $filename) ;
		return $exts;
	}
	
	public function passwordAction()
	{
		$this->view->translate = $this->translate();
		$form = new Spt_Form_Bp_ProfilPassword;
		$check = new Spt_Includes_User;
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		
		$db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$this->view->rowset = $db->fetchRow(
			$db->select('d.usr_foto')
				->from(array('u' => 'sys_user'),
					array('usr_fullname', 'usr_email', 'usr_identno'))
				->joinLeft(array('d' => 'sys_user_detail'),
					'd.usr_id = u.usr_id')
				->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
		);
		//
		if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
		
		$values = $form->getValues();
		
		if (!$check->checkOldPassword(Zend_Auth::getInstance()->getIdentity()->usr_id, $values['oldpassword'])) {
			$this->view->oldpasswordError = true;
			$this->view->form = $form;
            return;
		} elseif($values['newpassword1'] != $values['newpassword2']){
        	$this->view->newpasswordError = true;
            $this->view->form = $form;
            return;
        }
		
		$table = new SysUser;
		$data = array(
			'usr_password' => hash('SHA256', $values['newpassword1'])
		);
		$table->update($data,
			$table->getAdapter()->quoteInto('usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id)
		);
		
		$table = new AudiTrail;
			$data = array(
				'usr_id' => Zend_Filter::filterStatic(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_module' => Zend_Filter::filterStatic('Profil Pengguna', 'HtmlEntities'),
				'audit_trail_task' => Zend_Filter::filterStatic('Kemaskini Kata Laluan - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_datetime' => date('Y-m-d H:i:s'),
				'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
			);
			$table->insert($data);
		$this->view->profilSaved = true;
		//die();
	}
	
	public function bantuanAction()
	{
		$this->view->translate = $this->translate();
	}
}

?>