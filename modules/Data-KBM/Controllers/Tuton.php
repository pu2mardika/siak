<?php

namespace Modules\Kbm\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Modules\Tp\Models\TpModel;
use Modules\Kbm\Models\PtmModel;
use Modules\Kbm\Models\TutonModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;

class Tuton extends BaseController
{
    public  $keys='';
	protected $dconfig;
	protected $tendikModel;
	protected $TpModel;
	protected $form;
    protected $symbol = ['*','$','#','!','@'];
    public $TUTON = 1;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Kbm\Config\Ptm::class);
        $this->session = \Config\Services::session();
		$this->model = new PtmModel;	
        $this->TpModel  = model(\Modules\Tp\Models\TpModel::class); 	
		$this->rombelModel = model(\Modules\Room\Models\RombelModel::class); 	
		$this->currModel  = model(\Modules\Akademik\Models\KurikulumModel::class); 	
		$this->data['site_title'] = 'Manajemen Data Rombel';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
		
		helper(['cookie', 'form','date','file','download']);
    }

    public function getPD()
    {
        if (isset($_GET['tp']) && isset($_GET['sg'])) 
		{
			$ctp = is_hex($_GET['tp'])?decrypt($_GET['tp']):-1;
			$tp = $this->TpModel->find($ctp);
            $sg = is_hex($_GET['sg'])?decrypt($_GET['sg']):-1;
		}else{
			$this->session->setFlashdata('warning','Data gagal dibuat');
			return redirect()->to(base_url('ptm'));
		}
		
		if($sg == -1 || $tp == -1)
		{
		    $this->session->setFlashdata('warning','Akses Ditolak');
			return redirect()->to(base_url('ptm'));
		}

        //ambil data data roomember sesuai tp yang ditetapkan
		$tutonModel = model(\Modules\Kbm\Models\TutonModel::class);
		$PD = $tutonModel->getParticipan(['a.learn_metode'=>1, 'd.kode_ta'=>$ctp]);
		
		//ambil data pembagian tugas sesuai tp dan sbgrade
		$mp = $tutonModel->getMapel(['d.kode_ta'=>$ctp, 'a.subgrade'=>$sg]);
		//kelompokkan mapel berdasarkan rombelID
		$dtMP =[];
		foreach($mp as $MP)
		{
		    $dtMP[$MP['roomid']][]=$MP['id_mapel'];
		}
		 
		//pengulangan membuat baris data
		$prefix=$this->symbol;
		$header = ['username','password','email','firstname','lastname'];
		$result=[];
	    $ncourse = 0; 
		foreach($PD as $pd)
		{
		    $lst = substr($pd['noinduk'],9,1);
		    $x = $lst % 5;
		    $px = $prefix[$x];
		    $row['username']=$pd['noinduk'];
		    $row['password']=ucfirst(strtolower($pd['idreg'].$px));
		    
		    $email = (is_null($pd['email']))?strtolower($pd['id']).'@mbc.sch.id':$pd['email'];
		    $row['email'] = $email;
		    $row['firstname']=preg_replace("/[^a-zA-Z0-9_ -]/", "",$pd['nama']);
		    $row['lastname']="NIPD: ".$pd['noinduk'];
		    
		    $MPX = (array_key_exists($pd['roomid'],$dtMP))?$dtMP[$pd['roomid']]:[];
		    $nmp = count($MPX);
		    $ncourse = ($nmp > $ncourse)?$nmp:$ncourse;
		    foreach($MPX as $key => $mapel)
		    {
		        $cfield = "course".$key+1;
		        if(!in_array($cfield,$header))
		        {
		            $header[]=$cfield;
		        }
		        $row[$cfield]=$mapel;
		    }
		    $result[]=$row;
		}
		
		//menyesuaikan jumlah data dengan header
		$RESULT=[];
		foreach($result as $rs)
		{
		    $nrd=[];
		    foreach($header as $hf)
		    {
		        $nrd[$hf] = (array_key_exists($hf, $rs))?$rs[$hf]:"";
		    }
		    $RESULT[]=$nrd;
		}
		
		$delimiter = ",";
        $newline = "\r\n";
        $file_name = 'DT_TUTON_PD'.date("Y-m-d h-i-s").'.csv';
		$data=getCSVArray(['header'=>$header, 'dtrow'=>$RESULT],$delimiter, $newline);
		return $this->response->download($file_name, $data);
    }
    
    public function getTutor()
    {
        if (isset($_GET['tp']) && isset($_GET['sg'])) 
		{
			$ctp = is_hex($_GET['tp'])?decrypt($_GET['tp']):-1;
			$tp = $this->TpModel->find($ctp);
            $sg = is_hex($_GET['sg'])?decrypt($_GET['sg']):-1;
		}else{
			$this->session->setFlashdata('warning','Data gagal dibuat');
			return redirect()->to(base_url('ptm'));
		}
		
		if($sg == -1 || $tp == -1)
		{
		    $this->session->setFlashdata('warning','Akses Ditolak');
			return redirect()->to(base_url('ptm'));
		}

        //ambil data data roomember sesuai tp yang ditetapkan
		$tutonModel = model(\Modules\Kbm\Models\TutonModel::class);
		
		//ambil data pembagian tugas sesuai tp dan sbgrade
		$mp = $tutonModel->getMapel(['d.kode_ta'=>$ctp, 'a.subgrade'=>$sg]);
		
		//kelompokkan mapel berdasarkan rombelID
		$dtMP =[];
		foreach($mp as $MP)
		{
	//	    $dtMP[$MP['roomid']][]=$MP['id_mapel'];
		    $dtPTK[$MP['ptk_id']]['username']=$MP['ptk_id'];
		    $dtPTK[$MP['ptk_id']]['password']="Mbc13154#";
		    $email = (is_null($MP['email']))?strtolower($MP['ptk_id']).'@mbc.sch.id':$MP['email'];
		    $dtPTK[$MP['ptk_id']]['email']= $email;
		    $dtPTK[$MP['ptk_id']]['firstname']=preg_replace("/[^a-zA-Z0-9_ -]/", "",$MP['nama']);
		    $dtPTK[$MP['ptk_id']]['lastname']="[Guru]";
		    $dtPTK[$MP['ptk_id']]['course'][]=$MP['id_mapel'];
		}
		
		//pengulangan membuat baris data
		$prefix=$this->symbol;
		$header = ['username','password','email','firstname','lastname'];
		$result=[];
	    $ncourse = 0; $i=1;
		foreach($dtPTK as $gr)
		{
		    $row = $gr;
		    unset($row['course']);
		    
		    $MPX = $gr['course'];
		    $nmp = count($MPX);
		    $ncourse = ($nmp > $ncourse)?$nmp:$ncourse;
		    foreach($MPX as $key => $mapel)
		    {
		        $cfield = "course".$key+1;
		        $typefield = "type".$key+1;
		        $rolefield = "role".$key+1;
		        if(!in_array($cfield,$header))
		        {
		            $header[]=$cfield;
		        }
		        if(!in_array($typefield,$header))
		        {
		            $header[]=$typefield;
		        }
		        if(!in_array($rolefield,$header))
		        {
		            $header[]=$rolefield;
		        }
		        $row[$cfield]=$mapel;
		        $row[$typefield]=2;
		        $row[$rolefield]='editingteacher';
		    }
		    $result[$i]=$row;
		    $i++;
		}
		
		//menyesuaikan jumlah data dengan header
		$RESULT=[];
		foreach($result as $rs)
		{
		    $nrd=[];
		    foreach($header as $hf)
		    {
		        $nrd[$hf] = (array_key_exists($hf, $rs))?$rs[$hf]:"";
		    }
		    $RESULT[]=$nrd;
		}
		$delimiter = ",";
        $newline = "\r\n";
        $file_name = 'DT_TUTON_GR'.date("Y-m-d h-i-s").'.csv';
		$data=getCSVArray(['header'=>$header, 'dtrow'=>$RESULT],$delimiter, $newline);
		return $this->response->download($file_name, $data);
    }
    
    public function getMapel()
    {
        if (isset($_GET['tp']) && isset($_GET['sg'])) 
		{
			$ctp = $_GET['tp'];
			$tp = $this->TpModel->find($ctp);
            $sg = $_GET['sg'];
		}else{
			$this->session->setFlashdata('warning','Data gagal dibuat');
			return redirect()->to(base_url('ptm'));
		}
		$this->cekHakAkses('create_data');
		$data = $this->data;
		$data['title']	= "Generate Data Mapel Elearning";
		$fields = ['categori' => ['label' => 'Categori ID','width'=>0,'extra'=>['id' => 'idcat','class' => '', 'required' => true],'type'=>'text'], ];
		$data['error'] = [];
		$data['fields'] = $fields;
	    $data['hidden']	= ['tp'=>$ctp, 'sg'=>$sg];
		$data['rsdata'] = [];//['kode_ta'=>$ctp];
		$data['addONJs'] = $this->dconfig->addonJS;
		$data['rtarget']	= "#skl-content";
		//echo view($this->theme.'ajxform',$data);
		echo view($this->theme.'form',$data);
	}
    
    public function getMapelAction()
    {
        $rules = [
            'categori'	=> ['label' => 'Kategori', 'rules' =>'required'],
    	];
		if ($this->validate($rules)) {
			$input = $this->request->getPost();
            //ambil data data roomember sesuai tp yang ditetapkan
    		$tutonModel = model(\Modules\Kbm\Models\TutonModel::class);
    		$ctp = decrypt($input['tp']);
    		$sg = decrypt($input['sg']);
    		show_result($input);
    		//ambil data pembagian tugas sesuai tp dan sbgrade
    		$mp = $tutonModel->getMapel(['d.kode_ta'=>$ctp, 'a.subgrade'=>$sg]);
    	
    		//kelompokkan mapel berdasarkan rombelID
    		$header = ['category','shortname','fullname'];
    		$dtMP =[];
    		foreach($mp as $MP)
    		{
    		    $ROW['category']= $input['categori'];
    		    $ROW['shortname']= $MP['id_mapel'];
    		    $ROW['fullname']= $MP['subject_name']."-".$MP['nama_rombel'];
    		    $dtMP[$MP['id_mapel']]=$ROW;
    		}
    		//test_result($dtMP);
    		//pengulangan membuat baris data
    		
    		
    		$delimiter = ",";
            $newline = "\r\n";
            $file_name = 'DT_TUTON_Mapel'.date("Y-m-d h-i-s").'.csv';
    		$data=getCSVArray(['header'=>$header, 'dtrow'=>$dtMP],$delimiter, $newline);
    		return $this->response->download($file_name, $data);
        }else{
            $this->session->setFlashdata('warning','Data gagal dibuat');
			return redirect()->to(base_url('ptm'));
        }
    }
    
    function cekDataTuton()
    {
        $tutonModel = model(\Modules\Kbm\Models\TutonModel::class);
        $TPModel = model(\Modules\Tp\Models\TpModel::class);
        
        $TP = $TPModel->getcurTP();
        
		$PD = $tutonModel->getParticipan(['a.learn_metode'=>1, 'd.kode_ta'=>$TP->thid]);
		echo json_encode($PD);
    }
    
}
