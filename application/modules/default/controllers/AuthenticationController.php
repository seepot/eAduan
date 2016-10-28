<?php

class AuthenticationController extends Spt_Controller_Action
{
	
	public function googleAction() 
	{
		 /* $aGoogleConfig = array(
			'callbackUrl' =>  'http://210.19.20.218',
			'siteUrl' => 'https://www.google.com/accounts/',
			'authorizeUrl'  => 'https://www.google.com/accounts/OAuthAuthorizeToken',
			'requestTokenUrl'  => 'https://www.google.com/accounts/OAuthGetRequestToken',
			'accessTokenUrl' => 'https://www.google.com/accounts/OAuthGetAccessToken',
			'consumerKey' => '210.19.20.218',
			'consumerSecret' => 'FlZSf8EtGFrBiDWlDy0l3Wr_'
		 );

		$consumer = new Zend_Oauth_Consumer($aGoogleConfig);
		$token = null; 
		print_r($_SESSION);
		die();
		if($_SESSION['GOOGLE_ACCESS_TOKEN']){
		$token = unserialize($_SESSION['GOOGLE_ACCESS_TOKEN']);
		}
		else if(isset($_GET['oauth_token'])){
		$token = $consumer->getAccessToken( $_GET, unserialize($_SESSION['GOOGLE_REQUEST_TOKEN']) );
		$_SESSION['GOOGLE_ACCESS_TOKEN'] = serialize($token);
		}  */
		
		$openid = new OpenId_LightOpenID($_SERVER['HTTP_HOST']);
		
		/* echo '<pre>';
		print_r($openid->getAttributes());
		echo '</pre>';
		die(); */
		if ($openid->validate()) {
			//User logged in
			$d = $openid->getAttributes();

			$first_name = $d['namePerson/first'];
			$last_name = $d['namePerson/last'];
			$email = $d['contact/email'];
			var_dump($d);
			// do your login
			$auth = Zend_Auth::getInstance();
			$adapter = new My_Auth($email);
			$result = $auth->authenticate($adapter);
			if($result->isValid()) {
				
				$user = $adapter->getUser();
				$auth->getStorage()->write($user);
				$this->view->passedAuthentication = true;
				//print_r($user);
				//die();
				echo "<script language=\"Javascript\">";
				echo "top.location.href='".SYSTEM_URL."'; target='_top'";
				echo "</script>";
				//return true; // redirect instead 
			}

		} else {
			//user is not logged in
		}
		
		
	}
	
	public function facebookAction() 
	{
		$defSession = Zend_Registry::get ( 'defSession' );
		$token = $this->getRequest()->getParam('token',false);
		if($token == false) {
			return false; // redirect instead 
		}
	 
		$auth = Zend_Auth::getInstance();
		$adapter = new Zend_Auth_Adapter_Facebook($token);
		//print_r($defSession->newuser);
		//echo 'xx';
		//die();
		//if($adapter->getUser()){
			$result = $auth->authenticate($adapter);
		//}
		if(isset($defSession->newuser)) {
			
			//$user = $adapter->getUser();
			//$auth->getStorage()->write($user);
			//$this->view->passedAuthentication = true;
			
			if (!$result->isValid()) {
				//die('yy');
				echo "<script language=\"Javascript\">";
				echo "top.location.href='".SYSTEM_URL."/authentication/register'; target='_top'";
				echo "</script>";
			} else {
				//die('xx');
				$result = $auth->authenticate($adapter);
				$user = $adapter->getUser();
				$auth->getStorage()->write($user);
				echo "<script language=\"Javascript\">";
				echo "top.location.href='".SYSTEM_URL."'; target='_top'";
				echo "</script>";
			}
			//return true; // redirect instead 
		}
		
		/* if($result->isValid()) {
			
			$user = $adapter->getUser();
			$auth->getStorage()->write($user);
			$this->view->passedAuthentication = true;
			
			if ($defSession->newuser == '1') {
				echo "<script language=\"Javascript\">";
				echo "top.location.href='".SYSTEM_URL."/authentication/register'; target='_top'";
				echo "</script>";
			} else {
				echo "<script language=\"Javascript\">";
				echo "top.location.href='".SYSTEM_URL."'; target='_top'";
				echo "</script>";
			}
			//return true; // redirect instead 
		} */
		return false; // redirect instead 
	}
	
    public function loginAction()
    {
		$this->view->translate = $this->translate();
		
		$this->view->openid =  new OpenId_LightOpenID('210.19.20.218');
		
		$this->_helper->layout->disableLayout();
		/*Zend_Layout::startMvc(
            array(
                'layoutPath' => SYSTEM_PATH . '/application/layouts',
                'layout' => 'adminx'
            )
        );
		*/
		
        $form = new Spt_Form_UserLogin;
        $check = new Spt_Includes_User;
        
    	if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        }
        
    	$values = $form->getValues();

