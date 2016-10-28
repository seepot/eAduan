<?php

class Pesara
{
	public function getReligionById($id = 0) 
	{
	    $db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$sql = "SELECT religion_desc AS result FROM sys_religion WHERE religion_id = '".$id."'";
							
		$result = $db->fetchRow($sql);
	 
	    return $result->result;
  	}
	
	public function getRaceById($id = 0) 
	{
	    $db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$sql = "SELECT race_desc AS result FROM sys_race WHERE race_id = '".$id."'";
							
		$result = $db->fetchRow($sql);
	 
	    return $result->result;
  	}
	
	public function getSexById($id = 0) 
	{
	    $db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$sql = "SELECT gender_desc_may AS result FROM sys_gender WHERE gender_id = '".$id."'";
							
		$result = $db->fetchRow($sql);
	 
	    return $result->result;
  	}
	
	public function getMaritalStatusById($id = 0) 
	{
	    $db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$sql = "SELECT ursmrd_name AS result FROM sys_marital WHERE usrmrd_id = '".$id."'";
							
		$result = $db->fetchRow($sql);
	 
	    return $result->result;
  	}
	
	public function getParaById($id = 0) 
	{
	    $db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$sql = "SELECT para_sebab, para_peraturan FROM tbl_para_berhenti WHERE para_id = '".$id."'";
							
		$result = $db->fetchRow($sql);
	 
	    return $result->para_peraturan.' - '.$result->para_sebab;
  	}
	
	public function getEducationById($id = 0) 
	{
	    $db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$sql = "SELECT sys_edu_level_desc_bm AS result FROM sys_education_level WHERE sys_edu_level_id = '".$id."'";
							
		$result = $db->fetchRow($sql);
	 
	    return $result->result;
  	}
	
	public function getServiceById($id = 0) 
	{
	    $db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$sql = "SELECT perkhidmatan_desc AS result FROM sys_kategori_perkhidmatan WHERE perkhidmatan_id = '".$id."'";
							
		$result = $db->fetchRow($sql);
	 
	    return $result->result;
  	}
	
	public function getStatusPencenById($id = 0) 
	{
	    if($id == 1)
			return 'Berpencen';
		else
			return 'Tidak Berpencen';
	 
  	}
	
	public function getJenisPenerimaById($id = 0) 
	{
	    if($id == 1)
			return 'Pesara';
		else if($id == 2)
			return 'Waris';
		else 
			return 'Tiada';
	 
  	}
	
	public function getStateById($id = 0) 
	{
	    $db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$sql = "SELECT sta_name AS result FROM sys_state WHERE sta_id = '".$id."'";
							
		$result = $db->fetchRow($sql);
	 
	    return $result->result;
  	}
	
	public function getPangkatById($id = 0) 
	{
	    $db = Zend_Registry::get ( 'db' );
		$db->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$sql = "SELECT pangkat_desc AS result FROM sys_pangkat WHERE pangkat_id = '".$id."'";
							
		$result = $db->fetchRow($sql);
	 
	    return $result->result;
  	}

}