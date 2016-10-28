<?php 

class Nationality extends Zend_Db_Table_Abstract {
 
	protected $_name = 'sys_nationality';
 
	public function getNationalityOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('nationality_id', 'nationality_name'))
			->where('nationality_id <> 1');
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
}

?>