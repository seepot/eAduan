<?php

class SysType extends Zend_Db_Table
{

    protected $_name = 'sys_type';
	
	public function getTypeOptions() 
	{
		$select = $this->select();
		$select->from($this, array('type_id', 'type_name'));
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
	
	public function getTypeNameOptions() 
	{
		$select = $this->select();
		$select->from($this, array('type_name', 'type_name'));
		$result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}

}