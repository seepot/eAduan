<?php

class Admin_IndexController extends Spt_Controller_Action
{
    protected $_start_day = 0;
    protected $_calender_title = 'Calendar';
	
	public function indexAction()
    {
		$this->view->translate = $this->translate();
		
		$cal = new Spt_Includes_Calendar;
		
		//echo $cal->func_print_calendar($int_selected_day = 0,'7','2009');
		
		if ($this->_getParam('month') == "" || $this->_getParam('month') > 12 || $this->_getParam('month') < 1){
			$month = date("m");
		} else {
			$month = $this->_getParam('month');
		}
		if ($this->_getParam('year') == "" || $this->_getParam('year') < 1972 || $this->_getParam('year') > 2036){
			$year = date("Y");
		} else {
			$year = $this->_getParam('year');
		}

		$timestamp = mktime(0, 0, 0, $month, 1, $year);
	   
		$current = date("F Y", $timestamp);

		if ($month < 2)
		{
			$prevmonth = 12;
			$prevyear = $year - 1;
		}
		else
		{
			$prevmonth = $month - 1;
			$prevyear = $year;
		}

		if ($month > 11)
		{
			$nextmonth = 1;
			$nextyear = $year + 1;
		}
		else
		{
			$nextmonth = $month + 1;
			$nextyear = $year;
		}

		$backward = date("F Y", mktime(0, 0, 0, $prevmonth, 1, $prevyear));
		$forward = date("F Y", mktime(0, 0, 0, $nextmonth, 1, $nextyear));

		$first = date("w", mktime(0, 0, 0, $month, 1, $year));
	   
		$lastday = 28;
	   
		for ($i=$lastday;$i<32;$i++)
		{
			if (checkdate($month, $i, $year))
			{
				$lastday = $i;
			}
		}
   
		$str_calendar = '<center><table cellspacing=5 cellpadding=1 id=calendar>
				<tr>
				<td align="center" valign="middle" height=60 COLSPAN=7>
					<table class="top" cellspacing=0 cellpadding=0 width=100% border=0>
					<tr>
					<td class="ends" nowrap align="center" valign="bottom">
						<a href="'.SYSTEM_URL.'/admin/index/index/month/'.$prevmonth.'/year/'.$prevyear.'"><< '.$backward.'</a>
					</td>
					<td class="top" nowrap align="center" valign="middle">';
				if (isset($calender_title_image) && $calender_title_image != '')
				{
					$str_calendar .= '<img src="'.$calender_title_image.'">';
				}
				else
				{
					$str_calendar .= $this->_calender_title;
				}
				$str_calendar .= '<br>'.$current.'
					</td>
					<td class="ends" nowrap align="center" valign="bottom">
						<a href="'.SYSTEM_URL.'/admin/index/index/month/'.$nextmonth.'/year/'.$nextyear.'">'.$forward.' >></a>
					</td>
					</tr>
					</table>
				</td>
				</tr>
				<tr>';
				if (isset($start_day) && $start_day <= 6 && $start_day >= 0)
				{
					$n = $start_day;
				}
				else
				{
					$n = 0;
				} 
				for ($i=0;$i<7;$i++)
				{
					if ($n > 6)
					{
						$n = 0;
					}
					if ($n == 0)
					{
						$str_calendar .= '	<td class="days" nowrap align="center" valign="middle" width=90 height=40>Ahad</td>';
					}
					if ($n == 1)
					{
						$str_calendar .= '	<td class="days" nowrap align="center" valign="middle" width=90 height=40>Isnin</td>';
					}
					if ($n == 2)
					{
						$str_calendar .= '	<td class="days" nowrap align="center" valign="middle" width=90 height=40>Selasa</td>';
					}
					if ($n == 3)
					{
						$str_calendar .= '	<td class="days" nowrap align="center" valign="middle" width=90 height=40>Rabu</td>';
					}
					if ($n == 4)
					{
						$str_calendar .= '	<td class="days" nowrap align="center" valign="middle" width=90 height=40>Khamis</td>';
					}
					if ($n == 5)
					{
						$str_calendar .= '	<td class="days" nowrap align="center" valign="middle" width=90 height=40>Jumaat</td>';
					}
					if ($n == 6)
					{
						$str_calendar .= '	<td class="days" nowrap align="center" valign="middle" width=90 height=40>Sabtu</td>';
					}
					$n++;
				}
				$str_calendar .= '	</tr>';
				$calday = 1;
				while ($calday <= $lastday)
				{
			/* Alternate beginning day of the week for calendar view was created by Marion Heider of clixworx.net. */
					echo '<tr>';
					for ($j=0;$j<7;$j++)
					{
						if ($j == 0)
						{
							$n = $this->_start_day;
						}
						else
						{
							if ($n < 6)
							{
								$n = $n + 1;
							}
							else
							{
								$n = 0;
							}
						}
						if ($calday == 1)
						{
							if ($first == $n)
							{
								$info = $this->FillDay($n, $calday, $month, $year);
								$str_calendar .= $this->AddDay($calday, $month, $year, $info);
								$calday++;
							}
							else
							{
								$str_calendar .= $this->AddDay('', '', '', '');
							}
						}
						else
						{
							if ($calday > $lastday)
							{
								$str_calendar .= $this->AddDay('', '', '', '');
							}
							else
							{
								//$info = '';
								$info = $this->FillDay($n, $calday, $month, $year);
								$str_calendar .= $this->AddDay($calday, $month, $year, $info);
								$calday++;
							}
						}
					} 
					$str_calendar .= '</tr>';
				}
				$str_calendar .= '	</TABLE></CENTER>';
			   
		$this->view->calendar = $str_calendar;
    }
	
