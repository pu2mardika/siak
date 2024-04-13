<?php namespace Modules\Akademik\Controllers;
use App\Controllers\BaseController;
use Modules\Akademik\Models\ProdiModel;

class Prodi extends BaseController {
	
    function __construct() {
        parent::__construct();
       
		$this->model = new ProdiModel;	
		$this->data['site_title'] = 'Halaman Prodi';
		
		$this->addStyle ( $this->config->baseURL . 'public/vendors/bulma-switch/bulma-switch.min.css?r=' . time());
		$this->addJs ( $this->config->baseURL . 'public/themes/modern/builtin/js/module.js');
		
		helper(['cookie', 'form','filesystem']);
		
    }
    
    // index
	public function index()
	{
		$this->cekHakAkses('read_data');
		$m_prodi 		= new ProdiModel();
		$dprodi 		= $m_prodi->findAll();
		$total 			= $m_prodi->total();

		$data = [	'title'			=> 'Manajemen data Program Studi',
					'prodi'		=> $dprodi,
					'content'		=> 'admin/berita/index'
				];
		echo view('Modules\Akademik\Views\ps\panel_prodi',$data);
	}
     
    function shprodi()
    {
		$this->session->set_userdata('page',$this->uri->uri_string());
		$data['list']=Modules::run('akademik/list_prodi');
		$data['cat']=$this->mod_jurusan->get_jurusan_dropdown();
		$data['gcat']=0;
	//	$data['ur']="akademik/list_prodi";
		echo view('akademik/ps/panel_prodi',$data );
	}
		
	function list_prodi()
	{
		$offset = $this->uri->segment(4,0);
		$banyak_ya=$this->mod_prodi->get_num();		
		$perpage=$this->config->item('perpage');
		$data2=$this->fungsi->getAjaxPagination($banyak_ya,
				$perpage,'akademik/list_prodi/',3,'#x_result');
		$data['paging'] = $data2['paging'];
		$data['jml_jur']=$banyak_ya;
		$data['egrid']=$this->mod_prodi->get_grade_dropdown();
		$data['jurdd']=$this->mod_jurusan->get_jurusan_dropdown();
		$data['keys']=$this->keys;
		$data['prodi'] = $this->mod_prodi->get_paging($perpage,$offset);
		$this->load->view('akademik/ps/list_prodi',$data);
	}
	
	function add_prodi()
	{
		//''id_prodi', 'nm_prodi', 'desc', 'id_jur', 'jenjang', 'state'
		$this->form_validation->set_rules('nm_prodi','lang:prodi_name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('desc', 'lang:jur_desc', 'trim|required|xss_clean');
		
		//$this->simplival->hak('master',1);
		
		if ($this->form_validation->run()) {
			$this->_create_prodi();
		}else{
			$data['egrid']=$this->mod_prodi->get_grade_dropdown();
			$data['jurdd']=$this->mod_jurusan->active_jurusan_dropdown();
			$data['formview']='akademik/ps/frm_prodi_add';
			$this->load->view('admin/nform',$data);
		}
	}
	
	private function _create_prodi()
	{
		$field=array('nm_prodi', 'desc', 'id_jur', 'jenjang', 'state');
		$this->simplival->setFields($field);
		$data=$this->simplival->acceptData($field);
		if($this->mod_prodi->add_prodi($data))
		{
			$this->session->set_flashdata('msgclass','alert-success');
			$this->session->set_flashdata('message',$this->lang->line('common_saving_success'));
		}else{
			$this->session->set_flashdata('msgclass','alert-warning');
			$this->session->set_flashdata('message',$this->lang->line('common_saving_error'));
		}
		
		echo $this->fungsi->page_refresh();	

	}
	
	function edit_ps()
	{
		
		//'id_jur' ,  'nm_prodi' ,  'desc' ,  'state'
		$this->form_validation->set_rules('nm_prodi','lang:prodi_name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('desc', 'lang:jur_desc', 'trim|required|xss_clean');
		$ids = $this->uri->segment(3,0);
		//$this->simplival->hak('master',1);
		
		$id=$this->kriptograf->paramDecrypt($ids,$this->keys);
		
		if ($this->form_validation->run()) {
			$this->_update($id);
		}else{
			//$data['ids'] = $id;
			$data['egrid']=$this->mod_prodi->get_grade_dropdown();
			$data['jurdd']=$this->mod_jurusan->active_jurusan_dropdown();
			$data['prodi'] = $this->mod_prodi->get_prodi_by_id($id);
			$data['formview']='akademik/ps/frm_prodi_edit';
			$this->load->view('admin/nform',$data);
		}
	}
	
	private function _update($id)
	{
		$field=array('nm_prodi', 'desc', 'id_jur', 'jenjang', 'state');		
		$data['errors'] = array();
		$this->simplival->setFields($field);
		$data=$this->simplival->acceptData($field);
				
		if($this->mod_prodi->update_prodi($id,$data))
		{
			$this->session->set_flashdata('msgclass','alert-success');
			$this->session->set_flashdata('message',$this->lang->line('common_saving_success'));
		}else{
			$this->session->set_flashdata('msgclass','alert-warning');
			$this->session->set_flashdata('message',$this->lang->line('common_saving_error'));
		}
		
		echo $this->fungsi->page_refresh();
	}
	
	function delps(){
		$ids = $this->uri->segment(3,0);
		$id=$this->kriptograf->paramDecrypt($ids,$this->keys);
		if($this->input->post('hkey')){
			$this->mod_prodi->disable_prodi($id);
			$this->list_prodi();
		}else{
			//tampilkan dialogbox
			$ps=$this->mod_prodi->get_prodi_by_id($id);
			$ps=$ps->row_array();
			$data['hkey']=$ids;
			$data['subtitle']=$this->lang->line('rem').' : '.$ps['nm_prodi'];
			$data['msg_title']=$this->lang->line('common_remove_msg');
			//$data['msg'][]=$ps['nm_prodi'];
			$data['msg'][]=$ps['desc'];
			$this->load->view('admin/konfirm_modal',$data);
		}
	}
	
	function togle_ps($ids,$val){
		$id=$this->kriptograf->paramDecrypt($ids,$this->keys);
		$sts=$this->kriptograf->paramDecrypt($val,$this->keys);
		$this->mod_prodi->togle_state($id,$sts);
		$this->fungsi->load_ajax('akademik/list_prodi','#x_result');
	}
}

/* End of file yoa.php */
/* Location: ./application/controllers/akademik/yoa.php */