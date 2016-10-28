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


class Bvb_Grid_Deploy_Odt extends Bvb_Grid_DataGrid
{

    
    public $templateInfo;

    public $title;

    protected $options = array ();

    public $wordInfo;

    public $style;

    public $dir;

    private $inicialDir;

    protected $templateDir;

    protected $output = 'odt';


    function __construct($db, $title, $dir, $options = array('download'))
    {

        
        if (! in_array ( 'odt', $this->export ))
        {
            echo $this->__ ( "You dont' have permission to export the results to this format" );
            die ();
        }
        
        $this->dir = rtrim ( $dir, "/" ) . "/";
        $this->title = $title;
        $this->options = $options;
        $this->inicialDir = $this->dir;
        

        parent::__construct ( $db );
        
        if (! $this->temp ['odt'] instanceof Bvb_Grid_Template_odt_odt)
        {
            $this->setTemplate ( 'odt', 'odt' );
        }
    
    }


    /**
     * [Para podemros utiliza]
     *
     * @param string $var
     * @param string $value
     */
    
    function __set($var, $value)
    {

        parent::__set ( $var, $value );
    }


    /**
     * [PT] Fazer o scan recursivo dos dir
     *
     * @param string $directory
     * @param unknown_type $filter
     * @return unknown
     */
    function scan_directory_recursively($directory, $filter = FALSE)
    {

        // if the path has a slash at the end we remove it here
        $directory = rtrim ( $directory, '/' );
        

        // if the path is not valid or is not a directory ...
        if (! file_exists ( $directory ) || ! is_dir ( $directory ))
        {
            // ... we return false and exit the function
            return FALSE;
            
        // ... else if the path is readable
        } elseif (is_readable ( $directory ))
        {
            // we open the directory
            $directory_list = opendir ( $directory );
            
            // and scan through the items inside
            while ( FALSE !== ($file = readdir ( $directory_list )) )
            {
                // if the filepointer is not the current directory
                // or the parent directory
                if ($file != '.' && $file != '..' && $file != '.DS_Store')
                {
                    // we build the new path to scan
                    $path = $directory . '/' . $file;
                    
                    // if the path is readable
                    if (is_readable ( $path ))
                    {
                        // we split the new path by directories
                        $subdirectories = explode ( '/', $path );
                        
                        // if the new path is a directory
                        if (is_dir ( $path ))
                        {
                            // add the directory details to the file list
                            $directory_tree [] = array ('path' => $path . '|', 

                            // we scan the new path by calling this function
                            'content' => $this->scan_directory_recursively ( $path, $filter ) );
                            
                        // if the new path is a file
                        } elseif (is_file ( $path ))
                        {
                            // get the file extension by taking everything after the last dot
                            $extension = end ( explode ( '.', end ( $subdirectories ) ) );
                            
                            // if there is no filter set or the filter is set and matches
                            if ($filter === FALSE || $filter == $extension)
                            {
                                // add the file details to the file list
                                $directory_tree [] = array ('path' => $path . '|', 'name' => end ( $subdirectories ) );
                            }
                        }
                    }
                }
            }
            // close the directory
            closedir ( $directory_list );
            
            // return file list
            return $directory_tree;
            
        // if the path is not readable ...
        } else
        {
            // ... we return false
            return FALSE;
        }
    }


    // ------------------------------------------------------------
    


    /**
     * [PT] Remove direcotiros e subdirectorios
     *
     * @param string $dir
     */
    
    function deldir($dir)
    {

        $current_dir = @opendir ( $dir );
        while ( $entryname = @readdir ( $current_dir ) )
        {
            if (is_dir ( $dir . '/' . $entryname ) and ($entryname != "." and $entryname != ".."))
            {
                $this->deldir ( $dir . '/' . $entryname );
            } elseif ($entryname != "." and $entryname != "..")
            {
                @unlink ( $dir . '/' . $entryname );
            }
        }
        @closedir ( $current_dir );
        @rmdir ( $dir );
    }


