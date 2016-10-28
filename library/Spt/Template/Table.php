<?php 

class Spt_Template_Table
{
	public $str_table = '';
	
	public $form = array();
	
	function table($form,$action,$method)
	{
		$str_table = "<form action=\"$action\" method=\"$method\">"
					. "<div class=\"content-header\">"
					. "<table cellspacing=\"0\">"
					. "<tr>"
					. "<td style=\"width:50%;\"><h3 class=\"icon-head head-user\">Tambah Pengguna</h3></td>"
					. "<td class=\"a-right\">"
					. "<button type=\"button\" class=\"scalable back\" onclick=\"Javascript:history.back();\" ><span>Kembali</span></button>"  	           	            	                    
					//. $this->form->reset
					. "<button type=\"submit\" class=\"scalable save\" name=\"submit\" id=\"submit\"><span>Simpan</span></button>"
					. "</td>"
					. "</tr>"
					. "</table>"
					. "</div>";
		
		$str_table .= "<div class=\"entry-edit\">"
					. "<div class=\"fieldset\" id=\"group_fields63\">"
					. "<p class=\"box\">Sila masukkan maklumat pada ruangan di bawah.</p>"
					. "<table cellpadding=\"5\" cellspacing=\"1\" id=\"one-column-emphasis\" width=\"100%\">"
					. "<colgroup>"
					. "<col class=\"oce-first\" />"
					. "</colgroup>"
					. "<tbody>";
					
		foreach($form as $title=>$field){	
			$str_table .= "<tr>"
						. "<td width=\"25%\">".$title."&nbsp;<span class=\"required2\">*</span></td>"
						. "<td>"
						. $field
						. "</td>"
						. "</tr>";
		}
		
		$str_table .= "</tbody>"
					. "</table>"
					. "<p class=\"required2\" align=\"right\">* Diperlukan</p>"
					. "</div>"	
					. "</div>
					. </form>";
		
		echo $str_table;
		echo "<pre>";
		//print_r($form);
		echo "</pre>";
		echo count($form);
	}
}