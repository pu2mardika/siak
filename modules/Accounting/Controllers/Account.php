<?php

namespace Modules\Account\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use Modules\Account\Models\AccountModel;
use Modules\Account\Models\AkungrupModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;

class Account extends BaseController
{
    public  $keys='';
	protected $dconfig;
	protected $session;
	protected $theme;
	protected $model;
	protected $grupModel ;
	
    function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Account\Config\Account::class);
        $this->session = \Config\Services::session();
		$this->model = new AccountModel;	
		$this->grupModel = model('Modules\Account\Models\AkungrupModel');
		$this->data['site_title'] = 'Manajemen Data Account';
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->data['opsi'] 	  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
	//	$this->theme = $this->data[]
		helper(['cookie', 'form','date']);
	//	$this->addJs (base_url().'/js/modules/account.js?r=' . time());
		$this->addJs (base_url().'/js/jquery.easy-autocomplete.min.js?r=' . time());
	//	$this->addJs (base_url().'/js/modules/account.js?r=' . time());
    }
	
	function index()
	{
	//	$this->cekHakAkses('read_data');
		$dtaccount = $this->model->orderBy('kode_akun', 'ASC')->findAll();
//	$dtaccount=[];
	//	test_result($dtaccount);
	//	$dtaccount = $this->model->getall($parm);
		$data = $this->data;
		$data['title']	= "Manajemen Data Account";
		$data['rsdata']	= $dtaccount;
		$data['msg'] 	= "";
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['grup_akun'] 	= $this->grupModel->getDropdown();
		$data['actions']= $this->dconfig->actions;
		$data['allowimport']= $this->dconfig->importallowed;
		echo view($this->theme.'datalist',$data);
    }
	
	function detail($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$data=$this->data;
		$data['title']	= "Update Data Account";
		$data['error'] = validation_list_errors();
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['grup_akun'] 	= $this->grupModel->getDropdown();
		$rs =  $this->model->find($id);
		$tglLahir = $rs->tgllahir;
		$rsdata = $rs->toarray();
		//$rsdata['tgllahir']=$tglLahir->toDateTimeString();
		$rsdata['tgllahir']=$tglLahir->toDateString();
		$data['rsdata'] = $rsdata;
	//	show_result($rsdata);
		echo view($this->theme.'vdetail',$data);
	}
	
	
	function addView()
	{
		$this->cekHakAkses('create_data');	
		$data	=$this->data;
		
		$data['title']	= "Tambah Data Account";
		$fields = $this->dconfig->fields;
		$data['error'] = [];
		$data['fields'] = $fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['grup_akun'] 	= $this->grupModel->getDropdown();
		$data['rsdata'] = [];
		//$data['addONJs'] = "account.init()";
		//test_result($data);
		echo view($this->theme.'form',$data);
	}
	
	public function addAction(): RedirectResponse
	{
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$accountmodel = new AccountModel();
			//test_result($data);
			$account= new \Modules\Account\Entities\Account();
			$account->fill($data);
			$simpan = $accountmodel->insert($account,false);
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('akun'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function updateView($ids)
	{
		$this->cekHakAkses('update_data');
		$id = decrypt($ids); 
		$roles = $rules = $this->dconfig->roleEdit;
		$data=$this->data;
		$data['title']	= "Update Data Account";
		$data['error'] = [];
		$data['fields'] = $this->dconfig->fields;
		$data['opsi'] 	= $this->dconfig->opsi;
		$data['opsi']['grup_akun'] 	= $this->grupModel->getDropdown();
		$rs =  $this->model->find($id)->toarray();
		$data['rsdata'] = $rs;
		$data['addONJs'] = "account.init()";
		echo view($this->theme.'form',$data);
		
	}
	
	public function updateAction($ids)
	{
		$rules = $this->dconfig->roles;
		if ($this->validate($rules)) {
			$data = $this->request->getPost();
			$accountmodel = new AccountModel();
			$id = decrypt($ids); 
			$account= new \Modules\Account\Entities\Account();
			$account->fill($data);
			$simpan = $accountmodel->update($id, $account);
			 
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil diperbaharui');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('akun'));
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	function delete($ids){
		$id = decrypt($ids); 
		$accountmodel = new AccountModel();
		$accountmodel->delete($id);
		// masuk database
		$this->session->setFlashdata('sukses','Data telah dihapus');
		return redirect()->to(base_url('akun'));
	}
	
	function importView()
	{
		$data = $this->data;
		$data['title']	= "Import Data Account";
		$data['error'] = validation_list_errors();
		$data['u_ri']  = base_url('akun/tempxls');
		echo view($this->theme.'frmImport',$data);
	}

	function importAction(): RedirectResponse
	{
		$this->cekHakAkses('create_data');
		helper('text');
		$validationRule  =[
			'userfile' => ['uploaded[userfile]'],
		];
		
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
				//MEMBUKA WORKSHEET
				$worksheet = $spreadsheet->getActiveSheet();
				
				//ambil data
				$maxDataRow = $worksheet->getHighestDataRow();
				$maxDataColumn = $worksheet->getHighestDataColumn();

				//AMBIL BARIS PERTAMA TABEL NILAI
				$head=$worksheet->rangeToArray("A10:".$maxDataColumn."10",NULL,TRUE,TRUE,TRUE);
				$heads = $head[10];
		 
				//cek kesesuaan judul dengan kebutuhan
				$rfields = $this->dconfig->revAkunFields();
				$headName = array_keys($rfields);
				$fields=[]; 
				foreach($heads as $vh)
				{
					if(in_array($vh, $headName))
					{
						$fields[]=$rfields[$vh];
					}
				}

				//ambil data 
				$rowIterator = $worksheet->getRowIterator(11, $maxDataRow);
				$rowData=[]; $r = 0; $rsData=[];
				foreach ($rowIterator as $row) {
					if ($row->isEmpty()) { // Ignore empty rows
						continue;
					}
					$r++;
					$columnIterator = $row->getCellIterator('A', $maxDataColumn);
					$cellData=[]; $i=0; $data['id_mengajar']=$idm;
					foreach ($columnIterator as $cell) {
						// Do something with the cell here.
						$cellValue = $cell->getValue();
						$fd = $fields[$i];
						$cellData[$fields[$i]]=$cellValue;
						$i++;
					}
					$rsData[$r]=$cellData;
				}
			//	test_result($rowData);
				$Data['actY'] = random_string('md5',32);
				$Data['actN'] = random_string('alnum',12);
				$Data['fields'] = $mfields;
				$Data['rsdata'] = $rsData;
				$Data['rowData'] = $rsData;
				
				//Konfirmasi data
				$this->session->setTempdata('dtaccount',$Data,120);
				return redirect()->to(base_url('akun/konfirm'));
	         }else{
				$this->session->setFlashdata('warning','The file has already been moved.');
				return redirect()->to(base_url('nilai'));
			 }
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}
	
	public function simpanmasal($act = 0) {
		$DATA = $this->session->getTempdata('dtaccount');
		//test_result($Data);
		//$nilai $act = nol
		if($act === 0){
			//tampilkan ke browser
			$Data = $this->data;
			$data = array_merge($Data,$DATA);
			$data['title'] = "Konfirmasi Data!";
		//	test_result($data);
			echo view($this->theme.'list2konfirm',$data);
		}
		
		if($act === $DATA['actY']){
			$model = new AccountModel();
			$simpan = $model->insertBatch($DATA['rsdata']);
			
			if($simpan){
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('akun'));
		} 
		
		//$nilai $act = nol
		if($act === $DATA['actN']){
			//hapus data dari sesi
			unset($_SESSION['dtaccount']);
			$this->session->setFlashdata('warning','Data Dibatalkan oleh Pengguna');
			return redirect()->to(base_url('akun'));
		}
	}
	
	function tmpobyek()
	{
		$exc= new \PhpOffice\PhpSpreadsheet\Spreadsheet();

		$myconfig = new MyApp;
		$exc->getProperties()
			->setCreator(setting('MyApp.appName'))
			->setLastModifiedBy(setting('MyApp.appName')." Ver ".setting('MyApp.appVerison'))
			->setDescription(setting('MyApp.siteName'));
		
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
		$worksheet->getColumnDimension('B')->setWidth(270, 'px');
		$worksheet->getColumnDimension('C')->setWidth(120, 'px');
		$worksheet->getColumnDimension('D')->setWidth(120, 'px');
		$worksheet->setCellValue('A1', 'DAFTAR PERKIRAAN BUKU BESAR (ACCOUNT LIST)');
		$worksheet->getStyle('A1')->getFont()->setBold(true);
		
		$dirf = $myconfig ->tmpfile_dir;
		
		$filepath = $this->myconfig->tmpfile_dir;
		$headf = [];
		
		//show_result($ids);
		$judul = [
			['Company Name', setting('MyApp.companyName')],
			['Alamat', setting('MyApp.address1')],
			['Website', setting('MyApp.website')],
		];
		
		$worksheet->fromArray($judul, null, 'A3');
		$worksheet->getStyle('B3:B5')
				  ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		
		//TAMBAHKAN PETUNJUK PENGISIAN:
		$Notes = [
		    ["Petunjuk Pengisian :"],
		    ["1. Isikan Kolom Kelompok Akun sesuai dengan data pada Group Account"],
		    ["2. Isikan Saldo Normal dengan : Db untuk Saldo Normal di Sisi Debet, atau Kr untuk Saldo Normal di Sisi Kredit"]
		];
			$worksheet->fromArray($Notes, null, 'A7');
		$worksheet->getStyle('A7:A9')->getFont()->setBold(true)
				  ->getColor()->setARGB('000080');
		
			
		//INPUT JUDUL TABEL
		$rfields = $this->dconfig->revAkunFields();
		$headName = array_keys($rfields);
		$worksheet->fromArray($headName, null, 'A10');
		$ncol = count($headName);
	
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
	
		$nama_file = 'TMPAKUN_LIST';		
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($exc);
	    $writer->save($dirf.$nama_file.'.xlsx');
        return $this->response->download($dirf.$nama_file.'.xlsx', null);
	}
}