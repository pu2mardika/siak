<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Mod_curriculum extends CI_Model
{
	private $tbl_curriculum	= 'tbl_curriculum';			// tabel kurikulum
	
	
	//'`id_curriculum`, `id_prodi`, `curr_name`, `issued`, `curr_desc`, `l_duration`, `curr_system`, `state`
	
	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->tbl_curriculum	= $ci->config->item('db_table_prefix').$this->tbl_curriculum;
	}
	
	function get_num()
	{
		$this->db->select('*');
		$this->db->where('state <',2);
		$this->db->from($this->tbl_curriculum);
		$data = $this->db->get();
		return $data->num_rows();
	} 
  
	function get_all_curriculum()
	{
		$this->db->select('*');
		$this->db->from($this->tbl_curriculum);
		return $this->db->get();	
	}
	
	function get_paging($limit,$offset)
	{		
		$this->db->select('*');
		$this->db->from($this->tbl_curriculum);
		$this->db->where('state <',2);              //|-----> 0 = inactive, 1=active, 2=disable
		$this->db->limit($limit,$offset);
		$this->db->order_by('id_curriculum','asc');
		return $this->db->get();
	}
		
	function view_trash($limit,$offset)
	{		
		$this->db->select('*');
		$this->db->from($this->tbl_curriculum);
		$this->db->where('state',2);              //|-----> 0 = inactive, 1=active, 2=disable
		$this->db->limit($limit,$offset);
		$this->db->order_by('id_curriculum','asc');
		return $this->db->get();
	}
	
	function get_curriculum_by_id($id_curriculum)
	{
		$this->db->select('*');
		$this->db->from($this->tbl_curriculum);
		$this->db->where('id_curriculum',$id_curriculum);
		if($Q=$this->db->get())
		{
			return $Q->row_array();
		}
	}
	
	function get_curriculum_by($param=array(),$atrib="*")
	{
		$this->db->select($atrib);
		$this->db->from($this->tbl_curriculum);
		$this->db->where($param);
		if($Q=$this->db->get())
		{
			return $Q->row_array();
		}
	}
	
	function curent_curriculum($prodi)
	{
		$this->db->select('*');
		$this->db->from($this->tbl_curriculum);
		$this->db->where('id_prodi',$prodi);
		$this->db->where("issued IN (SELECT MAX(issued) FROM ".$this->tbl_curriculum." GROUP by id_prodi)");
		if($Q=$this->db->get())
		{
			return $Q->row_array();
		}
	}
	
	//'id_curriculum', 'curr_name', 'skl', 'id_prodi'
	
	function update_curriculum($id,$data)
	{
		$this->db->where('id_curriculum',$id);
		$this->db->update($this->tbl_curriculum,$data);
		return TRUE;
	}
	
	function hapus_curriculum($id)
	{
		$this->db->delete($this->tbl_curriculum,array('id_curriculum'=>$id));
	}

	function add_curriculum($data)
	{
		return ($this->db->insert($this->tbl_curriculum,$data))?TRUE:FALSE;
	}

	function togle_state($id,$sts=0)
	{
		$data = array();
		if($sts==0){$data['state']=1;}else{$data['state']=0;}
		$this->db->where('id_curriculum',$id);
		$this->db->update($this->tbl_curriculum,$data);
	}
	
	function disable_curriculum($id)
	{
		$data = array('state' => 2);//------------------> 0 = inactive, 1=active, 2=disable
		$this->db->where('id_curriculum',$id);
		$this->db->update($this->tbl_curriculum,$data);
	}
	
	//'id_curriculum', 'curr_name', 'skl', 'id_prodi'
	
	function get_curriculum_dropdown($param=array()){
	    $data = array();
	    $this->db->select('*');
		$this->db->from($this->tbl_curriculum);
		$this->db->where($param);
	    $Q = $this->db->get();
	    if ($Q->num_rows() > 0)
		{
	       	$data['-']='['.$this->lang->line('curr_name').']';
		   	foreach ($Q->result_array() as $row){
	        	$data[$row['id_curriculum']] = $row['curr_name'];
	    	}
	    }
	    $Q->free_result();  
	    return $data; 
	}
	
	function active_curriculum_dropdown($where=array()){
    $data = array();
	$where['state'] = 1;
    $Q = $this->db->get($this->tbl_curriculum,$where);
    if ($Q->num_rows() > 0)
	{
       	$data['-']='['.$this->lang->line('curr_name').']';
	   	foreach ($Q->result_array() as $row){
        	$data[$row['id_curriculum']] = $row['curr_name'];
    	}
    }
    $Q->free_result();  
    return $data; 
	}

}