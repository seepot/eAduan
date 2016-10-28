<?php 

class Service extends Zend_Db_Table_Abstract {
 
	protected $_name = 'sys_kategori_perkhidmatan';
 
	public function getServiceOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('perkhidmatan_id', 'perkhidmatan_desc'))
			->where('perkhidmatan_status <> 0');
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
}

?>