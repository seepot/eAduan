<?php 

class Spt_Includes_Icon
{
	function func_createIcon($icon='',$target='',$title='',$url='',$res='')	{
			
		if($res <> '')
			$arr_res = explode(',',$res);
		else
			$arr_res = '';
		return array('icon'=>$icon,'target'=>$target,'title'=>$title,'url'=>$url,'res'=>$arr_res);
	}
	
	function func_createIcon3($icon='',$target='',$title='',$url='',$onclick='',$res='')	{
			
		if($res <> '')
			$arr_res = explode(',',$res);
		else
			$arr_res = '';
		return array('icon'=>$icon,'target'=>$target,'title'=>$title,'url'=>$url,'onclick' => $onclick,'res'=>$arr_res);
	}
	
	function func_createOnClick($name='',$type='',$item='')	{
		
		$items = explode(',',$item);
		//print_r($items);
		return array('name'=>$name,'type'=>$type,'item'=>$items);
	}
	
	function func_createOnClick2($name='',$type='',$item='')	{
		//print_r($item);
		return array('name'=>$name,'type'=>$type,'item'=>$item);
	}
	
}

?>