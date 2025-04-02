<?php

namespace Modules\Register\Controllers;

use Modules\Register\Controllers\Enrollment;
use CodeIgniter\HTTP\ResponseInterface;

class Enroll extends Enrollment
{
    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $this->addNew();
    }

    public function addByGroupView()
    {
        $data = $this->data;
        $data['title']	= "Register Data Siswa Bergrup";
        $data['error'] = validation_list_errors();
        $data['u_ri']  = base_url('enroll/tempgroup');
        echo view($this->theme.'frmImport',$data);
    }

    public function addByGroupAcction()//: RedirectResponse
    {
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
				
			//	$myconfig = new MyApp;
				$dirf = setting('MyApp.tmpfile_dir');
				$filepath =setting('MyApp.tmpfile_dir');
				
				//echo $type; 
				$xlsx->move($filepath, $newName);
				
				$inputFileName = $filepath.$newName;
				
				//MEMBUKA FILE EXCEL
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
				$reader->setReadDataOnly(TRUE);
                $reader->setLoadSheetsOnly(["Worksheet"]);
				$spreadsheet = $reader->load($inputFileName);
				//MEMBUKA WORKSHEET
				$worksheet = $spreadsheet->getActiveSheet();
				
				//AMBIL IDENTITAS GRUP
				$CORP['id'] 	= $worksheet->getCell('B3')->getValue();
				$CORP['name'] 	= $worksheet->getCell('B4')->getValue();
				$CORP['cp'] 	= $worksheet->getCell('B5')->getValue();
				$CORP['address']= $worksheet->getCell('B6')->getValue();
				$CORP['prodi']	= $worksheet->getCell('B7')->getValue();

				//PERSIAPAN PEMBUATAN NOMOR INDUK
				//ambil data prodi dan ambil data nomor urut siswa di sistem
				$CORP['tgl_reg'] = date("Y-m-d");
				$thn= unix2Ind(strtotime($CORP['tgl_reg']),'Y');

				$ProdiModel = model(\Modules\Akademik\Models\ProdiModel::class);
				$SiswaModel = model(\Modules\Siswa\Models\SiswaModel::class);
				$ps = $ProdiModel->find($CORP['prodi'])->toarray();
				
				$param['tgl_reg >']=strtotime("01-01-".$thn. "00:00:00");
				$param['prodi']=$CORP['prodi'];

				$no=$SiswaModel->getOrder($param);
				$jur = $ps['jurusan'];
				$lv = $ps['jenjang'];
			//	test_result($no);
				$th = unix2Ind(strtotime($CORP['tgl_reg']),'y');
				//ambil baris data

				$maxDataRow = $worksheet->getHighestDataRow();
				$maxDataColumn = $worksheet->getHighestDataColumn();

				//AMBIL BARIS PERTAMA TABEL
				$head=$worksheet->rangeToArray("A14:".$maxDataColumn."14",NULL,TRUE,TRUE,TRUE);
				$heads = $head[14];
                
				//cek kesesuaian judul dengan kebutuhan
                $headField = setting('Siswa.fields');
				$rfields = $this->revFields($headField);
				$headName = array_keys($rfields);
				$fields=[]; 
				foreach($heads as $vh)
				{
					if(in_array($vh, $headName))
					{
						$fields[]=$rfields[$vh];
						$headField[$rfields[$vh]]['width']=10;
					}
				}

				//ambil data 
				$rowIterator = $worksheet->getRowIterator(15, $maxDataRow);
				$rowData=[]; $r = 0; $rsData=[];
				foreach ($rowIterator as $row) {
					if ($row->isEmpty()) { // Ignore empty rows
						continue;
					}
					$NoUrut = $no + $r;
					$r++;
					$columnIterator = $row->getCellIterator('A', $maxDataColumn);
					$cellData=[]; $i=0; //$data['id_mengajar']=$idm;
					foreach ($columnIterator as $cell) {
						// Do something with the cell here.
						$cellValue = $cell->getValue();
						$fd = $fields[$i];
						$cellData[$fields[$i]]=$cellValue;
						$i++;
					}
					$cellData['sumber_info']=$CORP['id'];
					$cellData['idreg']=register($CORP['tgl_reg']);
					$NOINDUK = $jur.$lv.$th.sprintf("%02d",$CORP['prodi']).sprintf("%03d",$NoUrut).random_string('numeric',1);
					$cellData['no_urt'] =$NoUrut;
					$cellData['noinduk']=$NOINDUK;
					$cellData['prodi']	=$CORP['prodi'];
					$cellData['nm_prodi']	=$CORP['prodi'];
					$cellData['tgl_reg']= strtotime($CORP['tgl_reg']);
					$cellData['tgllahir']= tglfromxlsx($cellData['tgllahir']);
					$rsData[$r]=$cellData;
				}
				$headField['idreg']['width']=10;
			//	$headField['noinduk']['width']=10;
				$Data['actY'] = random_string('md5',32);
				$Data['actN'] = random_string('alnum',12);
				$Data['fields'] = $headField;
				$Data['rsdata'] = $rsData;
				$Data['rowData'] = $rsData;
				$Data['corp'] = $CORP;

				//Konfirmasi data
				$this->session->setTempdata('dtpdgrup',$Data,120);
				return redirect()->to(base_url('enroll/konfirm'));
	         }else{
				$this->session->setFlashdata('warning','The file has already been moved.');
				return redirect()->to(base_url('enroll'));
			 }
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
    }

	public function simpanmasal($act = 0) {
		$DATA = $this->session->getTempdata('dtpdgrup');
		if(is_null($DATA))
		{
			$this->session->setFlashdata('warning','INVALID REQUEST.');
			return redirect()->to(base_url());
		}

		if($act === 0){
			//tampilkan ke browser
			$Data = $this->data;
			unset($Data['fields']);
			
			$data = array_merge($Data,$DATA);
		//	test_result($data);
			$data['title'] = "Konfirmasi Data!";
			echo view($this->theme.'list2konfirm',$data);
		}
		
		if($act === $DATA['actY']){
			//memilah data untuk dimasukkan ke sistem:
			$rdata = $DATA['rsdata'];

			//kebutuhan data untuk DATADIK dan SISWA
			$dtdikf= ['nik', 'idreg', 'nama', 'nisn', 'tempatlahir', 'tgllahir', 'jk', 'alamat', 'nohp', 
					  'nama_ayah', 'nama_ibu', 'alamat_ortu', 'nohp_ayah', 'nohp_ibu', 'sumber_info'];
			$siswaf = [
					'noinduk', 'nik', 'prodi', 'no_ijazah', 'tgl_ijazah', 'tgl_diterima', 'tgl_reg', 'no_urt'
					];
			$rsData = [];
			foreach($rdata as $data)
			{
				//mengambil data field datadik
				$datadik=[];
				foreach($dtdikf as $k)
				{
					$datadik[$k]=$data[$k];
				}
				
				$dtreg=[];
				foreach($siswaf as $k)
				{
					$dtreg[$k]=$data[$k];
				}
				$DaTa['datadik']=$datadik;
				$DaTa['dtreg']=$dtreg;
				$rsData[]=$DaTa;
			}
		//	test_result($rsData);
			//MENYIMPAN DATA	
			$siswamodel = new \Modules\Siswa\Models\SiswaModel();
			$simpan = $siswamodel->batchSaving($rsData);
			
			if($simpan){
				//jika data berhasil disimpan, persiapan pembuatan billing
				$CID = $DATA['corp'];
				$corpModel = new \Modules\Billing\Models\CorpModel();
				$isexist = $corpModel->find($CID['id']);
				
				if(is_null($isexist))
				{
					$crs = ['id'=>$CID['id'], 'corporate_name'=>$CID['name'], 'contact_person'=>$CID['cp'], 'address'=>$CID['address']];
					$corpbill = new \Modules\Billing\Entities\Corp();
					$corpbill->fill($crs);
					$simpan = $corpModel->insert($corpbill,false);
				}
				$this->session->setFlashdata('sukses','Data telah berhasil disimpan');
			}else{
				$this->session->setFlashdata('warning','Data gagal disimpan');
			}
			return redirect()->to(base_url('enrollment'));
		}
		
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
		
        $headField = setting('Siswa.fields');
        unset($headField['idreg']); //hapus idreg karena di generate by sistem
        unset($headField['state']); //hapus state karena belum di generate
        unset($headField['nm_prodi']); 
        $COLEXL = colExcel();
        
        //mengatur lebar kolom dan menentukan judul kolom
        $c=0; $headName = [];
        foreach($headField as $k =>$fn)
        {
            $l = $fn['width'];
        //    $cw = ((int)$l < 1)?183:$l * 25;
            $cw = 16 ; //lebar dibuat sama 
            $worksheet->getColumnDimension($COLEXL[$c])->setWidth($cw); //mengatur lebar kolom
            $headName[$c]=$fn['label'];
            $c++;
        }
		
		$worksheet->setCellValue('A1', 'REGISTRASI PESERTA DIDIK');
		
		$dirf = setting("MyApp.tmpfile_dir");
		
		$filepath = setting("MyApp.tmpfile_dir");
		
        $kodex = strtoupper(random_string("alnum",6));
		 
		$judul = [
			['Kode Grup:',$kodex],
			['Grup Name:',"Isikan dengan Nama Lembaga"],
			['Contact Person:', "Isikan dengan nama Penanggung Jawab"],
			['Alamat :', "Isi dengan alamat Lembaga"],
			['Program :', "Isi Dengan Kode Program"],
		];
		
		$worksheet->fromArray($judul, null, 'A3');
		$worksheet->getStyle('B3:B6')
				  ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		$worksheet->getStyle('B3:B3')->getFont()->setBold(true)
				  ->getColor()->setARGB('8B0000');
		//TAMBAHKAN PETUNJUK PENGISIAN:
		$Notes = [
		    ["PETUNJUK :"],
		    ["1. Mohon Untuk Tidak Merubah Posisi Kolom maupun baris"],
		    ["2. Isikan kolom PROGRAM dengan Kode Program sebagaimana terdaftar pada sheet berikutnya"],
		    ["3. Gunakan Format ini hanya untuk 1 (satu) angkatan dan sama untuk semua gelombang"],
		    ["4. Pastikan bahwa semua gelombang dalam angkatan yang sama menggunakan kode Grup YANG SAMA"],
		];
		$worksheet->fromArray($Notes, null, 'A9');
		$worksheet->getStyle('A9:A13')->getFont()->setBold(true)
				  ->getColor()->setARGB('000080');
		
		//INPUT JUDUL TABEL
		//$headName = array_keys($rfields);
		$worksheet->fromArray($headName, null, 'A14');
		$ncol = count($headName);
	
		$endCol = colExcel()[$ncol-1];
		$hedRange = 'A14:'.$endCol.'14';
		$worksheet->getStyle($hedRange)->applyFromArray($styleArray)
				  ->getFont()->setBold(true);
		$worksheet->getStyle($hedRange)
				  ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
		$worksheet->getStyle($hedRange)
				  ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$worksheet->getStyle($hedRange)->getFill()
				  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				  ->getStartColor()->setARGB('C0C0C0');
              
        //TAMBAHKAN WORKSHEET
        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($exc, 'Kode Program');
        $exc->addSheet($myWorkSheet, 1);
        $worksheet2 = $exc->setActiveSheetIndex(1);
        
        $worksheet2->getColumnDimension("A")->setWidth(10); //mengatur lebar kolom
        $worksheet2->getColumnDimension("B")->setWidth(42); //mengatur lebar kolom
        $worksheet2->setCellValue('A1', 'DAFTAR KODE PROGRAM');
        $worksheet2->getStyle('A1')->getFont()->setBold(true);
        $headCode =['Kode', 'Nama Program'];
        $worksheet2->fromArray($headCode, null, 'A3');

        //mengisikan data kode
        $PSM = model(\Modules\Akademik\Models\ProdiModel::class);
        $PS = $PSM->getDropdown();
        
        $dtCol = [];
        foreach($PS as $k=> $ps)
        {
            $dtCol[] = [$k, $ps];
        }
        
        $worksheet2->fromArray($dtCol, null, 'A4');

		$hedRange = "A3:B3";
        $dtRange = "A4:B".count($dtCol);
        $worksheet2->getStyle($hedRange)->applyFromArray($styleArray)
				  ->getFont()->setBold(true);
		$worksheet2->getStyle($hedRange)
				  ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
		$worksheet2->getStyle($hedRange)
				  ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$worksheet2->getStyle($hedRange)->getFill()
				  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				  ->getStartColor()->setARGB('C0C0C0');
                  $worksheet2->getStyle($hedRange)->applyFromArray($styleArray);

        $worksheet->getStyle('A1')->getFont()->setBold(true);
		$nama_file = 'FORM_DATA_PD';		
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($exc);
	    $writer->save($dirf.$nama_file.'.xlsx');
        return $this->response->download($dirf.$nama_file.'.xlsx', null);
	}

    protected function revFields($hField, $key='label')
	{
		$rev=[];
		foreach($hField as $k=>$A)
		{
			$rev[$A[$key]] = $k;
		}
        return $rev; 
	}
}
