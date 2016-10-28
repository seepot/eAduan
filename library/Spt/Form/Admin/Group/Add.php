<?php 

class Spt_Form_Admin_Group_Add extends Spt_Dojo_Form
{
    public function init()
    {
    	//setting environment
		$this->setAction(SYSTEM_URL.'/admin/group/add');
		$this->setMethod('post');
        $this->setAttribs(array(
            'name'  => 'AddGroupForm',
        ));
		
		$typegroup = new SysUserTypeGroup();
        $typegroupOptions = $typegroup->getSysUserTypeGroupOptions();
        $typegroupMultiOptions = array('[--Sila Pilih Jenis Pengguna--]') + $typegroupOptions;
		
		//Nama Kumpulan
		$this->addElement(
                'ValidationTextBox',
                'groupname',
                array(
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
					'validators' => array(
						array('StringLength', false, array(3,40))
					),
                )
            );
		
		//Keterangan Kumpulan
		$this->addElement(
                'Textarea',
                'groupdesc',
                array(
                    //'style'    => 'width: 200px;',
                )
            );
		
		$this->addElement(
                'FilteringSelect',
                'typegroup',
                array(
                    'autocomplete'=>'true',
					'onChange' => 'setVal1',
					'validators' => array(
						new Zend_Validate_InArray(array_keys($typegroupOptions))
					),
                    'multiOptions' => $typegroupMultiOptions,
                )
            );
		
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',
                
		));
    }
}

?>