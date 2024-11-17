<?php

namespace Modules\Raport\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Modules\Tp\Models\TpModel;
use Modules\Room\Models\RombelModel;
use Modules\Assessment\Models\NilaiModel;
use Modules\Raport\Models\CertModel;
use Config\Services;
use Config\MyApp;

class Cert extends BaseController
{
    public  $keys='';
	protected $dconfig;
	protected $tendikModel;
	protected $TpModel;
	protected $form;
	protected $footpdf;
	protected $RaporID;

	protected $LHB = 2;
	protected $MHB = 3;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Raport\Config\StsbConf::class);
        $this->session = \Config\Services::session();
		$this->model = new CertModel;	
        $this->nilaiModel= model(\Modules\Assessment\Models\NilaiModel::class); 	
        $this->TpModel   = model(\Modules\Tp\Models\TpModel::class); 
		$this->currModel = model(\Modules\Akademik\Models\KurikulumModel::class); 	
		$this->tendikModel = model(\Modules\Tendik\Models\TendikModel::class); 	
		$this->data['site_title'] = 'RAPORT';
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi']['curr_id'] = $this->currModel->Dropdown("b.jns_lhb='".$this->LHB."' OR b.jns_lhb='".$this->MHB."'");
		$this->data['opsi']['walikelas'] 	= $this->tendikModel->getDropdown();
		$this->data['allowimport']= $this->dconfig->importallowed;
		$this->addJs (base_url().'/js/jquery.easy-autocomplete.min.js?r=' . time());
		$this->addJs (base_url().'/js/modules/raport.js?r=' . time());
		//PERBAHARUI BREADCRUMB
		helper(['cookie', 'form','date']);
    }

    public function index()
    {
        $this->cekHakAkses('read_data');
		 
		//echo $this->theme;die();	
		if (isset($_GET['tp'])) 
		{
			$ctp = $_GET['tp'];
			$tp = $this->TpModel->find($ctp);
		}else{
			$tp = $this->TpModel->getcurTP();
			//test_result($tp);
			$ctp = $tp->thid;
		}
		
		$data=$this->data;	
		$addTitle = "TP ".$tp->deskripsi;
		$parm=['a.kode_ta'=>$ctp];
		
		//$rsdata = $this->model->getAll(['a.kode_ta'=>$ctp]);
		$rsdata = $this->model->where('kode_ta', $ctp)->findAll();

		$data['title']	= "MANAJEMEN STSB/SERTIFIKAT ".$addTitle;
		$data['rsdata']	= $rsdata;
		$data['isplainText'] = true;
		$data['dtparm']	= ['kode_ta'=>$ctp];
		$data['msg'] 	= "";
		$data['subtitle'] = "Sub Grade-";
		$dtfilter	= $this->dconfig->dtfilter;
		$tp = $this->TpModel->getcurTP();
		$dtfilter['cVal'] = $ctp;
		$TaPel = $this->TpModel->getDropdown();
		unset($TaPel['']);
		unset($TaPel[$ctp]);
		$data['TaPel'] 	= $TaPel;
		$data['dtfilter'] 	= $dtfilter;
		$data['panelAct']['add']= base_url().'cert/add/'.encrypt($ctp);
		$data['actions']= $this->dconfig->actions;
		$data['incUpActions']=['room'];
		echo view($this->theme.'datalist',$data); 
    }

	function addView($ids=0)
	{
		$this->cekHakAkses('create_data');
		$data	=$this->data;
	
		if ($ids == 0) 
		{
			$tp = $this->TpModel->getcurTP();
			$ctp = $tp->thid;
		}else{
			$id = decrypt($ids);
			$id = explode($data['strdelimeter'],$id);
			$ctp = $id[0];
			$tp = $this->TpModel->find($ctp);
		}
	//	$currModel  = model(\Modules\Akademik\Models\KurikulumModel::class); 
		$data['title']	= "Tambah Data Rapor";
		$data['hidden']	= ['kode_ta'=>encrypt($ctp)];
		$data['error']  = [];
		$data['fields'] = $this->dconfig->Addfields;
		
		$data['rsdata'] = [];
		echo view($this->theme.'form',$data);
	}

	
	function addAction(): RedirectResponse
	{
		$this->cekHakAkses('create_data');
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$tp = decrypt($data['kode_ta']);
			$data['kode_ta']=$tp;
			$data['id']=date("Ymd");
			$edata= new \Modules\Raport\Entities\Cert();
			$edata->fill($data);
			$simpan = $this->model->insert($edata,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('cert?tp='.$tp));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$id = decrypt($ids); 
		$data=$this->data;
		
		$rs =  $this->model->find($id)->toarray();
		$data['hidden']	= ['kode_ta'=>encrypt($rs['kode_ta'])];
		$data['error']  = [];
		$data['fields'] = $this->dconfig->Addfields;
	//	$data['opsi'] 	= $this->dconfig->opsi;
	//	$data['opsi']['curr_id'] = $currModel->getDropdown();
		$data['rsdata'] = $rs;
		echo view($this->theme.'form',$data);
	}

	function editAction($ids): RedirectResponse
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roles;
		
		if ($this->validate($roles)) {
			
			//$this->model->update($id, $data);
			$data = $this->request->getPost();
			$tp = decrypt($data['kode_ta']);
			$data['kode_ta']=$tp;
			
			$rsdata= new \Modules\Raport\Entities\Cert();
			$rsdata->fill($data);
			$simpan = $this->model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil diperbaharui');
			}else{
				$this->session->setFlashdata('warning','Data gagal diperbaharui');
			}
			
			return redirect()->to(base_url('cert?tp='.$tp));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function delete($ids){
		$id = decrypt($ids); 
		$rs =  $this->model->find($id)->toarray();
		$this->model->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('cert?tp='.$rs['kode_ta']));
	}

	function shwDetail()
	{
		$this->cekHakAkses('read_data');
		if (isset($_GET['ids'])) 
		{
			$ids= $_GET['ids'];
			$id = decrypt($ids);
		}else{
			$this->session->setFlashdata('warning','Data gagal ditampilkan');
			return redirect()->to(base_url('cert'));
		}
		
		$data=$this->data;
		$rs =  $this->model->find($id)->toarray();
		$sertif=$rs;
		$sertif['kode'] = $rs['id'];
		$sertif['issued'] = format_date($rs['issued']);
		$sertif['exam'] = format_date($rs['exam']);
		//menampilkan data sertifikat
		$data['resume']['field'] = $this->dconfig->ResumeFields;
		$data['resume']['data']  = $sertif;
		$data['resume']['subtitle'] = "SERTIFIKAT";//.$addTitle;
		//MENU DROPDOWN	
		$mainAct = $this->dconfig->condAddOnACt;	
		$data['addOnACt'] = $mainAct[1];
		$data['dataStated'] = 1;

		//AMBIL DATA KURIKULUM MEMILIKI PROJEK ATAU TIDAK
		
		$ActDet = $this->dconfig->condDetActions; 
		$STATE = 0;
		
		//AMBIL DATA MEMBER
		$memberModel 	  = model(\Modules\Raport\Models\DataCertModel::class);
		$dtmember 		  = $memberModel->getAllArr(['a.certId'=>$id]);	
		$data['rsdata']	  = $dtmember;
		$data['fields']   = $this->dconfig->fields3;
		$data['isplainText'] = false;
		$data['keys'] 	  = $this->dconfig->primarykey;
		$data['opsi']     = setting()->get('Siswa.opsi');
		$data['addOnActDet']= $ActDet[0];
		echo view($this->theme.'frmdatalist',$data);

	}

	/**
	 * menambah data asesi ke sertifikat
	 */

	function dataAsessi($ids=null)
	{
		$this->cekHakAkses('create_data');
		
		if(is_null($ids))
		{
			$this->session->setFlashdata('warning','Data gagal ditampilkan');
			return redirect()->to(base_url('nilai'));
		}
		$IDS = decrypt($ids);
		$ID = (is_hex($IDS))?decrypt($IDS):$IDS;
	//	test_result($ID);
		$data = $this->data;
		$data['title']	= "Tambah Data Asesi";
		$fields = $this->dconfig->fields4;
		$data['error'] = [];
		$data['hidden']	= ['certId'=>encrypt($ID)];
		$data['fields'] = $fields;
		$data['opsi']['roomid'] = $this->_roomDD();
		$data['rsdata'] = [];//['kode_ta'=>$ctp];
		$data['addONJs'] = "raport.add();";
		$data['rtarget']	= "#skl-content";
		echo view($this->theme.'ajxform',$data);
	//	echo view($this->theme.'form',$data);
	}

	function shwMembers($ids)
	{
		$id = (is_hex($ids))?decrypt($ids):$ids;
		$DATA = $this->data;

		$RoomModel = model(\Modules\Raport\Models\DataCertModel::class);
		//AMBIL ANGGOTA ROMBEL YANG roomId nya belum terdaftar pada sertifikat
		$partisipan = $RoomModel->getDataMember($id);
	//	test_result($partisipan);

		//menampilkan data siswa dalam cek box
		$data['resData'] = $partisipan;
		$data['keys'] 	 = 'noinduk';
		$data['fields']   = $this->dconfig->srcFields;
		$data['has_ref'] = ['learn_metode'];
		$data['opsi']    = setting()->get('Rombel.opsi');
		$data['inputype'] = $DATA['inputype'];
		echo view($this->theme.'cells/tablecheck',$data);
	}
	
	function NewPartAction() //: RedirectResponse
	{
		$this->cekHakAkses('create_data');
		$rules = $this->dconfig->ndroles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$dt['certId']=decrypt($data['certId']);
		//	test_result($data);
			//menyiapkan data member dari pd yang terpilih:
			$induk = $data['pd'];
			
			$rowD=[]; $no=1;
			foreach($induk as $key =>$val){
				$no++;
				$dt['id']	=substr($dt['certId'],0,2).$val.sprintf("%03d",$no).random_string('numeric',1);
				$dt['memberId']=$val;
				$dt['no_urut']=$no;
				$rowD[]=$dt;
			}

			$memberModel = new \Modules\Raport\Models\DataCertModel();
						
			$simpan = $memberModel->simpanMasal($rowD);
			if($simpan){
				$this->session->setFlashdata('sukses', $simpan.' Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('rombel'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function shwReport()
	{
		$this->cekHakAkses('read_data');
		$data=$this->data;		
		if (isset($_GET['ids'])) 
		{
			$ids= $_GET['ids'];
			$id = decrypt($ids);
		}else{
			$this->session->setFlashdata('warning','Data gagal ditampilkan');
			return redirect()->to(base_url('cert'));
		}
		$opsi = $this->dconfig->opsi;
		$dtReport = $this->_dtreport($id);
		$dtReport['glevel'] = $opsi['grade'];

		$ACTION = ucwords(strtolower($dtReport['PD']['action_class']));

		$this->RaporID = $dtReport['PD']['id'];
		$this->footpdf = $dtReport['siswa']['noinduk']." | ".$dtReport['PD']['nik'];
		$html =view_cell('\Raport\Controllers\\'.$ACTION.'::showRaport', $dtReport);
	
		//echo $html; die();
		$fname = $dtReport['PD']['action_class']."_".$this->RaporID.".pdf";
		$hsl = $this->makePdf($html, $fname, FALSE);
		
        $Data=$this->data;
	//	$Data['addOnAct'] = $this->dconfig->AddOnAct2;
        $Data['file_pdf'] = $hsl;
        $Data['ids'] = $ids;
        echo view($this->theme.'viewfile',$Data);
	}

	private function _dtreport($id)
	{
		//ambil data PD 
	//	test_result($id);
		$RESULT = []; $sgrade=1;
		$memberModel = model(\Modules\Raport\Models\DataCertModel::class);
		$PD = $memberModel->gets(['a.id'=>$id]);
	//	test_result($PD);
		$siswaModel = model(\Modules\Siswa\Models\SiswaModel::class);
		$Siswa = $siswaModel->get($PD['noinduk']);
		unset($Siswa['created_at']);
		unset($Siswa['updated_at']);
		unset($Siswa['deleted_at']);

		//KURIKULUM
		$KUR = $this->currModel->find($PD['curr_id'])->toarray();
		unset($KUR['curr_desc']);
		unset($KUR['created_at']);
		unset($KUR['updated_at']);
		unset($KUR['deleted_at']);
	
		//PRODI
		$ProdiModel = model(\Modules\Akademik\Models\ProdiModel::class);
		$PS = $ProdiModel->gets(['a.id_prodi'=>$PD['id_prodi']]);
	
		//LEGELITY 
		$legality = $this->myconfig->legality($PS[0]['unit_kerja']);
		//SKL
		$NilaiModel = model(\Modules\Assessment\Models\NilaiModel::class);
		$Nilai = $NilaiModel->getsNilai(['a.member_id'=>$PD['memberId']]);
		//kelompokkan nilai berdasarkan mapelID
		$NILAI =[];
		foreach($Nilai as $N)
		{
			$NILAI[$N['id_mapel']][$N['rating_id']][$N['idx']]=$N['nilai'];
		}

		//MAPEL
		$mapelModel = model(\Modules\Akademik\Models\MapelModel::class);
		$mapel = $mapelModel->getsMapel(['c.grade'=>$PD['grade'], 'c.subgrade'=>$sgrade, 'c.currId'=>$PD['curr_id']]);
		
		//KKM dari PTM
		$ptmModel = model(\Modules\Kbm\Models\PtmModel::class);
		$ptm = $ptmModel->where(['roomid'=>$PD['roomid'],'subgrade'=>$sgrade])->asarray()->findAll();
		foreach($ptm as $tm)
		{
			$kkm[$tm['id_mapel']]=$tm['kkm'];
		}
		//ATP jika Kurikulum memiliki descripsi
		$ratingModel = model(\Modules\Akademik\Models\RatingModel::class);
		$compNIlai = $ratingModel->asarray()->where(['curr_id'=>$PD['curr_id'], 'type_nilai'=>'NR'])->findAll();
		foreach($compNIlai as $CN)
		{
			$Rating[$CN['id']]=$CN;
		}

		$useATP = $ratingModel->where(['curr_id'=>$KUR['id'], 'has_descript'=>1])->findAll();
		$ATP = [];
		if($useATP){
			$atpModel = model(\Modules\Assessment\Models\ModelAtp::class);
			$OpsiATP = setting()->get('AtpConfig.opsi');
			$AP = $OpsiATP['aspek'];
			$atps = $atpModel->getAtp(['b.roomid'=>decrypt($Room['id']), 'b.subgrade'=>$sgrade]);
			foreach($atps as $A)
			{
				$ATP[$A['id_mapel']][$A['rating_id']][$A['idx']]=['desc'=>$A['atp'], 'aspek'=>$AP[$A['aspek']]];
			}
		}

		$dtRapor = $this->model->find($PD['certId'])->toarray();//$this->model->gets(['a.id'=>$PD['id']]);
		unset($dtRapor['created_at']);
		unset($dtRapor['updated_at']);
		unset($dtRapor['deleted_at']);
		$dtRapor['tmpview'] = $this->dconfig->viewtmp($dtRapor['jenis']);

		$RESULT['PS'] = $PS[0];
		$RESULT['legality'] = $legality;
	//	$RESULT['rombel'] = $Room;
		$RESULT['PD'] = $PD;
		$RESULT['siswa'] = $Siswa;
	//	$RESULT['GrupMapel'] = $grupMapel;
		$RESULT['Mapel'] = $mapel;
		$RESULT['NILAI'] = $NILAI;
		$RESULT['KKM'] = $kkm;
		$RESULT['Rating'] = $Rating;
		$RESULT['ATP'] = $ATP;
		$RESULT['dtRaport'] = $dtRapor;

		return $RESULT;
	}

	private function makePdf($html, $fname, $usefooter=TRUE)
	{
		$options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', TRUE);
        $options->set('enable_remote', TRUE);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper("A4", "landscape");
        $dompdf->render();
                  
	//	$fname 	 	 = 'RAPORT.pdf';
		$dirf 		 = setting()->get('MyApp.pdftmpDir');
		$path 		 = setting()->get('MyApp.pdfPath_Dir');
		$companyName = setting()->get('MyApp.companyName');
		//$footer 	 = setting()->get('MyApp.appName')." ".setting()->get('MyApp.appVerison');
		$footer		 = $this->footpdf;

		if($usefooter)
		{
			$canvas = $dompdf->get_canvas();
			$fontmatrik = new \Dompdf\FontMetrics($canvas, $options);
			$font = $fontmatrik->get_font("helvetica", "10");
			$txtHeight = $fontmatrik->get_font_height($font, 8);  
			$w = $canvas->get_width();
			$h = $canvas->get_height();
			$y = $h - 2 * $txtHeight - 30;
			
			$color = array(0, 0, 0);
			//$text = $footer." | Generated on: ".date("d-m-Y H:i");
			$text = $this->RaporID;
			$canvas->line(16, $y, $w - 16, $y, $color, 1);
							
			$canvas->page_text(17, $y+3, $footer, $font, 11, array(0,0,0));
			$canvas->page_text($w-100, $y+3, $text, $font, 10, array(0,0,0));   
		}
		$hsl= $dompdf->output();
		file_put_contents($path.$fname, $hsl);
		return base_url($dirf.$fname);
	}

	private function _roomDD()
	{
		$param = "AND (c.jns_lhb = ".$this->LHB." OR c.jns_lhb = ".$this->MHB.")";
		$rsData = $this->model->getRombel($param);
		
		$dd[""]="[--PILIH ROMBEL--]";
    	foreach($rsData as $val)
    	{
    		$dd[encrypt($val->id)]=$val->nama_rombel;
    	}
    	return $dd;
	}

}
