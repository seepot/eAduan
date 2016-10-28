<?php 

class AclRole extends Zend_Db_Table_Abstract {
 
	protected $_name = 'acl_role';
 
	public function getRoleOptions() 
	{
 
	    $select = $this->select()->from($this, array('acl_role_id', 'acl_role_name'));
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
	
	public function getRoleNameOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('acl_role_id', 'acl_role_name'))
			->where('type_group_id = 2');
			//->where('acl_role_id = 3');
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
	
	public function getRoleDalamanOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('acl_role_id', 'acl_role_name'))
			->where('type_group_id = 1');
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
}

?>