        // Setup DbTable adapter
        $adapter = new Zend_Auth_Adapter_DbTable(
            Zend_Db_Table::getDefaultAdapter() // set earlier in Bootstrap
        );
        $adapter->setTableName('sys_user');
        $adapter->setIdentityColumn('usr_id');
        $adapter->setCredentialColumn('usr_password');
        $adapter->setIdentity($values['name']);
        $adapter->setCredential(
            hash('SHA256', $values['password'])
        );

        // authentication attempt
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($adapter);

        // authentication succeeded
        if ($result->isValid() and $check->checkActive($values['name']) == true) {
        	$auth->getStorage()
	             ->write($adapter->getResultRowObject(null, 'password'));
	        $this->view->passedAuthentication = true;
			echo "<script language=\"Javascript\">";
			echo "top.location.href='".SYSTEM_URL."'; target='_top'";
			echo "</script>";
	        //$this->_forward('index', 'index', 'admin');
        } else { // or not! Back to the login page!
            $this->view->failedAuthentication = true;
            Zend_Auth::getInstance()->clearIdentity();
            //$this->_forward('index', 'index', 'default');
            $this->view->form = $form;
        }
		
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
		$defSession = Zend_Registry::get ( 'defSession' );
		unset($defSession);
        $this->_helper->redirector('index', 'index');
    }
    
    public function registerAction()
    {
		$defSession = Zend_Registry::get ( 'defSession' );
		//echo '<pre>';
		//print_r($defSession->newuserDtl);
		//echo '</pre>';
		
		$form = new Spt_Form_Authentication_Register;
			
		$this->view->translate = $this->translate();
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$this->view->front = $front;
		
		if (!$this->getRequest()->isPost()) {
            if (isset($defSession->newuserDtl)){
				$this->_repopulateForm($form,$defSession->newuserDtl);
			}
			$this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
        
        $values = $form->getValues();
		
		//echo '<pre>';
		//print_r($values);
		//echo '</pre>';
		//die(print_r($values));
		//echo checkdate(substr($values['user_identno'],2,2), substr($values['user_identno'],4,2), '19'.substr($values['user_identno'],0,2));
		//die();
		
			/***********  Semak duplicatel ada kat dbase ke x *****************/
		$v_usrID = new Zend_Validate_Db_RecordExists('sys_user', 'usr_id');
		$v_noKP = new Zend_Validate_Db_RecordExists('sys_user', 'usr_identno');
		$v_email = new Zend_Validate_Db_RecordExists('sys_user', 'usr_email');
		if ($v_usrID->isValid($values['user_id'])) {
			if (isset($defSession->newuserDtl)){
				$this->_repopulateForm($form,$defSession->newuserDtl);
			}
			$this->view->userError = true;
			$this->view->form = $form;
            return;
		} elseif ($v_noKP->isValid($values['user_identno'])) {
			if (isset($defSession->newuserDtl)){
				$this->_repopulateForm($form,$defSession->newuserDtl);
			}
			$this->view->nokpError = true;
			$this->view->form = $form;
            return;
		} elseif ($v_email->isValid($values['user_email'])) {
			if (isset($defSession->newuserDtl)){
				$this->_repopulateForm($form,$defSession->newuserDtl);
			}
			$this->view->emailError = true;
			$this->view->form = $form;
            return;
		} elseif (checkdate(substr($values['user_identno'],2,2), substr($values['user_identno'],4,2), '19'.substr($values['user_identno'],0,2)) == 0) {
			if (isset($defSession->newuserDtl)){
				$this->_repopulateForm($form,$defSession->newuserDtl);
			}
			$this->view->nokpError = true;
			$this->view->form = $form;
            return;
		} 
		//die();
			
		
		//check password same ke x

		if($values['user_password1'] != $values['user_password2']){
        	$this->_repopulateForm($form, $defSession->newuserDtl);
			$this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        }

		
		$table = new SysUser;
		$data = array(
            'usr_id' => Zend_Filter::filterStatic($values['user_id'], 'HtmlEntities'),
            'usr_fullname' => Zend_Filter::filterStatic($values['user_name'], 'HtmlEntities'),
        	'usr_identno' => Zend_Filter::filterStatic($values['user_identno'], 'HtmlEntities'), 	
        	'usr_password' => hash('SHA256', $values['user_password1']),
        	'usr_email' => Zend_Filter::filterStatic($values['user_email'], 'HtmlEntities'),
		//	'type_id' => $values['type_id'],
			'role_id' => $values['group_id'],
        );
		//echo '<pre>';
		//print_r($data);
		//echo '</pre>';
		//die();
        $table->insert($data);
		/* 
		$table2 = new SysUserType;
		$data2 = array(
			'user_type_id' => $values['type_id']
			);
			
		$table2->insert($data2);
		  */
		/* 
		$table3 = new SysUserTypeGroup;
		$data3= array(
			'type_group_id' => $values['group_id']
			);
			
		$table3->insert($data3);
		 */
		//get birthdate
		
		
		$table4 = new SysUserDetail;
		$data4 = array(
			'usr_id' => Zend_Filter::filterStatic($values['user_id'], 'HtmlEntities'),
			'usr_add_primary' => $values['primary_add'],
			'usr_poscode_primary' => $values['poskod_add'],
			'jhev_no' => $values['user_nojabatan'],
			'jhev_dept' => $values['jhev_dept'],
			'jhev_unit' => $values['jhev_unit'],
			'usr_state_primary' => $values['state_add'],
			'usr_city_primary' => $values['district_add'],
			'usr_mobile_no' => $values['mobile_no'],
			'usr_phone_no' => $values['office_no'],
			'usr_date_birth' => $this->_getbirthdate($values['user_identno']),
			'usr_sex' => $values['user_sex']
			);
		//echo '<pre>';
		//print_r($data4);
		//echo '</pre>';
		//die();
		$table4->insert($data4);
		//die();
		/*
		//store default contact type into sys_user_contact
		$tablec = new SysUserContact;
		$datac = array(
					'usr_id' => Zend_Filter::get($values['user_id'], 'HtmlEntities'),
					'contact_id' => 1
					);
		$tablec->insert($datac);
		//check for email and sms contact types and store into sys_user_contact		
		for($icontact=1;$icontact<4;$icontact++)
		{	//$tablec = new SysUserContact;
			if(isset($_POST['contacttype'.$icontact]))
			{	$datac = array(
					'usr_id' => Zend_Filter::get($values['user_id'], 'HtmlEntities'),
					'contact_id' => $icontact
					);
				$tablec->insert($datac);
			}
		} 
		*/
        $this->view->entrySaved = true;
		
	}
	//function to extract birthdate from ic number
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
	
	public function forgotpasswordAction()
    {
		$db = Zend_Registry::get ( 'db' );
		$this->view->translate = $this->translate();
		$form = new Spt_Form_Authentication_ForgotPassword;
		
		if (!$this->getRequest()->isPost()) {
            $this->view->form = $form;
            return;
        } elseif (!$form->isValid($_POST)) {
            $this->view->failedValidation = true;
            $this->view->form = $form;
            return;
        } 
		
		$values = $form->getValues();
		
		$v_email = new Zend_Validate_Db_NoRecordExists('sys_user', 'usr_email');
		if ($v_email->isValid($values['txt_email'])) {
			$this->view->emailError = true;
			$this->view->form = $form;
            return;
		}
		/*********** StartPassword Generator**************/
		$chars = array();
		$str_random = 	'';
		for($i = 0; $i < 8; $i++)
			$str_random .= rand(0,9);
		
		$password	=	$str_random;
		/*********** End Password Generator**************/
		//die($password);	
		/*********** Start Send Email**************/
		$txt_body = "Kata Laluan Baru Anda Ialah : ".$password;
		$txt_body .= "<br>";
		$txt_body .= "Sila log masuk ke dalam <a href=\"".SYSTEM_HOST.SYSTEM_URL."\">sistem</a>.";
		$mail = new Zend_Mail();
		$mail->setBodyHtml($txt_body);
		$mail->setFrom('admin@jhev.gov.my', 'Administrator');
		$mail->addTo($values['txt_email'], 'user1');
		$mail->setSubject('Lupa Kata Laluan');
		$mail->send();
		/*********** End Send Email**************/
		/*********** Start Update DB**************/
		$data = array('usr_password' => hash('SHA256',$password));
		$where[] = "usr_email = '".$values['txt_email']."'";
		$db->update('sys_user', $data, $where);
		/*********** End Update DB**************/
		$this->view->entrySaved = true;

	}
	
	protected function _repopulateForm($form, $detail)
    {
			
		foreach($detail as $item){
		
			if ($item->gender == 'male') {
				$gender = '1';
			} else if ($item->gender == 'female') {
				$gender = '2';
			} else {
				$gender = '3';
			}
			
			$values = array(
				'user_id' 	=> $this->_reverseAutoFormat($item->username),
				'user_name' 	=> $this->_reverseAutoFormat($item->name),
				'user_email' 	=> $this->_reverseAutoFormat($item->email),
				'user_sex' 	=> $this->_reverseAutoFormat($gender)
			);
		}
		echo '<pre>';
		print_r($values);
		echo '</pre>';
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
	
	function stateAction()
	{
		$db=Zend_Registry::get('db');
		$sql = 'SELECT * FROM sys_state';
		$result = $db->fetchAll($sql);
		$dojoData= new Zend_Dojo_Data('sta_id',$result,'sta_id');
		echo $dojoData->toJson();
		exit;
	}
	
	function districtAction()
	{
		$db=Zend_Registry::get('db');
		$sql = 'SELECT * FROM sys_district ORDER BY sta_id, district_name';
		$result = $db->fetchAll($sql);
		$dojoData= new Zend_Dojo_Data('district_id',$result,'district_id');
		echo $dojoData->toJson();
		exit;
	}
	function deptAction()
	{
		$db=Zend_Registry::get('db');
		$sql = 'SELECT * FROM ea_bahagian';
		$result = $db->fetchAll($sql);
		$dojoData= new Zend_Dojo_Data('id',$result,'id');
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
	
}