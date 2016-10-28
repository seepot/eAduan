<?php 

class Education extends Zend_Db_Table_Abstract {
 
	protected $_name = 'sys_education_level';
 
	public function getEducationOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('sys_edu_level_id', 'sys_edu_level_desc_bm'))
			->where('sys_edu_level_id <> 1');
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
}

?>