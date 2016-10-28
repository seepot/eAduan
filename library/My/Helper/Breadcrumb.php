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
          $output[] = '<a href="'.$crumbs[$i]['url']. '">'. $crumbs[$i]['title'] .'</a>';
        else
          $output[] = '' . $crumbs[$i]['title'] .'';
      }
    }
    else
    {
      $output = NULL;
    }

    return $output;
  }
}