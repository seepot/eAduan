<?php 

class Spt_Includes_Calendar
{
	protected $_int_selected_month = 0;
	protected $_int_selected_year = 0;
	
	function func_print_calendar($int_selected_day,$int_selected_month,$int_selected_year)	{
	
		$str_calendar = '';
		$this->_int_selected_month = $int_selected_month;
		$this->_int_selected_year = $int_selected_year;
		
		$int_month_start			=	mktime(0,0,0,$int_selected_month,1,$int_selected_year);		// get month start timestamp
		$int_total_days_of_month	=	date("t",$int_month_start);									// get total days in the given month
		$int_first_weekday			=	date("w",$int_month_start);									// get 1st week day in the given month
		$int_month_end				=	mktime(23,59,59,$int_selected_month,$int_total_days_of_month,$int_selected_year);	// get month end timestamp
		$int_day_counter			=	0;	// day counter initialize	
		
		
		$week_day	=	array();	// weekend array
		for ($int_day = 1; $int_day <= $int_total_days_of_month; $int_day++)	{
			$int_day_of_month	=	date("w",mktime(0,0,0,$int_selected_month,$int_day,$int_selected_year));
			$int_timestamp_day = mktime(0,0,0,$int_selected_month,$int_day,$int_selected_year);

			if ($int_day_of_month==0 || $int_day_of_month==6)	{
				if ($int_day_of_month==0)
					$week_day[$int_day] = array(3000,$int_timestamp_day,"Ahad");	// set day name 
				else
					$week_day[$int_day] = array(3000,$int_timestamp_day,"Sabtu");	// set day name 
			}
		}	
		// (end) get weekend for the given month-----------------------------------------------------------------------

		// generate 1st row -----
		$str_calendar .= "<tr valign=\"top\">";

		if ($int_first_weekday > 0)
			$str_calendar .= "<td colspan=\"".$int_first_weekday."\" bgcolor=\"#666666\">&nbsp;</td>";

		for ($int_day = $int_first_weekday; $int_day <= 6; $int_day++)	{	// generate day column for 1st row
			$this->func_print_column(++$int_day_counter,$week_day);	// print day column
		}

		$str_calendar .= "</tr>";
		
		// generate remaining rows -----
		for ($int_week = 2; $int_week <= 6; $int_week++)	{	
			$str_calendar .= "<tr valign=\"top\">";
		
			for ($int_day = 0; $int_day <= 6; $int_day++)	{	// generate day column for remaining rows
				$this->func_print_column(++$int_day_counter,$week_day);	// print day column
				if ($int_day_counter >= $int_total_days_of_month)	{	// finish print day of month
					if ($int_day < 6) 
					$str_calendar .= "<td colspan=\"".(6 - $int_day)."\" bgcolor=\"#666666\">&nbsp;</td>"; // generate remaining column

				$int_day	=	7;	// terminate day loop
				$int_week 	=	7;	// terminate week loop
				}
			}
			$str_calendar .= "</tr>";
		}
		
		return $str_calendar;
	}
	
