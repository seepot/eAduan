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
				->joinLeft(array('p' => 'sys_user_pesara'),
					'p.pesara_userid = u.usr_id')	
				->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
		);
		
		$this->view->func = new Pesara;
		
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
				->joinLeft(array('p' => 'sys_user_pesara'),
					'p.pesara_userid = u.usr_id')	
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
				'usr_identno' =>($values['nomykad'] <> '' ? $values['nomykad'] : NULL)
			);
			/* echo '<pre>';
			print_r($data1);
			echo '</pre>'; */
			$table1->update($data1,
				$table1->getAdapter()->quoteInto('usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id)
			);
			
			$table2 = new SysUserDetail;
			$data2 = array(
				'usr_date_birth' => ($values['date_bday'] <> '' ? $values['date_bday'] : NULL),
				'usr_religion' => ($values['religion'] <> 0 ? $values['religion'] : 1),
				'usr_race' => ($values['race'] <> 0 ? $values['race'] : 7),
				'usr_sex' => ($values['gender'] <> 0 ? $values['gender'] : 3),
				'usr_marital_status' => ($values['marital'] <> 0 ? $values['marital'] : 5),
				'usr_education_level' => ($values['education'] <> 0 ? $values['education'] : 1),
				'usr_add_primary' => ($values['alamat1'] <> '' ? $values['alamat1'] : NULL),
				'usr_add_primary2' => ($values['alamat2'] <> '' ? $values['alamat2'] : NULL),
				'usr_add_primary3' => ($values['alamat3'] <> '' ? $values['alamat3'] : NULL),
				'usr_poscode_primary' => ($values['poscode'] <> 0 ? $values['poscode'] : NULL),
				'usr_city_primary' => ($values['city'] <> '' ? $values['city'] : NULL),
				'usr_state_primary' => ($values['state'] <> 0 ? $values['state'] : 100),
				'usr_nokplama' => ($values['nokplama'] <> '' ? $values['nokplama'] : NULL),
				'usr_phone_no' => ($values['phone'] <> '' ? $values['phone'] : NULL),
				'usr_latestjob' => ($values['pekerjaan'] <> '' ? $values['pekerjaan'] : NULL),
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
			/* echo '<pre>';
			print_r($data2);
			echo '</pre>'; */
			//die();
			/* $table2->update($data2,
				$table2->getAdapter()->quoteInto('usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id)
			); */
			
			$table3 = new SysUserPesara;
			$data3 = array(
				'pesara_notentera' => ($values['notentera'] <> '' ? $values['notentera'] : NULL),
				'pesara_perkhidmatan' => ($values['perkhidmatan'] <> 0 ? $values['perkhidmatan'] : 1),
				'pesara_pangkat' => ($values['pangkat'] <> 0 ? $values['pangkat'] : 999),
				'pesara_tarikhmulakhidmat' => $values['tkh_mulakhidmat'],
				'pesara_tarikhtamatkhidmat' => $values['tkh_tamatkhidmat'],
				'pesara_statuspencen' => ($values['statuspencen'] <> '' ? $values['statuspencen'] : NULL),
				'pesara_tempoh_perkhidmatan' => ($values['tempoh'] <> '' ? $values['tempoh'] : NULL),
				'pesara_sebab_berhenti' => ($values['para'] <> '' ? $values['para'] : 99),
				'pesara_jenispenerima' => ($values['jenispenerima'] <> '' ? $values['jenispenerima'] : 0)
			);
			/* echo '<pre>';
			print_r($data3);
			echo '</pre>';
			die(); */
			$v_usrID = new Zend_Validate_Db_RecordExists('sys_user_pesara', 'pesara_userid');
			$v_noTentera = new Zend_Validate_Db_RecordExists('sys_user_pesara', 'pesara_notentera');
			
			if($v_usrID->isValid(Zend_Auth::getInstance()->getIdentity()->usr_id)){
				$update = $table3->update($data3,
					$table3->getAdapter()->quoteInto('pesara_userid = ?', Zend_Auth::getInstance()->getIdentity()->usr_id)
				);
			}  else if($v_noTentera->isValid($values['notentera'])){
				$data3 = array('pesara_userid' => Zend_Auth::getInstance()->getIdentity()->usr_id);
				$update = $table3->update($data3,
					$table3->getAdapter()->quoteInto('pesara_notentera = ?', $values['notentera'])
				);
			}  else {
				$data3 = array('pesara_userid' => Zend_Auth::getInstance()->getIdentity()->usr_id) + $data3;
				$table3->insert($data3);
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
	
	protected function _repopulateForm($form, $item)
    {
    	$date = new Spt_Includes_Date;
    	
    	$values = array(
        	'realname' => $this->_reverseAutoFormat($item->usr_fullname),
    		'date_bday' => $item->usr_date_birth,
    		'notentera' => $item->pesara_notentera,
    		'nomykad' => $item->usr_identno,
    		'nokplama' => $item->usr_nokplama,
    		//'age' => ($item->usr_age'] <> NULL ? $item->usr_age : ''),
    		'age' => ($item->usr_date_birth <> NULL ? date('Y') - substr($item->usr_date_birth,0,4) : ''),
    		'religion' => $item->usr_religion,
    		'race' => $item->usr_race,
			'gender' => $item->usr_sex,
			'marital' => $item->usr_marital_status,
			'education' => $item->usr_education_level,
			'alamat1' => ($item->usr_add_primary <> NULL ? $this->_reverseAutoFormat($item->usr_add_primary) : ''),
			'alamat2' => ($item->usr_add_primary2 <> NULL ? $this->_reverseAutoFormat($item->usr_add_primary2) : ''),
			'alamat3' => ($item->usr_add_primary3 <> NULL ? $this->_reverseAutoFormat($item->usr_add_primary3) : ''),
			'poscode' => ($item->usr_poscode_primary <> NULL ? $item->usr_poscode_primary : ''),
			'city' => ($item->usr_city_primary <> NULL ? $this->_reverseAutoFormat($item->usr_city_primary) : ''),
			'state' => $item->usr_state_primary,
			'pekerjaan' => ($item->usr_latestjob <> NULL ? $this->_reverseAutoFormat($item->usr_latestjob) : ''),
			'perkhidmatan' => ($item->pesara_perkhidmatan <> NULL ? $item->pesara_perkhidmatan : ''),
			'pangkat' => ($item->pesara_pangkat <> NULL ? $item->pesara_pangkat : ''),
			'tkh_mulakhidmat' => ($item->pesara_tarikhmulakhidmat <> NULL ? $item->pesara_tarikhmulakhidmat : ''),
			'tkh_tamatkhidmat' => ($item->pesara_tarikhtamatkhidmat <> NULL ? $item->pesara_tarikhtamatkhidmat : ''),
			'statuspencen' => ($item->pesara_statuspencen <> NULL ? $item->pesara_statuspencen : ''),
			'jenispenerima' => ($item->pesara_jenispenerima <> NULL ? $item->pesara_jenispenerima : ''),
			'tempoh' => ($item->pesara_tempoh_perkhidmatan <> NULL ? $item->pesara_tempoh_perkhidmatan : ''),
			'para' => ($item->pesara_sebab_berhenti <> NULL ? $item->pesara_sebab_berhenti : ''),
			'phone' => ($item->usr_phone_no <> NULL ? $item->usr_phone_no : ''),
			'mobile' => ($item->usr_mobile_no <> NULL ? $item->usr_mobile_no : '')
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
				'usr_id' => Zend_Filter::get(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_module' => Zend_Filter::get('Profil Pengguna', 'HtmlEntities'),
				'audit_trail_task' => Zend_Filter::get('Kemaskini Foto - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
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
				'usr_id' => Zend_Filter::get(Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
				'audit_trail_module' => Zend_Filter::get('Profil Pengguna', 'HtmlEntities'),
				'audit_trail_task' => Zend_Filter::get('Kemaskini Kata Laluan - '.Zend_Auth::getInstance()->getIdentity()->usr_id, 'HtmlEntities'),
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