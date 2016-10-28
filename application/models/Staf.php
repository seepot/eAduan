<?php 

class Staf extends Zend_Db_Table_Abstract {
 
	protected $_name = 'sys_user';
 
	public function getStafOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('usr_id', 'usr_fullname'));
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
}

?>