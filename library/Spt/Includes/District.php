<?php 

class Spt_Includes_District
{
	public function checkDistrict($district=null)
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'sys_district'),
							array('district_name'))
						->where( 'district_name = ?', $district )
        );
        
        if($result)
        	return true;
        else 
        	return false;
	}
}

?>