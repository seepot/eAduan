<?php 

class Religion extends Zend_Db_Table_Abstract {
 
	protected $_name = 'sys_religion';
 
	public function getReligionOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('religion_id', 'religion_desc'))
			->where('religion_id <> 1');
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
	
	public function getReligionById($id = 0) 
	{
 
	    $db = Zend_Registry::get ( 'db' );
		/* $select = $this->select();
		$select->from('sys_religion', array('religion_desc'))
			->where('religion_id = '.$id);
	    $result = $this->fetchRow($select); */
	    $result = $this->fetchRow("SELECT religion_desc
							FROM sys_religion
							WHERE religion_id = 1");
	 
	    return $result['religion_desc'];
  	}
}

?>