<?php 

class SysUserTypeGroup extends Zend_Db_Table_Abstract {
 
	protected $_name = 'sys_user_type_group';
 
	public function getSysUserTypeGroupOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('type_group_id', 'type_group_name'));
			//->where('type_group_id <> 1');
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
	
	
	
	
}
