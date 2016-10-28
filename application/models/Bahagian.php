<?php 

class Bahagian extends Zend_Db_Table_Abstract {
 
	protected $_name = 'tbl_bahagian';
 
	public function getBahagianOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('bahagian_id', 'bahagian_nama'))
			->where('bahagian_status = 1');
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
}

?>