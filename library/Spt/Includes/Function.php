<?php 

class Spt_Includes_Function
{
	function getMobileNoById($id = '') 
	{
		$db = Zend_Registry::get ( 'db' );
		//$select->where('status_id IN(?)', $data);
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'sys_user_detail'),
							array('usr_mobile_no'))
						->where( 'usr_id = ?', $id )
        );
        
        if($result)
        	return $result->usr_mobile_no;
        else 
        	return '';
  	}
	function getPegawaiById($id = '') 
	{
		$db = Zend_Registry::get ( 'db' );
		//$select->where('status_id IN(?)', $data);
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'ea_bpm'),
							array('pegawai_id'))
						->where( 'bpm_id = ?', $id )
        );
        
        if($result)
        	return $result->pegawai_id;
        else 
        	return '';
  	}
	function getTahapByUsrId($id = 0, $type = '') 
	{
		$db = Zend_Registry::get ( 'db' );
		$data = array(30,33,35);
		//$select->where('status_id IN(?)', $data);
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'ea_aduan'),
							array('count' => 'COUNT(*)'))
						->where( 'pegawai_user = ?', $id )
						->where('status IN(?)', $data)
						->where('pegawai_tahap = ?', $type)
        );
        
        if($result)
        	return $result->count;
        else 
        	return '';
  	}
	function getPenyeliaByUserId($id = '') 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
							->from(array('d' => 'sys_user_detail'),
								array())
							->join(array('u' => 'ea_unit'),
								'd.jhev_unit = u.unit_id',
								array())
							->join(array('a' => 'sys_user'),
								'u.penyelia_id = a.usr_id',
								array('usr_id'))
							->where( 'd.usr_id = ?', $id )
        );
        
        if($result)
        	return $result->usr_id;
        else 
        	return '';
  	}
	function getNoJabatanById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'sys_user_detail'),
							array('jhev_no'))
						->where( 'usr_id = ?', $id )
        );
        
        if($result)
        	return $result->jhev_no;
        else 
        	return '';
  	}
	function getPositionById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('a' => 'sys_user_detail'),
							array())
						->join(array('b' => 'ea_jawatan'),
							'a.jhev_jawatan = b.jawatan_id',
							array('jawatan_desc') )
						->where( 'usr_id = ?', $id )
        );
        
        if($result)
        	return $result->jawatan_desc;
        else 
        	return '';
  	}
	function getDeptById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('a' => 'sys_user_detail'),
							array())
						->join(array('b' => 'ea_bahagian'),
							'a.jhev_dept = b.id',
							array('desc') )
						->where( 'usr_id = ?', $id )
        );
        
        if($result)
        	return $result->desc;
        else 
        	return '';
  	}
	function getUnitBpm2ById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('a' => 'sys_user_detail'),
							array())
						->join(array('b' => 'ea_bpm'),
							'a.usr_bpm = b.bpm_id',
							array('bpm_name') )
						->where( 'usr_id = ?', $id )
        );
        
        if($result)
        	return $result->bpm_name;
        else 
        	return '';
  	}
	function getUnitById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('a' => 'sys_user_detail'),
							array())
						->join(array('b' => 'ea_unit'),
							'a.jhev_unit = b.unit_id',
							array('unit_desc') )
						->where( 'usr_id = ?', $id )
        );
        
        if($result)
        	return $result->unit_desc;
        else 
        	return '';
  	}
	function getPhoneNoById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('a' => 'sys_user_detail'),
							array('usr_mobile_no'))
						->where( 'usr_id = ?', $id )
        );
        
        if($result)
        	return $result->usr_mobile_no;
        else 
        	return '';
  	}
	function getStatusMasalah($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('a' => 'ea_statusmasalah'),
							array('status_desc'))
						->where( 'status_id = ?', $id )
        );
        
        if($result)
        	return $result->status_desc;
        else 
        	return '';
  	}
	function getNoKpById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'sys_user'),
							array('usr_identno'))
						->where( 'usr_id = ?', $id )
        );
        
        if($result)
        	return $result->usr_identno;
        else 
        	return '';
  	}
	function getTahapById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'ea_tahap'),
							array('tahap_desc'))
						->where( 'tahap_id = ?', $id )
        );
        
        if($result)
        	return $result->tahap_desc;
        else 
        	return '';
  	}
	function getKelulusanById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'ea_kelulusan'),
							array('kelulusan_desc'))
						->where( 'kelulusan_id = ?', $id )
        );
        
        if($result)
        	return $result->kelulusan_desc;
        else 
        	return '';
  	}
	
	function getPengesahanById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'ea_pengesahan'),
							array('pengesahan_desc'))
						->where( 'pengesahan_id = ?', $id )
        );
        
        if($result)
        	return $result->pengesahan_desc;
        else 
        	return '';
  	}
	
	function getFullNameById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'sys_user'),
							array('usr_fullname'))
						->where( 'usr_id = ?', $id )
        );
        
        if($result)
        	return $result->usr_fullname;
        else 
        	return '';
  	}
	
	function getUnitJhevById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'ea_unit'),
							array('unit_desc'))
						->where( 'unit_id = ?', $id )
        );
        
        if($result)
        	return $result->unit_desc;
        else 
        	return '';
  	}
	function getDeptJhevById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'ea_bahagian'),
							array('desc'))
						->where( 'id = ?', $id )
        );
        
        if($result)
        	return $result->desc;
        else 
        	return '';
  	}
	
	function getUnitBpmById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'ea_bpm'),
							array('bpm_name'))
						->where( 'bpm_id = ?', $id )
        );
        
        if($result)
        	return $result->bpm_name;
        else 
        	return '';
  	}
	
	function getUnitBpmByUserId($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'ea_bpm'),
							array('bpm_id'))
						->where( 'pegawai_id = ?', $id )
        );
        
        if($result)
        	return $result->bpm_id;
        else 
        	return '';
  	}
	
	function getKategoriMasalahById($id = 0) 
	{
		$db = Zend_Registry::get ( 'db' );
		
		$result = $db->fetchRow(
        			$db->select()
        				->from(array('d' => 'ea_kategoriMasalah'),
							array('km_desc'))
						->where( 'km_id = ?', $id )
        );
        
        if($result)
        	return $result->km_desc;
        else 
        	return '';
  	}
	
	function func_ymdhis2dmyhis($str_date = '')	{
	
		$str_date	=	trim($str_date);
		if (empty($str_date) == true)
			return '';
		if ((is_numeric(substr($str_date,0,4)) == true) &&
			(is_numeric(substr($str_date,5,2)) == true) &&
			(is_numeric(substr($str_date,-2)) == true))
			return (substr($str_date,8,2) . "-" . substr($str_date,5,2) . "-" . substr($str_date,0,4) . " " . substr($str_date,-8));
		else
			return '';
	}
	
	function func_ymd2dmy($str_date = '')	{
	
		$str_date	=	trim($str_date);
		if (empty($str_date) == true)
			return '';
		if ((is_numeric(substr($str_date,0,4)) == true) &&
			(is_numeric(substr($str_date,5,2)) == true) &&
			(is_numeric(substr($str_date,-2)) == true))
			return (substr($str_date,8,2) . "-" . substr($str_date,5,2) . "-" . substr($str_date,0,4));
		else
			return '';
	}

	
	function func_dmy2ymd($str_date = '')	{
	
		$str_date	=	trim($str_date);
		if (empty($str_date) == true)
			return '';
		if ((is_numeric(substr($str_date,0,2)) == true) &&
			(is_numeric(substr($str_date,3,2)) == true) &&
			(is_numeric(substr($str_date,-4)) == true))
			return (substr($str_date,6,4) . "-" . substr($str_date,3,2) . "-" . substr($str_date,0,2));
		else
			return '';
	}


	function func_mdy2ymd($str_date = '')	{
	
		$str_date	=	trim($str_date);
		if (empty($str_date) == true)
			return '';
		if ((is_numeric(substr($str_date,0,2)) == true) &&
			(is_numeric(substr($str_date,3,2)) == true) &&
			(is_numeric(substr($str_date,-4)) == true))
			return (substr($str_date,6,4) . "-" .substr($str_date,0,2). "-" .substr($str_date,3,2));
		else
			return '';
	}
	


	function func_ymd2dmytime($str_date = '')	{
	
		$str_date	=	trim($str_date);
		if (empty($str_date) == true)
			return '';
		if ((is_numeric(substr($str_date,0,4)) == true) &&
			(is_numeric(substr($str_date,5,2)) == true) &&
			(is_numeric(substr($str_date,-2)) == true))
			return (substr($str_date,8,2) . "-" . substr($str_date,5,2) . "-" . substr($str_date,0,4). substr($str_date,10,18));
		else
			return '';
	}

	
	function func_ymd2timestamp($str_date = '', $int_hour = 0, $int_min = 0, $int_second = 0)	{
	
		$str_date	=	trim($str_date);
		if (empty($str_date) == true)
			return '';

		$int_day = substr($str_date,8,2);
		$int_mon = substr($str_date,5,2);
		$int_year = substr($str_date,0,4);

		if ((is_numeric($int_day) == true) &&
			(is_numeric($int_mon) == true) &&
			(is_numeric($int_year) == true))
			return mktime($int_hour,$int_min,$int_second,$int_mon,$int_day,$int_year);
		else
			return '';
	
	}

	function date_yyyymmdd($dat_ToFormat) {	// Format date dd-mm-yyyy To yyyy-mm-dd
		return substr($dat_ToFormat,6,4).'-'.substr($dat_ToFormat,3,2).'-'.substr($dat_ToFormat,0,2);
	}	

	function date_ddmmyyyy($dat_ToFormat) {	// Format date dd-mm-yyyy To yyyy-mm-dd
		return substr($dat_ToFormat,8,2).'-'.substr($dat_ToFormat,5,2).'-'.substr($dat_ToFormat,0,4);
	}
	
	function date_ddmmyyyy2($dat_ToFormat) {	// Format date dd-mm-yyyy To yyyy-mm-dd
		return substr($dat_ToFormat,8,2).' '.func_get_month_name(substr($dat_ToFormat,5,2)).' '.substr($dat_ToFormat,0,4);
	}

	function func_get_day_desc($int_day = 0)	{
	
		switch($int_day)	{	
			case 0:		
				return 'Ahad';
				break;
			case 1:		
				return 'Isnin';
				break;
			case 2:		
				return 'Selasa';
				break;
			case 3:		
				return 'Rabu';
				break;
			case 4:		
				return 'Khamis';
				break;
			case 5:		
				return 'Jumaat';
				break;
			case 6:		
				return 'Sabtu';
				break;
		}
	}


	function func_get_month_name($int_month = 0)	{
	
		switch($int_month)	{
			case 1:		
				return 'Januari';
				break;
			case 2:		
				return 'Februari';
				break;
			case 3:		
				return 'Mac';
				break;
			case 4:		
				return 'April';
				break;
			case 5:		
				return 'Mei';
				break;
			case 6:		
				return 'Jun';
				break;
			case 7:		
				return 'Julai';
				break;
			case 8:		
				return 'Ogos';
				break;
			case 9:		
				return 'September';
				break;
			case 10:		
				return 'Oktober';
				break;
			case 11:		
				return 'November';
				break;
			case 12:		
				return 'Disember';
				break;
		}
	}

	function func_select_month($arr_month='',$str_id_name='',$int_selected=0)
	{
		$str_month				=	'';		// html drop down list (string)
		$int_total_month		=	0;		// counter
		//die($int_selected);
		global $sys_config;
		if (!is_array($arr_month)) { return ''; }		// no jnsproduk array exit
		
		
		$str_month		=	"\n<select id=\"" . (($str_id_name != '') ? $str_id_name : 'sel_month_id') . "\""
						.	"   name=\"" . (($str_id_name != '') ? $str_id_name : 'sel_month_id') . "\">\n"
						.	"<option value=\"0\" >"._SELECT_OPTION."</option>";
		
		
		$int_total_month = count($arr_month);
		for ($x = 0; $x < $int_total_month; $x++)	{
			$str_month .=	"\n<option value=\"".$arr_month[$x]['month_id']."\"".(($arr_month[$x]['month_id']==$int_selected) ? "selected=selected":'') ."\">";
				$str_month .= $arr_month[$x]['month_name'];
			$str_month .= "</option>";
		}
		$str_month .= "\n</select>"; 

		return $str_month;		// return html drop down list (string)
	
	}
	
	function func_arr_month()
	{
	
		global $db;	// databse object
		global $sys_config;
		$arr_month			=	array();	// category array
		$int_counter		=	0;			// counter
		
		$sql_select			=	"SELECT `month_id`, `month_name_".$sys_config['language']."` AS `month_name`"
							.	"  FROM `sys_month`"
							.	" WHERE 1";
						//echo($sql_select);
				
		$res_select			=	$db->sql_query($sql_select) or die(print_r($db->sql_error()));
		
		if ($db->sql_numrows($res_select) > 0)	
		{
			while($row_select = $db->sql_fetchrow($res_select))
			{
				$arr_month[$int_counter] = $row_select;
				// recursive function call
				$arr_month[$int_counter]['month_name'] = $row_select['month_name'];	
				$arr_month[$int_counter]['month_id'] = $row_select['month_id'];
				$int_counter++;		// increase counter
			}
			return $arr_month;	// return multi-demisional array
		}
		else
			return 0;	// no skop found
	
	
	}
}

?>