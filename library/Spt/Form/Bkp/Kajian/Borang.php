<?php

class Spt_Form_Bkp_Kajian_Borang extends Zend_Dojo_Form
{	public function init()
	{
		$front = Zend_Controller_Front::getInstance()->getBaseUrl(); 
		$translate = Zend_Registry::get ( 'translate' );
		
		$this->setAction($front.'/bkp/kajian/borang');
		$this->setMethod('post');
		
		//Tahun
		$tahunOptions = array();
		for($i=2000;$i<2020;$i++){
			$tahunOptions = $tahunOptions + array($i=>$i);
		}
		
        $tahunMultiOptions = array($translate->_('[--Sila Pilih Tahun--]')) + $tahunOptions;

        $this->addElement(
                'FilteringSelect',
                'sel_tahun',
                array(
                    'required'   => true,
                    'validators' => array(
                        new Zend_Validate_InArray(array_keys($tahunOptions))
                    ),
                    'multioptions'   => $tahunMultiOptions,
					'value'	=>	(date('Y')-1),
                )
            ); 
			
		//Kumpulan Jawatan
        $this->addElement(
                'RadioButton',
                'rad_kumpulanjawatan',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Pengurusan dan Profesional (Gred 41-54 / Z26 - Z20)'),
                        '2' => $translate->_('Sokongan 1 (Gred 17-36 / Z14 - Z6)'),
                        '3' => $translate->_('Sokongan 2 (Gred 1-16)')
                    ),
					//'value'			 => $this->getRowUserDetail('usr_sex'),
					'required'       => true,
                )
            );
		
		//Bahagian
		$bahagian = new Bahagian();
        $bahagianOptions = $bahagian->getBahagianOptions();
        $bahagianMultiOptions = array($translate->_('[--Sila Pilih Bahagian--]')) + $bahagianOptions;

        $this->addElement(
                'FilteringSelect',
                'sel_bahagian',
                array(
                    'required'   => true,
                    'validators' => array(
                        new Zend_Validate_InArray(array_keys($bahagianOptions))
                    ),
                    'multioptions'   => $bahagianMultiOptions,
                )
            ); 
		
		//Jantina
        $this->addElement(
                'RadioButton',
                'rad_jantina',
                array(
                    'multiOptions'  => array(
                        '1' => $translate->_('Lelaki'),
                        '2' => $translate->_('Perempuan')
                    ),
					//'value'			 => $this->getRowUserDetail('usr_sex'),
					'required'       => true,
                )
            );
		
		//Umur
		$umurOptions = array();
		for($i=20;$i<60;$i++){
			$umurOptions = $umurOptions + array($i=>$i);
		}
		
        $umurMultiOptions = array($translate->_('[--Sila Pilih Umur--]')) + $umurOptions;

        $this->addElement(
                'FilteringSelect',
                'sel_umur',
                array(
                    'required'   => true,
                    'validators' => array(
                        new Zend_Validate_InArray(array_keys($umurOptions))
                    ),
                    'multioptions'   => $umurMultiOptions,
                )
            ); 
		
		//soalan
		/* $dbM = Zend_Registry::get ( 'db' );
		$dbM->setFetchMode(Zend_Db::FETCH_OBJ);
		$soalan = $dbM->fetchAssoc("SELECT soalan_id, soalan_desc FROM tbl_soalan where soalan_status = '1'");
									
									foreach($soalan as $id => $q)		
										{
													$label = 'q'.$q['soalan_id'];	
													$this->addElement(
															'NumberSpinner',
															"$label",
															array(
																'smallDelta'        => 1,
																'largeDelta'        => 5,
																'defaultTimeout'    => 1000,
																'timeoutChangeRate' => 100,
																'min'               => 1,
																'max'               => 5,
																'places'            => 0,
																'maxlength'         => 2,
																'value' => 1,
													
																)
																	);
										}	 */
								
		//Komen / Cadangan
		$this->addElement(
                'Textarea',
                'txt_komen',
                array(
                    
                )
            );
			
		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));
		
		
	}	
		
		
	


	
}
	
?>