<?php 

class Status extends Zend_Db_Table_Abstract {
 
	protected $_name = 'ea_statusmasalah';
 
	public function getStatusOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('status_id', 'status_desc'));
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
}

?>