	function func_print_column($int_selected_day=0,$week_day)	{


	 global $sys_config,$int_selected_month,$int_selected_year;
	 
	 $db2 = Zend_Registry::get ( 'db2' );
	 
	 if(isset($_GET['syk_id']) == true)
		$int_syk_id	= $_GET['syk_id'];
	 elseif(isset($_POST['syk_id']) == true)
		$int_syk_id	= $_POST['syk_id'];
	 else
		$int_syk_id	= NULL;

	 if(isset($_GET['pita_id']) == true)
		$int_pita_id	= $_GET['pita_id'];
	 elseif(isset($_POST['pita_id']) == true)
		$int_pita_id	= $_POST['pita_id'];
	 else
		$int_pita_id	= NULL;
	 
	 if(strlen($this->_int_selected_month)==1)$this->_int_selected_month='0'.$this->_int_selected_month;
		if ($int_selected_day == 0)	
			return 0;

			$int_leave_id 	=	0;
			
		$int_page_offset = 0;
		/* check dalam tbl_flm_tape_jdl_com */
		$sql_criteria	=	" WHERE DATE_FORMAT(tbl_flm_tape_jdl.jdl_tkh,'%d-%m-%Y') = '"
						.	(($int_selected_day < 10)?"0".$int_selected_day:$int_selected_day)."-".$this->_int_selected_month."-".$this->_int_selected_year."'"
						.	"   AND tbl_flm_tape_jdl_com.jdl_id is not null ";

		$db->fetchRow("SELECT menu_id, menu_name 
							FROM tbl_menu 
							WHERE menu_type_id = ?",$type_id);
							
							
		$sql_select		=	" SELECT tbl_flm_tape.flm_tape_tajuk, "
						.	"   	 tbl_flm_tape_jdl.jdl_stat_id, "
						.	"   	 tbl_flm_tape_jdl.jdl_id, "
						.	"   	 tbl_flm_tape_jdl_pggng.pggng_desc "
						.	"   FROM tbl_flm_tape_jdl_com "
						.	"   LEFT OUTER JOIN tbl_flm_tape_jdl ON tbl_flm_tape_jdl.jdl_id = tbl_flm_tape_jdl_com.jdl_id "
						.	"   LEFT OUTER JOIN tbl_flm_tape ON tbl_flm_tape.flm_tape_id = tbl_flm_tape_jdl_com.flm_tape_id "
						.	"   LEFT OUTER JOIN tbl_flm_tape_jdl_pggng ON tbl_flm_tape_jdl_pggng.pggng_id = tbl_flm_tape_jdl_com.pggng_id "
						.	$sql_criteria;
		$res_select	=	$db -> sql_query( $sql_select,END_TRANSACTION ) or die ( print_r( $db -> sql_error() ) );
		$res_select2 =	$db -> sql_query( $sql_select,END_TRANSACTION ) or die ( print_r( $db -> sql_error() ) );
		$row_select2 = $db -> sql_fetchrow($res_select2 );
		if ($db->sql_numrows($res_select) > 0)
		{ 
				echo "<td ";
				if($row_select2['jdl_stat_id'] == 0) 
				{
				echo "bgcolor=\"" . ((isset($week_day[$int_selected_day]) == true)?  get_leave_color($week_day[$int_selected_day][0])  : get_leave_color(1000) ) . "\">" ;
				}
				elseif($row_select2['jdl_stat_id'] == 1) 
				{
				echo "class=\"contents_warning_3\"> " ;
				}
				elseif($row_select2['jdl_stat_id'] == 2)
				{
				echo "class=\"contents_warning_2\">" ;
				}
				elseif($row_select2['jdl_stat_id'] == 3)
				{
				echo "class=\"contents_warning_green\">" ;
				}
				echo "<p align=\"right\">";
				echo "</p>";
				echo "<table border=\"0\" width=\"100%\" \>";
				echo "<tr>";
				echo "<td align=\"right\" colspan=\"2\"><strong>" . $int_selected_day . "</strong></font></td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td align=\"right\"";
				if($row_select2['jdl_stat_id'] == 0) 
				{
				echo "bgcolor=\"" . ((isset($week_day[$int_selected_day]) == true)?  get_leave_color($week_day[$int_selected_day][0])  : get_leave_color(1000) ) . "\">" ;
				}
				elseif($row_select2['jdl_stat_id'] == 1) 
				{
				echo "class=\"contents_warning_3\"> " ;
				}
				elseif($row_select2['jdl_stat_id'] == 2)
				{
				echo "class=\"contents_warning_2\">" ;
				}
				elseif($row_select2['jdl_stat_id'] == 3)
				{
				echo "class=\"contents_warning_green\">" ;
				}
				echo func_preview_button($sys_config['system_url']	. "?mod=filem&opt=filem_jadual_view"
																	. ((isset($int_syk_id)==NULL)?'':"&syk_id=". $int_syk_id)
																	. ((isset($int_pita_id)==NULL)?'':"&pita_id=". $int_pita_id)
																	. "&date="
																	. ((strlen($int_selected_day) < 2)? '0'.$int_selected_day:$int_selected_day)
																	. "-"
																	. $this->_int_selected_month
																	. "-"
																	. $this->_int_selected_year
																	. "&jdl_id="
																	. $row_select2['jdl_id']
																	. "&int_stat=1",'Lihat Jadual Tapisan',1); 
				if(($row_select2['jdl_stat_id'] == 0) and (($_SESSION['user']['level_id'] == 107) or ($_SESSION['user']['level_id'] == 1)))
				{
				echo "&nbsp;&nbsp;"
					 .func_edit_button($sys_config['system_url']. "?mod=filem&opt=filem_jadual_harian"
																. ((isset($int_syk_id)==NULL)?'':"&syk_id=". $int_syk_id)
																. ((isset($int_pita_id)==NULL)?'':"&pita_id=". $int_pita_id)
																. "&date="
																. ((strlen($int_selected_day) < 2)? '0'.$int_selected_day:$int_selected_day)
																. "-"
																. $this->_int_selected_month
																. "-"
																. $this->_int_selected_year
																. "&jdl_id="
																. $row_select2['jdl_id'],'Kemaskini Jadual Tapisan',1) ;
				}
				if($row_select2['jdl_stat_id'] == 1) 
				{
					if(($_SESSION['user']['level_id'] == 105) or ($_SESSION['user']['level_id'] == 1)) {
						echo "&nbsp;&nbsp;".func_verify_button($sys_config['system_url']	. "?mod=filem&opt=filem_jadual_verify"
																	. ((isset($int_syk_id)==NULL)?'':"&syk_id=". $int_syk_id)
																	. ((isset($int_pita_id)==NULL)?'':"&pita_id=". $int_pita_id)
																	. "&date="
																	. ((strlen($int_selected_day) < 2)? '0'.$int_selected_day:$int_selected_day)
																	. "-"
																	. $this->_int_selected_month
																	. "-"
																	. $this->_int_selected_year
																		. "&jdl_id="
																		. $row_select2['jdl_id'],'Pengesahan Jadual Tapisan',1); 
					 }
				}
				if($row_select2['jdl_stat_id'] == 2) 
				{
					if(($_SESSION['user']['level_id'] == 107) or ($_SESSION['user']['level_id'] == 1)) {
				echo "&nbsp;&nbsp;"
					 .func_edit_button($sys_config['system_url']. "?mod=filem&opt=filem_jadual_harian"
																. ((isset($int_syk_id)==NULL)?'':"&syk_id=". $int_syk_id)
																. ((isset($int_pita_id)==NULL)?'':"&pita_id=". $int_pita_id)
																. "&date="
																. ((strlen($int_selected_day) < 2)? '0'.$int_selected_day:$int_selected_day)
																. "-"
																. $this->_int_selected_month
																. "-"
																. $this->_int_selected_year
																		. "&jdl_id="
																		. $row_select2['jdl_id'],'Kemaskini Jadual Tapisan',1) ;
					}
				}
				echo "&nbsp; </td>";
				echo "</tr>";

		while ( $row_select = $db -> sql_fetchrow($res_select ) )
		{
			$int_page_offset++;		

			
				echo "<tr class=\"contents\" onMouseOver=\"javascript: this.className='contents_mouseover';\" onMouseOut=\"javascript: this.className='contents_mouseout';\">";
				echo "<td align=\"left\"";
				if($row_select2['jdl_stat_id'] == 0) 
				{
				echo "bgcolor=\"" . ((isset($week_day[$int_selected_day]) == true)?  get_leave_color($week_day[$int_selected_day][0])  : get_leave_color(1000) ) . "\">" ;
				}
				elseif($row_select2['jdl_stat_id'] == 1) 
				{
				echo "class=\"contents_warning_3\"> " ;
				}
				elseif($row_select2['jdl_stat_id'] == 2)
				{
				echo "class=\"contents_warning_2\">" ;
				}
				elseif($row_select2['jdl_stat_id'] == 3)
				{
				echo "class=\"contents_warning_green\">" ;
				}
				echo "<strong>". $row_select['flm_tape_tajuk'] . " </strong>";
				echo "<br />";
				echo "&nbsp;&nbsp;- ". $row_select['pggng_desc']. "</td>";
				echo "</tr>";
		}		
				echo "</table border=\"0\" \>";
				echo "</p>";
				echo "</td>";				
		
		
		}
		elseif (isset($week_day[$int_selected_day]) == true)
		{ 
				echo "<td bgcolor=\"" . get_leave_color($week_day[$int_selected_day][0]) . "\" height=\"35px\" ";
				echo "<p align=\"right\">";
				echo "<font color=\"#FF0000\"><strong>" . $int_selected_day . "</strong></font><br>";
	//			echo func_add_button($sys_config['system_url']."?mod=filem&opt=filem_jadual_harian&syk_id=".$_GET['syk_id']."&pita_id=".$_GET['pita_id'],'Daftar Jadual Tapisan',1);
				echo "</p>";
				echo "</td>";				
		
		
		}
		else {
			$sql_jdl_id	= "SELECT MAX(jdl_id) As max_id FROM tbl_flm_tape_jdl ";
			$res_jdl_id = $db -> sql_query($sql_jdl_id, END_TRANSACTION) or die(print_r($db -> sql_error()));
			$row_jdl_id = $db -> sql_fetchrow($res_jdl_id);
			
		echo "<td bgcolor=\"" . get_leave_color(1000) . "\" height=\"35px\" ";
			echo "<p align=\"right\">";
			echo "<strong>".$int_selected_day."</strong><br>";
			if (strlen($int_selected_day)==1)
				$int_day = "0".$int_selected_day;
			else
				$int_day = $int_selected_day;
				if(($_SESSION['user']['level_id'] == 107) or ($_SESSION['user']['level_id'] == 1))
				{
				echo func_add_button($sys_config['system_url']	. "?mod=filem&opt=filem_jadual_harian"
																. ((isset($int_syk_id)==NULL)?'':"&syk_id=". $int_syk_id)
																. ((isset($int_pita_id)==NULL)?'':"&pita_id=". $int_pita_id)
																. "&date="
																. ((strlen($int_selected_day) < 2)? '0'.$int_selected_day:$int_selected_day)
																. "-"
																. $this->_int_selected_month
																. "-"
																. $this->_int_selected_year
																. "&jdl_id="
																. ($row_jdl_id['max_id']+1),'Daftar Jadual Tapisan',1);
				}
			echo "</p>";
			echo "</td>"; //--wrong redirect---//			
		}	
		
	}
	
}

?>