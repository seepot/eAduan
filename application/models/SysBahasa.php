<?php

class SysBahasa extends Zend_Db_Table
{

    protected $_name = 'sys_bahasa';
	
	public function getBahasaOptions() 
	{
		$select = $this->select();
		$select->from($this, array('bahasa_id', 'bahasa_name'))
			->where('bahasa_aktif = 1');
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
	

}