<?php 

class Spt_Includes_State
{
	public function checkState($state=null)
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('s' => 'sys_state'),
							array('sta_name'))
						->where( 'sta_name = ?', $state )
        );
        
        if($result)
        	return true;
        else 
        	return false;
	}
	
	public function checkStateCode($code=null)
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('s' => 'sys_state'),
							array('sta_code'))
						->where( 'sta_code = ?', $code )
        );
        
        if($result)
        	return true;
        else 
        	return false;
	}
}

?>