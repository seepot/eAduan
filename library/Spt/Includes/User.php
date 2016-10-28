<?php 

class Spt_Includes_User
{
	public function checkUser($user=null)
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('u' => 'sys_user'),
							array('usr_id'))
						->where( 'usr_id = ?', $user )
        );
        
        if($result)
        	return true;
        else 
        	return false;
	}
	
	public function checkNokp($nokp=null)
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('u' => 'sys_user'),
							array('usr_identno'))
						->where( 'usr_identno = ?', $nokp )
        );
        
        if($result)
        	return true;
        else 
        	return false;
	}
	
	public function checkEmail($email=null)
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('u' => 'sys_user'),
							array('usr_email'))
						->where( 'usr_email = ?', $email )
        );
        
        if($result)
        	return true;
        else 
        	return false;
	}
	
	public function checkActive($user=null)
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('u' => 'sys_user'),
							array('usr_active'))
						->where( 'usr_id = ?', $user )
        );
        
        if($result['usr_active'] == true)
        	return true;
        else 
        	return false;
	}
	
	public function checkOldPassword($user=null, $pwd=null)
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('u' => 'sys_user'),
							array('usr_password'))
						->where( 'usr_id = ?', $user )
        );
		
		//echo $result->usr_password.'<br>'.hash('SHA256', $pwd);
		
		if($result->usr_password == hash('SHA256', $pwd))
        	return true;
        else 
        	return false;
	}
}

?>