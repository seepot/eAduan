<?php

class Signature extends Zend_Db_Table
{

    protected $_name = 'tbl_signature';
	/*
	public function getSignatureOptions() 
	{
	    $select = $this->select();
		$select->from($this, array('district_id', 'district_name'))
			//->where('sta_id < 17')
			->where('district_status = 1');
	    $result = $this->getAdapter()->fetchPairs($select);

	    return $result;
  	}
	*/

}