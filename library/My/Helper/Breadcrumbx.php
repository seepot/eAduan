<?php
class My_Helper_Breadcrumb
{
	public static function process($crumbs = NULL)
	{
		if (is_array($crumbs))
		{
			$count = count($crumbs);
 
			for ($i = 0; $i < $count; $i++)
			{
				if ($i != ($count - 1))
					$output[] = '<a title="'. $crumbs[$i]['title'] .'" href="' . $crumbs[$i]['url'] .'">'. $crumbs[$i]['title'] .'</a>';
				else
					$output[] = '<a class="current" title="'. $crumbs[$i]['title'] .'">' . $crumbs[$i]['title'] .'</a>';
			}
		}
		else
		{
		$output = NULL;
		}
		return $output;
	}
}
