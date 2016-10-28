<?php 

class Spt_Form_Bp_ProfilFoto extends Zend_Dojo_Form
{
	public function init()
    {
        //get translate
		$translate = Zend_Registry::get ( 'translate' );
		
			
		$this->setAction(SYSTEM_URL.'/bp/personal/fotoedit/');
		$this->setMethod('post');
				
			
		//Decorator
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
    }
	
}

?>