    /**
     * [PT] Ir buscar os caminhos para depois zipar
     *
     * @param unknown_type $dirs
     * @return unknown
     */
    function zipPaths($dirs)
    {

        foreach ( $dirs as $key => $value )
        {
            if (! is_array ( @$value ['content'] ))
            {
                @$file .= $value ['path'];
            } else
            {
                @$file .= $this->zipPaths ( $value ['content'] );
            }
        }
        return $file;
    }


    /**
     * [PT] TEMOS que copiar os directórtio para a  loalização final
     *
     * @param unknown_type $source
     * @param unknown_type $dest
     * @return unknown
     */
    function copyDir($source, $dest)
    {

        // Se for ficheiro
        if (is_file ( $source ))
        {
            $c = copy ( $source, $dest );
            chmod ( $dest, 0777 );
            return $c;
        }
        
        // criar directorio de destino
        if (! is_dir ( $dest ))
        {
            mkdir ( $dest, 0777, 1 );
        }
        
        // Loop
        $dir = dir ( $source );
        while ( false !== $entry = $dir->read () )
        {
            
            if ($entry == '.' || $entry == '..' || $entry == '.svn')
            {
                continue;
            }
            
            // copiar directorios
            if ($dest !== "$source/$entry")
            {
                $this->copyDir ( "$source/$entry", "$dest/$entry" );
            }
        }
        
        // sair
        $dir->close ();
        return true;
    
    }


