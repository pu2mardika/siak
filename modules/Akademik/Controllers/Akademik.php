<?php

class Akademik extends Skl
{
	//private $key ;
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		echo "Akademik";
	}
	
	function vjur()
	{
		$offset = ($this->uri->segment(2,0)=='list_jurusan')?$this->uri->segment(3,0):0;
		$banyak_ya=$this->mod_jurusan->get_num();		
		$perpage=$this->config->item('perpage');
		$data2=$this->fungsi->getAjaxPagination($banyak_ya,
				$perpage,'akademik/vjur/',3,'#panel_editing');
		$data['paging'] = $data2['paging'];
		$data['banyak']=$banyak_ya;
		$data['keys']=$this->keys;
		$data['jurusan'] = $this->mod_jurusan->get_paging($perpage,$offset);
		//$this->load->view('akademik/jurusan/list_jurusan',$data);
		$DATA['dv']='akademik/jurusan/list_jurusan';
		$DATA['data']=$data;
		$this->load->view('pages/index',$DATA);
	}
	
	function comp_nilai($idx)
	{
		$this->auth->restrict();
		$ids=(is_array($idx))?$this->uri->segment(3,0):$idx;
		$id=$this->kriptograf->paramDecrypt($ids,$this->keys);
		
		$par['id_kurikulum']=$id;		
		$data['Data'] = $this->mod_comp_nilai->get_all($par);
		$data['keys']=$this->keys;
		$data['token']=$this->token;
		$data['currID']=$ids;
		$data['hasRef']=array('grup_comp','jns_nilai');
		$data['opsi']=array('grup_comp'=>$this->lang->line('grup_comp_arr'),
							'jns_nilai'=>$this->lang->line('jns_nilai_arr'));
		$fhead=array('nama_komponen'=>45, 'grup_comp'=>15, 'jns_nilai'=>15);
		$data['fhead']=$fhead;
		$this->load->view('akademik/comp_nilai/list_comp',$data);
	}
	
	function add_comp($idx)
	{
		$ids=(is_array($idx))?$this->uri->segment(3,0):$idx;
		$id=$this->kriptograf->paramDecrypt($ids,$this->keys);
		
		$this->form_validation->set_rules('nama_komponen', 'lang:nama_komponen', 'trim|required|xss_clean');
		$field=array('id_comp', 'id_kurikulum', 'nama_komponen', 'no_urut','grup_comp','jns_nilai');
		$this->simplival->setFields($field);
		$data=$this->simplival->acceptData($field);
		if ($this->form_validation->run()) {
			$currID=$id;
			$data['id_comp']=$currID.$data['grup_comp'].sprintf("%02d",$data['no_urut']);
			$data['id_kurikulum']=$currID;

			if($this->mod_comp_nilai->save($data,'id_comp'))
			{
				$msgclass='alert-success';
				$message=$this->lang->line('common_saving_success');
			}else{
				$msgclass='alert-warning';
				$message=$this->lang->line('common_saving_error');
			}
			$this->session->set_flashdata('msgclass',$msgclass);
			$this->session->set_flashdata('message',$message);
			$act_n='show("akademik/vcomp/'.$ids.'","#x-ads")';
			echo alert($message,$act_n);
		//	echo $this->fungsi->warning($message);
		}else{
			
			$data['keys']=$this->keys;
			$data['has_ref']=array('grup_comp','jns_nilai');
			$data['opsi']=array('grup_comp'=>$this->lang->line('grup_comp_arr'),
								'jns_nilai'=>$this->lang->line('jns_nilai_arr'));
			$data['field']=array('nama_komponen', 'no_urut','grup_comp','jns_nilai');
			$data['WAJIB']=$data['field'];//array('nama_komponen', 'no_urut','grup_comp');
			$data['row_data']=array("nama_komponen"=>"","no_urut"=>"","grup_comp"=>1,"jns_nilai"=>"A");
			$Data['formview']= 'akademik/comp_nilai/frm_comp';		
			$Data['data']= $data;
			$Data['token']=$this->token;	
			$Data['subtitle']=$this->lang->line('add_comp');	
			$Data['btn']= array('ok'=>'Simpan' , 'batal'=>'Batal');		
			$this->load->view('admin/nform_modal',$Data);
		}
		
	}
	
	function editcomp()
	{
		
	}
	
	function delcomp()
	{
		
	}
	
	function vcomp()
	{
		$ids=$this->uri->segment(3,0);
		$dtComp=Modules::run('akademik/comp_nilai',$ids);
		echo $dtComp;
	}
}