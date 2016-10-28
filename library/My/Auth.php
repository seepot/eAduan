<?php
class My_Auth implements Zend_Auth_Adapter_Interface  
{
	private $email = null;
    private $user = null;
 
     public function __construct($email) {
        $this->email = $email;
    } 
 
    public function getUser() {
        return $this->user;
    }
 
    public function authenticate()  {
        /* if($this->token == null) {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
                            false, array('Token was not set'));
        }
 
        $graph_url = "https://graph.facebook.com/me?access_token=" . $this->token;
        $details = json_decode(file_get_contents($graph_url)); */
		//echo $this->email;
        $user = $this->lookUpUserInDB($this->email); // NOT AN ACTUALL FUNCTION
        if($user ==  false) { // first time login, register user
            /* echo '<pre>';
			print_r($details);
			echo '</pre>';
			die(); */
			$this->registerUser($this->email); // NOT AN ACTUAL FUNCTION
			$user = $this->lookUpUserInDB($this->email);
			$this->user = $user;
			return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS,$user);
        } else {
			$this->user = $user;
			return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS,$user);
		}
		
    }
	
	public function lookUpUserInDB($email = '')  {
		
		$db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$v_email = new Zend_Validate_Db_RecordExists('sys_user', 'usr_email');
		if ($v_email->isValid($email)) {
            
			//echo $email;
			
			$user = $db->fetchRow("SELECT *
							FROM sys_user WHERE usr_email = '".$email."'");
			
			return $user;
		} else {
			return false;
		}
		
	}
	
	public function registerUser($email = '')
	{
	
		$openid = new OpenId_LightOpenID($_SERVER['HTTP_HOST']);
		
		$d = $openid->getAttributes();
		$_SERVER['HTTP_HOST'];
		$first_name = $d['namePerson/first'];
		$last_name = $d['namePerson/last'];
		$email = $d['contact/email'];
		$fullname = $first_name.' '.$last_name;
		
		// echo '<pre>';
		// print_r($d);
		// echo '</pre>';
		// die(); 
		
		$table = new SysUser;
		$data = array(
            'usr_id' => Zend_Filter::filterStatic($email, 'HtmlEntities'),
            'usr_fullname' => Zend_Filter::filterStatic($fullname, 'HtmlEntities'),
        	'usr_password' => hash('SHA256', 'password'),
        	'usr_email' => Zend_Filter::filterStatic($email, 'HtmlEntities'),
			'usr_active' => '1',
			'type_id' => '1',
			'role_id' => '3'
        );
		
        $table->insert($data);
		
		$table4 = new SysUserDetail;
		$data4 = array( 'usr_id' => Zend_Filter::filterStatic($email, 'HtmlEntities'));
		$table4->insert($data4);
		
		$table5 = new AudiTrail;
		$data5 = array(
			'usr_id' => Zend_Filter::filterStatic($email, 'HtmlEntities'),
			'audit_trail_module' => Zend_Filter::filterStatic('Pendaftaran', 'HtmlEntities'),
			'audit_trail_task' => Zend_Filter::filterStatic('Pengguna Baru - '.Zend_Filter::filterStatic($email, 'HtmlEntities'), 'HtmlEntities'),
			'audit_trail_datetime' => date('Y-m-d H:i:s'),
			'audit_trail_ipaddress' => $_SERVER['REMOTE_ADDR']
		);
		$table5->insert($data5);
		
		return;
	}
	
	public function getId()
    {
        $endpoint = 'https://graph.facebook.com/me?fields=id';
        $id = json_decode($this->_getData('id', $endpoint));
        if(isset($id->error)) {
            return NULL;
        }
        return $id->id;
    }

    public function getProfile()
    {
        $endpoint = 'https://graph.facebook.com/me';
        return (array) json_decode($this->_getData('profile', $endpoint));
    }

    public function getFriends()
    {
        $endpoint = 'https://graph.facebook.com/me/friends';
        return json_decode($this->_getData('friends', $endpoint))->data;
    }

    public function getPicture($large = false)
    {
        if (!$large) {
            $endpoint = 'https://graph.facebook.com/me/picture';
            return $this->_getData('picture', $endpoint, false);
        } else {
            $endpoint = 'https://graph.facebook.com/me/picture?type=large';
            return $this->_getData('picture_big', $endpoint, false);
        }
    }

    protected function _getData($label, $url, $redirects = true)
    {
        if (!$this->_hasData($label)) {
            $value = $this->getData($url, 
                                       $this->token,
                                       $redirects);
            $this->_setData($label, $value);
        }
        return $this->data[$label];
    }

    protected function _setData($label, $value)
    {
        $this->data[$label] = $value;
    }

    protected function _hasData($label)
    {
        return isset($this->data[$label]) && (NULL !== $this->data[$label]);
    }
    
	public function getData($url, $accesstoken, $redirects = true)
	{
		//Zend_Debug::dump($accesstoken,'$accesstoken');
		$client = new Zend_Http_Client();
		$client->setUri($url);
		$client->setParameterGet('access_token',$accesstoken);
		if($redirects) {
			$response = $client->request('GET')->getBody();
		}
		else {
			$client->setConfig(array('maxredirects'=>0));
			$response = $client->request()->getHeader('Location');
			$client->setConfig(array('maxredirects'=>5));
		}
		return $response;
	}
}