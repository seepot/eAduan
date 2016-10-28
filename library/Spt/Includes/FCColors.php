<?php 

class Spt_Includes_FCColors
{
	public $FC_ColorCounter=1;
	
	public $arr_FCColors = array("1941A5",
							"AFD8F8",
							"F6BD0F",
							"8BBA00",
							"A66EDD",
							"F984A1",
							"CCCC00", #Chrome Yellow+Green
							"999999", #Grey
							"0099CC", #Blue Shade
							"FF0000", #Bright Red 
							"006F00", #Dark Green
							"0099FF", #Blue (Light)
							"FF66CC", #Dark Pink
							"669966", #Dirty green
							"7C7CB4", #Violet shade of blue
							"FF9933", #Orange
							"9900FF", #Violet
							"99FFCC", #Blue+Green Light
							"CCCCFF", #Light violet
							"669900", #Shade of green
							);
	/*
	public $arr_FCColors[0] = "1941A5" ;//Dark Blue
	
	public $arr_FCColors[1] = "AFD8F8";
	public $arr_FCColors[2] = "F6BD0F";
	public $arr_FCColors[3] = "8BBA00";
	public $arr_FCColors[4] = "A66EDD";
	public $arr_FCColors[5] = "F984A1" ;
	public $arr_FCColors[6] = "CCCC00" ;//Chrome Yellow+Green
	public $arr_FCColors[7] = "999999" ;//Grey
	public $arr_FCColors[8] = "0099CC" ;//Blue Shade
	public $arr_FCColors[9] = "FF0000" ;//Bright Red 
	public $arr_FCColors[10] = "006F00" ;//Dark Green
	public $arr_FCColors[11] = "0099FF"; //Blue (Light)
	public $arr_FCColors[12] = "FF66CC" ;//Dark Pink
	public $arr_FCColors[13] = "669966" ;//Dirty green
	public $arr_FCColors[14] = "7C7CB4" ;//Violet shade of blue
	public $arr_FCColors[15] = "FF9933" ;//Orange
	public $arr_FCColors[16] = "9900FF" ;//Violet
	public $arr_FCColors[17] = "99FFCC" ;//Blue+Green Light
	public $arr_FCColors[18] = "CCCCFF" ;//Light violet
	public $arr_FCColors[19] = "669900" ;//Shade of green
*/
	//getFCColor method helps return a color from arr_FCColors array. It uses
	//cyclic iteration to return a color from a given index. The index value is
	//maintained in FC_ColorCounter

	function getFCColor() 
	{
		//accessing the global variables
		global $FC_ColorCounter;
		global $arr_FCColors;
		
		//Update index
		$FC_ColorCounter++;
		//Return color
		return($this->arr_FCColors[$FC_ColorCounter % count($this->arr_FCColors)]);
	}
}

?>