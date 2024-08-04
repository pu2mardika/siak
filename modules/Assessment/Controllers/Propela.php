<?php

namespace Modules\Assessment\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Events\Events;
use Modules\Tp\Models\TpModel;
use Modules\Room\Models\RombelModel;
use Modules\Assessment\Models\NilaiDeskModel;
use Config\Services;
use CodeIgniter\Files\File;
use Config\MyApp;
define('EVENTADD', 'AD102');
define('EVENTUPD', 'UP201');

class Propela extends BaseController
{
   function __construct() {
        parent::__construct();
        $this->dconfig = config(\Modules\Assessment\Config\PropelaConf::class);
        $this->session = \Config\Services::session();
		$this->model = new NilaiDeskModel;	
        $this->propModel = model(\Modules\Project\Models\SkenModel::class); 	
		$this->rombelModel = model(\Modules\Room\Models\RombelModel::class); 	
		$this->mapModel = model(\Modules\Project\Models\mappingModel::class);
		$this->data['site_title'] = 'Assessment';
		$this->opsi 	  		  = $this->dconfig->opsi;
		$this->data['key']		  = $this->dconfig->primarykey;
		$this->data['fields'] 	  = $this->dconfig->fields;
		$this->DELIMETER 		  = $this->dconfig->arrDelimeter;
		$this->ADMARK			  = $this->dconfig->addMark;
		$this->ADMARKDSC		  = $this->dconfig->addMarkDsc;

		helper(['cookie', 'form','date', 'html', 'text']);
		$this->addStyle (base_url().'css/personal.css?r=' . time());

		//HAPUS DATA breadcrumb
		if(isset($_GET['ids'])){
			$breadcrumb = $this->data['breadcrumb'];
			$modul = $this->data['current_module'];
			$URI = $breadcrumb[$modul['judul_module']];
			$breadcrumb[$modul['judul_module']]=$URI."?ids=".$_GET['ids'];
			$this->data['breadcrumb']=$breadcrumb;
		}
    }

	public function index()
    {
        if (isset($_GET['ids'])) 
		{
			$ids = $_GET['ids'];
		}else{
			$this->session->setFlashdata('warning','Data gagal Ditampilkan');
			return redirect()->to(base_url('nilai'));
		}
		$DELIMETER = $this->DELIMETER;

		$IDN = decrypt($ids);
		$IDX = (is_hex($IDN))?decrypt($IDN):$IDN;
		$ID = explode($DELIMETER,$IDX); //$ID[0] = RoomID ; $ID[1]=SUBGRADE
	//	test_result($ID);
		//ambil data rombel
		$room = $this->rombelModel->get(['a.id'=>$ID[0]]);
	//	show_result($room);
		//RESUME
		$ResFields = $this->dconfig->ResumeFields;
	//	unset($ResFields['nama_project']);
		unset($ResFields['deskripsi']);

		$resume['field']= $ResFields;
		$resume['data'] = $room;
		$resume['subtitle'] = "Nilai Project : ".$room['nama_rombel'];
		$data = $this->data;
		$data['resume'] = $resume;

		//ambil data project berdasarkan roombel
		$project = $this->propModel->getsAll(['a.room_id'=>$ID[0]]);
		 
	//	show_result($project);
		$mapProject = $this->mapModel->getsAll(['d.curr_id'=>$room['curr_id']]);
	//	test_result($mapProject);
		$EPROJ = []; $TPROJ=[];
		foreach($mapProject as $p)
		{
			$EPROJ[$p['project_id']][$p['nama_dimensi']][]=$p['elemen'];
		}

		$rsData = []; 
		$attributes = [
			'class' => 'boldlist',
			'id'    => 'mylist',
		];
		
		foreach($project as $p)
		{
			$el = $EPROJ[$p['project_id']];
			$p['elemen']=ul($el,$attributes);
			$p['ids']=encrypt($ID[0].$DELIMETER.$ID[1].$DELIMETER.$p['project_id']);
			$rsData[$p['project_id']]=$p;
		}
	//	test_result($rsData);
	//	$data['addOnACt'] = $this->dconfig->detAddOnACt;
		$act = $this->dconfig->actions;
		$data['rsdata']	= $rsData;
		$data['msg'] 	= "";
		$data['isplainText'] = false;
		$data['dataTable'] = false;
		$data['keys'] 	= $this->dconfig->primarykey;
		$data['key'] 	= 'ids';
		$data['opsi']   = setting()->get('Siswa.opsi');
		$act = $this->dconfig->detAddOnACt;
	//	$src = $act['add']['src'].$ids."&pid=";
	//	$act['add']['src']=$src;
		$data['addOnActDet']= $act;
	//	$data['addOnACt']= $addOnAct;
		echo view($this->theme.'frmdatalist',$data);				
    }

