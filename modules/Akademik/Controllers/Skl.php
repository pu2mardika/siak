<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('Kurikulum.php');
class Skl extends Kurikulum
{
	private $field;
    function __construct() {
        parent::__construct();
		$this->auth->restrict();
		//$this->simplival->cek(7);
        $this->load->model(array('akademik/mod_skl','akademik/mod_prodi','akademik/mod_curriculum'));
		$this->field=array('id_skl', 'id_curriculum', 'grade', 'subgrade', 'skl', 'grade_name', 'state');
    }
		
	function list_skl()
	{
		$offset = $this->uri->segment(4,0);
		$banyak_ya=$this->mod_skl->get_num();		
		$perpage=$this->config->item('perpage');
		$data2=$this->fungsi->getAjaxPagination($banyak_ya,
				$perpage,'akademik/akademik/skl/list_skl/',4,'#panel_editing');
		$data['paging'] = $data2['paging'];
		$data['banyak']=$banyak_ya;
		$data['skl'] = $this->mod_skl->get_paging($perpage,$offset);
		$data['dt_prodi'] = $this->mod_prodi->get_prodi_dropdown();
		$this->load->view('akademik/skl/panel_skl',$data);
	}
	
	function skl_list_by_cur($idx)
	{
		$this->auth->restrict();
		$ids=(is_array($idx))?$this->uri->segment(3,0):$idx;
		$id=$this->kriptograf->paramDecrypt($ids,$this->keys);
		$data['Data'] = $this->mod_skl->get_skl_by_curr($id)->result_array();
		//$data['curr']= $this->mod_curriculum->get_curriculum_by_id($id);
		$data['keys']=$this->keys;
		$data['token']=$this->token;
		//'grade', 'subgrade', 'skl', 'state'
		$fhead=array('grade'=>15, 'subgrade'=>15,'skl'=>50);
		$data['fhead']=$fhead;
		$this->load->view('akademik/skl/list_skl',$data);
	}
	
	function v_trash()
	{
		$offset = $this->uri->segment(4,0);
		$banyak_ya=$this->mod_skl->get_num();		
		$perpage=$this->config->item('perpage');
		$data2=$this->fungsi->getAjaxPagination($banyak_ya,
				$perpage,'akademik/skl/v_trash/',4,'#panel_editing');
		$data['paging'] = $data2['paging'];
		$data['banyak']=$banyak_ya;
		$data['curr'] = $this->mod_skl->view_trash($perpage,$offset);
		$data['dt_prodi'] = $this->mod_prodi->get_prodi_dropdown();
		$this->load->view('akademik/skl/trash_panel',$data);
	}
	
	function addskl()
	{
		$this->auth->restrict();
		//$this->simplival->hak('master',1);
		$ids=$this->uri->segment(3,0);
		$this->form_validation->set_rules('grade', 'lang:grade', 'trim|required|xss_clean');
		$this->form_validation->set_rules('subgrade', 'lang:subgrade', 'trim|required|xss_clean');
		$id=$this->kriptograf->paramDecrypt($ids,$this->keys);
		$this->simplival->setFields($this->field);
		$data=$this->simplival->acceptData($this->field);
		if ($this->form_validation->run()) {
			$this->_create_skl($ids,$data);
		}else{
			//$data['cmb_prodi'] = $this->mod_prodi->active_prodi_dropdown();
			$Data['subtitle']=$this->lang->line('curr_add_skl');
			$Data['options']=$this->lang->line('norm_state_arr');
			$curr= $this->mod_curriculum->get_curriculum_by_id($id);
			//tentukan grade : `l_duration`, `curr_system`
			$g=0;$G=array();
			for($g=1; $g<=$curr['l_duration'];$g++)
			{
				$G[$g]=$this->lang->line('curr_grade')."&nbsp;".$g;
			}
			$Data['grade']=$G;
			//tentukan subgrade
			$g=0; $S=array();
			for($g=1; $g<=$curr['curr_system'];$g++)
			{
				$S[$g]=$this->lang->line('curr_subgrade')."&nbsp;".$g;
			}
			$Data['subgrade']=$S;
			$Data['keys']=$this->keys;
			$Data['ids']=$ids;
			$Data['target']="#xcv".$this->token;
			$Data['action']="akademik/addskl/{$ids}";
			$Data['token']=$this->token;
			$Data['skl']=$data;//array('grade'=>"", 'subgrade'=>"", 'skl'=>"");
			$Data['formview']='akademik/skl/frm_skl';
			$Data['data']=$Data;
			$this->load->view('admin/nform_modal',$Data);
			//$this->load->view('akademik/skl/frm_skl',$data);
		}
	}
	
