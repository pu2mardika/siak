<?php

namespace Modules\Assessment\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events; 
use Modules\Assessment\Models\ModelAtp;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;

class Atp extends BaseController
{
    function __construct() {
        parent::__construct();
        $this->dconfig 		= config(\Modules\Assessment\Config\AtpConfig::class);
        $this->session 		= \Config\Services::session();
		$this->model 		= new ModelAtp;	
		$this->TpModel      = model(\Modules\Tp\Models\TpModel::class); 	
		$this->rombelModel  = model(\Modules\Room\Models\RombelModel::class); 	
		$this->mengajar     = model(\Modules\Kbm\Models\PtmModel::class); 	
		$this->ratingModel  = model(\Modules\Akademik\Models\RatingModel::class); 	
		$this->data['site_title'] = 'Halaman Subject';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['allowimport']= $this->dconfig->importallowed;
		//HAPUS DATA breadcrumb
		$breadcrumb = $this->data['breadcrumb'];
		$modul = $this->data['current_module'];
		unset($breadcrumb[$modul['judul_module']]);
		$breadcrumb['Nilai']=base_url('lognilai');
		$breadcrumb['Capaian Pembelajaran'] = "";
		$this->data['breadcrumb']=$breadcrumb;
		//show_result($breadcrumb);
		helper(['cookie', 'form', 'util']);
    }
    public function index()
    {
     //   $this->session->setFlashdata('warning','NO ACCESS ALLOWED');
		return redirect()->to(base_url('nilai'));
    }

    public function showAtp()
    {
        $data=$this->data;	
		if (isset($_GET['ids'])) 
		{
			 $idm = decrypt($_GET['ids']);
		}else{
			$this->session->setFlashdata('warning','Data gagal Ditampilkan');
			return redirect()->to(base_url());
		}

		//tampilkan data ATP yang ada
		$parm['a.id'] = $idm;
		$subject = $this->mengajar->getAll($parm);
		$subject = (array_key_exists(0,$subject))?$subject[0]:[];
	//	test_result($subject);

		//RESUME
		$resume['field']= setting('LogNilai.ResumeFields');
		$resume['data']= $subject;
		$resume['subtitle'] = "Capaian Pembelajaran Mata Pelajaran : ".$subject['subject_name'];
		$data['resume'] = $resume;
		$data['addOnACt'] = $this->dconfig->cpActions;
		$data['condAddOnAct'] = $this->dconfig->condActions;
		
	//	test_result($resume);
		
		//Menampilkan Data ATP sesuai dengan ?
		//'id_mengajar', 'rating_id', 'idx', 'atp'
		$RS = $this->model->where('id_mengajar', $idm)->asArray()->findAll();
		$rsData = [];
		foreach($RS as $rs)
		{
			$id = $rs['id_mengajar'].$this->dconfig->arrDelimeter.$rs['rating_id'].
				  setting('AtpConfig.arrDelimeter').$rs['idx'];
			$rs['id']=$id;
			$rsData[]=$rs;
		}
		$data['dataStated'] = (count($rsData)>0)?1:0;
		//test_result($rsData);
		$data['fields']	= setting('AtpConfig.fields');
		$data['rsdata']	= $rsData;
		$data['opsi']['rating_id']	= $this->ratingModel->getDropdown($subject['curr_id']);
		$data['msg'] 	= "";
		$data['isplainText'] = false;
		$data['keys'] 	= $this->dconfig->primarykey;
		$data['detAction'] = $this->dconfig->actions;
		//test_result($resume);
		echo view($this->theme.'frmdatalist',$data);
    }

	function addView()
	{
		$this->cekHakAkses('create_data');
		
		if (isset($_GET['idm'])) 
		{
			 $idm = $_GET['idm'];
		}else{
			$this->session->setFlashdata('warning','Data gagal Ditampilkan');
			return redirect()->to(base_url());
		}
		$parm['a.id'] = $idm;
		$subject = $this->mengajar->getAll($parm);
		$subject = (array_key_exists(0,$subject))?$subject[0]:[];
		$fields = $this->dconfig->fields;
		unset($fields['idx']);
		$DATA = $this->data;
		$data['inputype'] = $DATA['inputype'];
		unset($DATA);
	//	$data = $this->data;
	//	test_result($DATA);
		$data['title']	= "Tambah Tujuan Pembelajaran";
		
		$data['error'] = [];
		$data['hidden']	= ['id_mengajar'=>$idm];
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['rating_id']	= $this->ratingModel->getDropdown($subject['curr_id']);
		$data['rsdata'] = []; //['kode_ta'=>$ctp];
		$data['addONJs'] = setting('AtpConfig.addonJS');
		$data['rtarget']	= "#dtHistory";
		echo view($this->theme.'ajxform',$data);
	}

