<?php

class ZFBlog_Form_EntryAdd extends ZFBlog_Form
{
   
    public function init()
    {
        $this->setAction('/admin/entry/add');

        // Display Group #1 : Entry Data
       
        $this->addElement('text', 'title', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Title:',
            'attribs' => array(
                'maxlength' => 120,
                'size' => 50
            ),
            'validators' => array(
                array('StringLength', false, array(3,200))
            ),
            'filters' => array('StringTrim'),
            'required' => true
        ));
       
        $this->addElement('text', 'date', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Date:',
            'attribs' => array(
                'maxlength' => 16,
                'size' => 16
            ),
            'value' => Zend_Date::now()->toString('yyyy-MM-dd HH:mm'),
            'validators' => array(
                array('Date', false, array('yyyy-MM-dd HH:mm', 'en'))
            ),
            'required' => true
        ));
       
        $this->addElement('textarea', 'entrybody', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Entry Body:',
            'filters' => array('HtmlBody'),
            'required' => true
        ));
       
        $this->addElement('textarea', 'entrybodyextended', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Extended Body:',
            'filters' => array('HtmlBody')
        ));
       
        $this->addDisplayGroup(
            array('title','date','entrybody','entrybodyextended'), 'entrydata',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_standardGroupDecorator,
                'legend' => 'New Entry'
            )
        );
       
        // Display Group #2 : Submit

        $this->addElement('submit', 'submit', array(
            'decorators' => $this->_buttonElementDecorator,
            'label' => 'Save'
        ));

        $this->addDisplayGroup(
            array('submit'), 'entrydatasubmit',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_buttonGroupDecorator,
                'class' => 'submit'
            )
        );
    }
}