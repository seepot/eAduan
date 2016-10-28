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


class My_Template_Table_Work2 extends Bvb_Grid_Template_Table_Table
{

    public $ic;

    public $insideLoop;

    public $go = 0;
	
	public $_editUrl;
	
	public $translate;

    function globalStart()
    {

        return "<table id=\"unijaya\" width=\"100%\"  align=\"center\" cellspacing=\"1\" >";
    }
	
	function globalEnd ()
    {
        return "</table><br><div style=\"text-align:right;float:right;\">{{column2}}</div>";
    }
	
	function titlesStart ()
    {
        return "<tr><th width=\"10%\">Bil&nbsp;&nbsp;&nbsp;<a href='#' onClick=\"filters()\"><img title='Carian' src=\"".IMAGES_PATH."spt/narrow_by_li_by.gif\"></a></th>";
    }

    
	function filtersLoop ()
    {
        return "<td class=\"subtitulo\" >{{value}}</td>";
    }
	
    function loopStart ($values, $ppagina = 10, $actual = 1)
    {
        //echo $actual;
		$this->i++;
		$page = ($actual*$ppagina-$ppagina) + $this->i;

        $this->insideLoop = 1;

        return "<tr><td>$page</td>";
		//<td>$this->i</td>
    }

    function loopLoop ($values)
    {
        $class =  $this->i % 2 ? "alt" : "";
        return "<td class=\"$class {{class}} \" >{{value}}</td>";
    }
	
	function filtersStart ()
    {
        //$filter = "<div dojoType=\"dijit.TitlePane\" title=\"Carian\">";
		return "<tr style=\"display:none;\" id=\"filter\"><td>&nbsp;</td>";
    }


	function noResults()
    {
        return "<td  colspan=\"".($this->colSpan+2)."\" style=\"padding:10px;text-align:center;color:brown;font-size:14px;\">{{value}}</div>";
    }
	
	function pagination()
    {
        return "<tr><td class=\"barra_tabela\" colspan=\"".($this->colSpan+2)."\"><div style=\"padding:2px;\">
        <div style=\"float:left;text-align:left;width:570px;\">  {{pagination}}  View {{pagingNo}} per page | Total {{numberRecords}} records&nbsp;&nbsp;|</div>
        <div style=\"text-align:right;float:right;width:270px;\">{{export}} | {{column}}</div>
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

    