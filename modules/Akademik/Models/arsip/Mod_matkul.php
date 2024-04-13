<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Mod_matkul extends CI_Model
{
	private $tbl_matkul	= 'tbl_matkul';			//  tabel mata kuliah
	
	
	//`kode_mk`, `nama_mk`, `bobot`, `semester`, `prasyarat`, `id_skl`, `cat_mk`, `sk`, `desk`, `materi`, `state`
	
	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->tbl_matkul	= $ci->config->item('db_table_prefix').$this->tbl_matkul;
	}
	
	function get_num()
	{
		$this->db->select('*');
		$this->db->from($this->tbl_matkul);
		$data = $this->db->get();
		return $data->num_rows();
	} 
  
	function get_all_matkul()
	{
		$this->db->select('*');
		$this->db->from($this->tbl_matkul);
		return $this->db->get();	
	}
	
	function get_matkul_by_curr($skl)
	{
		$this->db->select('*');
		$this->db->from($this->tbl_matkul);
		$this->db->where('id_skl',$skl);
		$this->db->where('state <',2);              //|-----> 0 = inactive, 1=active, 2=disable
		$this->db->order_by('kode_mk','asc');
		return $this->db->get();	
	}
	
	function get_paging($limit,$offset, $ids)
	{		
		$this->db->select('*');
		$this->db->from($this->tbl_matkul);
		$this->db->where('id_skl',$ids);
		$this->db->where('state <',2);              //|-----> 0 = inactive, 1=active, 2=disable
		$this->db->limit($limit,$offset);
		$this->db->order_by('kode_mk','asc');
		return $this->db->get();
	}
		
	function view_trash($limit,$offset)
	{		
		$this->db->select('*');
		$this->db->from($this->tbl_matkul);
		$this->db->where('state',2);              //|-----> 0 = inactive, 1=active, 2=disable
		$this->db->limit($limit,$offset);
		$this->db->order_by('kode_mk','asc');
		return $this->db->get();
	}
	
	function get_matkul_by_id($kode_mk)
	{
		$this->db->select('*');
		$this->db->from($this->tbl_matkul);
		$this->db->where('kode_mk',$kode_mk);
		return $this->db->get();
	}
	
	//'kode_mk', 'curr_name', 'skl', 'id_prodi'
	
	function update_matkul($id,$data)
	{
		$this->db->where('kode_mk',$id);
		$this->db->update($this->tbl_matkul,$data);
		return TRUE;
	}
	
	function hapus_matkul($id)
	{
		$this->db->delete($this->tbl_matkul,array('kode_mk'=>$id));
	}

	function add_matkul($data)
	{
		$this->db->insert($this->tbl_matkul,$data);
	}

	function togle_state($id,$sts=0)
	{
		$data = array();
		if($sts==0){$data['state']=1;}else{$data['state']=0;}
		$this->db->where('kode_mk',$id);
		$this->db->update($this->tbl_matkul,$data);
	}
	
	function disable_matkul($id)
	{
		$data = array('state' => 2);//------------------> 0 = inactive, 1=active, 2=disable
		$this->db->where('kode_mk',$id);
		$this->db->update($this->tbl_matkul,$data);
	}
	
	//'kode_mk', 'curr_name', 'skl', 'id_prodi'
	
	function get_matkul_dropdown(){
    $data = array();
    $Q = $this->db->get($this->tbl_matkul);
    if ($Q->num_rows() > 0)
	{
       	$data['-']='['.$this->lang->line('curr_name').']';
	   	foreach ($Q->result_array() as $row){
        	$data[$row['kode_mk']] = $row['curr_name'];
    	}
    }
    $Q->free_result();  
    return $data; 
	}
	
	function active_matkul_dropdown(){
    $data = array();
	$where = array('state' => 1);
    $Q = $this->db->get($this->tbl_matkul,$where);
    if ($Q->num_rows() > 0)
	{
       	$data['-']='['.$this->lang->line('curr_name').']';
	   	foreach ($Q->result_array() as $row){
        	$data[$row['kode_mk']] = $row['curr_name'];
    	}
    }
    $Q->free_result();  
    return $data; 
	}

}

/* End of file mod_matkul.php */
/* Location: ./application/models/academic/mod_matkul.php */