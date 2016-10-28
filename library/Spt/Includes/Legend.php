<?php 

class Spt_Includes_Legend
{
	function func_createLegend($arr_legend = array())	{
	
		$translate = Zend_Registry::get ( 'translate' );
		
		$str_legend = '<div class="entry-edit">';
		$str_legend .= '<div class="fieldset" id="group_fields63">';
		$str_legend .= '<table width="100%" cellpadding="5" cellspacing="1">';
		$str_legend .= '<tr>';
		$str_legend .= '<td width="10%"><strong>'.$translate->_('Petunjuk').':</strong></td>';
		foreach ($arr_legend['item'] as $value){
			$str_legend .= '<td width="30px" style="border:solid 1px #000000" class="'.$value['class'].'"></td>';
			$str_legend .= '<td width="70px" align="left" valign="top"> <nobr>&nbsp;'.$value['label'].'</nobr></td>';
		}
		$str_legend .= '</tr>';
		$str_legend .= '</table>';
		$str_legend .= '</div>';
		$str_legend .= '</div>';
		
		return $str_legend;
	}
	
}

?>