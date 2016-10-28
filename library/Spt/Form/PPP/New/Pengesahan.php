<?php

class Spt_Form_PPP_New_Pengesahan extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/ppp/new/applynew?currtab=pengesahan');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: pengesahan///////
        //
        //
        //Pengesahan
        $this->addElement(
                'Checkbox',
                'pengesahan',
                array(
                    'required'       => true,
					'invalidMessage' => 'Diperlukan',
					'checkedValue'   => 'true',
					'uncheckedValue' => 'false',
					'checked'        => false,
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