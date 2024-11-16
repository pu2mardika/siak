<?php

namespace Modules\Raport\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Modules\Tp\Models\TpModel;
use Modules\Room\Models\RombelModel;
use Modules\Assessment\Models\NilaiModel;
use Modules\Raport\Models\RaportModel;
use Config\Services;
use Config\MyApp;

class Raport extends BaseController
{
    public  $keys='';
	protected $dconfig;
	protected $tendikModel;
	protected $TpModel;
	protected $form;
	protected $footpdf;
	protected $RaporID;

	protected $LHB = 1;
	protected $MHB = 3;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Raport\Config\RaportConf::class);
        $this->session = \Config\Services::session();
		$this->model = new RaportModel;	
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
		//$rsdata = $this->model->where('kode_ta', $ctp)->findAll();
		$rsReport = $this->model->getAll(['a.kode_ta'=>$ctp]);

		$rsdata=[];
		foreach($rsReport as $v)
		{
			$id = $v['id'];
			$sg = $v['subgrade'];
		//	$rsdata[$sg][0]['gtitle']=' Sub Grade: '.$sg; tanpa grup title
			$detail = $v;
			$detail['issued'] = format_date($v['issued']);
			$rsdata[$sg][0]['detail'][]=$detail;
		}

		$data['title']	= "MANAJEMEN RAPORT ".$addTitle;
		$data['rsdata']	= $rsdata;
		$data['isplainText'] = True;
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
		$data['panelAct']= $this->dconfig->panelAct;
		$data['actions']= $this->dconfig->actions;
		$data['incUpActions']=['room'];
		
