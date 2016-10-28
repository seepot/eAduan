    <?php

    //require_once 'Zend/View/Helper/Abstract.php';

    class Spt_View_Helper_Grid extends Zend_View_Helper_Abstract
    {
		public $view = null;

		public function setView(Zend_View_Interface $view)
        {
            $this->view = $view;
            return $this;
        }

       // this constructor takes 4 args, name of the grid, header columns, paginator and the bool value sorting.
        public function grid ($name, $fields = null,$paginator=null,$sorting=false, $itemPerPage=null, $search=null, $index=null)
        {
			//icon
			$icon = new Spt_View_Helper_Icon;
				
			// taking value of sort using Fron controller getRequest() method.
			$sort = Zend_Controller_Front::getInstance()->getRequest()->getParam('sort','DESC');
			
			//page
			$page = Zend_Controller_Front::getInstance()->getRequest()->getParam('page','1');
			
			// checking and handling sorting.
			if ($sort  ==  'ASC') {
				$sort = 'DESC';
			}  
			else  {
				$sort = "ASC";
			}
			
			//echo $itemPerPage;
			//print_r($paginator->_itemCountPerPage*2);
			// start constructing the gird.
			$output="<div id='".$name."'>";
            $output .= "<table class='data-table'><thead><tr>";

            // this foreach loop display the column header  in "th" tag.
			foreach ($fields as $key => $value)  
			{
				
				$output .= "<th>";

                // check if sorting is true, if so add link to the fields headers
				if($sorting && $value != "Aktiviti" && $value != "Bil")
				{
					$output .= "<a href='".$this->view->url(array('sort'=>$sort,'by'=>$key))."'>".$value."</a>&nbsp;";
					
					if(Zend_Controller_Front::getInstance()->getRequest()->getParam('by') == $key)
					{
						if(Zend_Controller_Front::getInstance()->getRequest()->getParam('sort') == "ASC")
							$output .= $icon->sort_asc();
						else
							$output .= $icon->sort_desc();
					}
				}  
				else  
				{
					$output .= $value;
				}

				$output .= "</th>";

            }

            $output .= "</tr></thead>";
			
			//Highlight search results
			$pattern = "(" . quotemeta($search) . ")";
			$replacement = '<span class="highlight">\\1</span>';

            // constructing the body that contain the records in rows and columns.
			$output .="<tbody>";

			// this loop display the actual data.
			if(count($paginator) > 0)
			{
				$int_page = 0+(($itemPerPage*$page)-$itemPerPage);
				foreach($paginator as $p) 
				{
					$int_page++;
					$output.="<tr onMouseOver=\"javascript: this.className='contents_mouseover';\" onMouseOut=\"javascript: this.className='contents_mouseout';\">";
					$output.="<td>".$int_page."</td>";
					foreach($p as $record) 
					{
						$output .= "<td>".eregi_replace($pattern, $replacement, $record)."</td>";
					}
					//$output .= $search;
				
					$output.="<td>".$icon->view('Papar Pengguna', '/admin/user/view/id/'.$p[$index]);
					$output.="&nbsp;";
					$output.=$icon->edit('Kemaskini Pengguna', '/admin/user/edit/id/'.$p[$index]);
					$output.="&nbsp;";
					$output.=$icon->delete('Hapus Pengguna', '/admin/user/delete/id/'.$p[$index])."</td>";
					$output.="</tr>";
				}
			}
			else
			{
				$output.="<tr><td colspan='".count($fields)."' align=\"center\">Tiada Rekod</td></tr>";
			}
			$output .= "</tbody>";

			// check if paginator is ture, if so then add paginator component to the table "tfoot".
			if($paginator) 
			{
				$output .="<tfoot>";
				$output .="<td align='right' colspan='".count($fields)."'>";
				$output.= $this->view->paginationControl($paginator,'Sliding','p.phtml');
				$output .="</td></tfoot>";
			}
			$output .="</table></div>";

			return $output;
        }
    }