	function GetID()
	{
		if (isset($_GET['idm']) && isset($_GET['idr']))
		{
			$parm['id_mengajar'] = $_GET['idm']; //MENGAJAR ID
			$parm['rating_id'] = $_GET['idr']; //RATING ID
			//show_result($parm);
			$idx = $this->model->getIdx($parm);
			//test_result($idx);
			$data = [
				'type'  => 'hidden',
				'name'  => 'idx',
				'id'    => 'jIDX',
				'value' => set_value('idx',$idx),
			];
			echo form_input($data);
		}
	}

	function addAction() : RedirectResponse
	{
	//	$this->cekHakAkses('create_data');
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();	
		//	test_result($data);
			$AtpModel = new ModelAtp();
			$atpcp= new \Modules\Assessment\Entities\Atps();
			$atpcp->fill($data);
			$simpan = $AtpModel->insert($atpcp,false);		
			if($simpan){
				$this->session->setFlashdata('sukses', ' Data telah berhasil disimpan');
				show_alert("Data Berhasil disimpan","SUKSES");
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
				show_alert("Data Gagal disimpan","warning");
			}
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
		
	}

	function editView($idx)
	{
		$this->cekHakAkses('create_data');
		$idx = decrypt($idx);
		$ID = explode(setting('AtpConfig.arrDelimeter'),$idx); //ID[0] = id_mengajar; ID[1]=rating_id; ; ID[2]=idx
		//test_result($ID);
		$parm['a.id'] = $ID[0];
		$subject = $this->mengajar->getAll($parm);
		$subject = (array_key_exists(0,$subject))?$subject[0]:[];
		$fields = $this->dconfig->Editfields;
		//unset($fields['idx']);

		//cari RS DATA
		$parm = [];
		$parm['id_mengajar'] = $ID[0];
		$parm['rating_id'] = $ID[1];
		$parm['idx'] = $ID[2];

		//$rsData = $this->model->find($parm)->toarray();
		$rsData = $this->model->where($parm)->asarray()->find();
		//$data=$this->data;
		$DATA = $this->data;
		$data['inputype'] = $DATA['inputype'];
		unset($DATA);
		$data['title']	= "Tambah Tujuan Pembelajaran";
		
		$data['error'] = [];
		$data['hidden']	= ['id_mengajar'=>$ID[0]];
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['rating_id']	= $this->ratingModel->getDropdown($subject['curr_id']);
		$data['rsdata'] = $rsData[0]; //['kode_ta'=>$ctp];
		$data['addONJs'] = setting('AtpConfig.addonJS');
		$data['rtarget']	= "#dtHistory";
		echo view($this->theme.'ajxform',$data);
	}