	function _create_skl($ids,$data)
	{
		
		$field=array('id_skl', 'id_curriculum', 'grade', 'subgrade', 'skl', 'state', 'grade_name');
		
	//	$ids=$this->input->post('curr_id');
		$data['id_curriculum']=$this->kriptograf->paramDecrypt($ids,$this->keys);
		$data['id_skl']=$data['id_curriculum'].$data['grade'].$data['subgrade'];
		//cek id_skl
		//test_result($data);
		//$data['id_skl']=$idk;	
		if($this->mod_skl->add_skl($data))
		{
			$msgclass='alert-success';
			$message=$this->lang->line('common_saving_success');
		}else{
			$msgclass='alert-warning';
			$message=$this->lang->line('common_saving_error');
		}
		$this->session->set_flashdata('msgclass',$msgclass);
		$this->session->set_flashdata('message',$message);
		//$act_y ='location.reload()';
		$message .="akademik/skl_list_by_cur/".$ids;
		$act_y ='show("akademik/skl_list_by_cur/'.$ids.'","#x-add")';
		echo alert($message,$act_y);
		//echo $this->fungsi->page_refresh();
		//$this->list_skl();			
		//echo $this->uri->uri_string();
	}
	
	function edit()
	{
		//'id_skl', 'curr_id', 'id_prodi', 'skl', 'state'
		
		//$this->form_validation->set_rules('curr_id', 'lang:curr_id', 'trim|required|xss_clean');
		$this->form_validation->set_rules('skl', 'lang:skl_skl', 'trim|required|xss_clean');
		$this->form_validation->set_rules('id_prodi', 'lang:prodi', 'trim|required|xss_clean');
		
		$ids = $this->uri->segment(4,0);
		$this->simplival->hak('master',1);
		$keys=$this->config->item('dynamic_key');
		$id=$this->kriptograf->paramDecrypt($ids,$keys);
		
		if ($this->form_validation->run()) {
			$this->update($id);
		}else{
			//$data['ids'] = $id;
			$data['skl'] = $this->mod_skl->get_skl_by_id($id);
			$data['cmb_prodi'] = $this->mod_prodi->active_prodi_dropdown();
			$this->load->view('akademik/skl/frm_skl_edit',$data);
		}
	}
	
	function update($id)
	{
		$field=array('skl', 'id_prodi','state');		
		$data['errors'] = array();
		$this->simplival->setFields($field);
		$data=$this->simplival->acceptData($field);
				
		if($this->mod_skl->update_skl($id,$data))
		{
			$this->session->set_flashdata('message',$this->lang->line('mhs_updated'));
		}
		$pages=$this->session->userdata('page');
		$this->fungsi->load_ajax($pages,'#panel_editing');
	}
	
	function delete($ids){
		$keys=$this->config->item('dynamic_key');
		$id=$this->kriptograf->paramDecrypt($ids,$keys);
		$this->mod_skl->disable_skl($id);
		$this->session->set_flashdata('message','Profile deleted');
		$$pages=$this->session->userdata('page');
		$this->fungsi->load_ajax($pages,'#panel_editing');
	}
	
	function togle_sts($ids,$val){
		$keys=$this->config->item('dynamic_key');
		$id=$this->kriptograf->paramDecrypt($ids,$keys);
		$sts=$this->kriptograf->paramDecrypt($val,$keys);
		$this->mod_skl->togle_state($id,$sts);
		$pages=$this->session->userdata('page');
		$this->fungsi->load_ajax($pages,'#panel_editing');
	}	
	
}

/* End of file curriculum.php */
/* Location: ./application/controllers/akademik/skl.php */