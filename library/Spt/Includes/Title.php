<?php 

class Spt_Includes_Title
{
	function func_createTitle($label = '', $head = '', $arr_button = array())	{
	
		$translate = Zend_Registry::get ( 'translate' );
		
		//print_r($arr_button);
		$str_title = '<div class="content-header">';
		$str_title .= '<table cellspacing="0">';
		$str_title .= '<tr>';
		$str_title .= '<td style="width:50%;"><h3 class="icon-head '.$head.'">'.$translate->_($label).'</h3></td>';
		$str_title .= '<td class="a-right">';
		foreach ($arr_button as $value){
			$str_title .= '<button type="'.$value['type'].'" ';
			$str_title .= 'class="'.$value['class'].'" ';
			foreach($value['attribs'] as $key=>$val){
				$str_title .= $key.'="'.$val.'" ';
			}
			$str_title .= '><span>'.$translate->_($value['label']).'</span></button>';
		}
		$str_title .= '</td>';
		$str_title .= '</tr>';
		$str_title .= '</table>';
		$str_title .= '</div>';
		
		return $str_title;
	}
	
}

?>