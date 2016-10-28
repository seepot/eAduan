<?php 

class Tahap extends Zend_Db_Table_Abstract {
 
	protected $_name = 'ea_tahap';
 
	public function getTahapOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('tahap_id', 'tahap_desc'));
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
}

?>