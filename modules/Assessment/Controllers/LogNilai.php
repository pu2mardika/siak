<?php

namespace Modules\Assessment\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Modules\Tp\Models\TpModel;
use Modules\Room\Models\RombelModel;
use Modules\Assessment\Models\NilaiModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;

class LogNilai extends BaseController
{
    public  $keys='';
	protected $dconfig;
	protected $tendikModel;
	protected $TpModel;
	protected $form;

    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Assessment\Config\LogNilai::class);
        $this->session = \Config\Services::session();
		$this->model = new NilaiModel;	
        $this->tendikModel  = model(\Modules\Tendik\Models\TendikModel::class); 	
        $this->TpModel  = model(\Modules\Tp\Models\TpModel::class); 	
		$this->rombelModel = model(\Modules\Room\Models\RombelModel::class); 	
		$this->mengajar  = model(\Modules\Kbm\Models\PtmModel::class); 	
		$this->data['site_title'] = 'Assessment';
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['fields'] 	  = $this->dconfig->fields;
		helper(['cookie', 'form','date']);
    }

    public function index()
    {
        $this->cekHakAkses('read_data');
		
		//echo $this->theme;die();
		$data=$this->data;		
		if (isset($_GET['tp'])) 
		{
			$ctp = $_GET['tp'];
			$tp = $this->TpModel->find($ctp);
		}else{
			$tp = $this->TpModel->getcurTP();
			//test_result($tp);
			$ctp = $tp->thid;
		}
		$addTitle = "Tahun ".$tp->deskripsi;
		$parm=['kode_ta'=>$ctp];
		$dtrombel = $this->rombelModel->where('kode_ta', $ctp)->findAll();
		//$dtrombel = $this->model->getAll(['kode_ta'=>$ctp]);
		$data['title']	= "Manajemen Nilai ".$addTitle;
		$data['rsdata']	= $dtrombel;
		$data['fields']	= $this->dconfig->fields;
		$data['dom']	= $this->dconfig->dom;
		$data['msg'] 	= "";
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['walikelas'] 	= $this->tendikModel->getDropdown();
		$dtfilter	= $this->dconfig->dtfilter;
		$tp = $this->TpModel->getcurTP();
		$dtfilter['cVal'] = $ctp;
		$data['TaPel'] 	= $this->TpModel->getDropdown();
		$data['dtfilter'] 	= $dtfilter;
		$data['actions']= $this->dconfig->panelAct;
		$data['allowADD']	=  $this->dconfig->addAllowed;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);	
    }

	function showMapel()
	{
		$mp = $this->request->getGet();
		if(!isset($mp['ids']))
		{
			$this->session->setFlashdata('warning','Data gagal Ditampilkan');
			return redirect()->to(base_url('nilai'));
		}
		//test_result($mp);

		$roomID = decrypt($mp['ids']);
		//echo $roomID;
		$room = $this->rombelModel->find($roomID);
		$currID = $room->curr_id;

	//	test_result($room);

		//ambil componen nilai berdasarkan kurikulum
		$ratingModel = model(\Modules\Akademik\Models\RatingModel::class);
		
		$compNIlai = $ratingModel->where(['curr_id'=>$currID, 'has_descript'=>1])->findAll();
		//show_result($compNIlai);
		if($compNIlai){
			//"HAS DESCRIPSI" maka arahkan action ke input Alur Tujuan Pembelajaran /ATP atau Capaian Pembelajaran
			$act= 0;
			$keyField = "id_mapel";
		}else{
			//"No DESCRIPT", arahkan action ke show peserta didik untuk input nilai sesuai komponen penilaian yang disediakan
			$act= 1;	
			$keyField = "roomid";
		}

		//AMBIL KOMPONEN PENILAIAN SELAIN NILAI RAPORT
		$other_cr = $ratingModel->asarray()->where(['curr_id'=>$currID, 'type_nilai !='=>"NR"])->findAll();
		//test_result($other_cr);
		//TAMPILKAN MAPEL BERDASARKAN PEMBAGIAN TUGAS MENGAJAR SESUAI SKL
		//test_result($room);
		//tetapkan parameter pengambilan data mapel berdasarkan currID, grade dan sub grade
		$roomID = decrypt($room->id);
		$parm['a.roomid'] = $roomID;
	//	$mengajar  = model(\Modules\Kbm\Models\PtmModel::class); 
	//	$subject = $mengajar->getAll($parm);
		$subject = $this->mengajar->getAll($parm);
		//show_result($act);
		//mengelompokkan mapel berdasarkan subgrade
		$mapel =[];
		$strdelimeter = setting('LogNilai.arrDelimeter');
	//	show_result($subject);
		foreach($subject as $mp)
		{
			$mapel[$mp['subgrade']][0]['gtitle']="Rincian mapel subgrade-".$mp['subgrade'];
			$mp['idx']=$mp['roomid'].$strdelimeter.$mp['id'];
			$mapel[$mp['subgrade']][0]['detail'][]=$mp;

			//tambahkan subfootnote

		}
	//	test_result($mapel);
		$data=$this->data;
		$actions = $this->dconfig->actions;
		$data['fields'] = $this->dconfig->fields2;
		$data['title']	= "INPUT NILAI KELAS ".strtoupper($room->nama_rombel);
		$data['rsdata']	= $mapel;
		$data['key'] 	= "id"; //$keyField;
		$data['isplainText'] = TRUE;
		$data['subtitle'] = "Sub Grade-";
		$data['actions']  = $actions[$act];
		echo view($this->theme.'acordiontable',$data);
	}

	function showPD()
	{
		//tampilkan data mapel sebagai resume dan data peserta didik sesuai data rombel sebagai detail
		$ids = (isset($_GET['ids']))?decrypt($_GET['ids']):""; //ID Mengajar
		//ambil data mapel:
		$data=$this->data;
		$parm['a.id'] = $ids;
		$subject = $this->mengajar->getAll($parm);
		$subject = (array_key_exists(0,$subject))?$subject[0]:[];
		
		//RESUME
		$resume['field']= setting('LogNilai.ResumeFields');
		$resume['data']= $subject;
		$resume['subtitle'] = "Nilai Mata Pelajaran : ".$subject['subject_name'];
		$data['resume'] = $resume;
		$data['condAddOnAct'] = $this->dconfig->condActions;
		$data['dataStated'] = 0;
		//DETAIL DATA

		$mfields = setting('LogNilai.markFields');
		$nfield = $mfields['nilai'];
		unset($mfields['nilai']);
		
		//Rating Model
		$currID = $subject['curr_id'];
		$DCN = $this->_setNilai($currID, $ids);
		$mfields=$DCN['mfields'];
		$CN =$DCN['CN'];
		$defNilai=$DCN['defNilai'];
		$colWidth = $DCN['colWidth'];
	//	show_result($DCN);
		//data member :
		$MemberModel = model(\Modules\Room\Models\MemberModel::class); 
		$id = $subject['roomid'];
		$pd = $MemberModel->getAll(['a.roomid'=>$id]);
		
		//detail nilai
		$nilai = $this->model->where('id_mengajar', $ids)->asArray()->findAll();
	//	show_result($nilai);

		//generate nilai untuk masing-masing PD
		$Nilai = []; $cnnFd=[];
		foreach($nilai as $N)
		{
			//perbaharui data $mfields
			$fid = $CN[$N['rating_id']]['alias'];
			$I   = ($N['idx']>0)?"-".$N['idx']:"";
			$ccn = $fid.$I;
			$cnnFd[$ccn]=$fid;
			$Nilai[$N['member_id']][$ccn]=$N['nilai'];
		}

		$based=(count($cnnFd)>0)?count($cnnFd):1;
		$w= floor($colWidth/$based);
		foreach($cnnFd as $k =>$fdv)
		{
			if(array_key_exists($fdv, $mfields)){
				$dfield = $mfields[$fdv];
				unset($mfields[$fdv]); 
			}//menghapus fileds awal
			//tetapkan judul $mfields baru
			$dfield['label']=$k;
			$dfield['width']=$w;
			$dfield['type'] ="disp";
		//	show_result($dfield);
			$mfields[$k]=$dfield;
		}

	//	show_result($Nilai);
		//menggabungkan PD dengan Nilai (jika ada)
		$rsData=[];
		foreach($pd as $PD)
		{
			$nilai = (array_key_exists($PD['id'],$Nilai))?$Nilai[$PD['id']]:$defNilai;
			$dtPD = array_merge($PD,$nilai);
			$rsData[]=$dtPD;
		}
	//	test_result($rsData);
		$data['fields']	= $mfields;
		$data['rsdata']	= $rsData;
		$data['msg'] 	= "";
		$data['isplainText'] = false;
		$data['keys'] 	= $this->dconfig->primarykey;
		$data['detAction'] = $this->dconfig->detAddOnACt;
	//	test_result($data);
		echo view($this->theme.'frmdatalist',$data);
	}

	function fromxlsx($idm=0){
		$data = $this->data;
		$data['title']	= "UPLOAD NILAI";
		$data['error'] = validation_list_errors();
		$data['u_ri']  = base_url('nilai/tempxls?idm='.$idm);
		echo view($this->theme.'frmImport',$data);
	}

	function importAction($idm): RedirectResponse
	{
		$this->cekHakAkses('create_data');
		helper('text');
		$validationRule  =[
			'userfile' => ['uploaded[userfile]'],
		];
		
		$idm = decrypt($idm);

		if ($this->validate($validationRule)) {
			
			 $xlsx = $this->request->getFile('userfile');
			 if ($xlsx->isValid() && ! $xlsx->hasMoved()) {
	             // Get random file name
				$newName = $xlsx->getRandomName();
				// Store file in public/csvfile/ folder
				
				$myconfig = new MyApp;
				$dirf = $myconfig ->tmpfile_dir;
				$filepath = $this->myconfig->tmpfile_dir;
				
				//echo $type; 
				$xlsx->move($filepath, $newName);
				
				$inputFileName = $filepath.$newName;
				
				//MEMBUKA FILE EXCEL
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
				$reader->setReadDataOnly(TRUE);
				$spreadsheet = $reader->load($inputFileName);

				$worksheet = $spreadsheet->getActiveSheet();

				$IDM = $worksheet->getCell('A3')->getValue();

				//mencocokkan ID MENGAJAR
				if($idm <> $IDM)
				{
					$this->session->setFlashdata('warning','Kode Mapel Tidak Sesuai');
					return redirect()->to(base_url('nilai'));
				} 
				
				//ambil data
				$maxDataRow = $worksheet->getHighestDataRow();
				$maxDataColumn = $worksheet->getHighestDataColumn();

				//Ambil Data Mepel dan menyesuaikan componen nilai
				$parm['a.id'] = $IDM;
				$subject = $this->mengajar->getAll($parm);
				$subject = (array_key_exists(0,$subject))?$subject[0]:[];

				$currID  = $subject['curr_id'];
				$DCN 	 = $this->_setNilai($currID);
				$headName= $DCN['headName'];
				$rheadf  = $DCN['rheadf'];
				$mainhf  = $DCN['mainhf'];
				$rcomName= $DCN['rcomName'];
				$mfields = $DCN['mfields'];
				$colWidth = $DCN['colWidth'];
			//	show_result($DCN);
				//AMBIL BARIS PERTAMA TABEL NILAI
				$head=$worksheet->rangeToArray("A10:".$maxDataColumn."10",NULL,TRUE,TRUE,TRUE);
				$heads = $head[10];
			//	show_result($heads);
			//	show_result($headName);
				//cek kesesuaan judul dengan kebutuhan
				$fields=[]; $cnn=[]; $ncnn = 0;
				foreach($heads as $vh)
				{
					if(in_array($vh, $mainhf))
					{
						$fields[]=$rheadf[$vh];
					}else{
						//cek apakah $heads merupakan bagian dari komponen nilai
						/*
						mengingat  bahwa setiap komponen bisa lebih dari 1 nilai maka akan dilakukan exlode yang terdiri dari komponen nilai dan index
						# komponen pemisah bisa berupa "-"
						*/
						$fd = explode("-",$vh); 
						if(in_array($fd[0],$headName)||in_array($vh, $headName))
						{
							$fields[]=$vh;
							$vcn = (in_array($vh, $headName))?$vh:$fd[0];
							$cnn[$vh]=$fd[0];//$vcn;
						}
					}
				}
			//	show_result($cnn);
			//	show_result($fields);
			//	test_result($rcomName);
				//update mfields
				$wCol = $colWidth / count($cnn);
				foreach($cnn as $fk => $vk)
				{
					//UPDATE $mfields
					if(array_key_exists($vk,$mfields)){
						$nfield = $mfields[$vk];
						unset($mfields[$vk]);
					}
					$nfield['label']=$fk;
					$nfield['width']=$wCol;
					$nfield['extra']['id']="n".strtolower($fk);
					$mfields[$fk] = $nfield;
				}
			//	test_result($cnn);
				//ambil data 
				$rowIterator = $worksheet->getRowIterator(11, $maxDataRow);
				$rowData=[]; $r = 0; $rsData=[];
				foreach ($rowIterator as $row) {
					if ($row->isEmpty()) { // Ignore empty rows
						continue;
					}
					$r++;
					$columnIterator = $row->getCellIterator('A', $maxDataColumn);
					$colData=[]; $i=0; $data['id_mengajar']=$idm; $cellData=[];
					foreach ($columnIterator as $cell) {
						// Do something with the cell here.
						$cellValue = $cell->getValue();
						$fd = $fields[$i];
						if(array_key_exists($fd, $cnn)){
							$cellValue = (float)$cellValue;
							$colData['nilai'][$cnn[$fd]][]=$cellValue;
						}else{
							$colData[$fields[$i]]=$cellValue;
						}
						$cellData[$fields[$i]]=$cellValue;
						$i++;
					}
					$data['member_id']=$colData['id'];
					$nilai=$colData['nilai'];
				//	show_result($nilai);
					foreach($nilai as $cn =>$NILAI)
					{
						$data['rating_id']=$rcomName[$cn];
						$s = (count($NILAI)>1)?1:0;// $a=1;
						foreach($NILAI as $i => $N )
						{
							$data['idx']=$i+$s;
							$data['nilai']=$N;
							$rowData[]=$data;
							//$a++;
						}
					}
					$rsData[$r]=$cellData;
				}
			//	test_result($rowData);
				$Data['actY'] = random_string('md5',32);
				$Data['actN'] = random_string('alnum',12);
				$Data['fields'] = $mfields;
				$Data['rsdata'] = $rsData;
				$Data['rowData'] = $rowData;
				$Data['idm'] = encrypt($idm);
				//Konfirmasi data
				$this->session->setTempdata('dtptk',$Data,120);
				return redirect()->to(base_url('nilai/konfirm'));
	         }else{
				$this->session->setFlashdata('warning','The file has already been moved.');
				return redirect()->to(base_url('nilai'));
			 }
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	public function simpanmasal($act = 0) {
		$DATA = $this->session->getTempdata('dtptk');
		//echo $act;
	//	test_result($DATA);
		//$nilai $act = nol
		if($act === 0){
			//tampilkan ke browser
			$Data = $this->data;
			$data = array_merge($Data,$DATA);
			$data['title'] = "Konfirmasi Data!";
		//	test_result($data);
			echo view($this->theme.'list2konfirm',$data);
		}
		
		$uri = 'nilai/vdata?ids='.$DATA['idm'];
		if($act === $DATA['actY']){
			$model = new NilaiModel();
			$simpan = $model->insertBatch($DATA['rowData']);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url($uri));
		} 
		
		//$nilai $act = nol
		if($act === $DATA['actN']){
			//hapus data dari sesi
			unset($_SESSION['dttendik']);
			$this->session->setFlashdata('warning','Data Dibatalkan oleh Pengguna');
			return redirect()->to(base_url($uri));
		}
		
	}
	
	function tmpobyek()
	{
		$ids = (isset($_GET['idm']))?decrypt($_GET['idm']):""; //ID Mengajar
	//	$excel = new \App\Libraries\Exc_lib();

		$exc= new \PhpOffice\PhpSpreadsheet\Spreadsheet();

		$myconfig = new MyApp;
		$exc->getProperties()
			->setCreator('pu2mardika')
			->setLastModifiedBy('Mandiri Bina Cipta')
			->setDescription("SIA-MBC");
		
		$styleArray = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '0000'],
				],
			],
		];
		
		$exc->getDefaultStyle()->getFont()->setName('Arial');
		$exc->getDefaultStyle()->getFont()->setSize(10);
	 	//membuat sheet;
		$worksheet = $exc->setActiveSheetIndex(0);
		//$worksheet->setTitle($filename);
		
		$worksheet->getColumnDimension('A')->setWidth(16);
		$worksheet->getColumnDimension('B')->setWidth(130, 'px');
		$worksheet->getColumnDimension('C')->setWidth(270, 'px');
		$worksheet->getColumnDimension('D')->setWidth(120, 'px');
		$worksheet->setCellValue('A1', 'TEMPLATE UPLOAD NILAI');
		$worksheet->getStyle('A1')->getFont()->setBold(true);

		//input identitas showMapel
		
		$dirf = $myconfig ->tmpfile_dir;
		
		$filepath = $this->myconfig->tmpfile_dir;
		$headf = [];
		
		//show_result($ids);
		//MENYIAPKAN DATA
		$parm['a.id'] = $ids;
		$subject = $this->mengajar->getAll($parm);
		$subject = (array_key_exists(0,$subject))?$subject[0]:[];
	

		$judul = [
		//	['Kode Mapel', ],
			[$subject['id'], $subject['subject_name']],
			['SKK', $subject['skk']],
			['KKMM/KKTP', $subject['kkm']],
			['Pengampu', $subject['nama']],
		];
		
		$worksheet->fromArray($judul, null, 'A3');
		$worksheet->setCellValue('A7', '(Jangan Merubah Data Mapel)');
		$worksheet->getStyle('A7')->getFont()->setBold(true)
				  ->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
		$worksheet->getStyle('A3')->getFill()
				  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				  ->getStartColor()->setARGB('000000');
		$worksheet->getStyle('B3:B6')
				  ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		//test_result($subject);
		
		$currID  = $subject['curr_id'];
		$DCN 	 = $this->_setNilai($currID, $ids);
		$mfields = $DCN['mfields'];
		$headName= $DCN['headName'];
		$headf	 = $DCN['headf'];
		$defNilai= $DCN['defNilai'];
		$cnn_desc= $DCN['cnn_desc'];
		
		//TULIS KETERANGAN KOMPONEN NILAI
		$text = "Keterangan Nilai: ".$cnn_desc;
		$worksheet->setCellValue('A9', $text);
		$worksheet->getStyle('A9')->getFont()->setBold(true)
				  ->getColor()->setARGB('000080');
		
		//INPUT JUDUL TABEL
		$worksheet->fromArray($headName, null, 'A10');
		$ncol = count($headName);
	//	$colExc = colExcel();
		$endCol = colExcel()[$ncol-1];
		$hedRange = 'A10:'.$endCol.'10';
		$worksheet->getStyle($hedRange)->applyFromArray($styleArray)
				  ->getFont()->setBold(true);
		$worksheet->getStyle($hedRange)
				  ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
		$worksheet->getStyle($hedRange)
				  ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$worksheet->getStyle($hedRange)->getFill()
				  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				  ->getStartColor()->setARGB('C0C0C0');

		//data member :
		$MemberModel = model(\Modules\Room\Models\MemberModel::class); 
		$id = $subject['roomid'];
		$pd = $MemberModel->getAll(['a.roomid'=>$id]);
	
		//menggabungkan PD dengan Nilai (jika ada)
		$rsData=[];
		
		foreach($pd as $PD)
		{
		//	$dtPD = array_merge($PD,$defNilai);
			foreach($headf as $fd)
			{
				if(array_key_exists($fd, $PD)){$dtPD[$fd]=$PD[$fd];}
			}
			$rsData[]=$dtPD;
		}
		
		$worksheet->fromArray($rsData, null, 'A11');
		$lastRow = 10 + count($rsData);
		$pdRange = 'A11:D'.$lastRow;
		$worksheet->getStyle($pdRange)->getNumberFormat()
				  ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT); // will show as 0019 in Excel
			
		//protect_worksheet
		/*
		$protection = $worksheet->getProtection();
		$protection->setPassword('PhpSpreadsheet');
		$protection->setSheet(true);
		$protection->setSort(false);
		$protection->setInsertRows(false);
		$protection->setFormatCells(false);
		*/
	//	$worksheet->protectCells('D:D');
	//	$worksheet->protectCells('A:B', 'sortpw');
		

		$nama_file = 'Tmp_Nilai_'.$subject['id']."-".$subject['subject_name'].date("Ymhdis");
		//$fn = $excel->write_data($nama_file,$headf,$rsData);
				
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($exc);
	    $writer->save($dirf.$nama_file.'.xlsx');
        return $this->response->download($dirf.$nama_file.'.xlsx', null);
	}

	private function _setNilai($currID, $idm=0)
	{
		$mfields = setting('LogNilai.markFields');
		$nfield = $mfields['nilai'];
		$colWidth = $nfield['width'];
		unset($mfields['nilai']);
		
		//menyiapkan head dan headname 
		$headf[]='id'; $headName[]="Member ID";
		$rheadf['Member ID']='id';
		foreach ($mfields as $k => $v){
			$headf[]=$k;
			$headName[]=$v['label'];
			$rheadf[$v['label']]=$k;
		}
		$mainhf = $headName;
		//Rating Model
		$ratingModel = model(\Modules\Akademik\Models\RatingModel::class);
		//$currID = $subject['curr_id'];
		$compNIlai = $ratingModel->where(['curr_id'=>$currID, 'type_nilai'=>"NR", 'has_descript'=>1])->findAll();
		$CN = [];
		if($compNIlai){
			//MEMILIKI DESKRIPSI PENILAIAN
			$AtpModel = model(\Modules\Assessment\Models\ModelAtp::class);
			$comp_nilai = $AtpModel->getAll(['id_mengajar'=>$idm]);
			//mengelompokkan componen nilai berdasarkan rating_id
			$cp=[];
			foreach($comp_nilai as $v)
			{
				$cp[$v['rating_id']][$v['idx']]=$v;
			}
		//	show_result($cp);
			$desc=[];
			foreach($cp as $p => $ccn)
			{
				$nid = count($ccn);
				ksort($ccn);
				foreach($ccn as $cn)
				{
					$idx = ($nid > 1)?$cn['akronim']."-".$cn['idx']:$cn['akronim'];
					$mfields[$idx]=$nfield;
					$mfields[$idx]['label'] = $cn['nm_komponen'];
					$mfields[$idx]['extra']['id'] = $cn['akronim'].$cn['idx'];
					$CN[$cn['rating_id']]['alias']=$cn['akronim'];
					$CN[$cn['rating_id']]['label']=$cn['nm_komponen'];
					$defNilai[$idx]="";
					$headName[]=$idx;
					$rcomName[$cn['akronim']]=$cn['rating_id'];
					$desc[$cn['akronim']]=$cn['nm_komponen'];
				}
			}

			foreach($desc as $k => $dn)
			{
				$cnn_desc[]= $k."=".$dn;
			}

		}else{
			//"No DESCRIPT", aambil nilai dari komponen penilaian yang disediakan
			$comp_nilai = $ratingModel->asArray()->where(['curr_id'=>$currID, 'type_nilai'=>"NR"])->findAll();
			//menyiapkan tambahan fields berdasarkan komponen nilai
		//	$l = $nfield['width']/(($comp_nilai)?count($comp_nilai):1);
		//	$nfield['width']=$l;
			foreach($comp_nilai as $cn)
			{
				$mfields[$cn['akronim']]=$nfield;
				$mfields[$cn['akronim']]['label'] = $cn['nm_komponen'];
				$CN[$cn['id']]['alias']=$cn['akronim'];
				$CN[$cn['id']]['label']=$cn['nm_komponen'];
				$defNilai[$cn['akronim']]="";
				$headName[]= $cn['akronim'];
				$rcomName[$cn['akronim']]=$cn['id'];
				$cnn_desc[]=$cn['akronim']."=".$cn['nm_komponen'];
			}
		}

		$CDN['mfields']  = $mfields;
		$CDN['headf']    = $headf;
		$CDN['rheadf']   = $rheadf;
		$CDN['mainhf']   = $mainhf;
		$CDN['rcomName'] = $rcomName;
		$CDN['headName'] = $headName;
		$CDN['CN'] 		 = $CN;
		$CDN['defNilai'] = $defNilai;
		$CDN['colWidth'] = $colWidth;
		$CDN['cnn_desc'] = implode(", ",$cnn_desc);
	//	test_result($CDN);
		return $CDN;
	}
}
