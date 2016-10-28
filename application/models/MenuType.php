<?php 

class MenuType extends Zend_Db_Table_Abstract {
 
	protected $_name = 'tbl_menu_type';
 
	public function getMenuTypeOptions() 
	{
 
	    $select = $this->select();
		$select->from($this, array('menu_type_id', 'menu_type_name'));
			//->where('type_group_id <> 1');
	    $result = $this->getAdapter()->fetchPairs($select);
	 
	    return $result;
  	}
	
	
	
	
}
