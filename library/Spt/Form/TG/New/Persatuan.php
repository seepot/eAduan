<?php
class Spt_Form_TG_New_Persatuan extends Zend_Dojo_Form
{
	public function init()
    {
		//setting environment
		$this->setAction(SYSTEM_URL.'/tg/new/applynew?currtab=persatuan');
		$this->setMethod('post');

		$translate = Zend_Registry::get ( 'translate' );


        ////section: persatuan////

		//Nama Persatuan
		$this->addElement(
                'ValidationTextBox',
                'appl_persatuan_name',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );

		//Tarikh Menjadi Ahli
		$this->addElement(
                'DateTextBox',
                'appl_persatuan_tkh_ahli',
                array(
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidah Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );

		//Jawatan
		$this->addElement(
                'ValidationTextBox',
                'appl_persatuan_jawatan',
                array(
                    //'label'      => 'TextBox',
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );


		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
	}

}
?>