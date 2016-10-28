<?php
//require_once 'Zend/Search/Lucene.php';
 
class Spt_Search_Lucene
{
    private $__baseUrl = null;
    private $__path = null;
    private $__pattern = null;
    private $__indexPath = null;
 
    public function __construct($baseUrl, $path, $pattern, $indexPath)
    {
        $this->__baseUrl = $baseUrl;
        $this->__path = $path;
        $this->__pattern = $pattern;
        $this->__indexPath = $indexPath;
    }
 
    public function getBaseUrl()
    {
        return $this->__baseUrl;
    }
 
    public function getPath()
    {
        return $this->__path;
    }
 
    public function getPattern()
    {
        return $this->__pattern;
    }
 
    public function getIndexPath()
    {
        return $this->__indexPath;
    }
 
    public function createIndex()
    {
        $path = rtrim(str_replace('\\', '/', realpath($this->getPath())), '/');
        $files = $this->__glob($path, $this->getPattern());
 
        $baseUrl = rtrim($this->getBaseUrl(), '/');
        $index = Zend_Search_Lucene::create($this->getIndexPath());
        foreach ($files as $file)
        {
/* For html documents. */
            $docUrl = $baseUrl . str_replace('\\', '/', substr($file, strlen($path)));
 
            $doc = Zend_Search_Lucene_Document_Html::loadHTMLFile($file);
            $doc->addField(Zend_Search_Lucene_Field::Text('url', $docUrl));
 
/* For general documents, use the following code instead of the above.
            $docContent = file_get_contents($file);
            $docUrl = $baseUrl . str_replace('\\', '/', substr($file, strlen($path)));
 
            $doc = new Zend_Search_Lucene_Document();
            $doc->addField(Zend_Search_Lucene_Field::Text('url', $docUrl));
            $doc->addField(Zend_Search_Lucene_Field::Text('title', $docUrl));
            $doc->addField(Zend_Search_Lucene_Field::Text('body', $docContent));
*/
            $index->addDocument($doc);
        }
    }
 
    public function search($query)
    {
        if (!file_exists($this->getIndexPath()))
        {
            $this->createIndex();
        }
 
        $index = Zend_Search_Lucene::open($this->getIndexPath());
        $args = func_get_args();
        $results = call_user_func_array(array($index, 'find'), $args);
        return $results;
    }
 
    private function __glob($path, $pattern)
    {
        // see http://jp.php.net/glob
        $paths=glob($path.'/*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
        $files=glob($path.'/'.$pattern);
        if ($files === FALSE)
        {
            $files = array();
        }
        foreach ($paths as $path)
        {
            $path = rtrim(str_replace('\\', '/', $path), '/');
            $files=array_merge($files, $this->__glob($path, $pattern));
        }
        return $files;
    }
}