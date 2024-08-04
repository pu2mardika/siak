<?php

namespace Raport\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use chillerlan\QRCode\{QRCode, QROptions};

class Ikmv01 extends BaseController
{
    public function index()
    {
        //
    }
    public function showRaport($rsData):string
    {
       // $compRaport = model(\Modules\Akademik\Models\RaportsModel::class);
        $KUR = $rsData['kurikulum'];
        $PS = $rsData['PS'];
        //test_result($rsData);
        //$CR = $compRaport->asarray()->where('curr_id',$KUR['id'])->findAll();
        $ID  = $this->getKelas($rsData['PS']['jenjang'],$rsData['rombel']['grade']);
        $JUR = setting()->get('Program.opsi');
        $UO  = $JUR['unit_kerja'];
        $ID['SP'] = $JUR['unit_kerja'][$PS['unit_kerja']];
        $ID['alamat_sp'] = setting()->get('MyApp.address1');
        $ID['PD'] = $rsData['siswa']['nama'];
        $ID['NIPD'] = $rsData['siswa']['noinduk'];
        $ID['NISN'] = $rsData['siswa']['nisn'];
        $ID['tapel'] = $rsData['dtRaport']['tapel'];
        $ID['subgrade'] = $rsData['dtRaport']['subgrade'];
        $ID['otorized_by'] = $rsData['dtRaport']['otorized_by'];
        $ID['wali'] = $rsData['rombel']['wali'];
        $ID['issued'] = format_date($rsData['dtRaport']['issued']);
        
        $NR = $rsData['NILAI'];
        $Mapel = $rsData['Mapel'];
        $ComRpt = $rsData['Rating']; //KOMPONEN PENILAIAN

        //Menggabungkan Nilai dengan Mapel
        foreach($Mapel as $MP)
        {
            $nilai = (array_key_exists($MP['id_mapel'], $NR))?$NR[$MP['id_mapel']]:[];
          //  test_result($nilai);
         //   $nilai = $NR[$MP['id_mapel']];

            //membaca nilai untuk setiap komponen nilai yang ada
            $desc1=""; $desc2="";
            if(count($nilai)>0)
            {
                //ambil componen nilai
                $NA = 0; $descMax=[]; $descMin=[]; $descAvg=[]; $desc=[];
                foreach($ComRpt as $CR =>$VCR)
                {
                    $N = (array_key_exists($CR, $nilai))?$nilai[$CR]:[];
                    //cek apakah komponen nilai memiliki deskripsi atau tidak
                    if($VCR['has_descript']==1)
                    {
                        //mengurut nilai maks dan nilai min dan mengambil indeknya
                        //arsort() - sort associative arrays in descending order, according to the value
                     //  test_result($rsData['ATP']);
                        if(count($N)>1)
                        {
                            arsort($N);
                            $maxKey = array_key_first($N); //key untuk nilai tertinggi
                            $minKey = array_key_last($N);  //key untuk nilai terendah
                            $DESC = $rsData['ATP'];
                            if(array_key_exists($MP['id_mapel'],$DESC))
                            {
                                $atp  = $DESC[$MP['id_mapel']];
                                $nMax = $N[$maxKey];
                                $nMin = $N[$minKey];

                                $atpMax = $atp[$CR][$maxKey];
                                $atpMin = $atp[$CR][$minKey];
                               
                                $KKM = $rsData['KKM'][$MP['id_mapel']];
                            //  test_result($KKM);
                                if($nMax == $nMin)
                                {
                                    $descAvg[] = sprintf($this->predikat($nMax,$KKM,$atpMax['aspek']),$atpMax['desc']);
                                }else{
                                    $descMax[] = sprintf($this->predikat($nMax,$KKM,$atpMax['aspek']),$atpMax['desc']);
                                    $descMin[] = sprintf($this->predikat($nMin,$KKM,$atpMin['aspek']),$atpMin['desc']);
                                }
                            }
                        }
                    }
                    $Nilai = array_sum($N) / count($N);
                    $bnilai = round($Nilai,0,PHP_ROUND_HALF_UP) * $VCR['bobot']/100;
                    $NA += $bnilai;
                }
                //menggabungkan descripsi
                $desc[] = implode(" ",$descMax);
                $desc[] = implode(" ",$descAvg);
                $desc[] = implode(" ",$descMin);
                $Desc = implode(" ",$desc);
            }else{
                $NA = 0;
                $Desc = "";
            }
            //menyatukan mapel dengan Nilai
            $row['nama_mapel'] = $MP['subject_name'];
            $row['skk'] = $MP['skk'];
            $row['nilai'] = round($NA,0,PHP_ROUND_HALF_UP);
            $row['Desc'] = $Desc;
            $dtMP[$MP['grup_id']][]=$row;
        }

        $data['mapel'] = $dtMP;
        $data['eks'] =[];
        $data['presensi']=[];
        $data['ID'] = $ID;
        $data['GrupMapel'] = $rsData['GrupMapel'];
        //test_result($data);
        return view('Raport\Views\data_rapor',$data);
    }

