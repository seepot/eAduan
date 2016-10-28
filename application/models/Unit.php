<?php 

class Unit extends Zend_Db_Table_Abstract {
 
	protected $_name = 'ea_bpm';
 
	public function getUnitOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('bpm_id', 'bpm_name'));
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
	
	public function getLookup($filterName = null, $filterValue = null) 
	{   
		$select = $this->select();
		$select->from($this, array('bpm_id', 'bpm_name'));
		if (null !== $filterName && null !== $filterValue) 
		{ 
			$select->where($filterName.' = '.$filterValue); 
		} 
		$select->order($this->_order); 
		$result = $this->getAdapter()->fetchAll($select);

	    return $result;
	} 
}

?>