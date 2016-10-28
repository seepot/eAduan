<?php 

class Race extends Zend_Db_Table_Abstract {
 
	protected $_name = 'sys_race';
 
	public function getRaceOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('race_id', 'race_desc'))
			->where('race_id <> 7');
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
}

?>