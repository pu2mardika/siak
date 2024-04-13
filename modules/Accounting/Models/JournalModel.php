<?php

namespace Modules\Account\Models;

use CodeIgniter\Model;

class JournalModel extends Model
{
    protected $table            = 'jurnal';
    protected $primaryKey       = 'trx_id';
    protected $useAutoIncrement = true;
    protected $returnType       = \Modules\Account\Entities\Journal::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    protected $tabel2 	= 'jurnal_detail';
    
    
    public function setJurnal($induk, $detail){
		//$this->db->transException(true);
		//INDUK : `trx_id`, `tanggal`, `deskripsi`, `no_bukti`, `amount`
		$idTrx = $this->idTrx($induk['tanggal']);
		$induk['trx_id']= $idTrx;	
		
		try {
	    	$this->db->transException(true)->transStart();
			$save_induk = $this->db->table($this->table)->insert($induk);
			if ($save_induk)
			{
				foreach($detail as $x => $gl)
				{
					$gl['trx_id']=$idTrx;
					$state = $this->db->table('jurnal_detail')->insert($gl);
					//show_result($state);
				}
			}
			$this->db->transComplete();
			return $idTrx;
		} catch (DatabaseException $e) {
		    return false;
		}
    }
    
    public function getDropdown($where)
    {
    	$data = $this->getDetailGl($where);
    	$dd=[];
    	foreach($data as $val)
    	{
    		$dd[$val['kode_akun']][]=$val;
    	}
    	return $dd;
    }
    
    public function getDetailGl($where)
    {
    	$builder = $this->db->table('jurnal_detail a');
		$builder->select('b.tanggal, b.no_bukti, a.*, b.deskripsi, c.nama_akun')->join('jurnal b', 'b.trx_id = a.trx_id')
				->join('akun_bb c', 'c.kode_akun = a.kode_akun');
		$builder->where($where);
		$builder->orderBy('b.tanggal', 'ASC');
		$builder->orderBy('a.indek', 'ASC');
		$query = $builder->get()->getResultArray();
		return $query;
    }
    
    public function idTrx($tgl)
    {
    	helper(['text','app']);
    	$tg=preg_split("/(\/|-)/i",$tgl);
		$d = $tg[0]; 
		$m = $tg[1];
		$y = $tg[2];
		
		$tstgl = ind_to_unix($tgl);
		$nomor=date("z",$tstgl);
		$no=sprintf("%'.03d",$nomor);
		
		if(strlen($tg[0])===4){
			$d = $tg[2]; $y = $tg[0];
		}
		$t=$y-2000;
		return strtoupper(trim($t.$no.date('his').random_string('alpha',2).random_string('nozero',2))); //15 digit
    }
    
}
