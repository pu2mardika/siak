<?php namespace Modules\Akademik\Models;


Class Mod_jurusan extends \App\Models\BaseModel
{
	private $tbl_jurusan	= 'tbl_jurusan';			// tabel prodi
	//`id_jur` ,  `nm_jurusan` ,  `desc` ,  `state`
	
	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->tbl_jurusan	= $ci->config->item('db_table_prefix').$this->tbl_jurusan;
	}
	
	function get_num()
	{
		$this->db->select('*');
		$this->db->from($this->tbl_jurusan);
		$this->db->where('state <',2);
		$data = $this->db->get();
		return $data->num_rows();
	} 
  
	function get_all_jurusan()
	{
		$this->db->select('*');
		$this->db->from($this->tbl_jurusan);
		return $this->db->get();	
	}
	
	function get_paging($limit,$offset)
	{		
		$this->db->select('*');
		$this->db->from($this->tbl_jurusan);
		$this->db->where('state <',2);              //|-----> 0 = inactive, 1=active, 2=disable
		$this->db->limit($limit,$offset);
		$this->db->order_by('id_jur','asc');
		return $this->db->get();
	}
	
	function view_trash($limit,$offset)
	{		
		$this->db->select('*');
		$this->db->from($this->tbl_jurusan);
		$this->db->where('state',2);              //|-----> 0 = inactive, 1=active, 2=disable
		$this->db->limit($limit,$offset);
		$this->db->order_by('id_jur','asc');
		return $this->db->get();
	}
	
	function get_jurusan_by_id($id_jur)
	{
		$this->db->select('*');
		$this->db->from($this->tbl_jurusan);
		$this->db->where('id_jur',$id_jur);
		return $this->db->get();
	}
	
	function update_jurusan($id,$data)
	{
		$this->db->where('id_jur',$id);
		return ($this->db->update($this->tbl_jurusan,$data))?TRUE:FALSE;
	}
	
	function togle_state($id,$sts=0)
	{
		$data = array();
		if($sts==0){$data['state']=1;}else{$data['state']=0;}
		$this->db->where('id_jur',$id);
		$this->db->update($this->tbl_jurusan,$data);
	}
	
	function disable_jurusan($id)
	{
		$data = array('state' => 2);//------------------> 0 = inactive, 1=active, 2=disable
		$this->db->where('id_jur',$id);
		return($this->db->update($this->tbl_jurusan,$data))?TRUE:FALSE;
	}
	
	function hapus_jurusan($id)
	{
		return ($this->db->delete($this->tbl_jurusan,array('id_jur'=>$id)))?TRUE:FALSE;
	}

	function add_jurusan($data)
	{
		return ($this->db->insert($this->tbl_jurusan,$data))?TRUE:FALSE;
	}
	
	function get_jurusan_dropdown(){
    $data = array();
    $Q = $this->db->get($this->tbl_jurusan);
    if ($Q->num_rows() > 0)
	{
       	$data['-']='['.$this->lang->line('jur_name').']';
	   	foreach ($Q->result_array() as $row){
        	$data[$row['id_jur']] = $row['nm_jurusan'];
    	}
    }
    $Q->free_result();  
    return $data; 
	}
	
	function active_jurusan_dropdown(){
    $data = array();
	$this->db->where('state', 1);
    $Q = $this->db->get($this->tbl_jurusan);
    if ($Q->num_rows() > 0)
	{
       	$data['-']='['.$this->lang->line('jur_name').']';
	   	foreach ($Q->result_array() as $row){
        	$data[$row['id_jur']] = $row['nm_jurusan'];
    	}
    }
    $Q->free_result();  
    return $data; 
	}
	
}