//	//	show_result($rsdata);
		echo view($this->theme.'acordiontable',$data);	
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
			$data['id']=$data['subgrade'];
			$edata= new \Modules\Raport\Entities\Raport();
			$edata->fill($data);
			$simpan = $this->model->insert($edata,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('rapor?tp='.$tp));
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
			
			$rsdata= new \Modules\Raport\Entities\Raport();
			$rsdata->fill($data);
			$simpan = $this->model->update($id, $rsdata);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil diperbaharui');
			}else{
				$this->session->setFlashdata('warning','Data gagal diperbaharui');
			}
			
			return redirect()->to(base_url('rapor?tp='.$tp));
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
		return redirect()->to(base_url('rapor?tp='.$rs['kode_ta']));
	}

	function showDataRoom($ids=0)
	{
		if($ids == 0)
		{
			$this->session->setFlashdata('warning','Akses data tidak sah!!');
			return redirect()->to(base_url('rapor'));
		}
		$data = $this->data;
		$idg = decrypt($ids); 
		$id = explode($data['strdelimeter'],$idg); //id[0]=raport_id; id[1]=subgrade
		$rs =  $this->model->find($id[0])->toarray();

		//ambil data rombel berdasarkan kode_ta dan CURR_ID
		$parm = ['kode_ta'=>$rs['kode_ta'], 'curr_id'=>$rs['curr_id']];
		$RoomModel = model(\Modules\Room\Models\RombelModel::class);
		
		//$rsData = $RoomModel->getAll($parm);
		$rsData = $RoomModel->where($parm)->findAll();
//		test_result($rsData);
		
		$data['title']		 = "DAFTAR ROMBEL";
		$data['rsdata']		 = $rsData;
     //   $data['isplainText'] = TRUE;
		$data['fields']		 = $this->dconfig->fields2;
		$data['allowADD']	 = FALSE;
		$actions = $this->dconfig->AddOnACt;
		$actions['show']['src']='rapor/shwpd?sg='.encrypt($id[1]).'&ids=';
		$data['actions']	 = $actions;
		echo view($this->theme.'datalist',$data);
	}
	
	function shwRoomMember()
	{
		$this->cekHakAkses('read_data');
		$data=$this->data;		
		if (isset($_GET['ids'])) 
		{
			$ids= $_GET['ids'];
			$id = decrypt($ids);
		}else{
			$this->session->setFlashdata('warning','Data gagal ditampilkan');
			return redirect()->to(base_url('rapor'));
		}

		if (isset($_GET['sg'])) 
		{
			$sg= $_GET['sg'];
			$sgrade = decrypt($sg);
		}else{
			$this->session->setFlashdata('warning','Data gagal ditampilkan');
			return redirect()->to(base_url('rapor'));
		}
				
		//AMbil detail Rombel
		$RoomModel = model(\Modules\Room\Models\RombelModel::class);
		$KUR = $data['opsi']['curr_id'];
		$LM = setting()->get('Rombel.opsi');
		$R = $RoomModel->getAll(['id'=>$id]);
		
		$room = (array) $R[0];
		$addTitle = $room['nama_rombel'];
		$currID = $room['curr_id'];
		$room['curr_id']=$KUR[$currID];
		$room['subgrade'] = $sgrade;
		$room['learn_metode']=$LM['learn_metode'][$room['learn_metode']];
		$roomID = decrypt($room['id']);
		
		//RESUME DATA
		$data['resume']['field'] = $this->dconfig->ResumeFields;
		$data['resume']['data']  = $room;
		$data['resume']['subtitle'] = "DATA RAPOR";//.$addTitle;
		//MENU DROPDOWN		
		$data['condAddOnAct'] = $this->dconfig->condAddOnACt;
		$data['dataStated'] = 1;

		//AMBIL DATA KURIKULUM MEMILIKI PROJEK ATAU TIDAK
		$KUR = $this->currModel->find($currID);
		$detAction = $this->dconfig->condDetActions; 
		$STATE = 0;
		if($KUR->has_project==1)
		{
			$STATE = 1;
		}
		
		//Modifikasi variabel uri
		foreach($detAction[$STATE] as $k =>$A)
		{
			//rapor/vrept?ids=
			$src = $A['src'];
			$A['src']=$src.'sg='.$sg.'&ids=';
			$ActDet[$k]=$A;
		}

		//AMBIL DATA MEMBER
		$memberModel = model(\Modules\Room\Models\MemberModel::class);
		$dtmember 		  = $memberModel->getAll(['a.roomid'=>$id]);
		$data['rsdata']	  = $dtmember;
		$data['fields']   = $this->dconfig->fields3;
		$data['isplainText'] = false;
		$data['keys'] 	  = $this->dconfig->primarykey;
		$data['opsi']     = setting()->get('Siswa.opsi');
		$data['addOnActDet']= $ActDet;
		echo view($this->theme.'frmdatalist',$data);
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
			return redirect()->to(base_url('rapor'));
		}

		if (isset($_GET['sg'])) 
		{
			$sg= $_GET['sg'];
			$sgrade = decrypt($sg);
		}else{
			$this->session->setFlashdata('warning','Data gagal ditampilkan');
			return redirect()->to(base_url('rapor'));
		}
		
		$dtReport = $this->_dtreport($id, $sgrade);
		
		$ACTION = ucwords(strtolower($dtReport['kurikulum']['action_class']));

		$this->RaporID = $dtReport['PD']['id'];
		$this->footpdf = $dtReport['siswa']['noinduk']." | ".$dtReport['siswa']['nama'];
		$html =view_cell('\Raport\Controllers\\'.$ACTION.'::showRaport', $dtReport);
	//	$html =view_cell('\Raport\Controllers\Ikmv01::showRaport', $dtReport);
		$hsl = $this->makePdf($html);
		
        $Data=$this->data;
		$Data['addOnAct'] = $this->dconfig->AddOnAct2;
        $Data['file_pdf'] = $hsl;
        $Data['ids'] = $ids;
        echo view($this->theme.'viewfile',$Data);
	}

	public function coverPage()
	{
		$this->cekHakAkses('read_data');
		$data=$this->data;		
		if (isset($_GET['ids'])) 
		{
			$ids= $_GET['ids'];
			$id = decrypt($ids);
		}else{
			$this->session->setFlashdata('warning','Data gagal ditampilkan');
			return redirect()->to(base_url('rapor'));
		}

		$dtCover = $this->subdata_raport($id);
		/*
		$vhtml=[];
		for($x=1;$x<=3;$x++){
			$dtCover['hal']=$x;
			$html =view_cell('\Raport\Controllers\Ikmv01::showCover', $dtCover);
			$vhtml[$x] = ['html'=>$html, "header"=>"", "footer"=>""];
		}

		$hsl = $this->useMpdf($vhtml);
		*/
		$html =view_cell('\Raport\Controllers\Ikmv01::showCover', $dtCover);
		$hsl = $this->makePdf($html, false);
		$Data=$this->data;
        $Data['addOnAct'] = $this->dconfig->AddOnAct2;
        $Data['file_pdf'] = $hsl;
        $Data['ids'] = $ids;
        echo view($this->theme.'viewfile',$Data);
	
	}

	function r_project()
	{
		$this->cekHakAkses('read_data');
		$data=$this->data;		
		if (isset($_GET['ids']) && isset($_GET['sg'])) 
		{
			$ids= $_GET['ids'];
			$id = decrypt($ids);
			$sg= $_GET['sg'];
			$sgrade = decrypt($sg);
		}else{
			$this->session->setFlashdata('warning','Data gagal ditampilkan');
			return redirect()->to(base_url('rapor'));
		}
		
		$dtReport	   = $this->_dtproject($id, $sgrade);
		$ACTION = ucwords(strtolower($dtReport['kurikulum']['action_class']));
		
		$this->RaporID = $dtReport['PD']['id'];
		$this->footpdf = $dtReport['siswa']['noinduk']." | ".$dtReport['siswa']['nama'];
		$html =view_cell('\Raport\Controllers\\'.$ACTION.'::RptProject', $dtReport);
	//	echo $html;
		$hsl = $this->makePdf($html);
		
        $Data=$this->data;
	///	$Data['addOnAct'] = $this->dconfig->AddOnAct2;
        $Data['file_pdf'] = $hsl;
        $Data['ids'] = $ids;
        echo view($this->theme.'viewfile',$Data);
	}

	private function useMpdf($vhtml)
	{
		$mpdf = new \Mpdf\Mpdf();
		$fname 	 	 = 'RAPORT.pdf';
		$dirf 		 = setting()->get('MyApp.pdftmpDir');
		$path 		 = setting()->get('MyApp.pdfPath_Dir');
		$logo 		 = 'images/' . setting()->get('MyApp.logo');
		$p=1; $n = count($vhtml);
		foreach($vhtml as $x => $v)
		{
	//	$mpdf->SetHeader('First section header');
	//	$mpdf->SetFooter('First section footer');
	//	$mpdf->WriteHTML('First section text...');
		$mpdf->imageVars['myLogo'] = file_get_contents($logo);
		// Set the new Header before you AddPage
		$mpdf->SetHeader($v['header']);
		if($p>1 && $p<=$n){$mpdf->AddPage();}
		
		// Set the new Footer after you AddPage
		$mpdf->SetFooter($v['footer']);
		$mpdf->WriteHTML($v['html']);
		$p++;
		}
		//$mpdf->output();
		//$mpdf->OutputHttpDownload();
		$this->response->setHeader('Content-Type', 'application/pdf');
		$mpdf->OutputHttpInline($fname, "F");
		 
		return base_url($dirf.$fname);
	}

	private function makePdf($html, $footer=TRUE)
	{
		$options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', TRUE);
        $options->set('enable_remote', TRUE);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper("A4", "potrait");
        $dompdf->render();
                  
		$fname 	 	 = 'RAPORT.pdf';
		$dirf 		 = setting()->get('MyApp.pdftmpDir');
		$path 		 = setting()->get('MyApp.pdfPath_Dir');
		$companyName = setting()->get('MyApp.companyName');
		//$footer 	 = setting()->get('MyApp.appName')." ".setting()->get('MyApp.appVerison');
		$footer		 = $this->footpdf;

		if($footer)
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

	private function subdata_raport($id)
	{
		//ambil data PD 
		$RESULT = [];
		$memberModel = model(\Modules\Room\Models\MemberModel::class);
		$PD = $memberModel->find($id)->toarray();
		unset($PD['created_at']);
		unset($PD['updated_at']);
		unset($PD['deleted_at']);

		$siswaModel = model(\Modules\Siswa\Models\SiswaModel::class);
		$Siswa = $siswaModel->get($PD['noinduk']);
		unset($Siswa['created_at']);
		unset($Siswa['updated_at']);
		unset($Siswa['deleted_at']);

		$RoomModel = model(\Modules\Room\Models\RombelModel::class);
	//	$KUR = $data['opsi']['curr_id'];
		$LM = setting()->get('Rombel.opsi');
		$R = $RoomModel->getAll(['id'=>$PD['roomid']]);
		$Room = (array) $R[0];
		unset($Room['created_at']);
		unset($Room['updated_at']);
		unset($Room['deleted_at']);

		//KURIKULUM
		$KUR = $this->currModel->find($Room['curr_id'])->toarray();
		unset($KUR['curr_desc']);
		unset($KUR['created_at']);
		unset($KUR['updated_at']);
		unset($KUR['deleted_at']);

		//PRODI
		$ProdiModel = model(\Modules\Akademik\Models\ProdiModel::class);
		$PS = $ProdiModel->gets(['a.id_prodi'=>$KUR['id_prodi']]);
		$RESULT['PS'] = $PS[0];
		$RESULT['kurikulum'] = $KUR;
		$RESULT['rombel'] = $Room;
		$RESULT['PD'] = $PD;
		$RESULT['siswa'] = $Siswa;
		return $RESULT;
	}

	private function _dtreport($id, $sgrade=1)
	{
		//ambil data PD 
		$RESULT = [];
		$memberModel = model(\Modules\Room\Models\MemberModel::class);
		$PD = $memberModel->find($id)->toarray();
		unset($PD['created_at']);
		unset($PD['updated_at']);
		unset($PD['deleted_at']);

		$siswaModel = model(\Modules\Siswa\Models\SiswaModel::class);
		$Siswa = $siswaModel->get($PD['noinduk']);
		unset($Siswa['created_at']);
		unset($Siswa['updated_at']);
		unset($Siswa['deleted_at']);

		$RoomModel = model(\Modules\Room\Models\RombelModel::class);
	//	$KUR = $data['opsi']['curr_id'];
		$LM = setting()->get('Rombel.opsi');
		$R = $RoomModel->getAll(['id'=>$PD['roomid']]);
		$Room = (array) $R[0];
		unset($Room['created_at']);
		unset($Room['updated_at']);
		unset($Room['deleted_at']);

		//KURIKULUM
		$KUR = $this->currModel->find($Room['curr_id'])->toarray();
		unset($KUR['curr_desc']);
		unset($KUR['created_at']);
		unset($KUR['updated_at']);
		unset($KUR['deleted_at']);

		//PRODI
		$ProdiModel = model(\Modules\Akademik\Models\ProdiModel::class);
		$PS = $ProdiModel->gets(['a.id_prodi'=>$KUR['id_prodi']]);

		//SKL
		$NilaiModel = model(\Modules\Assessment\Models\NilaiModel::class);
		$Nilai = $NilaiModel->getsNilai(['a.member_id'=>$id, 'b.subgrade'=>$sgrade]);
		//kelompokkan nilai berdasarkan mapelID
		$NILAI =[];
		foreach($Nilai as $N)
		{
			$NILAI[$N['id_mapel']][$N['rating_id']][$N['idx']]=$N['nilai'];
		}

		//MAPEL
		$mapelModel = model(\Modules\Akademik\Models\MapelModel::class);
		$mapel = $mapelModel->getsMapel(['c.grade'=>$Room['grade'], 'c.subgrade'=>$sgrade, 'c.currId'=>$KUR['id']]);
		
		//GRUP MAPEL
		$grupModel = model(\Modules\Akademik\Models\GmapelModel::class);
		$grupMapel = $grupModel->asarray()->where('curr_id', $KUR['id'])->findAll();

		//KKM dari PTM
		$ptmModel = model(\Modules\Kbm\Models\PtmModel::class);
		$ptm = $ptmModel->where(['roomid'=>decrypt($Room['id']),'subgrade'=>$sgrade])->asarray()->findAll();
		foreach($ptm as $tm)
		{
			$kkm[$tm['id_mapel']]=$tm['kkm'];
		}
		//ATP jika Kurikulum memiliki descripsi
		$ratingModel = model(\Modules\Akademik\Models\RatingModel::class);
		$compNIlai = $ratingModel->asarray()->where(['curr_id'=>$KUR['id'], 'type_nilai'=>'NR'])->findAll();
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

		//$dtRapor = $this->model->asarray()->where(['curr_id'=>$KUR['id'],'kode_ta'=>$Room['kode_ta'], 'subgrade'=>$sgrade])->findAll();
		$dtRapor = $this->model->gets(['curr_id'=>$KUR['id'],'kode_ta'=>$Room['kode_ta'], 'subgrade'=>$sgrade]);
		$RESULT['PS'] = $PS[0];
		$RESULT['kurikulum'] = $KUR;
		$RESULT['rombel'] = $Room;
		$RESULT['PD'] = $PD;
		$RESULT['siswa'] = $Siswa;
		$RESULT['GrupMapel'] = $grupMapel;
		$RESULT['Mapel'] = $mapel;
		$RESULT['NILAI'] = $NILAI;
		$RESULT['KKM'] = $kkm;
		$RESULT['Rating'] = $Rating;
		$RESULT['ATP'] = $ATP;
		$RESULT['dtRaport'] = $dtRapor;

		return $RESULT;
	}

	private function _dtproject($id, $sgrade=1)
	{
		//ambil data PD 
		$RESULT = [];
		$memberModel = model(\Modules\Room\Models\MemberModel::class);
		$PD = $memberModel->find($id)->toarray();
		unset($PD['created_at']);
		unset($PD['updated_at']);
		unset($PD['deleted_at']);
	//	test_result($PD);

		$siswaModel = model(\Modules\Siswa\Models\SiswaModel::class);
		$Siswa = $siswaModel->get($PD['noinduk']);
		unset($Siswa['created_at']);
		unset($Siswa['updated_at']);
		unset($Siswa['deleted_at']);

		$RoomModel = model(\Modules\Room\Models\RombelModel::class);
	//	$KUR = $data['opsi']['curr_id'];
		$LM = setting()->get('Rombel.opsi');
		$R = $RoomModel->getAll(['id'=>$PD['roomid']]);
		$Room = (array) $R[0];
		$RoomID = decrypt($Room['id']);
		unset($Room['created_at']);
		unset($Room['updated_at']);
		unset($Room['deleted_at']);
	//	show_result($Room);
		
		//KURIKULUM
		$KUR = $this->currModel->find($Room['curr_id'])->toarray();
		unset($KUR['curr_desc']);
		unset($KUR['created_at']);
		unset($KUR['updated_at']);
		unset($KUR['deleted_at']);
		
		//PRODI
		$ProdiModel = model(\Modules\Akademik\Models\ProdiModel::class);
		$PS = $ProdiModel->gets(['a.id_prodi'=>$KUR['id_prodi']]);

		//ambil data project berdasarkan roombel
		$propModel = model(\Modules\Project\Models\SkenModel::class);
		$project = $propModel->getsAll(['a.room_id'=>$RoomID]);
		$PROJECT=[];
		foreach($project as $P3)
		{
			$PROJECT[$P3['project_id']]['nama_project']=$P3['nama_project'];
			$PROJECT[$P3['project_id']]['deskripsi']=$P3['deskripsi'];
		}
	//	show_result($propela);

		//NILAI
		$NilaiModel = model(\Modules\Assessment\Models\NilaiDeskModel::class);
		$Nilai = $NilaiModel->getsNilai(['member_id'=>$PD['id'], 'subgrade'=>$sgrade]);
	//	show_result($Nilai);

		//kelompokkan nilai berdasarkan mapelID
		$NILAI =[];
		foreach($Nilai as $N)
		{
			$NILAI[$N['idx']][$N['rating_id']]=$N['nilai'];
		}
	//	test_result($NILAI);

		$mapModel = model(\Modules\Project\Models\mappingModel::class);
		$mapProject = $mapModel->getsAll(['d.curr_id'=>$Room['curr_id']]);
	//	show_result($mapProject);
		
		$EPROJ = []; $TPROJ=[]; $Rating =[];
		foreach($mapProject as $p)
		{
			$EPROJ[$p['project_id']][$p['dimensi_id']]['dimensi_title']=$p['nama_dimensi'];
			$EPROJ[$p['project_id']][$p['dimensi_id']]['dimensi_det'][$p['elemen_id']]['elemen']=$p['elemen'];
			$EPROJ[$p['project_id']][$p['dimensi_id']]['dimensi_det'][$p['elemen_id']]['detail'][$p['id']]['tujuan']=$p['tujuan'];
			$EPROJ[$p['project_id']][$p['dimensi_id']]['dimensi_det'][$p['elemen_id']]['detail'][$p['id']]['deskripsi']=$p['deskripsi'];
		}
/*
		$compNIlai = $ratingModel->asarray()->where(['curr_id'=>$KUR['id'], 'type_nilai'=>'NR'])->findAll();
		foreach($compNIlai as $CN)
		{
			$Rating[$CN['id']]=$CN;
		}
*/
	//	show_result($EPROJ);
			
		//$dtRapor = $this->model->asarray()->where(['curr_id'=>$KUR['id'],'kode_ta'=>$Room['kode_ta'], 'subgrade'=>$sgrade])->findAll();
		$dtRapor = $this->model->gets(['curr_id'=>$Room['curr_id'],'kode_ta'=>$Room['kode_ta'], 'subgrade'=>$sgrade]);
		$RESULT['PS'] = $PS[0];
		$RESULT['rombel'] = $Room;
		$RESULT['PD'] = $PD;
		$RESULT['siswa'] = $Siswa;
		$RESULT['kurikulum'] = $KUR;
		$RESULT['project'] = $PROJECT;
		$RESULT['propela'] = $EPROJ;
		$RESULT['NILAI'] = $NILAI;
		$RESULT['dtRaport'] = $dtRapor;
		$RESULT['ADMARK'] = setting()->get('PropelaConf.addMark');
	//	test_result($RESULT);		
		return $RESULT;
	}
}