    public function showPD()
    {
        //membutuhkan ROOMID, SUBGRADE, SUBGRADE
		//if (isset($_GET['ids']) && isset($_GET['pid'])) 
		if (isset($_GET['ids'])) 
		{
			$tmps = decrypt($_GET['ids']);
			$ids = (is_hex($tmps))?decrypt($tmps):$tmps;
		}else{
			$this->session->setFlashdata('warning','Data gagal Ditampilkan');
			return redirect()->to(base_url('nilai'));
		}
		$tmp = (is_hex($tmps))?$tmps:encrypt($tmps);
		$ID = explode($this->DELIMETER,$ids); //$ID[0] = RoomID ; $ID[1]=SUBGRADE; $ID[2] = project_id
		$pid = $ID[2];
		$ADMARK = $this->ADMARK;

		$room = $this->rombelModel->get(['a.id'=>$ID[0]]);
		$ProJModel = model(\Modules\Project\Models\DataProjectModel::class);
		$P = $ProJModel->find($pid);
		//test_result($P);

		//$room['nama_project'] = $P->nama_project;
		$room['deskripsi'] = $P->deskripsi;
		//RESUME
		$resume['field']= $this->dconfig->ResumeFields;
		$resume['data']= $room;
		$resume['subtitle'] = "Nilai Project : ".$P->nama_project;
		$data = $this->data;
		$data['resume'] = $resume;

		$opsi = $this->opsi;
		$mark = $opsi['nilai_huruf'];

		//ambil data anggota rombel dan nilai yang dimiliki
		$MemberModel = model(\Modules\Room\Models\MemberModel::class); 
		$pd = $MemberModel->getAll(['a.roomid'=>$ID[0]]);
		
		//ambil rating model yang merupakan data project menjadi komponen nilai
		$mfields = setting('LogNilai.markFields');
		$nfield = $mfields['nilai'];
		$colWidth = $mfields['nilai']['width'];
		unset($mfields['nilai']);

		$mapProject = $this->mapModel->getsAll(['d.curr_id'=>$room['curr_id'], 'a.project_id'=>$pid]);
	//	test_result($mapProject);
		$CN =[];
		foreach($mapProject as $P)
		{
			$CN[$P['id']]['tujuan']=$P['tujuan'];
			$CN[$P['id']]['deskripsi']=$P['deskripsi'];
		}
		$AddMarkDesc = $this->dconfig->addMarkDsc;
		$CN[$ADMARK]['tujuan']=$AddMarkDesc;
	//	test_result($CN);
	//	detail nilai
		$nilai = $this->model->getsNilai(['a.idx'=>$pid, 'b.roomid'=>$ID[0] ]);
	//	show_result($nilai);
		
		//generate nilai untuk masing-masing PD
		$Nilai = []; $cnnFd=[];
		foreach($nilai as $N)
		{
		//	$Nilai[$N['member_id']][$N['rating_id']]=$mark[$N['nilai']];
			$dmark = (array_key_exists($N['nilai'], $mark))?$mark[$N['nilai']]:character_limiter($N['nilai'],40);
			$Nilai[$N['member_id']][$N['rating_id']]=$dmark;
		}
	//	show_result($Nilai);
		
		$datastate = (count($Nilai)==0)?0:1;

		$based=(count($CN)>0)?count($CN):1;
		$w= floor($colWidth/$based);
		foreach($CN as $k =>$fdv)
		{
			//tetapkan judul $mfields baru
			$dfield['label']=$fdv['tujuan'];
			$dfield['width']=$w;
			$dfield['type'] ="disp";
		//	show_result($dfield);
			$mfields[$k]=$dfield;
			$defNilai[$k]="";
		}
	//	test_result($mfields);
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
	//	$data['keys'] 	= $this->dconfig->primarykey;
		$PanelAct = $this->dconfig->condActions;
		foreach($PanelAct[$datastate] as $k => $act)
		{
			$src = $act['src'];
			$PanelAct[$datastate][$k]['src'] = $src.$tmp;
		}
		$data['condAddOnAct'] = $PanelAct;
		$data['dataStated'] = $datastate;
		
	//	test_result($PanelAct);
		echo view($this->theme.'frmdatalist',$data);
    }