	public function AddDay($fday, $fmonth, $fyear, $fvar)
	{
		$str_day = '';
		
		if (!isset($fday) || $fday == "")
		{
			$str_day .= '	<TD class="calendar" align="left" valign="top" width=130 height=100 style="background-color:#CCCCCC">&nbsp;';
		}
		else
		{
			//$schurl = 'schedule.php?day='.$fday.'&month='.$fmonth.'&year='.$fyear;
			$schurl = SYSTEM_URL.'/tempahan/transaksi/schedule/day/'.$fday.'/month/'.$fmonth.'/year/'.$fyear;
			if (date("m") == $fmonth && date("Y") == $fyear && date("j") == $fday)
			{
				$str_day .= '	<TD ID="day'.$fday.'" class="curday" style="cursor: hand" align="left" valign="top" width=130 height=100 
						onMouseOver="tdmouseover(\'day'.$fday.'\')"; onMouseOut="tdcurmouseout(\'day'.$fday.'\')"; 
						onClick="window.open(\''.$schurl.'\', \'schedule\', \'width=800,height=600,scrollbars=yes,resizable=yes\')">';
			}
			else
			{
				$str_day .= '	<TD ID="day'.$fday.'" class="calendar" style="cursor: hand" align="left" valign="top" width=130 height=100 
						onMouseOver="tdmouseover(\'day'.$fday.'\')"; onMouseOut="tdmouseout(\'day'.$fday.'\')"; 
						onClick="window.open(\''.$schurl.'\', \'schedule\', \'width=800,height=600,scrollbars=yes,resizable=yes\')">';
			}
			$str_day .= '<b>'.$fday.'</b><br>';
			if (isset($fvar) && $fvar != "")
			{
				$str_day .= '<A class=\'calendar\' style="cursor: hand" onClick="javascript:window.open(\''.$schurl.'\', \'schedule\', \'width=800,height=600,scrollbars=yes,resizable=yes\')">';
				$str_day .= '		'.$fvar.'</A>';
			}
		}
		$str_day .= '	</TD>';
	  
		return $str_day;
	}
   
	public function FillDay($dayofweek, $dayofmonth, $thismonth, $thisyear)
	{
		$textbody = '<ul>';
		$nr = $this->GetByDate($thismonth, $dayofmonth, $thisyear);
		
		foreach($nr as $value){
			//$textbody .= $value['tempahan_bahagian'].'('.$value['tempahan_masa_mula'].' - '.$value['tempahan_masa_tamat'].')<br>';
			$textbody .= '<li> - '.$value['tempahan_bahagian'].'</li>';
		}
		//print_r($nr);
		$textbody .= '</ul>';
		return $textbody;
	}
	
	protected function GetByDate($month, $day, $year)
	{
		$db = Zend_Registry::get ( 'db' );
		$chkdate = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
		/* $query = "SELECT tempahan_bahagian FROM tbl_tempahan 
					WHERE tempahan_tarikh_mula >= '$chkdate' 
					AND tempahan_tarikh_tamat <= '$chkdate'
					ORDER BY tempahan_masa_mula"; */
		$query = "SELECT tempahan_bahagian,tempahan_masa_mula,tempahan_masa_tamat 
					FROM tbl_tempahan 
					WHERE tempahan_tarikh_mula <= '$chkdate' 
					AND '$chkdate' <= tempahan_tarikh_tamat
					AND tempahan_status = 3
					ORDER BY tempahan_masa_mula
					
					";
		
		//echo $query.'<br><br>';
		
		return $db->fetchAll($query);
	}
} 