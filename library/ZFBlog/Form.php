<?php

class ZFBlog_Form extends Zend_Form
{
	
    protected $_standardElementDecorator = array(
        'ViewHelper',
	    'Description',
	    'Errors',
	    array(array('elementDiv' => 'HtmlTag'), array('tag' => 'br')),
	    array(array('td' => 'HtmlTag'), array('tag' => 'li')),
	    array('Label', array('tag' => 'td')),
    
    );
	
	
	public $_elementDecorators = array(
        'ViewHelper',
	    'Description',
	    'Errors',
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
        array('Label', array('tag' => 'td'),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
    ));
	
    protected $_buttonElementDecorator = array(
        'ViewHelper'
    );

    protected $_standardGroupDecorator = array(
        'FormElements',
        array('HtmlTag', array('tag'=>'ol')),
        'Fieldset'
    );
    
    protected $_yusriGroupDecorator = array(
        'FormElements',
        array('HtmlTag', array('tag'=>'ul', 'class'=>'form-list'))
        //'Fieldset'
    );

    protected $_buttonGroupDecorator = array(
        'FormElements',
        'Fieldset'
    );
   
    protected $_noElementDecorator = array(
        'ViewHelper'
    );

    public function __construct($options = null)
    {
        // Path setting for custom classes MUST ALWAYS be first!
        $this->addElementPrefixPath('ZFBlog_Form_Decorator', 'ZFBlog/Form/Decorator/', 'decorator');
        $this->addElementPrefixPath('ZFBlog_Filter', 'ZFBlog/Filter/', 'filter');

        $this->_setupTranslation();

        parent::__construct($options);

        $this->setAttrib('accept-charset', 'UTF-8');
        $this->setDecorators(array(
            'FormElements',
            'Form'
        ));
    }

    protected function _setupTranslation()
    {
        if (self::getDefaultTranslator()) {
            return;
        }
        $path = Bootstrap::$root . '/translate/forms.php';
        $translate = new Zend_Translate('array', $path, 'en');
        self::setDefaultTranslator($translate);
    }

}