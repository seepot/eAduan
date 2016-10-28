<?php 

class Resources extends Zend_Db_Table_Abstract {
 
	protected $_name = 'acl_resource';
 
	public function getResourceOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('acl_resource_id', 'acl_resource_name', 'acl_module_id'));
			//->where('acl_module_id <> 1');
	    $result = $this->getAdapter()->fetchAll($select);
	 
	    return $result;
  	}
}
?>