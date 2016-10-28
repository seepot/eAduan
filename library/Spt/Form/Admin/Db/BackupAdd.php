<?php 

class Spt_Form_Admin_Db_BackupAdd extends Zend_Dojo_Form
{
    /**
     * Form initialization
     *
     * @return void
     */
    public function init()
    {
		//setting environment
		$this->setAction(SYSTEM_URL.'/admin/db/backup');
		$this->setMethod('post');
		$translate = Zend_Registry::get ( 'translate' );
		
		//Keterangan Kumpulan
		$this->addElement(
                'Textarea',
                'backupDesc',
                array(
                    //'style'    => 'width: 200px;',
                )
            );
		
		//Export Tables
		$this->addElement(
			'CheckBox',
			'tables',
			array(
				'checkedValue'  => 'on',
				'uncheckedValue'=> '',
				'checked'       => true,
			)
		);
		
		//Export Data
		$this->addElement(
			'CheckBox',
			'data',
			array(
				'checkedValue'  => 'on',
				'uncheckedValue'=> '',
				'checked'       => true,
			)
		);
		
		//Drop Table
		$this->addElement(
			'CheckBox',
			'drop',
			array(
				'checkedValue'  => 'on',
				'uncheckedValue'=> '',
				'checked'       => true,
			)
		);
		
		//Compression
		$this->addElement(
                'FilteringSelect',
                'zip',
                array(
                    'autocomplete' => true,
                    'multiOptions'  => array(
                        '' => $translate->_('None'),
                        'zip' => $translate->_('Zip'),
                    ),
                )
            );
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
    }
	
}

?>