	function updateAction($idx) : RedirectResponse
	{
	//	$this->cekHakAkses('create_data');
		$idx = decrypt($idx);
		$ID = explode(setting('AtpConfig.arrDelimeter'),$idx); //ID[0] = id_mengajar; ID[1]=rating_id; ; ID[2]=idx
		//test_result($ID);
		
		$rules = $this->dconfig->rolesEdit;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();	
		//	test_result($data);
			$AtpModel = new ModelAtp();
			
			$parm['id_mengajar'] = $ID[0];
			$parm['rating_id'] = $ID[1];
			$parm['idx'] = $ID[2];
			$simpan = $AtpModel->Update(['atp'=>$data['atp']],$parm);
		
		//	$atpcp= new \Modules\Assessment\Entities\Atps();
		//	$atpcp->fill($data);
		//	$simpan = $AtpModel->insert($atpcp,false);		
			if($simpan){
				$this->session->setFlashdata('sukses', ' Data telah berhasil disimpan');
				show_alert("Data Berhasil disimpan","SUKSES");
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
				show_alert("Data Gagal disimpan","warning");
			}
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}	
	}

	function delete($ids){
		$idx = decrypt($ids);
		$ID = explode(setting('AtpConfig.arrDelimeter'),$idx); //ID[0] = id_mengajar; ID[1]=rating_id; ; ID[2]=idx
		$atpModel = new ModelAtp();
		$parm['id_mengajar'] = $ID[0];
		$parm['rating_id'] = $ID[1];
		$parm['idx'] = $ID[2];
		if($atpModel->remove($parm))
		{
			$this->session->setFlashdata('sukses','Data telah dihapus');
		}else{
			$this->session->setFlashdata('sukses','Data telah dihapus');
		}
		$uri = 'atp/show?ids='.encrypt($ID[0]);
		return redirect()->to(base_url($uri));
	}

	public function resetData($idm)
	{
		$id = decrypt($idm); 
		$atpModel = new ModelAtp();
		$atpModel->delete($id);
		$this->session->setFlashdata('sukses','Data telah direset');
		$uri = 'atp/show?ids='.$idm;
		return redirect()->to(base_url($uri));
	}

	function fromxlsx($idx=0){
		$idm = (isset($_GET['idm']))?$_GET['idm']:$idx; //ID Mengajar
		$data = $this->data;
		$data['title']	= "UPLOAD CAPAIAN PEMBELAJARAN";
		$data['error'] = validation_list_errors();
		$data['u_ri']  = base_url('atp/tempxls?idm='.$idm);
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
				$rcomName= $DCN['rcomName'];
				$mfields = $DCN['mfields'];
				
			//	show_result($DCN);
				//AMBIL BARIS PERTAMA TABEL NILAI
				$head=$worksheet->rangeToArray("A10:".$maxDataColumn."10",NULL,TRUE,TRUE,TRUE);
				$heads = $head[10];

				//cek kesesuaan judul dengan kebutuhan
				$fields=[]; $cnn=[]; $ncnn = 0;
				foreach($heads as $vh)
				{
					if(in_array($vh, $headName))
					{
						$fields[]=$rheadf[$vh];
					}
				}

				//ambil data 
				$rowIterator = $worksheet->getRowIterator(11, $maxDataRow-2);
				$rowData=[]; $r = 0; $rsData=[];
				foreach ($rowIterator as $row) {
					if ($row->isEmpty()) { // Ignore empty rows
						continue;
					}
					$r++;
					$columnIterator = $row->getCellIterator('A', $maxDataColumn);
					$i=0; $cellData['id_mengajar']=$idm; $idx = 1; //$cnn=[];
					foreach ($columnIterator as $cell) {
						$cellValue = $cell->getValue(); 
						$colData[$fields[$i]]=$cellValue;
						//cek ketersediaan CellValue di rcomName
						if(array_key_exists($cellValue, $rcomName))
						{
							$cellValue = $rcomName[$cellValue];
							$cnn = $cellValue;
							$$cnn[] = 1;
							$idx = count($$cnn);
						}
						$cellData[$fields[$i]]=$cellValue;
						$i++;
					}
					$cellData['idx']=$idx;
					$rsData[$r]	=$colData; //untuk ditampilkan pada tabel konfirmasi
					$rowData[$r]=$cellData; //untuk disimpan ke dalam database
				}
			
				$Data['actY'] = random_string('md5',32);
				$Data['actN'] = random_string('alnum',12);
				$Data['fields'] = $mfields;
				$Data['rsdata'] = $rsData;
				$Data['rowData'] = $rowData;
				$Data['idm'] = encrypt($idm);
				//Konfirmasi data
				$this->session->setTempdata('atp',$Data,120);
				return redirect()->to(base_url('atp/konfirm'));
	         }else{
				$this->session->setFlashdata('warning','The file has already been moved.');
				return redirect()->to(base_url('nilai'));
			 }
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	public function simpanmasal($act = 0) {
		$DATA = $this->session->getTempdata('atp');
		
		if($act === 0){
			//tampilkan ke browser
			$Data = $this->data;
			$data = array_merge($Data,$DATA);
			$data['title'] = "Konfirmasi Data!";
		//	test_result($data);
			echo view($this->theme.'list2konfirm',$data);
		}
		
		$uri = 'atp/show?ids='.$DATA['idm'];
		if($act === $DATA['actY']){
			$model = new ModelAtp();
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
			unset($_SESSION['atp']);
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
		$worksheet->setCellValue('A1', 'TEMPLATE UPLOAD CAPAIAN PEMBELAJARAN (CP/ATP)');
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
		
		$currID    = $subject['curr_id'];
		$DCN 	   = $this->_setNilai($currID);
		$mfields   = $DCN['mfields'];
		$headName  = $DCN['headName'];
		$headf	   = $DCN['headf'];
		$validList = $DCN['validList'];

		//TULIS KETERANGAN
		$worksheet->setCellValue('A9', 'Tuliskan setiap Alur Tujuan Pembelajaran dalam satu baris dengan singkat dan padat');
		$worksheet->getStyle('A9')->getFont()->setBold(true)
				  ->getColor()->setARGB('000080');
		
		//INPUT JUDUL TABEL
		$worksheet->fromArray($headName, null, 'A10');
		$ncol = count($headName);
		$colExc = colExcel();
		$endCol = $colExc[$ncol-1];
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

		//SET VALIDASI DATA pad Colom rating_id	
		$validCol = $colExc[$DCN['validColm']];

		$validation = $worksheet->getCell($validCol.'11')->getDataValidation();
		$validation->setType( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST );
		$validation->setErrorStyle( \PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION );
		$validation->setAllowBlank(false);
		$validation->setShowInputMessage(true);
		$validation->setShowErrorMessage(true);
		$validation->setShowDropDown(true);
		$validation->setErrorTitle('Input error');
		$validation->setError('Value is not in list.');
		$validation->setPromptTitle('PILIH DARI DAFTAR');
		$validation->setPrompt('Silakan Pilih dari Daftar yang tersedia.');
		$validation->setFormula1('"'.$validList.'"');
		$validation->setSqref($validCol.'11:'.$validCol.'18');

		//TULIS KETERANGAN KOMPONEN NILAI
		$hedRange = 'A18:'.$endCol.'18';
		$worksheet->getStyle($hedRange)->getFill()
				  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				  ->getStartColor()->setARGB('0000FF');

		$worksheet->setCellValue('A19', 'Silakan sisipkan baris secukpunya di atas warna BIRU, apabila baris yang tersedia kurang');
		$worksheet->getStyle('A19')->getFont()->setBold(true)
				  ->getColor()->setARGB('000080');

		//ATUR LEBAR KOLOM
		$pwidth = 17; $c = 0;
		foreach($mfields as $k =>$vl)
		{
			$col = $colExc[$c];
			$wdt = ($vl['width']/100)*$pwidth;
			$worksheet->getColumnDimension($col)->setWidth($wdt,'cm');
			$c++;
		}
		$nama_file = 'Temp_ATP_'.$subject['id']."-".$subject['subject_name'];
				
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($exc);
	    $writer->save($dirf.$nama_file.'.xlsx');
        return $this->response->download($dirf.$nama_file.'.xlsx', null);
	} 


	//PRIVATE AREA
	private function _setNilai($currID)
	{
		$mfields = setting('AtpConfig.fields');
		unset($mfields['idx']);
		
		//menyiapkan head dan headname 
		$headf=[]; $headName=[]; $rheadf=[]; $ncol=0; $vcol=0;
		foreach ($mfields as $k => $v){
			$headf[]=$k;
			$headName[]=$v['label'];
			$rheadf[$v['label']]=$k;
			if($k == 'rating_id'){$vcol = $ncol;}
			$ncol++;
		}

		$ratingModel = model(\Modules\Akademik\Models\RatingModel::class);
		$compNIlai = $ratingModel->asArray()->where(['curr_id'=>$currID, 'type_nilai'=>"NR", 'has_descript'=>1])->findAll();
		$CN = []; $validList=[];
		if($compNIlai){
			foreach($compNIlai as $cn)
			{
			//	$mfields[$cn['akronim']]=$nfield;
			//	$mfields[$cn['akronim']]['label'] = $cn['nm_komponen'];
				$CN[$cn['id']]['alias']=$cn['akronim'];
				$CN[$cn['id']]['label']=$cn['nm_komponen'];
				$rcomName[$cn['akronim']]=$cn['id'];
				$rcomName[$cn['nm_komponen']]=$cn['id'];
				$cnn_desc[]=$cn['akronim']."=".$cn['nm_komponen'];
				$validList[]=$cn['nm_komponen'];
			}
		}
		$CDN['mfields']  = $mfields;
		$CDN['headf']    = $headf;
		$CDN['rheadf']   = $rheadf;
		$CDN['rcomName'] = $rcomName;
		$CDN['headName'] = $headName;
		$CDN['CN'] 		 = $CN;
		$CDN['cnn_desc'] = implode(", ",$cnn_desc);
		$CDN['validList']= implode(", ",$validList);
		$CDN['validColm']= $vcol;
		return $CDN;
	}
}
