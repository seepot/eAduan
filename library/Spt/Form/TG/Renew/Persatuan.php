<?php
class Spt_Form_TG_Renew_Persatuan extends Zend_Dojo_Form
{
	protected $_id;
	
	public function init($id = 0)
    {
		$this->_id = $id;
		//setting environment
		$this->setAction(SYSTEM_URL.'/tg/renew/renew?currtab=persatuan');
		$this->setMethod('post');

		$translate = Zend_Registry::get ( 'translate' );


	//section: persatuan

		//Nama Persatuan
		$this->addElement(
                'ValidationTextBox',
                'renew_persatuan_name',
                array(
                    'value'		=> $this->getRowPermohonanLesen('appl_persatuan_name'),
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );

		//Tarikh Menjadi Ahli
		$this->addElement(
                'DateTextBox',
                'renew_persatuan_tkh_ahli',
                array(
					'value'		=> $this->getRowPermohonanLesen('appl_persatuan_tkh_ahli'),
					'required'       => true,
					'invalidMessage' => 'Tarikh Tidah Sah',
					'datePattern'   => 'dd-MM-yyyy',
					'formatLength'   => 'short',
                )
            );

		//Jawatan
		$this->addElement(
                'ValidationTextBox',
                'renew_persatuan_jawatan',
                array(
                    'value'		=> $this->getRowPermohonanLesen('appl_persatuan_jawatan'),
                    'trim'       => true,
					'required'       => true,
					'invalidMessage' => 'Diperlukan',
                )
            );


		$this->setElementDecorators(array(
				'DijitElement',
				'Errors',

		));

		$this->setDecorators(array(
				'FormElements',
				array(array('data'=>'HtmlTag'),
				array('tag'=>'table','cellspacing'=>'4')),
				'DijitForm'
		));

	}

	public function getRowPermohonanLesen($field = '')
	{
		$db = Zend_Registry::get ( 'db' );
		$rowpermohonanlesen = $db->fetchRow(
			$db->select()
					->from(array('a' => 'tbl_tg_application'),
						array(	'appl_id','appl_date', 'appl_nama_penuh', 'appl_nama_lain', 
								'appl_tkh_lahir', 'appl_umur', 'appl_tmpt_lahir', 'sta_id', 'gender_id', 'usrmrd_id', 
								'nationality_id', 'appl_no_kerakyatan', 'appl_kp_passport', 'appl_warna_kp', 
								'appl_kp_keluar_tkh', 'appl_kp_keluar_tmpt', 'appl_alamat_rumah', 
								'appl_poskod', 'appl_tel_rumah', 'appl_tel_bimbit', 'appl_alamat_lain', 
								'appl_pekerjaan', 'appl_majikan_alamat', 'appl_majikan_tel', 
								'appl_pernah', 'appl_no_lesen', 'appl_tkh_lesen_keluar', 
								'appl_tkh_lesen_tamat', 'appl_kerja_memandu', 'appl_kursus_name', 
								'appl_kursus_tkh', 'appl_kursus_tkh_tamat', 'penganjur_id', 'appl_kursus_keputusan', 
								'appl_persatuan_name', 'appl_persatuan_tkh_ahli', 'appl_persatuan_jawatan', 
								'appl_ruj_name1', 'appl_ruj_alamat1', 'appl_ruj_pekerjaan1', 
								'appl_ruj_nama2', 'appl_ruj_alamat2', 'appl_ruj_pekerjaan2', 
								'appl_perakuan', 'appl_semak_kp', 'appl_semak_resit_keahlian', 
								'appl_semak_surat_kesihatan', 'tg_type_id', 'appl_semak_cg_sijil', 'appl_semak_cg_skm', 
								'appl_semak_kelayakan_akademik', 'appl_semak_cg_sijil_pmm', 'appl_semak_cg_surat_tawaran', 
								'appl_semak_catatan', 'appl_semak_usr_id', 'appl_semak_tkh', 'taraf_pekerjaan_id',
								'appl_sah_usr_id', 'appl_sah_tkh', 'appl_syor_usr_id', 
								'appl_syor_tkh', 'appl_syor_ulasan', 'appl_peraku_usr_id', 
								'appl_peraku_tkh', 'appl_peraku_perakuan', 'appl_kelulusan_usr_id', 
								'appl_kelulusan_tkh', 'appl_kelulusan', 'appl_serah_resit', 'appl_serah_tkh', 'appl_serah_usr_id'))
					->join(array('sta' => 'sys_state'),
						'a.sta_id = sta.sta_id',
						array('sta_name'))
					->join(array('g' => 'sys_gender'),
						'a.gender_id = g.gender_id',
						array('gender_desc_may'))
					->join(array('m' => 'sys_marital'),
						'a.usrmrd_id = m.usrmrd_id',
						array('ursmrd_name'))
					->join(array('n' => 'sys_nationality'),
						'a.nationality_id = n.nationality_id',
						array('nationality_name'))
					->joinLeft('sys_taraf_pekerjaan',
						'a.taraf_pekerjaan_id = sys_taraf_pekerjaan.taraf_pekerjaan_id',
						array('taraf_pekerjaan_name'))
					->joinLeft('sys_penganjur',
						'a.penganjur_id = sys_penganjur.penganjur_id',
						array('penganjur_name'))
					->joinLeft(array('t' => 'sys_tg_type'),
						'a.tg_type_id = t.tg_type_id',
						array('tg_type_name'))
					->where( 'usr_id = ?', $this->_id )
		);
		return $rowpermohonanlesen[$field];
	}
	
}
?>