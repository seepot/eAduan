<?php 

class Marital extends Zend_Db_Table_Abstract {
 
	protected $_name = 'sys_marital';
 
	public function getMaritalOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('usrmrd_id', 'ursmrd_name'))
			->where('usrmrd_id <> 5');
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
}

?>