    function deploy()
    {

        $this->setPagination ( 0 );
        
        parent::deploy ();
        
        if (! $this->temp ['odt'] instanceof Bvb_Grid_Template_Odt_Odt)
        {
            $this->setTemplate ( 'odt', 'odt' );
        }
        
        $this->templateInfo = $this->temp ['odt']->templateInfo;
        
        $this->templateDir = explode ( '/', $this->templateInfo ['dir'] );
        array_pop ( $this->templateDir );
        
        $this->templateDir = ucfirst ( end ( $this->templateDir ) );
        
        $this->wordInfo = $this->temp ['odt']->info ();
        
        $this->dir = rtrim ( $this->dir, '/' ) . '/' . ucfirst ( $this->templateInfo ['name'] ) . '/';
        
        $pathTemplate = rtrim ( $this->libraryDir, '/' ) . '/' . substr ( $this->templateInfo ['dir'], 0, - 4 ) . '/';
        

        $this->deldir ( $this->dir );
        
        $this->copyDir ( $pathTemplate, $this->dir );
        
        $xml = $this->temp ['odt']->globalStart ();
        

        $titles = parent::buildTitles ();
        
        #$nome = reset ( $titles );
        $wsData = parent::buildGrid ();
        $sql = parent::buildSqlExp ();
        

        /////////////////////////
        /////////////////////////
        


        #O HEADER
        


        if (file_exists ( $this->wordInfo ['logo'] ))
        {
            copy ( $this->wordInfo ['logo'], $this->dir . 'Pictures/' . end ( explode ( "/", $this->wordInfo ['logo'] ) ) );
        }
        

        $header = str_replace ( array ('{{title}}', '{{subtitle}}','{{footer}}' ), array ($this->wordInfo ['title'], $this->wordInfo ['subtitle'], $this->wordInfo ['footer'] ), $this->temp ['odt']->header () );
        
        file_put_contents ( $this->dir . "styles.xml", $header );
        

        /////////////////////////
        /////////////////////////
        #END HEADER
        


        #START DOCUMENT.XML
        


        $xml = $this->temp ['odt']->globalStart ();
        
        $xml .= $this->temp ['odt']->titlesStart ();
        
        foreach ( $titles as $value )
        {
            
            if ((@$value ['field'] != @$this->info ['hRow'] ['field'] && @$this->info ['hRow'] ['title'] != '') || @$this->info ['hRow'] ['title'] == '')
            {
                
                $xml .= str_replace ( "{{value}}", $value ['value'], $this->temp ['odt']->titlesLoop () );
            
            }
        }
        $xml .= $this->temp ['odt']->titlesEnd ();
        
        if (is_array ( $wsData ))
        {
            
            /////////////////
            /////////////////
            /////////////////
            if (@$this->info ['hRow'] ['title'] != '')
            {
                $bar = $wsData;
                
                $hbar = trim ( $this->info ['hRow'] ['field'] );
                
                $p = 0;
                foreach ( $wsData [0] as $value )
                {
                    if ($value ['field'] == $hbar)
                    {
                        $hRowIndex = $p;
                    }
                    
                    $p ++;
                }
                $aa = 0;
            }
            
            //////////////
            //////////////
            //////////////
            


            $i = 1;
            $aa = 0;
            foreach ( $wsData as $row )
            {
                
                ////////////
                ////////////
                //A linha horizontal
                if (@$this->info ['hRow'] ['title'] != '')
                {
                    
                    if (@$bar [$aa] [$hRowIndex] ['value'] != @$bar [$aa - 1] [$hRowIndex] ['value'])
                    {
                        
                        $xml .= str_replace ( "{{value}}", @$bar [$aa] [$hRowIndex] ['value'], $this->temp ['odt']->hRow () );
                    
                    }
                }
                
                ////////////
                ////////////
                


                $xml .= $this->temp ['odt']->loopStart ();
                
                $a = 1;
                
                foreach ( $row as $value )
                {
                    
                    $value ['value'] = strip_tags ( $value ['value'] );
                    
                    if ((@$value ['field'] != @$this->info ['hRow'] ['field'] && @$this->info ['hRow'] ['title'] != '') || @$this->info ['hRow'] ['title'] == '')
                    {
                        
                        $xml .= str_replace ( "{{value}}", $value ['value'], $this->temp ['odt']->loopLoop () );
                    
                    }
                    $a ++;
                
                }
                $xml .= $this->temp ['odt']->loopEnd ();
                $aa ++;
                $i ++;
            }
        }
        

        if (is_array ( $sql ))
        {
            $xml .= $this->temp ['odt']->sqlExpStart ();
            foreach ( $sql as $value )
            {
                $xml .= str_replace ( "{{value}}", $value ['value'], $this->temp ['odt']->sqlExpLoop () );
            }
            $xml .= $this->temp ['odt']->sqlExpEnd ();
        }
        
        $xml .= $this->temp ['odt']->globalEnd ();
        

        file_put_contents ( $this->dir . "content.xml", $xml );
        
        $final = $this->scan_directory_recursively ( $this->dir );
        $f = explode ( '|', $this->zipPaths ( $final ) );
        array_pop ( $f );
        

        $this->title = strlen ( $this->title ) > 0 ? $this->title : 'Openoffice Document';
        
        $zip = new ZipArchive ( );
        $filename = $this->dir . $this->title . ".zip";
        
        if ($zip->open ( $filename, ZIPARCHIVE::CREATE ) !== TRUE)
        {
            exit ( "cannot open <$filename>\n" );
        }
        
        foreach ( $f as $value )
        {
            $zip->addFile ( $value, str_replace ( $this->dir, '', $value ) );
        }
        
        $zip->close ();
        

        rename ( $filename, $this->inicialDir . $this->title . '.odt' );
        

        if (in_array ( 'download', $this->options ))
        {
            header ( 'Content-type: application/vnd.oasis.opendocument.text' );
            header ( 'Content-Disposition: attachment; filename="' . $this->title . '.odt"' );
            readfile ( $this->inicialDir . $this->title . '.odt' );
        }
        
        if (! in_array ( 'save', $this->options ))
        {
            unlink ( $this->inicialDir . $this->title . '.odt' );
        }
        
        $this->deldir ( $this->dir );
        
        die ();
    }

}




