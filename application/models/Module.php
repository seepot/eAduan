<?php 

class Module extends Zend_Db_Table_Abstract {
 
	protected $_name = 'acl_module';
 
	public function getModuleOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('acl_module_id', 'acl_module_name'));
			//->where('acl_module_id <> 1');
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
	
	public function getModulexOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('acl_module_id', 'acl_module_name'));
			//->where('acl_module_id <> 1');
	    $result = $this->getAdapter()->fetchAll($select);
	 
	    return $result;
  	}
}
