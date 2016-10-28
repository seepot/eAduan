<?php

class SysUser extends Zend_Db_Table
{

    protected $_name = 'sys_user';
	
	public function getUserOptions() 
	{
		$select = $this->select();
		$select->from($this, array('usr_id', 'usr_fullname'))
			->where('usr_active = 1');
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
	
	public function getInternalUserOptions() 
	{
		$select = $this->select();
		$select->from($this, array('usr_id', 'usr_fullname'))
			->where('usr_active = 1');
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}

}