<?php

class Spt_Form_PPP_New_Dokumen extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/ppp/new/applynew?currtab=dokumen');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: dokumen///////
        //
        //
		 //Salinan kad pengenalan
        $this->addElement(
                'file',
                'doc1',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 110400),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );
       //Dokumen Sokongan A
        $this->addElement(
                'file',
                'doc2',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 110400),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );
		//Dokumen Sokongan B
        $this->addElement(
                'file',
                'doc3',
                array(
					'validators' => array(
						array('Count', false, 1),
						array('Size', false, 110400),
						array('Extension', false, 'jpg,png,gif'),
					),
                )
            );
		
		///
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
	
	
	
	
	
	
	
	
	}
}

?>