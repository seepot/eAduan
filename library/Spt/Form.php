<?php

class Spt_Form extends Zend_Form
{
	public $checkboxDecorator = array(
                                    'ViewHelper',
                                    'Errors',
                                    'Description',
                                    array('HtmlTag',array('tag' => 'td')),
                                    array('Label',array('tag' => 'td','class' =>'element')),
                                    array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
                                    
    public $elementDecorators = array(
                                    'ViewHelper',
								    'Description',
								    'Errors',
								    //array(array('elementDiv' => 'HtmlTag')),
								    array(array('td' => 'HtmlTag'), array('tag' => 'li')),
								    array('Label'),
								    );

	public $element2Decorators = array(
                                    'ViewHelper',
								    'Description',
								    'Errors',
								   // array('HtmlTag',array('tag' => 'li')),
                                    //array('Label'),
                                   // array(array('row' => 'HtmlTag'), array('tag' => 'li'))
								    );
								    
	public $radioDecorators = array(
                                    'ViewHelper',
								    'Description',
								    'Errors',
								    //array('HtmlTag', array('tag' => 'li')),
								    //array('Label', array('tag' => 'dt')),
	
								    );		
								    
	protected $_standardRadioElementDecorator = array(
        'ViewHelper',
        'Errors',
        //array(array('data' => 'HtmlTag'), array('tag' => 'span', 'class' => 'element')),
		//array('decorator' => array('td' => 'HtmlTag'), 'options' => array('tag' => 'td','width'=>'74%','align'=>'left')),
        //array('Label', array('tag' => 'td')),
        //array('decorator' => array('tr' => 'HtmlTag'), 'options' => array('tag' => 'tr')),
    ); 
    							    					                                        
    public $buttonDecorators = array(
                                    'ViewHelper',
                                    array('HtmlTag',array('tag' => 'td')),
                                    //array('Label',array('tag' => 'td')), NO LABELS FOR BUTTONS
                                    array(array('row' => 'HtmlTag'), array('tag' => 'tr')));
	
	public $buttonDecorators2 = array(
                                    'ViewHelper');
                                    
    public $button2Decorators = array(
                                    'ViewHelper',
    								'Description',
                                    //array('HtmlTag',array('tag' => 'td')),
                                   //array('Label',array('tag' => 'span')),
                                    //array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
                                    );

	public function init()
    {
        // Dojo-enable the form:
        Zend_Dojo::enableForm($this);
	}
	
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