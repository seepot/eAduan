<?php 

class Problem extends Zend_Db_Table_Abstract {
 
	protected $_name = 'ea_kategoriMasalah';
 
	public function getProblemOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('km_id', 'km_desc'));
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
	
	public function getLookup($filterName = null, $filterValue = null) 
	{   
		$select = $this->select();
		$select->from($this, array('km_id', 'km_desc'));		
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