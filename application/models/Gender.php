<?php 

class Gender extends Zend_Db_Table_Abstract {
 
	protected $_name = 'sys_gender';
 
	public function getGenderOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('gender_id', 'gender_desc_may'))
			->where('gender_id <> 3');
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
}

?>