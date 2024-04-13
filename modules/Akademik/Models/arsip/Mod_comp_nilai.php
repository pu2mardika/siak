<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Mod_comp_nilai extends CI_Model
{
	private $tbl_comp_nilai	= 'tbl_comp_nilai';			// tabel kurikulum
	private $tbl_curriculum	= 'tbl_curriculum';			// tabel kurikulum
	
	//SELECT 'id_comp', 'id_kurikulum', 'nama_komponen', 'deskripsi', 'no_urut' FROM 'tbl_comp_nilai'
	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->tbl_comp_nilai	= $ci->config->item('db_table_prefix').$this->tbl_comp_nilai;
		$this->tbl_curriculum	= $ci->config->item('db_table_prefix').$this->tbl_curriculum;
	}
	
	function gets($attrib="*",$parm=array())
	{
		$this->db->select($attrib);
		$this->db->from($this->tbl_comp_nilai);
		$this->db->where($parm);
		$data = $this->db->get();
		return $data->row_array();
	}
	
	function get_all($parm=array())
	{
		$this->db->select('*');
		$this->db->from($this->tbl_comp_nilai);
		$this->db->where($parm);
		$data = $this->db->get();
		return $data->result_array();
	} 
 		
	function get_paging($limit,$offset)
	{		
		$this->db->select('*');
		$this->db->from($this->tbl_comp_nilai);      //|-----> 0 = inactive, 1=active, 2=disable
		$this->db->limit($limit,$offset);
		$this->db->order_by('id_comp','asc');
		return $this->db->get();
	}

	//'id_comp', 'curr_name', 'skl', 'id_prodi'
	function save($data,$key)
	{
		$validasi[$key]=$data[$key];
		if($this->not_exist($validasi)){
			$this->add($data);
		}else{
			$this->update($data,$key);
		}
	}
	
	function update($id,$data)
	{
		$this->db->where('id_comp',$id);
		return ($this->db->update($this->tbl_comp_nilai,$data))?TRUE:FALSE;
		//return TRUE;
	}
	
	function hapus($id)
	{
		return ($this->db->delete($this->tbl_comp_nilai,array('id_comp'=>$id)))?TRUE:FALSE;
	}

	function add($data)
	{
		return ($this->db->insert($this->tbl_comp_nilai,$data))?TRUE:FALSE;
	}

	function is_id_exists($id)
	{
		$this->db->from($this->tbl_comp_nilai);
		$this->db->where('id_comp',$id);
		$num = $this->db->count_all_results();
		if($num == 0)
		{
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function comp_ddown($param=array(),$r=FALSE){
	   	if($r){
			$k='nama_komponen';
			$v='id_comp';
		}else{
			$v='nama_komponen';
			$k='id_comp';
		}
		
	    $dt=$this->get_all($param);
	    if (count($dt) > 0)
		{
		   	foreach ($dt as $row){
	        	$data[$row[$k]] = $row[$v];
	    	}
	    }
	    return $data; 
	}
	
	function not_exist($keys)
	{
		$this->db->select('*');
		$this->db->from($this->tbl_comp_nilai);
		$this->db->where($keys);
		$data = $this->db->get();
		$R=$data->num_rows();
		return ($R > 0)?FALSE:TRUE;
	}
}