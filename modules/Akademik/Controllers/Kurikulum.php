<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Prodi.php');
class Kurikulum extends Prodi
{	//public $keys;
	private $field =array();
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('akademik/mod_curriculum','akademik/mod_prodi','akademik/mod_comp_nilai'),TRUE);
		$this->lang->load('akademik/kurikulum');
		$this->field=array('id_curriculum', 'id_prodi', 'curr_name', 'issued', 'curr_desc', 'l_duration', 'curr_system', 'state');
		
	}
	
	function curriculum()
	{
		$this->session->set_userdata('page',$this->uri->uri_string());
		$this->load->view('akademik/kurikulum/panel_curr', array('list'=>Modules::run('akademik/list_curr')));
	}
	
	function list_curr()
	{
		$offset =($this->uri->segment(2,0)=='list_curriculum')?$this->uri->segment(3,0):0;
		$banyak_ya=$this->mod_curriculum->get_num();		
		$perpage=$this->config->item('perpage');
		$data2=$this->fungsi->getAjaxPagination($banyak_ya,
				$perpage,'akademik/list_curriculum/',3,'#x_result');
		$data['paging'] = $data2['paging'];
		$data['banyak']=$banyak_ya;
		$data['keys']=$this->keys;
		$data['curr'] = $this->mod_curriculum->get_paging($perpage,$offset);
		$this->load->view('akademik/kurikulum/list_curr',$data);
	}
	
	function cur_archive()
	{
		$offset = $this->uri->segment(3,0);
		$banyak_ya=$this->mod_curriculum->get_num();		
		$perpage=$this->config->item('perpage');
		$data2=$this->fungsi->getAjaxPagination($banyak_ya,
				$perpage,'akademik/kurikulumiculum/v_trash/',3,'#panel_editing');
		$data['paging'] = $data2['paging'];
		$data['jml_jur']=$banyak_ya;
		$data['curr'] = $this->mod_curriculum->view_trash($perpage,$offset);
		$this->load->view('akademik/kurikulum/trash_panel',$data);
	}
	
	function dtlcurr()
	{
		$ids = $this->uri->segment(3,0);
		//$this->simplival->hak('master',1);
		$keys=$this->config->item('dynamic_key');
		$id=$this->kriptograf->paramDecrypt($ids,$this->keys);
					
		//$data['ids'] = $id;
		$data['curriculum'] = $this->mod_curriculum->get_curriculum_by_id($id);
		$data['curr_system_list'] = $this->lang->line("curr_system_list");
		$data['cmb_prodi'] = $this->mod_prodi->active_prodi_dropdown();
		$data['ids']=$ids;
		$data['token']=$this->token;
		$data['options'] = $this->lang->line('norm_state_arr');
		$data['dskl']=Modules::run('akademik/skl_list_by_cur',$ids);
		$data['dcomp']=Modules::run('akademik/comp_nilai',$ids);
		$this->load->view('akademik/kurikulum/frm_curr_view',$data);
	}
	
	function add_curr()
	{
		$this->form_validation->set_rules('curr_name', 'lang:curr_name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('curr_desc', 'lang:curr_desc', 'trim|required|xss_clean');
		$this->form_validation->set_rules('issued', 'lang:issued', 'trim|required|xss_clean');
		
		//$this->simplival->hak('master',1);
	
		$field=$this->field;
		$this->simplival->setFields($field);
		$data=$this->simplival->acceptData($field);
		
		if ($this->form_validation->run()) {
			$this->_create_curriculum($data);
		}else{
			$Data['issued']=now();
			$Data['cmb_prodi'] = $this->mod_prodi->active_prodi_dropdown();
			$Data['options']=$options=$this->lang->line('norm_state_arr');
			$Data['ls_options']=$options=$this->lang->line('curr_system_list');
			$Data['curriculum'] =$data;
			$Data['formview']='akademik/kurikulum/frm_curr';
			$Data['keys']=$this->keys;
			$this->load->view('admin/nform',$Data);
		}
	}
	
	private function _create_curriculum($data)
	{
		$tgl=$this->input->post('issued');//format data 'd-m-Y'
		$issued=ind_to_unix($tgl);
		$yy=date('y',$issued);
		$rdnum=random_string('numeric',1);
		$idk=sprintf("%02d",$data['id_prodi']).$yy.$rdnum;
		
		$data['id_curriculum']=$idk;
		$data['issued']=$issued;//date('Y-m-d');
		
		if($this->mod_curriculum->add_curriculum($data))
		{
			$this->session->set_flashdata('msgclass','alert-success');
			$this->session->set_flashdata('message',$this->lang->line('common_saving_success'));
		}else{
			$this->session->set_flashdata('msgclass','alert-warning');
			$this->session->set_flashdata('message',$this->lang->line('common_saving_error'));
		}
		//echo $this->fungsi->page_refresh();
		$this->curriculum();
	}
	
	function editcur()
	{
		//'id_curriculum', 'id_prodi', 'curr_name', 'issued', 'curr_desc', 'l_duration', 'curr_system', 'state'
		$this->form_validation->set_rules('curr_name', 'lang:curr_name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('curr_desc', 'lang:curr_desc', 'trim|required|xss_clean');
		$this->form_validation->set_rules('issued', 'lang:issued', 'trim|required|xss_clean');
		
		$ids = $this->uri->segment(3,0);
		//$this->simplival->hak('master',1);
		$id=$this->kriptograf->paramDecrypt($ids,$this->keys);
		
		if ($this->form_validation->run()) {
			$this->_update($id);
		}else{
			//$data['ids'] = $id;
			$data['curriculum'] = $this->mod_curriculum->get_curriculum_by_id($id);
			$data['cmb_prodi'] = $this->mod_prodi->active_prodi_dropdown();
			$data['options']=$options=$this->lang->line('norm_state_arr');
			$data['ls_options']=$options=$this->lang->line('curr_system_list');
			$data['formview']='akademik/kurikulum/frm_curr';
			$this->load->view('admin/nform',$data);
		}
	}
	
	private function _update($id)
	{
		//'id_curriculum', 'curr_name', 'issued', 'curr_desc', 'state'
		$field=$this->field;		
		$data['errors'] = array();
		$this->simplival->setFields($field);
		$data=$this->simplival->acceptData($field);
		$tgl=$this->input->post('issued');//format data 'd-m-Y'
		$data['issued']=ind_to_unix($tgl);//date('Y-m-d');
		$data['id_curriculum']=$id;//date('Y-m-d');
				
		if($this->mod_curriculum->update_curriculum($id,$data))
		{
			$this->session->set_flashdata('msgclass','alert-success');
			$this->session->set_flashdata('message',$this->lang->line('common_saving_success'));
		}else{
			$this->session->set_flashdata('msgclass','alert-warning');
			$this->session->set_flashdata('message',$this->lang->line('common_saving_error'));
		}
		//echo $this->fungsi->page_refresh();
		$this->curriculum();
	}
	
	function delcur($ids){
		$ids = $this->uri->segment(3,0);
		$id=$this->kriptograf->paramDecrypt($ids,$this->keys);
		if($this->input->post('hkey')){
			$this->mod_curriculum->disable_curriculum($id);
			$this->list_curr();
		}else{
			//tampilkan dialogbox
			$ps=$this->mod_curriculum->get_curriculum_by_id($id);
			$ps=$ps->row_array();
			$data['hkey']=$ids;
			$data['subtitle']=$this->lang->line('rem').' : '.$ps['curr_name'];
			$data['msg_title']=$this->lang->line('common_remove_msg');
			//$data['msg'][]=$ps['nm_prodi'];
			$data['msg'][]=$ps['curr_desc'];
			$this->load->view('admin/konfirm_modal',$data);
		}
	}
	
	function cur_tsts($ids,$val){
		$keys=$this->config->item('dynamic_key');
		$id=$this->kriptograf->paramDecrypt($ids,$keys);
		$sts=$this->kriptograf->paramDecrypt($val,$keys);
		$this->mod_curriculum->togle_state($id,$sts);
		$this->fungsi->load_ajax('akademik/kurikulumiculum/list_curriculum','#panel_editing');
	}	
	
	function testtt()
	{
		echo "ADA APA YA...";
	}
	
}