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



class Bvb_Grid_Source_Db_Select extends Zend_Db_Select
{

    public $data = array ();

    protected $_db;


    function getFieldsFromTable($table, $prefix = null, $order = 0)
    {

        $table = $this->_db->describeTable ( $table );
        
        foreach ( $table as $column )
        {
            
            if ($order == 0)
            {
                $columns [] = isset ( $prefix ) ? $prefix . '.' . $column ['COLUMN_NAME'] : $column ['COLUMN_NAME'];
            } else
            {
                $columns [] = isset ( $prefix ) ? $prefix . '.' . $column ['COLUMN_NAME'] : $column ['COLUMN_NAME'];
            }
        }
        
        return $columns;
    }


    function __construct($select, $db)
    {

        $this->_db = $db;
        
        $parts = $select->_parts;
        

        //A parte das tables que existem
        foreach ( $parts ['from'] as $key => $table )
        {
            $this->data ['table'] [$key] = array ('prefix' => $key, 'table' => $table ['tableName'] );
        }
        

        if (count ( $parts ['columns'] ) == 1)
        {
            
            if ($parts ['distinct']==true)
            {
                $this->data ['columns'] [] = ' DISTINCT('.$parts ['columns'] [0] [1].') AS  '.$parts ['columns'] [0] [0].' ';
                $this->data ['orderField'] [] = 'pTotal';
            } else
            {
                $this->data ['columns'] = $this->getFieldsFromTable ( $this->data ['table'] [$parts ['columns'] [0] [0]] ['table'], $this->data ['table'] ['prefix'] );
            }
            
            
        } else
        {
            

            //A parte dos fields
            foreach ( $parts ['columns'] as $key => $column )
            {
                
                if ($column [1] == '*')
                {
                    
                    $this->data ['columns'] = @array_merge ( $this->data ['columns'], $this->getFieldsFromTable ( $this->data ['table'] [$column [0]] ['table'], $column [0] ) );
                    $this->data ['orderField'] = @array_merge ( $this->data ['orderField'], $this->getFieldsFromTable ( $this->data ['table'] [$column [0]] ['table'], $column [0] ), 1 );
                
                } elseif (! is_object ( $column [1] ))
                {
                    $this->data ['columns'] [] = strlen ( $column [2] ) > 0 ? $column [0] . '.' . $column [1] . ' AS ' . $column [2] : $column [0] . '.' . $column [1];
                    if (strlen ( $column [0] ) > 0)
                    {
                        $this->data ['orderField'] [] = $column [0] . '.' . $column [1];
                    } else
                    {
                        $this->data ['orderField'] [] = $column [1];
                    }
                
                } elseif (is_object ( $column [1] ))
                {
                    $this->data ['columns'] [] = $column [1] . ' AS ' . $column [2];
                    $this->data ['orderField'] [] = $column [2];
                
                } elseif (null === $column [2])
                {
                    $this->data ['columns'] [] = $column [1];
                    if (strlen ( $column [0] ) > 0)
                    {
                        $this->data ['orderField'] [] = $column [0] . '.' . $column [1];
                    } else
                    {
                        $this->data ['orderField'] [] = $column [1];
                    }
                }
            }
        }
        

        $this->data ['where'] = implode ( ' ', $parts ['where'] );
        

        //Agora construir o FROM
        


        $from = $parts ['from'];
        $totalFrom = count ( $from );
        

        if ($totalFrom == 1)
        {
            
            if (@key ( $parts ['from'] ) == @$parts ['from'] ['tableName'])
            {
                $this->data ['from'] = $parts ['from'] ['tableName'];
            } else
            {
                $keyFrom = key ( $parts ['from'] );
                
                $this->data ['from'] = $parts ['from'] [$keyFrom] ['tableName'] . ' ' . $keyFrom;
            }
        
        } else
        {
            
            $i = 0;
            
            foreach ( $from as $key => $value )
            {
                if ($i == 0)
                {
                    
                    $this->data ['from'] .= $value ['tableName'] . ' ' . $key . ' ';
                
                } else
                {
                    $this->data ['from'] .= $value ['joinType'] . ' ' . $value ['tableName'] . ' ' . $key . ' ON ' . $value ['joinCondition'];
                }
                
                $i ++;
            }
        }
        

        $this->data ['groupBy'] = implode ( ', ', $parts ['group'] );
        @$this->data ['having'] = $parts ['having'] [0];
        

        $order = $parts ['order'];
        
        foreach ( $order as $value )
        {
            $this->data ['order'] .= $value [0] . ' ' . $value [1] . ' ,';
        }
        
        @$this->data ['order'] = substr ( $this->data ['order'], 0, - 1 );
        

        $query = "SELECT " . implode ( ', ', $this->data ['columns'] ) . ' FROM  ' . $this->data ['from'] . ' WHERE ( ' . $this->data ['where'] . ' ) GROUP BY  ' . $this->data ['groupBy'] . '  HAVING ' . $this->data ['having'];
        

        #$this->_db->fetchAll($query);
        


        
        return $this->data;
    }

}