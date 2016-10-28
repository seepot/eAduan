<?php 

class Spt_Includes_Tab
{
	function func_createTab($label = '', $url = '', $no_tab = '', $tab_selected = 0, $disabled = '')	{
	
		$translate = Zend_Registry::get ( 'translate' );
		$str_tab = '<div id="header">';
		$str_tab .= '<ul id="primary">';
		foreach ($no_tab as $index => $value){
			$str_tab .= '<li>';
			if($no_tab[$value] == $tab_selected) {
				$str_tab .= '<span>&nbsp;'.$translate->_($label[$value]).'&nbsp;</span>';
			}else{
				if($disabled[$value] == 0){
					$str_tab .= '<a href="'.$url[$value].'" onclick="ajax_loader();">';
					$str_tab .= '&nbsp;'.$translate->_($label[$value]).'&nbsp;';
					$str_tab .= '</a>';
				} else {
					$str_tab .= '<a class="disabled">';
					$str_tab .= '&nbsp;'.$translate->_($label[$value]).'&nbsp;';
					$str_tab .= '</a>';
				}
			}
			$str_tab .= '</li>';
		}
		$str_tab .= '</ul>';
		$str_tab .= '</div>';
		
		return $str_tab;
	}
	
	function func_createTab2($label = '', $url = '', $no_tab = '', $tab_selected = '', $disabled = '')	{
	
		$translate = Zend_Registry::get ( 'translate' );
		$str_tab = '<div id="header">';
		$str_tab .= '<ul id="primary">';
		foreach ($no_tab as $index => $value){
			$str_tab .= '<li>';
			if($no_tab[$value] == $tab_selected) {
				$str_tab .= '<span>&nbsp;'.$translate->_($label[$value]).'&nbsp;</span>';
			}else{
				if($disabled[$value] == 0){
					$str_tab .= '<a href="'.$url[$value].'" onclick="ajax_loader();">';
					$str_tab .= '&nbsp;'.$translate->_($label[$value]).'&nbsp;';
					$str_tab .= '</a>';
				} else {
					$str_tab .= '<a class="disabled">';
					$str_tab .= '&nbsp;'.$translate->_($label[$value]).'&nbsp;';
					$str_tab .= '</a>';
				}
			}
			$str_tab .= '</li>';
		}
		$str_tab .= '</ul>';
		$str_tab .= '</div>';
		
		return $str_tab;
	}
	
}

?>