	function fromxlsx(){
		if (isset($_GET['ids'])) 
		{
			$ids = $_GET['ids'];
		}else{
			$this->session->setFlashdata('warning','Data gagal Ditampilkan');
			return redirect()->to(base_url('nilai'));
		}
		
		$data = $this->data;
		$data['title']	= "UPLOAD NILAI";
		$data['hidden']	= ['ids'=>$ids, 'pids'=>encrypt(EVENTADD)];
		$data['error'] = validation_list_errors();
		$data['u_ri']  = base_url('propela/tempxls?ids='.$ids);
		echo view($this->theme.'frmImport',$data);
	}

	function updatexlsx(){
			if (isset($_GET['ids'])) 
			{
				$ids = $_GET['ids'];
			}else{
				$this->session->setFlashdata('warning','Data gagal Ditampilkan');
				return redirect()->to(base_url('nilai'));
			}
			
			$data = $this->data;
			$data['title']	= "UPLOAD NILAI";
			$data['hidden']	= ['ids'=>$ids, 'pids'=>encrypt(EVENTUPD)];
			$data['error'] = validation_list_errors();
			$data['u_ri']  = base_url('propela/tempxls?ids='.$ids);
			echo view($this->theme.'frmImport',$data);
		}

	function tmpobyek()
	{
		if (isset($_GET['ids'])) 
		{
			$ids = decrypt($_GET['ids']);
		//	$ids = $_GET['ids'];
		}else{
			$this->session->setFlashdata('warning','Data gagal Ditampilkan');
			return redirect()->to(base_url('nilai'));
		}
	//	test_result($ids);
		$ID = explode($this->DELIMETER,$ids); //$ID[0] = RoomID ; $ID[1]=SUBGRADE ; $ID[2] = Project_ID
		$RID = $ID[0]; $SG = $ID[1] ; $PID = $ID[2];

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
		
		$worksheet->getColumnDimension('A')->setWidth(12);
		$worksheet->getColumnDimension('B')->setWidth(12);
		$worksheet->getColumnDimension('C')->setWidth(36);
		$worksheet->getColumnDimension('D')->setWidth(20);
		$worksheet->setCellValue('A1', encrypt($RID));
		$worksheet->setCellValue('B1', 'TEMPLATE UPLOAD NILAI PROPELA');
		$worksheet->getStyle('A1')->getFill()
				  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				  ->getStartColor()->setARGB('000000');
		$worksheet->getStyle('B1')->getFont()->setBold(true);

		//input identitas showMapel
		
		$dirf = $myconfig ->tmpfile_dir;
		
		$filepath = $this->myconfig->tmpfile_dir;
		
		//MENYIAPKAN DATA
	//	$parm['a.id'] = $ids;
		$room = $this->rombelModel->get(['a.id'=>$RID]);
		$ProModel = model(\Modules\Project\Models\DataProjectModel::class);
		$project = $ProModel->find($PID)->toarray();

	//	test_result($room);
		$judul = [
			[encrypt($PID), $project['nama_project']],
			['Deskripsi', $project['deskripsi']],
			['Rombel', $room['nama_rombel']],
			['Semester',$SG]
		];
		
		$worksheet->fromArray($judul, null, 'A3');
		$worksheet->setCellValue('A7', '(Jangan Merubah Data Project)');
		$worksheet->getStyle('A7')->getFont()->setBold(true)
				  ->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
		$worksheet->getStyle('A3')->getFill()
				  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				  ->getStartColor()->setARGB('000000');
		$worksheet->getStyle('B3:B6')
				  ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		
		//TULIS KETERANGAN KOMPONEN NILAI DAN JENIS NILAI
		//ambil rating model yang merupakan data project menjadi komponen nilai
		$mfields = setting('LogNilai.markFields');
		$nfield = $mfields['nilai'];
		$colWidth = $mfields['nilai']['width'];
		unset($mfields['nilai']);
		
		$headf[]='id'; $headName[]="Member ID";
	//	$rheadf['Member ID']='member_id';
		foreach($mfields as $k =>$mf)
		{
			$headf[]=$k;
			$headName[] = $mf['label'];
		}

		$mapProject = $this->mapModel->getsAll(['d.curr_id'=>$room['curr_id'], 'a.project_id'=>$PID]);
	//	test_result($mapProject);
		$KET=[];
		foreach($mapProject as $P)
		{
			$headName[]=$P['id'];
			$Ket[]=[$P['id'],$P['tujuan']];
		}

		//tambahan untuk Catatan Proses:
		$headf[] = $this->ADMARK;
		$headName[]=$this->ADMARKDSC;
		$Ket[]=["Catatan Proses sebanyak Satu Paragraf (maks: 250 Karakter)",""];

		$sRow = count($Ket) + 10 + 3;
		$jket =[$sRow,"KETERANGAN KOMPONEN NILAI"];
		$worksheet->fromArray($jket, null, 'A9');
		$worksheet->fromArray($Ket, null, 'A10');
		$worksheet->getStyle('A9:B9')->getFont()->setBold(true)
				  ->getColor()->setARGB('000080');
		$worksheet->getStyle('A9')->getFill()
				  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
				  ->getStartColor()->setARGB('000000');
		$nRows = count($Ket) + 10 + 1;
		$ncell = "A".$nRows;
		//Jenis Nilai
		$OPSI = $this->dconfig->opsi;
		$Desc = $OPSI['descNilai'];
		$text = "Jenis Nilai: ".implode(", ",$Desc);
		$worksheet->setCellValue($ncell, $text);
		$worksheet->getStyle($ncell)->getFont()->setBold(true)
				  ->getColor()->setARGB('000080');
		$sRow +=1;
		$nRows +=2;
		$ncell = "A".$nRows;
		//INPUT JUDUL TABEL
		$worksheet->fromArray($headName, null, $ncell);
		$ncol = count($headName);
		$colExc = colExcel();
		$endCol = $colExc[$ncol-1];
		//mengatur lebar kolom 
		for($i = 4; $i<$ncol; $i++)
		{
			$worksheet->getColumnDimension($colExc[$i])->setWidth(10);
		}

		//atur lebar kolom Catatan Proses:
		$worksheet->getColumnDimension($endCol)->setWidth(70);

		$hedRange = $ncell.':'.$endCol.$nRows;
	//	
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
		$id = $room['id'];
		$pd = $MemberModel->getAll(['a.roomid'=>$id]);
	
		//menggabungkan PD dengan Nilai (jika ada)
		$rsData=[];
	//	show_result($headf);
	//	show_result($pd);
		
		foreach($pd as $PD)
		{
		//	$dtPD = array_merge($PD,$defNilai);
			foreach($headf as $fd)
			{
				if(array_key_exists($fd, $PD)){$dtPD[$fd]=$PD[$fd];}
			}
			$rsData[]=$dtPD;
		}
	//	test_result($rsData);
		$sCell = "A".$sRow;
		$worksheet->fromArray($rsData, null, $sCell);
		$lastRow = $sRow + count($rsData);
		$pdRange = $sCell.':D'.$lastRow;
		$worksheet->getStyle($pdRange)->getNumberFormat()
				  ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT); // will show as 0019 in Excel

