<?php 

class Nolesen extends Zend_Db_Table_Abstract {
 
	protected $_name = 'sys_nolesen';
 
	public function getNolesenOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('nolesen_id', 'nolesen_id'));
//			->where('sta_id < 17')
//			->where('sta_status = 1');
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
}

?>