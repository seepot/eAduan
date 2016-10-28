<?php

class ZFBlog_Form_EntryEdit extends ZFBlog_Form_EntryAdd
{
   
    public function init()
    {
        parent::init();
        $this->setAction('/admin/entry/edit');
       
        // What entry id are we editing?!
        $this->addElement('hidden', 'id', array(
            'decorators' => $this->_noElementDecorator,
            'validators' => array(
                'Digits'
            ),
            'required' => true
        ));
       
        $this->getDisplayGroup('entrydata')->setLegend('Edit Entry');
        $this->getDisplayGroup('entrydata')->addElement(
            $this->getElement('id')
        );
    }
   
}