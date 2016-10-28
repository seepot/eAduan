<?php 

class Menu extends Zend_Db_Table_Abstract {
 
	protected $_name = 'tbl_menu';
 
	public function getMenuOptions($type_id) 
	{
 
	    $select = $this->select();
		$select->from($this, array('menu_id', 'menu_name'))
			->where('menu_type_id = '.$type_id);
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
}

?>