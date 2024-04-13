<?php 
namespace App\Libraries;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Config\MyApp;
use CodeIgniter\Files\File;

Class Exc_lib
{

	function __construct()
	{
		$this->session = \Config\Services::session();
	}
	
		
	function read_data($filname='',$head=array(),$sheet_idx=0)
	{
		$exc= new Spreadsheet_Excel_Reader($filname);
		
		//-------- import dari sheet 1 ----------

		// baca jumlah baris dalam sheet 1
		$jmlbaris = $exc->rowcount($sheet_index=$sheet_idx); //rowcount(0)==>sheet1
		$baris=array();
		
		for ($i=2; $i<=$jmlbaris; $i++)
		{
			$col=1;
			foreach($head as $field){
				$data[$field]=$exc->val($i,$col);
				$col++;
			}
			$baris[]=$data;
		}
		
		return $baris;		
	}
	
	function write_data($filename='',$head=array(),$data=array())
	{
		$col=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		           'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');
		
		$exc= new Spreadsheet();
		
		$exc->getProperties()->setCreator('pu2mardika');
		$exc->getProperties()->setLastModifiedBy('Mandiri Bina Cipta');
		$exc->getProperties()->setDescription("SIA-MBC");
				
	 	//membuat sheet;
		$sheet = $exc->setActiveSheetIndex(0);
		$sheet->setTitle($filename);
		
		//menambahkan data:
		$i=1;
		//menulis judul kolom
		foreach($head as $key => $hc)
		{
			$sheet->setCellValue($col[$key].$i,$hc);
		}
		
		//menulis data
		$i++;
		foreach ($data as $row)
		{
			foreach($head as $num => $field){
				if(array_key_exists($field,$row)){
					$sheet->setCellValue($col[$num].$i,$row[$field]);
				}
			}
			$i++;
		}
		
		$exc->setActiveSheetIndex(0);
		return $exc;
	}
	
	function read_data_xlsx($inputFileName)
	{
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
       	
		$spreadsheet = $reader->load($inputFileName);
		$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		
		$jmlbaris= count($sheetData);
		$baris=array();
		$head = [];
		//cek header data;
		$header = $sheetData[1];
		foreach($header as $col => $val){
			$head[$col]=$val;
		}
		
		//mengambil data		
		for ($i=2; $i<$jmlbaris; $i++)
		{
			foreach($head as $col => $field){
				$data[$field]=$sheetData[$i][$col];
			}
			$baris[]=$data;
		}
		unlink($inputFileName);
		//$file = new \CodeIgniter\Files\File($inputFileName);
		//$file->removeFile($inputFileName);
		return $baris;
		//return $sheetData;
	}
	
	function read_dataxls($filname='',$head=array(),$sheet_idx=0,$rowstart=1)
	{
		include 'exc_lib/PHPExcel/IOFactory.php';
		//$inputFileType = 'Excel5';
			$inputFileType = 'Excel2007';
		//	$inputFileType = 'Excel2003XML';
		//	$inputFileType = 'OOCalc';
		//	$inputFileType = 'Gnumeric';
		$inputFileName = $filname;

		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($inputFileName);

		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,false);
		
	//	test_result($sheetData);
		
		$jmlbaris= count($sheetData);
		$baris=array();
		
		/*
		//matching judul baris data
		$state=0;
		
		$i=$rowstart;
		
		$col=0;
		foreach($head as $field){
			$state=($field==$sheetData[$i][$col])?0:1;
			$col++;
		}
		*/
		
		for ($i=$rowstart; $i<$jmlbaris; $i++)
		{
			$col=0;
			foreach($head as $field){
				$data[$field]=$sheetData[$i][$col];
				$col++;
			}
			$baris[]=$data;
		}
		return $baris;
	}
}
