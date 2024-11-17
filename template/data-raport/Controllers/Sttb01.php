<?php

namespace Raport\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use chillerlan\QRCode\{QRCode, QROptions};
use Picqer;

class Sttb01 extends BaseController
{
    public function showRaport($rsData):string
    {
       // $compRaport = model(\Modules\Akademik\Models\RaportsModel::class);
        $PS = $rsData['PS'];
        $nostsb = $rsData['PD']['id'];
       
        $ID  = [];
        $JUR = setting()->get('Program.opsi');
        $UO  = $JUR['unit_kerja'];
        $ID['SP'] = $JUR['unit_kerja'][$PS['unit_kerja']];
        $ID['alamat_sp'] = setting()->get('MyApp.address1');
        $ID['program'] = $rsData['PS']['nm_prodi'];
        $ID['nama'] = $rsData['siswa']['nama'];
        $ID['NIPD'] = $rsData['siswa']['noinduk'];
        $ID['NISN'] = $rsData['siswa']['nisn'];
        $ID['idreg'] = $rsData['siswa']['idreg'];
        $ID['tmp_lahir'] = $rsData['siswa']['tempatlahir'];
        $ID['tgl_lahir'] = format_date($rsData['siswa']['tgllahir']);
    //    $ID['tapel'] = $rsData['dtRaport']['tapel'];
        $ID['grade']= $rsData['glevel'][$rsData['PD']['grade']];
        $ID['exam'] = format_date($rsData['dtRaport']['exam']);
        $ID['otorized_by'] = $rsData['dtRaport']['otorized_by'];
        $ID['issued'] = format_date($rsData['dtRaport']['issued']);
        $views = $rsData['dtRaport']['tmpview'];
        $dtbarcode =$rsData['PD']['id'];

        $NR = $rsData['NILAI'];
        $Mapel = $rsData['Mapel'];
        $ComRpt = $rsData['Rating']; //KOMPONEN PENILAIAN
        $JNA = 0;
        $KKM = 60;

        //Menggabungkan Nilai dengan Mapel
        foreach($Mapel as $MP)
        {
            $nilai = (array_key_exists($MP['id_mapel'], $NR))?$NR[$MP['id_mapel']]:[];
        //    test_result($nilai);
        
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
            $XNA =  round($NA,0,PHP_ROUND_HALF_UP);
            $row['nilai'] = $XNA;
            $JNA += $XNA;
            $row['Desc'] = $Desc;
            $dtMP[]=$row;
        }
        
        $AVGN = (count($Mapel)>0)?$JNA / count($Mapel):0;
        $ID['avgn'] = round($AVGN,2,PHP_ROUND_HALF_UP);
        $ID['predikat'] =$this->setPredikat($AVGN,$KKM);
        $data['legality']=$rsData['legality'];
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        $data['qrcode'] = '<img src="'.(new QRCode)->render($dtbarcode).'" alt="QR Code" height="150" width="150" />';
        $barcode   = $generator->getBarcode($dtbarcode, $generator::TYPE_CODE_128_B);
        $data['barcode'] = '<img src="data:image/png;base64,'. base64_encode($barcode).'"/>';
        $data['dtbarcode'] = $dtbarcode;
        $data['mapel'] = $dtMP;
        $data['ID'] = $ID;
        $data['norpt'] = $nostsb;

        $html="";
        foreach($views as $V)
        {
            $tmp = "Raport\Views". DIRECTORY_SEPARATOR.$V;
            $html .= view($tmp, $data);
        }
       /*
        $html = view('Raport\Views\sttb_fs',$data)
               .view('Raport\Views\sttb_bs',$data);
       */
        return $html;
        
    }

    private function setPredikat($nilai, $kkm=70, $nmax=100)
    {
        $p = ['Tidak Memuaskan', 'Kurang Memuaskan', 'Memuaskan', 'Sangat Memuaskan', 'Dengan Pujian'];
        $i = round(($nmax - $kkm-1)/4,0,PHP_ROUND_HALF_UP);
        $R=0;
        //hitung data
        if($nilai < $kkm){
            return $p[0];
        }
        $R = $kkm + $i;
        if($nilai < $R){
            return $p[1];
        }
        $R = $kkm + 2 * $i;
        if($nilai < $R){
            return $p[2];
        }
        $R = $kkm + 3 * $i;
        if($nilai < $R){
            return $p[3];
        }

        if($nilai <= $nmax){
            return $p[4];
        }

        if($nilai > $nmax){
            return "DATA INVALID";
        }
    }
}
