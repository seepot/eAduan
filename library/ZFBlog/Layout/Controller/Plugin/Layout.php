<?php

class ZFBlog_Layout_Controller_Plugin_Layout extends Zend_Layout_Controller_Plugin_Layout
{
   
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        switch ($request->getModuleName())
        {
            case 'admin':
                $this->_moduleChange('admin');
        }
    }

    protected function _moduleChange($moduleName)
    {
        $this->getLayout()->setLayoutPath(
            dirname(dirname(
                $this->getLayout()->getLayoutPath()
            ))
            . DIRECTORY_SEPARATOR . $moduleName . '/views/layouts'
        );
        $this->getLayout()->setLayout($moduleName);
    }
   
} 