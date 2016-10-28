<?php

/**
 * Mascker
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license
 * It is  available through the world-wide-web at this URL:
 * http://www.petala-azul.com/bsd.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to geral@petala-azul.com so we can send you a copy immediately.
 *
 * @package    Mascker_Grid
 * @copyright  Copyright (c) Mascker (http://www.petala-azul.com)
 * @license    http://www.petala-azul.com/bsd.txt   New BSD License
 * @version    0.1  mascker $
 * @author     Mascker (Bento Vilas Boas) <geral@petala-azul.com > 
 */


class Bvb_Grid_Template_Table_Images extends Bvb_Grid_Template_Table_Table 
{

    public $colSpan;

    public $hasExtraRow = 0;

    public $hasFilters = 1;

    public $i; 
    public $insideLoop;


    function globalStart ()
    {
        return "<input type=\"inputId\" style=\"display:none;\">
        <table  width=\"100%\" name=\"listagem\" class=\"borders\" align=\"center\" cellspacing=\"0\" celpadding=\"0\">
        ";
    }

    function globalEnd ()
    {
        return "</td></tr></table>";
    }



    function extra()
    {
        return "<tr><td  colspan=\"$this->colSpan\" class=\"querySupport\"><div style=\"text-align:right;\">{{value}}</div></td></tr>";
    }

    function titlesStart ()
    {
        return "<tr>";
    }

    function titlesEnd ()
    {
        return "</tr><tr><td><ul style=\"list-style:none;padding:0px;margin:0px;\">";
    }



    function titlesLoop ()
    {
        return "<th>{{value}}</th>";
    }



    function filtersStart ()
    {
        return "";
    }



    function filtersEnd ()
    {
        return "";
    }


    function noResults()
    {
        return "<td  colspan=\"$this->colSpan\" style=\"padding:10px;text-align:center;color:brown;font-size:14px;\">{{value}}</div>";
    }


    function filtersLoop ()
    {
        return "";
    }


    function hRow ($values)
    {
        return "<td  colspan=\"$this->colSpan\" class=\"hbar\"><div>{{value}}</div></td>";
    }



    function loopStart ($values)
    {
        $this->i++;

        $this->insideLoop = 1;

        return "";
    }



    function loopEnd ($values)
    {
        return "";
    }



    function loopLoop ($values)
    {
        return "<li {{class}} style=\"border:1px solid #333; padding:10px; float:left; width:88px;text-align:center;\" >{{value}}&nbsp;</li>";
    }



    function sqlExpStart ()
    {
        return "<tr>";
    }



    function sqlExpEnd ()
    {
        return "</tr>";
    }



    function sqlExpLoop ()
    {
        return "<td class=\"sum\">{{value}}</td>";
    }




    function pagination()
    {
        return "";
    }



    function formStart ()
    {
        return "<tr>";
    }



    function formGlobal ()
    {
        return "<table width=\"900\" name=\"listagem\" class=\"borders\" align=\"center\" cellspacing=\"0\" celpadding=\"0\">";
    }



    function formHeader ()
    {
        return "<th style=\"width:120px;\">Nome</th><th>Valor</th>";
    }



    function formLeft ()
    {
        return "<td class=\"alt\" width='33%' >{{value}}</td>";
    }



    function formRight ()
    {
        return "<td>{{value}}</td>";
    }



    function formButtons ()
    {
        return "<td class=\"barra_tabela\" colspan=\"2\">{{value}}</td>";
    }



    function formEnd ()
    {
        return "</tr>";
    }



    function formMessage ($ok=false)
    {

        if($ok) {
            $class = "";
        } else {
            $class = "_red";
        }
        return "<div class=\"alerta$class\">{{value}}</div>";
    }



    function images ($url)
    {
 
        return $images = array(
        'asc' => "<img src=\"" . $url . "seta_cima.gif\" border=\"0\">" ,
        'desc' => "<img src=\"" . $url . "seta_baixo.gif\" border=\"0\">" ,
        'delete' => "<img src=\"" . $url . "delete.png\" border=\"0\">" ,
        'edit' => "<img src=\"" . $url . "edit.png\"  border=\"0\">" ,
        'excel' => "<img title=\"Microsoft Excel\"  src=\"" . $url . "excel.gif\"  border=\"0\">" ,
        'word' => "<img  title=\"Microsoft Office 2003\" src=\"" . $url . "word.gif\"  border=\"0\">" ,
        'wordx' => "<img title=\"Microsoft Office 2007\" src=\"" . $url . "wordx.gif\"  border=\"0\">" ,
        'pdf' => "<img title=\"PDF\"  src=\"" . $url . "pdf.gif\"  border=\"0\">" ,
        'csv' => "<img src=\"" . $url . "csv.gif\"  border=\"0\">" ,
        'xml' => "<img src=\"" . $url . "xml.gif\"  border=\"0\">" ,
        'print' => "<img  src=\"" . $url . "print.gif\"  border=\"0\">");
    }


}

