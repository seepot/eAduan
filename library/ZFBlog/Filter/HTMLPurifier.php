<?php

class ZFBlog_Filter_HTMLPurifier implements Zend_Filter_Interface
{
   
    protected $_htmlPurifier = null;
   
    public function __construct($options = null)
    {
        $config = null;
        if (!is_null($options)) {
            $config = HTMLPurifier_Config::createDefault();
                foreach ($options as $option) {
                    $config->set($option[0], $option[1], $option[2]);
                }
        }
        $this->_htmlPurifier = new HTMLPurifier($config);
    }

    public function filter($value)
    {
        return $this->_htmlPurifier->purify($value);
    }

}