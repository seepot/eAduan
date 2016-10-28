<?php 

class User_ProfilController extends Zend_Controller_Action
{
	public function personalAction()
	{
		$form = new Spt_Form_ProfilPersonal;
		$form_password = new Spt_Form_ProfilPassword;
		$check = new Spt_Includes_User;
		$date = new Spt_Includes_Date;
		
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		if(Zend_Controller_Front::getInstance()->getRequest()->getParam('tab'))
			$tab = Zend_Controller_Front::getInstance()->getRequest()->getParam('tab');
		else
			$tab = 'personal';
			
		$this->view->tab = $tab;
		
		$db = Zend_Registry::get ( 'db' );
		
		$rowset = $db->fetchRow(
			$db->select()
				->from(array('u' => 'sys_user'),
					array('usr_fullname', 'usr_email', 'usr_identno'))
				->join(array('d' => 'sys_user_detail'),
					'd.usr_id = u.usr_id')
				->where( 'u.usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id )
		);
		//die(print_r($rowset));	
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
			$this->view->form_password = $form_password;
            return;
        } 
		elseif ($tab == 'personal' && !$form->isValid($_POST)) {
			$this->view->failedValidation = true;
            $this->view->form = $form;
			$this->view->form_password = $form_password;
            return;
        }
		elseif ($tab == 'password' && !$form_password->isValid($_POST)) {
			$this->view->failedValidationPassword = true;
            if (count($rowset) == 0) {
                $this->view->failedFind = true;
                return;
            }
            $this->view->rowset = $rowset;
            $form->setElementFilters(array()); // disable all element filters
            $this->_repopulateForm($form, $rowset);
			$this->view->form = $form;
            $this->view->form_password = $form_password;
            return;
        }

		if($tab == 'personal')
		{
			$values = $form->getValues();
			
			$table = new SysUser;
			$data = array(
				'usr_fullname' => $values['realname'],
				'usr_email' => $values['email']
			);
			$table->update($data,
				$table->getAdapter()->quoteInto('usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id)
			);
			
			$table = new SysUserDetail;
			$data = array(
				'usr_date_birth' => $values['date_bday'],
				'usr_age' => ($values['age'] <> '' ? $values['age'] : NULL),
				'usr_religion' => ($values['religion'] <> 0 ? $values['religion'] : 1),
				'usr_sex' => ($values['gender'] <> 0 ? $values['gender'] : 1),
				'usr_nationality' => ($values['nationality'] <> 0 ? $values['nationality'] : 1),
				'usr_marital_status' => ($values['marital'] <> 0 ? $values['marital'] : 1),
				'usr_education_level' => ($values['education'] <> 0 ? $values['education'] : 1),
				'usr_add_primary' => ($values['address'] <> '' ? $values['address'] : NULL),
				'usr_poscode_primary' => ($values['poscode'] <> 0 ? $values['poscode'] : NULL),
				'usr_city_primary' => ($values['city'] <> '' ? $values['city'] : NULL),
				'usr_state_primary' => ($values['state'] <> 0 ? $values['state'] : 97),
				'usr_country_primary' => ($values['country'] <> '' ? $values['country'] : NULL),
				'usr_phone_no' => ($values['phone'] <> '' ? $values['phone'] : NULL),
				'usr_mobile_no' => ($values['mobile'] <> '' ? $values['mobile'] : NULL)
			);
			$table->update($data,
				$table->getAdapter()->quoteInto('usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id)
			);
			/*
			//die(print_r($data));
			$update = $table->update($data,
				$table->getAdapter()->quoteInto('usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id)
			);
			//print_r($update);
			//die();
			if(!$update && $check->checkUser(Zend_Auth::getInstance()->getIdentity()->usr_id) == false)
			{
				$datax = array('usr_id' => Zend_Auth::getInstance()->getIdentity()->usr_id) + $data;
				$table->insert($datax);
			}
			*/
		}
		elseif($tab == 'password')
		{
			$vpassword = $form_password->getValues();
			
			if($vpassword['newpassword1'] <> $vpassword['newpassword2']){
				$this->view->failedValidation = true;
				if (count($rowset) == 0) {
					$this->view->failedFind = true;
					return;
				}
				$this->view->rowset = $rowset;
				$form->setElementFilters(array()); // disable all element filters
				$this->_repopulateForm($form, $rowset);
				$this->view->form = $form;
				$this->view->form_password = $form_password;
				return;
			}
			$table = new SysUser;
			$data = array(
				'usr_password' => hash('SHA256', $vpassword['newpassword1'])
			);
			$table->update($data,
				$table->getAdapter()->quoteInto('usr_id = ?', Zend_Auth::getInstance()->getIdentity()->usr_id)
			);
		}
        
        $this->view->profilSaved = true;
		
	}
	
	protected function _repopulateForm($form, $item)
    {
    	$date = new Spt_Includes_Date;
    	
    	$values = array(
        	'realname' => $this->_reverseAutoFormat($item['usr_fullname']),
    		'email' => $this->_reverseAutoFormat($item['usr_email']),
    		'date_bday' => $item['usr_date_birth'],
    		'age' => ($item['usr_age'] <> NULL ? $item['usr_age'] : ''),
    		'religion' => $item['usr_religion'],
			'gender' => $item['usr_sex'],
			'nationality' => $item['usr_nationality'],
			'marital' => $item['usr_marital_status'],
			'education' => $item['usr_education_level'],
			'address' => ($item['usr_add_primary'] <> NULL ? $this->_reverseAutoFormat($item['usr_add_primary']) : ''),
			'poscode' => ($item['usr_poscode_primary'] <> NULL ? $item['usr_poscode_primary'] : ''),
			'city' => ($item['usr_city_primary'] <> NULL ? $this->_reverseAutoFormat($item['usr_city_primary']) : ''),
			'state' => $item['usr_state_primary'],
			'country' => ($item['usr_country_primary'] <> NULL ? $this->_reverseAutoFormat($item['usr_country_primary']) : ''),
			'phone' => ($item['usr_phone_no'] <> NULL ? $item['usr_phone_no'] : ''),
			'mobile' => ($item['usr_mobile_no'] <> NULL ? $item['usr_mobile_no'] : '')
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