<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Mod_ketuntasan extends CI_Model
{
	private $tbl_ketercapaian	= 'tbl_ketercapaian';			//
	
	//`nilai`, `ketercapaian`, `id_curriculum`
	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->tbl_ketercapaian	= $ci->config->item('db_table_prefix').$this->tbl_ketercapaian;
		$this->pk="nilai";
	}
		
	function gets($key=array(), $all=TRUE)
	{
		$this->db->select('*');
		$this->db->from($this->tbl_ketercapaian);
		$this->db->where($key);
		$Q=$this->db->get();
		$R=array();
		if($Q->num_rows()>0)
		{
			$R = ($all)?$Q->result_array():$Q->row_array();
		}
		$Q->free_result();
		return $R ;		
	}
	
	function getDD($key=NULL,$gf="nilai", $v="ketercapaian")
	{
		$dt=$this->gets($key);
		$R=array();
		if(count($dt)>0)
		{
			foreach($dt as $rs)
			{
				$R[$rs[$gf]]=$rs[$v];
			}
		}
		return $R;
	}
	
	function add($data,$key)
	{
		if(is_array($key))
		{
			foreach($key as $v)
			{
				$validasi[$v]=$data[$v];
			}
		}else{
			$validasi[$key]=$data[$key];
		}
		if($this->not_exist($validasi)){
			if($this->db->insert($this->tbl_ketercapaian,$data)){
				return true;
			}else{
				$this->update($data,$validasi);
			}
		}
	}
	
	/**
	* update grup account
	* @param undefined $id
	* @param undefined $data
	* 
	* @return
	*/
	function update($data, $param)
	{
		$ky=$this->pk;
		$valid=(is_array($param))?$param:array($ky=>$param);
		
		$this->db->where($valid);
		if($this->db->update($this->tbl_ketercapaian,$data)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function ddown($key=NULL)
	{
		$Q=$this->get_all($key);
		$R=array();
		if($Q->num_rows()>0)
		{
			foreach($Q->result_array()as $v)
			{
				$R[$v[$this->pk]]=$v['ketercapaian'];
			}
		}
		$Q->free_result();
		return $R ;
	}
	
	function not_exist($keys)
	{
		$this->db->select('*');
		$this->db->from($this->tbl_ketercapaian);
		$this->db->where($keys);
		$data = $this->db->get();
		$R=$data->num_rows();
		return ($R > 0)?FALSE:TRUE;
	}

}