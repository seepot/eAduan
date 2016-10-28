<?php

class Spt_Form_PPP_New_Persatuan extends Zend_Dojo_Form
{
    public function init()
    {
        $this->setAction(SYSTEM_URL.'/ppp/new/applynew?currtab=persatuan');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );

        ///////section: persatuan///////
        //
        //
        //Nama Persatuan
        $this->addElement(
                'ValidationTextBox',
                'association_name',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );
        //No Ahli
        $this->addElement(
                'ValidationTextBox',
                'association_member_no',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
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