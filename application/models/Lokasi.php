<?php 

class Lokasi extends Zend_Db_Table_Abstract {
 
	protected $_name = 'ea_unit';
 
	public function getLokasiOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('unit_id', 'unit_desc'));
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
}

?>