<?php 

class State extends Zend_Db_Table_Abstract {
 
	protected $_name = 'sys_state';
 
	public function getStateOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('sta_id', 'sta_name'))
			->where('sta_id < 17')
			->where('sta_status = 1');
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
}

?>