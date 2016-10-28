<?php 

class AclRolePrivilege extends Zend_Db_Table_Abstract {
 
	protected $_name = 'acl_role_privilege';
 
	public function getPrivilegeOptions() 
	{
 
	    $select = $this->select()->from($this, array('acl_role_id', 'acl_privilege_id'));
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
}

?>