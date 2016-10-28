<?php 

class Pangkat extends Zend_Db_Table_Abstract {
 
	protected $_name = 'sys_pangkat';
 
	public function getPangkatOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('pangkat_id', 'pangkat_desc'))
			->where('pangkat_id <> 999')
			->where('pangkat_status <> 0');
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
}

?>