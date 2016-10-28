<?php 

class Spt_Includes_Cronology
{
	function func_createCronology($label = '', $detail = '', $no_cro = '')	{
	
		$translate = Zend_Registry::get ( 'translate' );
		
		$bil = count($label);
		$str_cronology = '<div class="entry-edit"><div class="fieldset " id="group_fields63">';
		$str_cronology .= '<table cellpadding="0" cellspacing="0" width="100%">';
		$str_cronology .= '<tr align="left" valign="middle">';
		foreach ($no_cro as $index => $value){
			$str_cronology .= '<td width="150px">';
			$str_cronology .= '<table cellpadding="0" cellspacing="0" border="0">';
			$str_cronology .= '<tr>';
			$str_cronology .= '<td><img src="'.IMAGES_PATH.'corner/corner_left.gif"></td>';
			$str_cronology .= '<td bgcolor="#CCCCCC"><!---null---></td>';
			$str_cronology .= '<td><img src="'.IMAGES_PATH.'corner/corner_right.gif"></td>';
			$str_cronology .= '</tr>';
			$str_cronology .= '<tr>';
			$str_cronology .= '<td bgcolor="#CCCCCC"><!---null---></td>';
			$str_cronology .= '<td bgcolor="#CCCCCC"><div align="center"><strong>'.$translate->_($label[$value]).'</strong><br>'.$detail[$value].'</div></td>';
			$str_cronology .= '<td bgcolor="#CCCCCC"><!---null---></td>';
			$str_cronology .= '</tr>';
			$str_cronology .= '<tr>';
			$str_cronology .= '<td><img src="'.IMAGES_PATH.'corner/corner_left_bottom.gif"></td>';
			$str_cronology .= '<td bgcolor="#CCCCCC"><!---null---></td>';
			$str_cronology .= '<td><img src="'.IMAGES_PATH.'corner/corner_right_bottom.gif"></td>';
			$str_cronology .= '</tr>';
			$str_cronology .= '</table>';
			$str_cronology .= '</td>';
			if($value < $bil-1){
				$str_cronology .= '<td width="60px" align="center">';
				$str_cronology .= '&nbsp;<img src="'.IMAGES_PATH.'corner/barrow_green.gif" height="30" width="40">&nbsp;';
				$str_cronology .= '</td>';
			}
		}
		$str_cronology .= '<td>&nbsp;</td>';
		$str_cronology .= '</tr>';
		$str_cronology .= '</table>';
		$str_cronology .= '</div></div>';
		
		return $str_cronology;
	}
	
}

?>