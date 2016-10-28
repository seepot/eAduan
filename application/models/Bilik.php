<?php 

class Bilik extends Zend_Db_Table_Abstract {
 
	protected $_name = 'tbl_bilik';
 
	public function getBilikOptions($type_id) 
	{
 
	    $select = $this->select();
		$select->from($this, array('bilik_id', 'bilik_name'))
			->where('bilik_type_id = '.$type_id);
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
}

?>