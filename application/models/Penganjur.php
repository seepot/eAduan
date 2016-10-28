<?php

class Penganjur extends Zend_Db_Table
{

    protected $_name = 'sys_penganjur';
	
	public function getPenganjurOptions() 
	{
	    $select = $this->select();
		$select->from($this, array('penganjur_id', 'penganjur_name'))
			->where('aktif_id = 1');
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
	

}