    public function showCover($Data):string
    {
       // $KUR = $Data['kurikulum'];
       // $PS = $Data['PS'];
        $PS = $Data['PS'];
        $skl = strip_tags($PS['skl']);
        $Data['PS']['skl'] = $skl;
        $Satker = setting()->get('Satker.unit');
        $SP = $Satker[$Data['PS']['unit_kerja']];
        $image ='images/' . setting()->get('MyApp.logo');
		$SP['logo']	= base_url($image);
        $SP['address1'] = setting()->get('MyApp.address1');
        $SP['address2'] = setting()->get('MyApp.address2');       
        $SP['kelurahan'] = setting()->get('MyApp.kelurahan');       
        $SP['kecamatan'] = setting()->get('MyApp.kecamatan');       
        $SP['city'] = setting()->get('MyApp.city');       
        $SP['phone'] = setting()->get('MyApp.phone');       
        $SP['email'] = setting()->get('MyApp.primary_contact_email');       
        $SP['website'] = setting()->get('MyApp.website');        
        $SP['locus'] = setting()->get('MyApp.locus');        
        $Data['SP'] =$SP;
        $Data['norpt'] = $Data['siswa']['idreg']."-".$Data['PS']['jenjang'];
        $PD = $Data['siswa'];
   //     $qrtxt= $Data["norpt"]."/".$PD['idreg']."<br>".$PD['nama']."<br>NIS/NISN".$PD['noinduk']."/".$PD['nisn'];
        $dtQR = base_url('enroll/detail/');
        $PD['qrcode'] = '<img src="'.(new QRCode)->render($dtQR).'" alt="QR Code" height="150" width="150" />';
        //test_result($Data);
        if(array_key_exists('hal', $Data))
        {
            $hal = $Data['hal'];
            $html[1]= view('Raport\Views\cpg1_cov',$Data);
            $html[2]= view('Raport\Views\cpg2_sp',['PS'=>$PS, 'SP'=>$SP]);
            $html[3]= view('Raport\Views\cpg3_pd',['PS'=>$PS, 'SP'=>$SP, 'PD'=>$PD, 'opsi'=>setting()->get('Datadik.opsi')]) ;
            $vhtml = $html[$hal];
        }else{
            $vhtml = view('Raport\Views\cpg1_cov',$Data)
                    .view('Raport\Views\cpg2_sp',['PS'=>$PS, 'SP'=>$SP])
                    .view('Raport\Views\cpg3_pd',['PS'=>$PS, 'SP'=>$SP, 'PD'=>$PD, 'opsi'=>setting()->get('Datadik.opsi')]);
        }
        return $vhtml;
    } 
    
    function RptProject($rsData):string
    {
        $PS = $rsData['PS'];
        //test_result($rsData);
        //$CR = $compRaport->asarray()->where('curr_id',$KUR['id'])->findAll();
        $ID  = $this->getKelas($rsData['PS']['jenjang'],$rsData['rombel']['grade']);
        $JUR = setting()->get('Program.opsi');
        $UO  = $JUR['unit_kerja'];
        $ID['SP'] = $JUR['unit_kerja'][$PS['unit_kerja']];
        $ID['alamat_sp'] = setting()->get('MyApp.address1');
        $ID['PD'] = $rsData['siswa']['nama'];
        $ID['NIPD'] = $rsData['siswa']['noinduk'];
        $ID['NISN'] = $rsData['siswa']['nisn'];
        $ID['tapel'] = $rsData['dtRaport']['tapel'];
        $ID['subgrade'] = $rsData['dtRaport']['subgrade'];
        $ID['otorized_by'] = $rsData['dtRaport']['otorized_by'];
        $ID['wali'] = $rsData['rombel']['wali'];
        $ID['issued'] = format_date($rsData['dtRaport']['issued']);
        $dview=[];
        foreach($rsData['NILAI'] as $pid => $N)
        {
            $data['nilai'] = $N;
            $data['propela'] = $rsData['propela'][$pid];
            $data['ID'] = $ID;
            $data["AddMark"]=$rsData['ADMARK'];
            $data['project'] = $rsData['project'][$pid];
            $dview[]=view('Raport\Views\rpt_project',$data);
        }
        $html = implode("",$dview);
        return $html;
    }

    private function getKelas($jenjang, $grade)
    {
       //Fase A (kelas 1 dan 2 SD), Fase B (Kelas 3 dan 4 SD), Fase C (kelas 5 dan 6 SD), Fase D (kelas 7,8 dan 9 SMP), Fase E (kelas 10 SMA), Fase F (kelas 11 dan 12 SMA).
        $LV =[
            1 =>[1=>['Kelas' =>'I','Fase'  => "A"], 2=>['Kelas' =>'II', 'Fase'  => "A"], 3=>['Kelas' =>'III', 'Fase'  => "B"], 4=>['Kelas' =>'IV', 'Fase'  => "B"], 5=>['Kelas' =>'V','Fase'  => "C"], 6=>['Kelas' =>'VI','Fase'  => "A"], ], 
            2 =>[1=>['Kelas' =>'VII','Fase'=> "D"], 2=>['Kelas' =>'VIII', 'Fase'  => "D"], 3=>['Kelas' =>"IX", 'Fase' => "D"],], 
            3 =>[1=>['Kelas' =>'X','Fase'  => "E"], 2=>['Kelas' =>'XI', 'Fase'  => "F"], 3=>['Kelas' =>"XII", 'Fase' => "F"],], 
        ];
        return $LV[$jenjang][$grade];
    }

    private function predikat($nilai, $kkm, $aspek)
    {
        if ($nilai<=0 || $nilai=="") 
        {
            return "nilai tidak valid";
        }

        //hitung interval predikat
		$i=round((100 - $kkm)/3,0,PHP_ROUND_HALF_UP);
		$b1=$kkm + 2*$i; //batas awal nilai A
		$b2=$kkm + $i ; //batas awal nilai B
		//$KKM = batas awal nilai  C
        
		if ($nilai >= $b1) {
			$pr="Menunjukkan ".strtolower($aspek)." yang sangat baik dalam %s";
		}elseif($nilai >= $b2 ){
			$pr="Menunjukkan ".strtolower($aspek)." yang baik dalam %s";
		}elseif($nilai >= $kkm){
			$pr="Menunjukkan ".strtolower($aspek)." yang mulai berkembang dalam %s";
		} else {
			$pr="Perlu bimbingan dalam %s";
		}
        return $pr;
    }
}