		$nama_file = 'Tmp_Propela_'.$room['id']."-P".$PID."-".date("Ymhdis");
		//$fn = $excel->write_data($nama_file,$headf,$rsData);
				
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($exc);
	    $writer->save($dirf.$nama_file.'.xlsx');
        return $this->response->download($dirf.$nama_file.'.xlsx', null);
	}

	function importAction(): RedirectResponse
	{
		$this->cekHakAkses('create_data');
		helper('text');
		$validationRule  =[
			'userfile' => ['uploaded[userfile]'],
		];
		
		$R = $this->request->getPost();
		
		$ids = decrypt($R['ids']);
	//	$PIDs = decrypt($R['pids']);
		
		$ID = explode($this->DELIMETER,$ids); //$ID[0] = Rating_ID/Project_ID ; $ID[1]=SUBGRADE
		$roomID = $ID[0]; $SG=$ID[1]; $pid=$ID[2];

		if ($this->validate($validationRule)) {
			
			 $xlsx = $this->request->getFile('userfile');
			 if ($xlsx->isValid() && ! $xlsx->hasMoved()) {
	             // Get random file name
				$newName = $xlsx->getRandomName();
				// Store file in public/csvfile/ folder
				
				$myconfig = new MyApp;
				$dirf = $myconfig ->tmpfile_dir;
				$filepath = $this->myconfig->tmpfile_dir;
				//ambil skor berdasarkan Nilai
				$opsi = $this->opsi;
				$mark = $opsi['reserv_nilai'];
				//show_result($mark);
				//echo $type; 
				$xlsx->move($filepath, $newName);
				
				$inputFileName = $filepath.$newName;
				
				//MEMBUKA FILE EXCEL
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
				$reader->setReadDataOnly(TRUE);
				$spreadsheet = $reader->load($inputFileName);

				$worksheet = $spreadsheet->getActiveSheet();
				$RoomID = $worksheet->getCell('A1')->getValue();
				$PIDS 	= $worksheet->getCell('A3')->getValue();
				$RID = (is_hex($RoomID))?decrypt($RoomID):$RoomID; //RoomID
				$PID = (is_hex($PIDS))?decrypt($PIDS):$PIDS; //RatingID / ProjectID
				$SG  = $worksheet->getCell('B6')->getValue(); //SUbgrade 
				$SR  = $worksheet->getCell('A9')->getValue(); //start Row ->awal bari pengambilan set data 

				//mencocokkan KODE PROJECT
				if($PID <> $pid)
				{
					$this->session->setFlashdata('warning','KODE PROJECT TIDAK SESUAI');
					return redirect()->to(base_url('nilai'));
				} 

				//mencocokkan KODE ROMBEL
				if($roomID <> $RID)
				{
					$this->session->setFlashdata('warning','KODE PROJECT TIDAK SESUAI');
					return redirect()->to(base_url('nilai'));
				} 
				
				//ambil data
				$maxDataRow = $worksheet->getHighestDataRow();
				$maxDataColumn = $worksheet->getHighestDataColumn();

				//ambil rating model yang merupakan data project menjadi komponen nilai
				$mfields = setting('LogNilai.markFields');
				$nfield = $mfields['nilai'];
				$colWidth = $mfields['nilai']['width'];
				unset($mfields['nilai']);

				$headf[]='member_id'; $headName[]="Member ID";
				$rheadf['Member ID']='member_id';
				foreach($mfields as $k =>$mf)
				{
					$headf[]=$k;
					$headName[] = $mf['label'];
					$rheadf[$mf['label']]=$k;
				}
				$mainhf = $headName;
				$room = $this->rombelModel->get(['a.id'=>$RID]);
				$mapProject = $this->mapModel->getsAll(['d.curr_id'=>$room['curr_id'], 'a.project_id'=>$PID]);
			//	test_result($mapProject);
				$CN =[];
				foreach($mapProject as $P)
				{
					$headName[]=$P['id'];
					$CN[$P['id']]['tujuan']=$P['tujuan'];
					$CN[$P['id']]['deskripsi']=$P['deskripsi'];
				}
				$CN[$this->ADMARK]['tujuan']=$this->ADMARKDSC;
				$headName[]=$this->ADMARKDSC;
				$headf[]=$this->ADMARK;
				
				//AMBIL BARIS PERTAMA TABEL NILAI
				$head=$worksheet->rangeToArray("A".$SR.":".$maxDataColumn.$SR,NULL,TRUE,TRUE,TRUE);
				$heads = $head[$SR];
			
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
						mengingat  bahwa setiap merupakan nilai tunggal maka tidak dilakukan exlode yang terdiri dari komponen nilai dan index
						# komponen pemisah bisa berupa "-"
						*/
						//$fd = explode("-",$vh); 

						if(in_array($vh, $headName))
						{
							if($vh==$this->ADMARKDSC)
							{
								$fields[]=$this->ADMARK;
								$cnn[$this->ADMARK]=$this->ADMARK;
							}else{
								$fields[]=$vh;
								$cnn[$vh]=$vh;//$vcn;
							}
							
						}

					}
				}
			//test_result($fields);
				$wCol = $colWidth / count($cnn);
				foreach($cnn as $fk => $vk)
				{
					//UPDATE $mfields
					if(array_key_exists($vk,$mfields)){
						$nfield = $mfields[$vk];
						unset($mfields[$vk]);
					}
					$nfield['label']=(array_key_exists($fk,$CN))?$CN[$fk]['tujuan']:$fk;
					$nfield['width']=$wCol;
					$nfield['extra']['id']="n".strtolower($fk);
					$mfields[$fk] = $nfield;
				}
			//	show_result($cnn);
			//	echo $maxDataRow;
			//	show_result($fields);
			//	test_result($mfields);
				//ambil data 
				$rowIterator = $worksheet->getRowIterator($SR+1, $maxDataRow);
				$rowData=[]; $r = 0; $rsData=[]; 
				foreach ($rowIterator as $row) {
					if ($row->isEmpty()) { // Ignore empty rows
						continue;
					}
					$r++;
					$columnIterator = $row->getCellIterator('A', $maxDataColumn);
					$colData=[]; $i=0; $cellData=[];
					foreach ($columnIterator as $cell) {
						// Do something with the cell here.
						$cellValue = $cell->getValue();
						$fd = $fields[$i];
						
						if(array_key_exists($fd, $cnn)){
							$cellValue = $cellValue;
							$colData['nilai'][$cnn[$fd]]=$cellValue;
						}else{
							$colData[$fields[$i]]=$cellValue;
						}
						$cellData[$fields[$i]]=$cellValue;
						$i++;
					}
				//	show_result($cellData);
				if(count($colData['nilai'])<1)
				{
					$this->session->setFlashdata('warning','Data Nilai Tidak Ditemukan');
					return redirect()->to(base_url('nilai'));
				}
				//	test_result($colData);
				//  Hindari Baris Kosong
					if(strlen($colData['member_id'])>0)
					{
						$data['member_id']=$colData['member_id'];
						$data['subgrade']=$SG; 
						$nilai=$colData['nilai'];
					//	show_result($nilai);
					//	test_result($nilai);
						foreach($nilai as $cn =>$N)
						{
							$data['rating_id']=$cn;
							$data['idx']=$PID;
							$data['nilai']=(array_key_exists($N, $mark))?$mark[$N]:$N;
							$rowData[]=$data;
						}
					}
					$rsData[$r]=$cellData;
				}
			//	show_result($rowData);
			//	test_result($rsData);
				$Data['actY'] = $R['pids'];
				$Data['actN'] = random_string('alnum',12);
				$Data['fields'] = $mfields;
				$Data['rsdata'] = $rsData;
				$Data['rowData'] = $rowData;
				$Data['ids'] = $R['ids'];
			//	$Data['sts'] = $R['pids'];
				//Konfirmasi data
				$this->session->setTempdata('RDAT',$Data,120);
				return redirect()->to(base_url('propela/konfirm'));
	         }else{
				$this->session->setFlashdata('warning','The file has already been moved.');
				return redirect()->to(base_url('nilai'));
			 }
		}else{
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}
	}

	public function simpanmasal($act = 0) {
		$DATA = $this->session->getTempdata('RDAT');
		//echo $act;
	//	test_result($DATA);
		//$nilai $act = nol
		if($act === 0){
			//tampilkan ke browser
			$Data = $this->data;
			$data = array_merge($Data,$DATA);
			$data['title'] = "Konfirmasi Data!";
			echo view($this->theme.'list2konfirm',$data);
		}
		
		$uri = 'propela/show?ids='.$DATA['ids'];
		if($act === $DATA['actY']){
		//	$model = new NilaiModel();
		//	test_result($DATA['rowData']);
			$simpan = FALSE;
			$STS = decrypt($act);
			if($STS === EVENTADD)
			{
				$simpan = $this->model->insertBatch($DATA['rowData']);
			}
			
			if($STS === EVENTUPD)
			{
				$simpan = $this->model->updateMasal($DATA['rowData']);
			}
			
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

	function resetData()
	{
		if (isset($_GET['ids'])) 
		{
			$ids = decrypt($_GET['ids']);
		
		}else{
			$this->session->setFlashdata('warning','Aksi dan Tindakan Ditolak');
			return redirect()->to(base_url('nilai'));
		}
		$ID = explode($this->DELIMETER,$ids); //$ID[0]=RoomID, $ID[1]=SubGRade; $ID[2]=ProjectID = idx
		$parm = ['rommID'=>$ID[0],'subgrade'=>$ID[1], 'pid'=>$ID[2]];

		$uri = 'propela/show?ids='.$_GET['ids'];
		if($this->model->reset($parm)){
			$this->session->setFlashdata('sukses','Data telah berhasil direset');
		}else{
			$this->session->setFlashdata('warning','Data gagal direset');
		}
		return redirect()->to(base_url($uri));
	}
	
}
