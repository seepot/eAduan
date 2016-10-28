<?php

class Spt_View_Helper_Icon extends Zend_View_Helper_Abstract
{
	public function __construct()
	{
		$front = Zend_Controller_Front::getInstance(); 
		$this->front = $front->getBaseUrl();
	}
	
	public function view($name, $url = null, $title = null)
	{ 
		$image = $this->front.'/public/images/icon/view.png';
		
		return "<a href=\"".$url."\"><img src=\"".$image."\" title=\"".$name."\">&nbsp;<strong>".$title."</strong></a>";
	}
	
	public function add($name, $url = null, $title = null)
	{
		$image = $this->front.'/public/images/icon/add.png';
		
		return "<a href=\"".$url."\"><img src=\"".$image."\" title=\"".$name."\">&nbsp;<strong>".$title."</strong></a>";
	}
	
	public function edit($name, $url = null, $title = null)
	{
		$image = $this->front.'/public/images/icon/edit.png';
		
		return "<a href=\"".$url."\"><img src=\"".$image."\" title=\"".$name."\">&nbsp;<strong>".$title."</strong></a>";
	}
	
	public function delete($name, $url = null, $title = null)
	{
		$image = $this->front.'/public/images/icon/del.png';
		
		return "<a onclick=\"confirmSetLocation('Are you sure?', '".$url."')\"><img src=\"".$image."\" title=\"".$name."\" style=\"cursor:pointer;\">&nbsp;<strong>".$title."</strong></a>";
	}
	
	public function active($name, $url = null, $title = null)
	{
		$image = $this->front.'/public/images/icon/active.gif';
		
		return "<a href=\"".$url."\"><img src=\"".$image."\" alt=\"".$name."\">&nbsp;<strong>".$title."</strong></a>";
	}
	
	public function sort_asc()
	{
		$image = $this->front.'/public/images/icon/seta_cima.gif';
		
		return "<img src=\"".$image."\">";
	}
	
	public function sort_desc()
	{
		$image = $this->front.'/public/images/icon/seta_baixo.gif';
		
		return "<img src=\"".$image."\">";
	}
	
	public function other($target = '_self', $name, $img = null, $url = null, $onclick = '')
	{ 
		$image = IMAGES_PATH.'icon/'.$img;
		
		if($onclick != ''){
			return "<a href='javascript:".$onclick."(\"".$url."\",\"info\",false,\"\")' target=\"$target\"><img src=\"".$image."\" title=\"".$name."\"></a>";
		} else {
			return "<a href=\"".$url."\" target=\"$target\"><img src=\"".$image."\" title=\"".$name."\"></a>";
		}
	}
	
	public function other2($target = '_self', $name, $img = null, $url = null, $onclick = '')
	{ 
		$image = IMAGES_PATH.'icon/'.$img;
		
		if($onclick != ''){
			return "<a href='#' onclick=\"javascript:".$onclick['name']."('".$onclick['type']."','".$onclick['item'][0]."','".$onclick['item'][1]."')\" target=\"$target\"><img src=\"".$image."\" title=\"".$name."\"></a>";
			//return "<a href='#' onclick='javascript:".$onclick."' target=\"$target\"><img src=\"".$image."\" title=\"".$name."\"></a>";
			//return "<a href='#' onclick=\"javascript:insert_name('xx','cc')\" target=\"$target\"><img src=\"".$image."\" title=\"".$name."\"></a>";
		} else {
			return "<a href=\"".$url."\" target=\"$target\"><img src=\"".$image."\" title=\"".$name."\"></a>";
		}
	}
}