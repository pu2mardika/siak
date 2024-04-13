<?php
namespace Modules\Akademik\Models;
use App\Libraries\Auth;

class Mod_prodi extends \CodeIgniter\Model 
{
	private $tbl_prodi	= 'tbl_prodi';	// tabel prodi  => `id_prodi`, `nm_prodi`, `desc`, `id_jur`, `jenjang`, `state`
	private $tbl_grade	= 'tbl_educ_grade';	// tabel grade => `grade_id`, `desc`
	
	function __construct()
	{
		parent::__construct();

		//$ci =& get_instance();
		$this->tbl_prodi	= $ci->config->item('db_table_prefix').$this->tbl_prodi;
	}
	
	function get_num()
	{
		$this->db->select('*');
		$this->db->from($this->tbl_prodi);
		$data = $this->db->get();
		return $data->num_rows();
	} 
	
	function get_num_by_jur($jur)
	{
		$this->db->select('*');
		$this->db->from($this->tbl_prodi);
		$this->db->where('id_jur',$jur);
		$data = $this->db->get();
		return $data->num_rows();
	} 
  
	function get_all_prodi()
	{
		$this->db->select('*');
		$this->db->from($this->tbl_prodi);
		return $this->db->get();	
	}
	
	function get_paging($limit,$offset)
	{		
		$this->db->select('*');
		$this->db->from($this->tbl_prodi);
		$this->db->where('state <',2);
		$this->db->limit($limit,$offset);
		$this->db->order_by('id_prodi','asc');
		return $this->db->get();
	}
	
	function get_prodi_by_id($id_prodi)
	{
		$this->db->select('*');
		$this->db->from($this->tbl_prodi);
		$this->db->where('id_prodi',$id_prodi);
		return $this->db->get();
	}
	
	function update_prodi($id,$data)
	{
		$this->db->where('id_prodi',$id);
		$this->db->update($this->tbl_prodi,$data);
		return TRUE;
	}
	
	function disable_prodi($id)
	{
		$data = array('state' => 2);//------------------> 0 = inactive, 1=active, 2=disable
		$this->db->where('id_prodi',$id);
		$this->db->update($this->tbl_prodi,$data);
	}
	
	function hapus_prodi($id)
	{
		$this->db->delete($this->tbl_prodi,array('id_prodi'=>$id));
	}

	function add_prodi($data)
	{
		return($this->db->insert($this->tbl_prodi,$data));
		
	}
	
	function togle_state($id,$sts=0)
	{
		$data = array();
		if($sts==0){$data['state']=1;}else{$data['state']=0;}
		$this->db->where('id_prodi',$id);
		$this->db->update($this->tbl_prodi,$data);
	}
	
	function get_prodi_dropdown(){
	    $data = array();
	    $Q = $this->db->get($this->tbl_prodi);
	    if ($Q->num_rows() > 0){
	       	$data['']='['.$this->lang->line('actions_select').'&nbsp;'
	       				  .$this->lang->line('prodi_name').']';
		   	foreach ($Q->result_array() as $row){
	         	$data[$row['id_prodi']] = $row['nm_prodi'];
	       	}
	    }
	    $Q->free_result();  
	    return $data; 
	}
	
	function active_prodi_dropdown($parm=NULL){
	    $data = array();
		$this->db->where('state',1);
		if(!is_null($parm)){$this->db->where($parm);}
	    $Q = $this->db->get($this->tbl_prodi);
	    if ($Q->num_rows() > 0){
    		$data['']='['.$this->lang->line('actions_select').'&nbsp;'
       				  .$this->lang->line('prodi_name').']';
		   	foreach ($Q->result_array() as $row){
	         	$data[$row['id_prodi']] = $row['nm_prodi'];
	       	}
	    }
	    $Q->free_result();  
	    return $data; 
	}
	
	function get_grade_dropdown(){
	    $data = array();
	    $Q = $this->db->get($this->tbl_grade);
	    if ($Q->num_rows() > 0){
	       	$data['-']='['.$this->lang->line('prodi_grade').']';
		   	foreach ($Q->result_array() as $row){
	         	$data[$row['grade_id']] = $row['desc'];
	       	}
	    }
	    $Q->free_result();  
	    return $data; 
	}	
}