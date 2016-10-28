<?php

/**
 * Mascker
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License 2.0
 * It is  available through the world-wide-web at this URL:
 * http://www.opensource.org/licenses/gpl-2.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to geral@petala-azul.com so we can send you a copy immediately.
 *
 * @package    Mascker_Grid
 * @copyright  Copyright (c) Mascker (http://www.petala-azul.com)
 * @license    http://www.opensource.org/licenses/gpl-2.0.php   GNU General Public License 2.0
 * @version    0.1  mascker 
 * @author     Mascker (Bento Vilas Boas) <geral@petala-azul.com > 
 */


class My_Template_Table_Work3 extends Bvb_Grid_Template_Table_Table
{

    public $ic;

    public $insideLoop;

    public $go = 0;
	
	public $_editUrl;
	
	public $translate;
	
	public $_class = '';

    function globalStart()
    {

        return "<table id=\"unijaya\" width=\"90%\"  align=\"center\" cellspacing=\"1\" >";
    }
	
	function globalEnd ()
    {
        return "</table><br><div style=\"text-align:right;float:right;\">{{column2}}</div>";
    }
	
	function titlesStart ()
    {
        return "<tr>";
        //return "<tr><th width=\"10%\">Bil</th>";
    }

    function titlesEnd ()
    {
        return "<th>".$this->translate()->_('Activity')."</th></tr>";
    }
	
	function filtersLoop ()
    {
        return "<td class=\"subtitulo\" >{{value}}</td>";
    }
	
	function loopFirst ($class = '')
    {
		return "<tr>";
	}
	
    function loopStart ($values, $ppagina = 10, $actual = 1, $class = '')
    {
        //echo $actual;
		$this->i++;
		$page = ($actual*$ppagina-$ppagina) + $this->i;

        $this->insideLoop = 1;
        $this->_class = $class;

        return "<tr>";
		//<td>$this->i</td>
    }
	
	function loopLoop ($values)
    {
        $class =  $this->i % 2 ? "alt" : "";
        return "<td class=\"{{class2}} {{class}} \" >{{value}}</td>";
    }
	
    function loopEnd ($view, $edit, $delete, $other, $arr_icon, $id, $field, $values,$idname)
    {
		
		$icon = new Spt_View_Helper_Icon;
		$translate = Zend_Registry::get ( 'translate' );
		$viewIcon = ($view['bool'] == true ? $icon->view($view['title'], $view['url']."/id/".$id)."&nbsp;" : "");
		$editIcon = ($edit['bool'] == true ? $icon->edit($edit['title'], $edit['url']."/id/".$id)."&nbsp;" : "");
		$otherIcon = ($icon->other($other['target'], $other['title'], $other['img'], $other['url']."/id/".$id));
		$deleteIcon = ($delete['bool'] == true ? $icon->delete($delete['title'], $delete['url']."/id/".$id)."&nbsp;" : "");
		
		$str_loop = "<td class=\"".$this->_class."\">";
		//foreach($arr_icon as $name=>$value){
			//print_r($value);
			//echo "<br>";
			$t_icon = $arr_icon['icon']; //jenis ikon
			$target = $arr_icon['target']; //target
			$title = $translate->_($arr_icon['title']); //title
			$url = $arr_icon['url']."/id/".$id; //url
			//$onclick = '';
			//print_r($value['onclick']);
			$onclick = $arr_icon['onclick'];
	
			$c_icon = $icon->other2($target,$title,$t_icon,$url,$onclick);
			//print_r($c_icon);
			$str_loop .= $c_icon."&nbsp;";
		//}
		
		$str_loop .= "$viewIcon$editIcon$otherIcon$deleteIcon</td>";
		
		return $str_loop;
		
    }

	function loopLast ()
    {
		return "</tr>";
	}
	
	function filtersStart ()
    {
		return "<tr style=\"display:none;\" id=\"filter\"><td>&nbsp;</td>";
    }



    function filtersEnd ()
    {
        return "<td>&nbsp;</td></tr>";
    }
	
	function noResults()
    {
        return "<td  colspan=\"".($this->colSpan+2)."\" style=\"padding:10px;text-align:center;color:brown;font-size:14px;\">{{value}}</div>";
    }
	
	function pagination()
    {
		
		return "<tr><td class=\"barra_tabela\" colspan=\"".($this->colSpan+2)."\"><div style=\"padding:2px;\">
        <div style=\"float:left;text-align:left;width:450px;\"> {{pagination}} View {{pagingNo}} per page&nbsp;|&nbsp;Total {{numberRecords}} records&nbsp;
		</div>
        </td></tr>";
		
		//<div style=\"float:right;width:80px;\">{{pageSelect}}</div>
    }
	
	function translate()
	{
		$translate = Zend_Registry::get ( 'translate' );
		return $translate;
	}

}

    