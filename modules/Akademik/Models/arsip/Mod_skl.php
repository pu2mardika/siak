<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Mod_skl extends MY_Model
{
	private $tbl_skl	= 'tbl_skl';			// tabel kurikulum
	private $tbl_curriculum	= 'tbl_curriculum';			// tabel kurikulum
	
	//`id_skl`, `grade`, `subgrade`, `skl`, `state`, `id_curriculum`, `grade_name`
	
	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->tbl_skl	= $ci->config->item('db_table_prefix').$this->tbl_skl;
		$this->tbl_curriculum	= $ci->config->item('db_table_prefix').$this->tbl_curriculum;
		parent::set_table($this->tbl_skl,'id_skl');
	}
	
	function gets($attrib="*",$parm=array())
	{
		$this->db->select($attrib);
		$this->db->from($this->tbl_skl);
		$this->db->where($parm);
		$data = $this->db->get();
		return $data->row_array();
	}
	
	function get_all($parm=array())
	{
		$this->db->select('*');
		$this->db->from($this->tbl_skl);
		$this->db->where($parm);
		$data = $this->db->get();
		return $data->result_array();
	} 
 
	function get_all_skl()
	{
		$this->db->select('*');
		$this->db->from($this->tbl_skl);
		return $this->db->get();	
	}
	
	function get_skl_by_curr($ids)
	{
		$this->db->select('*');
		$this->db->from($this->tbl_skl);
		$this->db->where('id_curriculum',$ids);
		$this->db->where('state <',2);              //|-----> 0 = inactive, 1=active, 2=disable
		$this->db->order_by('id_skl','asc');
		return $this->db->get();	
	}
	
	function get_paging($limit,$offset)
	{		
		$this->db->select('*');
		$this->db->from($this->tbl_skl);
		$this->db->where('state <',2);              //|-----> 0 = inactive, 1=active, 2=disable
		$this->db->limit($limit,$offset);
		$this->db->order_by('id_skl','asc');
		return $this->db->get();
	}
		
	function view_trash($limit,$offset)
	{		
		$this->db->select('*');
		$this->db->from($this->tbl_skl);
		$this->db->where('state',2);              //|-----> 0 = inactive, 1=active, 2=disable
		$this->db->limit($limit,$offset);
		$this->db->order_by('id_skl','asc');
		return $this->db->get();
	}
	
	function get_skl_by_id($id_skl)
	{
		$this->db->select('a.*, id_skl, curr_id, id_prodi, skl, state');
		$this->db->from($this->tbl_skl);
		$this->db->join('(select id_curriculum, curr_name from tbl_curriculum) a','a.id_curriculum=tbl_skl.id_curriculum','left');
		$this->db->where('id_skl',$id_skl);
		$Q= $this->db->get();
		return $Q->row_array();
	}
	
	//'id_skl', 'curr_name', 'skl', 'id_prodi'
	
	function update_skl($id,$data)
	{
		$this->db->where('id_skl',$id);
		return ($this->db->update($this->tbl_skl,$data))?TRUE:FALSE;
		//return TRUE;
	}
	
	function hapus_skl($id)
	{
		return ($this->db->delete($this->tbl_skl,array('id_skl'=>$id)))?TRUE:FALSE;
	}

	function add_skl($data)
	{
		return ($this->db->insert($this->tbl_skl,$data))?TRUE:FALSE;
	}

	function togle_state($id,$sts=0)
	{
		$data = array();
		if($sts==0){$data['state']=1;}else{$data['state']=0;}
		$this->db->where('id_skl',$id);
		$this->db->update($this->tbl_skl,$data);
	}
	
	function disable_skl($id)
	{
		$data = array('state' => 2);//------------------> 0 = inactive, 1=active, 2=disable
		$this->db->where('id_skl',$id);
		$this->db->update($this->tbl_skl,$data);
	}
	
	//'id_skl', 'curr_name', 'skl', 'id_prodi'
	
	function get_skl_dropdown($param=array()){
	    $data = array();
	    $this->db->select('*');
		$this->db->from($this->tbl_skl);
		$this->db->where('state',2);
		$this->db->where($param);
	    $Q = $this->db->get();
	    if ($Q->num_rows() > 0)
		{
	       	$data['-']='['.$this->lang->line('curr_name').']';
		   	foreach ($Q->result_array() as $row){
	        	$data[$row['id_skl']] = $row['curr_name'];
	    	}
	    }
	    $Q->free_result();  
	    return $data; 
	}
	
	function active_skl_dropdown(){
    $data = array();
	$where = array('state' => 1);
    $Q = $this->db->get($this->tbl_skl,$where);
    if ($Q->num_rows() > 0)
	{
       	$data['-']='['.$this->lang->line('curr_name').']';
	   	foreach ($Q->result_array() as $row){
        	$data[$row['id_skl']] = $row['curr_name'];
    	}
    }
    $Q->free_result();  
    return $data; 
	}
	
	function skl_DD($param = array(),$ky="id_skl", $vl="grade_name")
	{
		$Q=$this->get_all($param);
		$R=array();
		if (count($Q) > 0)
		{
		   	foreach ($Q as $row){
	        	$R[$row[$ky]] = $row[$vl];
	    	}
	    }
		return $R;
	}
	
	
	function is_skl_id_exists($id)
	{
		$this->db->from($this->tbl_skl);
		$this->db->where('id_skl',$id);
		$num = $this->db->count_all_results();
		if($num == 0)
		{
			return FALSE;
		}else{
			return TRUE;
		}
	}

}