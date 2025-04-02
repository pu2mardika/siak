<?php  
function encrypting($plainText){
	$encrypter = \Config\Services::encrypter();
	$ciphertext = $encrypter->encrypt($plainText);
	return base64_encode($ciphertext);
}

function decrypting($ciphertext){
	$encrypter = \Config\Services::encrypter();
	$plainText = $encrypter->decrypt(base64_decode($ciphertext));
	return $plainText;
}

function encrypt($plainText){
	$encrypter = \Config\Services::encrypter();
	$ciphertext = $encrypter->encrypt($plainText);
	return bin2hex($ciphertext);
}

function decrypt($ciphertext){
	$encrypter = \Config\Services::encrypter();
	$plainText = $encrypter->decrypt(hex2bin($ciphertext));
	return $plainText;
}

function proper($text): string 
{
	return ucwords(strtolower($text));
}

function hari($n)
{
	$day= ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
	return $day[$n];
}
/**
* convert tanggal dari format standar ke unix_timestamp
* @param string $tgl  format "dd-mm-yyyy"
* @param string jam  format "hh:mm:ss"
* @return
*/
function ina_to_unix($tgl, $jam=NULL) {
	$Jam=(is_null($jam))?date('h:i:s'):$jam;
	$d=substr($tgl,0,2);
	$m=substr($tgl,3,2);
	$y=substr($tgl,6,4);
	$hasil=strtotime($y.'-'.$m.'-'.$d.' '.$Jam);
	return $hasil;
}

/**
* Format tanggal dari unix time stemp
* @param int unix timestamp $timestam
* 
* @return string
*/
function format_tgl_funix($timestamp)
{
	$CI =& get_instance();
	$T=getdate($timestamp);
	$M=$CI->lang->line('month_name');
	
	$d=$T['mday']; $m=$M[$T['mon']]; $y=$T['year'];
	$hasil= $d." ".$m." ".$y;
}

function format_angka($angka,$n=0) {
	$hasil = number_format($angka,$n, ",",".");
	return $hasil;
}

function unix2Ind($timestamp, $format="d M Y")
{
	helper('date');
	return nice_date(unix_to_human($timestamp),$format);
}

function formatTgl($tgl, $format="d-m-Y")
{
	return date($format, strtotime($tgl));
}

function format_npwp($npwp)
{
	//##.###.###-#-###.###
	if(strlen($npwp)==15)
	{
		return substr($npwp,0,2).".".substr($npwp,2,3).".".substr($npwp,5,3).".".substr($npwp,8,1).".".
		   substr($npwp,9,3).".".substr($npwp,12,3);
	}elseif($npwp=="-"||$npwp==0||is_null($npwp))
	{
		return "-";
	}
	return "INVALID NPWP";
}

function test_result($data=array())
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	die;
}

function show_result($data=array())
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function get_periode($str='TA', $thn=NULL)
{
	$Y=is_null($thn)?date("Y"):$thn;
	$hsl=array();
	$str_arr=array('TW1','TW2','TW3','TW4','SM1','SM2','TA');
	if(in_array($str,$str_arr)){
		$TW1=array('awal'=>strtotime($Y.'-01-01 01:10:00'),'akhir'=>strtotime($Y.'-03-31 23:59:59'));
		$TW2=array('awal'=>strtotime($Y.'-04-01 00:00:00'),'akhir'=>strtotime($Y.'-06-30 23:59:59'));
		$TW3=array('awal'=>strtotime($Y.'-07-01 00:00:00'),'akhir'=>strtotime($Y.'-09-30 23:59:59'));
		$TW4=array('awal'=>strtotime($Y.'-10-01 00:00:00'),'akhir'=>strtotime($Y.'-12-31 23:59:59'));
		
		$SM1=array('awal'=>strtotime($Y.'-01-01 01:10:00'),'akhir'=>strtotime($Y.'-06-30 23:59:59'));
		$SM1=array('awal'=>strtotime($Y.'-07-01 00:00:00'),'akhir'=>strtotime($Y.'-12-31 23:59:59'));
		
		$TA=array('awal'=>strtotime($Y.'-01-01 00:10:00'),'akhir'=>strtotime($Y.'-12-31 23:59:59'));
		$hsl= $$str;
	}else{
		$b=intval(substr($str,1,2));
		if(substr($str,0,1)=='B' && $b >=1 && $b <=12 )
		{
			$efb=array(1=>31,28,31,30,31,30,31,31,30,31,30,31);
			if(!($Y % 4)){$efb[2]=29;} //CEK TAHUN KABISAT
			$jamAwal=($b==1)?"01:10:00":"00:00:00";
			$hsl=array('awal'=>strtotime($Y.'-'.$b.'-01 '.$jamAwal),'akhir'=>strtotime($Y.'-'.$b.'-'.$efb[$b].' 23:59:59'));
			//return $hsl;
		}else{
			$hsl['awal']=strtotime($Y.'-01-01 01:00:00');
			$hsl['akhir']=strtotime($Y.'-12-31 00:00:00');
		}
	}
	
	$hsl['tahun']=$Y;
	return $hsl	;
}

/**
* count diffrent between two dates
* @param undefined $timeStart format : d-m-Y => "dd-mm-yyyy"
* @param undefined $timeEnd format : d-m-Y => "dd-mm-yyyy"
* 
* @return integer
*/
function deftgl($timeStart, $timeEnd)
{
	$selisih = ((abs(ind_to_unix($timeEnd) - ind_to_unix($timeStart)))/(60*60*24));
	return $selisih;
}

/**
* 
* @param timestamp $timeStart
* @param timestamp $timeEnd
* 
* @return
*/
function hitEndWeak($timeStart, $timeEnd,$fds=0)
{
	$detik = 24 * 3600;
	$n=0;
	for($i=$timeStart; $i<=$timeEnd; $i += $detik)
	{
		//$h=unix2Ind($i,'d-m-Y');
		$t=date("w",$i);
		if($t==0){  // minggu
			$n++;
		}
		
		if($fds > 0){
			if($fds < $i)
			{
				if($t==6){  // sabtu
					$n++;
				}
			}
		}
	}
	return $n;
}

/**
* Menghitung hari ke berapa dalam satu tahun
* @param timestamp $tgl
* @param timestamp $margin : tanggal batas bawah
* @return integer
*/
function harike($tgl,$margin=NULL)
{
	$hke=date("z",$tgl);
	$bts=(is_null($margin))?0:date("z",$margin);
	return $hke-$bts+1;
}

/**
* menghitung jumlah hari kerja
* @param timestamp $timeStart : hari yang dihitung
* @param timestamp $timeMargin : tanggal margin bawah
* @param fixed $expt as exception. it must an integer or an array
* 
* @return integer
*/
function workDay($timeStart, $timeMargin, $expt,$fds=0)
{
	//hitung hari Ke....
	$hke=harike($timeStart,$timeMargin);
	$wekend=hitEndWeak($timeMargin, $timeStart,$fds);
	$libur = (is_array($expt))?count($expt):$expt;
	$r['hke']=$hke;
	$r['wnd']=$wekend;
	$r['lbr']=$libur;
	//test_result($r);
	return $hke-$wekend-$libur;	
}

function formN0Surat($nokendali,$noUrut,$kode="",$tgl="",$full=TRUE)
{
	//$CI =& get_instance();
	$KODE=($kode==""||is_null($kode))?"":"/";
	$Tgl=($tgl=="")?now():((is_int($tgl))?$tgl:ind_to_unix($tgl));
	$NO=sprintf('%1$03d',$nokendali).sprintf('%1$02d',$noUrut);
	$nosurat= $kode.$KODE.$NO."/".get_prefix($tgl);
			 // $CI->config->item("prefix_surat");
	return ($full)?$nosurat:$NO;
	//echo $NO;
}

/**
* menentukan tanggal tutup buku (cut-off)
* @param unixtimestamp $timestamp, tanggal acuan
* @param array $libur (daftar hari libur);
* @param boolean $fds fullday school
* 
* @return
*/
function cutOff($timestamp,$libur=array())
{
	$CI =& get_instance();
	$fds= $CI->config->item('fds');
	
	//menetukan tanggal akhir bulan dari tanggal acuan dan konversi ke unix_timestamp
	$tg=strtotime("last day of", $timestamp);
	
	//cek hari apakah $tg adalah hari minggu
	$n=0;
	$t=date("w",$tg);
	if($t==0){  // minggu
		$tg = strtotime("-1 days", $tg);
	}
	
	if($fds && $t==6){  //  sabtu dan fullday school
		//$n--;
		$tg = strtotime("-1 days", $tg);
	}
	
	//cek tgl apakah hari libur
	if(in_array($tg,$libur)){
		//$n--;
		$tg = strtotime("-1 days", $tg);
	}
	
	return $tg;
	
}
/**
* 
* @param Tanggal  $tgl_indo format "dd-mm-yyyy"
* @param bolean $uts unix time stamp
* 
* @return
*/
function get_prefix($tgl)
{
	//$CI =& get_instance();
	//$id=($uts)?$tgl_indo:ind_to_unix($tgl_indo);
	$dt="TEST";//$dt=$CI->mod_numen->get_numen($tgl);
	//$num=$CI->mod_numen->get($dt);
	return ($dt)?$dt:$CI->config->item("prefix_surat");
}
 
/**
* 
* @param time $tgl
* 
* @return
*/
function konvNO($tgl=0,$C=1)
{
	$T=['1','A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
	$B=array(1=>"B","C","D","F","G","H","K","L","M","N","P","Q" );
	$D=array("A","E","O","U");
	if($tgl==0){
		return 0;
	}
	$tg=preg_split("/(\/|-)/i",$tgl);
	$hr=sprintf("%1$02d",$tg[0]);
	$bl=(int)$tg[1];
	//return $B[$bl].$D[substr($hr,0,1)].substr($hr,1,1).sprintf("%1$02d",$C);
	return $tg;
}

/**
 * @param $tgl
 */
function register($tgl)
{
	$T=['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
	$B=[
		['O','O'], ['H','U'], ['I','V'], ['J','W'], ['K','X'], 
		['L','Y'], ['M','Z'], ['N','A'], ['P','B'], 
		['Q','C'], ['R','D'], ['S','E'], ['T','F'],
	];

	$J=['N', 'Y','U','Q','V','A','B','Z','H','G','J','M','P','R','W','E','C','L','D','S','T','X','F','K'];
	$tg=preg_split("/(\/|-)/i",$tgl);
	
	//test_result($tg);
	$d = $tg[0]; 
	$m = (int) $tg[1];
	$y = $tg[2];
	
	if(strlen($tg[0])===4){
		$d = $tg[2]; $y = $tg[0];
	}
	$t= $y % 26; 
	return $T[$t].random_string('nozero',1).$B[$m][rand(0,1)].$J[date('G')].strtoupper(random_string('nozero',3)).strtoupper(random_string('alpha',1)); //format: TT[M]DD[J]XX
}

function regID($tgl)
{
	$tg=preg_split("/(\/|-)/i",$tgl);
	
	//test_result($tg);
	$d = $tg[0]; 
	$m = (int) $tg[1];
	$y = $tg[2];
	
	if(strlen($tg[0])===4){
		$d = $tg[2]; $y = $tg[0];
	}
	$t=$y-2000;
	return $t.$tg[1].random_string('numeric',2).$d.date('hi').random_string('numeric',2);
}

/**
* convert tanggal dari format standar ke unix_timestamp
* @param string $tgl  format "dd-mm-yyyy"
* @param string jam  format "hh:mm:ss"
* @return
*/
function ind_to_unix($tgl, $jam=NULL) {
	$Jam=(is_null($jam))?date('h:i:s'):$jam;
	
	$tg=preg_split("/(\/|-)/i",$tgl);
	
	//test_result($tg);
	$d = $tg[0]; 
	$m = $tg[1];
	$y = $tg[2];
	
	if(strlen($tg[0])===4){
		$d = $tg[2]; $y = $tg[0];
	}

	$hasil=strtotime($y.'-'.$m.'-'.$d.' '.$Jam);
	return $hasil;
}

function ind2unix($tgl)
{
	if ($tgl == '0000-00-00 00:00:00' || !$tgl) {
		return false;
	}
	$exp = explode (' ', $tgl);
	return ind_to_unix($exp[0]);
}

function nextTgl($time_sekarang, $n, $format="d F Y",$ofset=1)
{
	$N=$n - $ofset;
	
	return date($format, strtotime("+$N days", $time_sekarang));
}

function getTgl($tgl)
{
	if ($tgl == '0000-00-00 00:00:00' || !$tgl) {
		return false;
	}
	$exp = explode (' ', $tgl);
	//$exp_tgl = explode ('-', $exp[0]);
	return $exp[0];
}
/**
* 
* @param {object} $TglLahir
* @param {object} $tglSekarang
* @param {object} $type (0, 1, 2)
* 
* @return
*/
function getAge($TglLahir, $tglSekarang=0, $type=0)
{
	$tanggal_lahir = new DateTime($TglLahir);
    $sekarang = new DateTime("today");
    
    if( ! $tglSekarang == 0){$sekarang = new DateTime($tglSekarang);}
    	
    if ($tanggal_lahir > $sekarang) { 
    $thn = "0";
    $bln = "0";
    $tgl = "0";
    }
    $thn = $sekarang->diff($tanggal_lahir)->y;
    $bln = $sekarang->diff($tanggal_lahir)->m;
    $tgl = $sekarang->diff($tanggal_lahir)->d;
    
    $hasil[0] = $thn." tahun";
    $hasil[1] = $thn." tahun ".$bln." bulan";
    $hasil[2] = $thn." tahun ".$bln." bulan ".$tgl." hari";
    if($type > 2){return "ERROR TYPE";}
    return $hasil[$type];
}

/**
* 
* @param {object} $tgl
* @param {object} int
* 
* @return
*/
function overdue($tgl, $tenor)
{
	$n = "+".$tenor." month";
	$ovd = date("Y-m-d", strtotime($n, strtotime($tgl)));
	return $ovd;
}

/**
* BEBERAPA func YANG DIAMBIL DARI METHODE LAMA
*/
if ( ! function_exists('unix_to_human'))
{
	/**
	 * Unix to "Human"
	 *
	 * Formats Unix timestamp to the following prototype: 2006-08-21 11:35 PM
	 *
	 * @param	int	Unix timestamp
	 * @param	bool	whether to show seconds
	 * @param	string	format: us or euro
	 * @return	string
	 */
	function unix_to_human($time = '', $seconds = FALSE, $fmt = 'us')
	{
		$r = date('Y', $time).'-'.date('m', $time).'-'.date('d', $time).' ';

		if ($fmt === 'us')
		{
			$r .= date('h', $time).':'.date('i', $time);
		}
		else
		{
			$r .= date('H', $time).':'.date('i', $time);
		}

		if ($seconds)
		{
			$r .= ':'.date('s', $time);
		}

		if ($fmt === 'us')
		{
			return $r.' '.date('A', $time);
		}

		return $r;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('human_to_unix'))
{
	/**
	 * Convert "human" date to GMT
	 *
	 * Reverses the above process
	 *
	 * @param	string	format: us or euro
	 * @return	int
	 */
	function human_to_unix($datestr = '')
	{
		if ($datestr === '')
		{
			return FALSE;
		}

		$datestr = preg_replace('/\040+/', ' ', trim($datestr));

		if ( ! preg_match('/^(\d{2}|\d{4})\-[0-9]{1,2}\-[0-9]{1,2}\s[0-9]{1,2}:[0-9]{1,2}(?::[0-9]{1,2})?(?:\s[AP]M)?$/i', $datestr))
		{
			return FALSE;
		}

		sscanf($datestr, '%d-%d-%d %s %s', $year, $month, $day, $time, $ampm);
		sscanf($time, '%d:%d:%d', $hour, $min, $sec);
		isset($sec) OR $sec = 0;

		if (isset($ampm))
		{
			$ampm = strtolower($ampm);

			if ($ampm[0] === 'p' && $hour < 12)
			{
				$hour += 12;
			}
			elseif ($ampm[0] === 'a' && $hour === 12)
			{
				$hour = 0;
			}
		}

		return mktime($hour, $min, $sec, $month, $day, $year);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('nice_date'))
{
	/**
	 * Turns many "reasonably-date-like" strings into something
	 * that is actually useful. This only works for dates after unix epoch.
	 *
	 * @param	string	The terribly formatted date-like string
	 * @param	string	Date format to return (same as php date function)
	 * @return	string
	 */
	function nice_date($bad_date = '', $format = FALSE)
	{
		if (empty($bad_date))
		{
			return 'Unknown';
		}
		elseif (empty($format))
		{
			$format = 'U';
		}

		// Date like: YYYYMM
		if (preg_match('/^\d{6}$/i', $bad_date))
		{
			if (in_array(substr($bad_date, 0, 2), array('19', '20')))
			{
				$year  = substr($bad_date, 0, 4);
				$month = substr($bad_date, 4, 2);
			}
			else
			{
				$month  = substr($bad_date, 0, 2);
				$year   = substr($bad_date, 2, 4);
			}

			return date($format, strtotime($year.'-'.$month.'-01'));
		}

		// Date Like: YYYYMMDD
		if (preg_match('/^(\d{2})\d{2}(\d{4})$/i', $bad_date, $matches))
		{
			return date($format, strtotime($matches[1].'/01/'.$matches[2]));
		}

		// Date Like: MM-DD-YYYY __or__ M-D-YYYY (or anything in between)
		if (preg_match('/^(\d{1,2})-(\d{1,2})-(\d{4})$/i', $bad_date, $matches))
		{
			return date($format, strtotime($matches[3].'-'.$matches[1].'-'.$matches[2]));
		}

		// Any other kind of string, when converted into UNIX time,
		// produces "0 seconds after epoc..." is probably bad...
		// return "Invalid Date".
		if (date('U', strtotime($bad_date)) === '0')
		{
			return 'Invalid Date';
		}

		// It's probably a valid-ish date format already
		return date($format, strtotime($bad_date));
	}
}

function colExcel():array
{
	$col=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
	   'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
	   'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
	   'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ',
	   'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ',
	   'EA','EB','EC','ED','EE','EF','EG','EH','EI','EJ','EK','EL','EM','EN','EO','EP','EQ','ER','ES','ET','EU','EV','EW','EX','EY','EZ',
	   'FA','FB','FC','FD','FE','FF','FG','FH','FI','FJ','FK','FL','FM','FN','FO','FP','FQ','FR','FS','FT','FU','FV','FW','FX','FY','FZ',
	   'GA','GB','GC','GD','GE','GF','GG','GH','GI','GJ','GK','GL','GM','GN','GO','GP','GQ','GR','GS','GT','GU','GV','GW','GX','GY','GZ',
	   'HA','HB','HC','HD','HE','HF','HG','HH','HI','HJ','HK','HL','HM','HN','HO','HP','HQ','HR','HS','HT','HU','HV','HW','HX','HY','HZ',
	   'IA','IB','IC','ID','IE','IF','IG','IH','II','IJ','IK','IL','IM','IN','IO','IP','IQ','IR','IS','IT','IU','IV','IW','IX','IY','IZ',
	   'JA','JB','JC','JD','JE','JF','JG','JH','JI','JJ','JK','JL','JM','JN','JO','JP','JQ','JR','JS','JT','JU','JV','JW','JX','JY','JZ',
	   ];
	return $col;
}

function tglfromxlsx($excell_date, $format="Y-m-d")
{
	$base_timestamp = mktime(0,0,0,1,$excell_date-1,1900);
	// $base_day dikurangkan 1 untuk mendapatkan timestamp yang tepat
	return date($format,$base_timestamp);
}

if( ! function_exists('penyebut'))
{
	function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
	
}

function terbilang($nilai) {
	if($nilai<0) {
		$hasil = "minus ". trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}     		
	return $hasil;
}

function getAuth($otorisator)
{
	$group_name = setting('MyApp.bod')['group_name'];
	$jabatan = setting('MyApp.bod')['group_comp'];
	
	$dbod = [];
	foreach ($otorisator as $k => $el)
	{
		$dbod[$k]['jabatan'] = $jabatan[$k];
		foreach($el as $comp)
		{
			$dbod[$k][$comp] = setting('MyApp.'.$k.$comp);
		}
	}
	return $dbod;
}

//konversi gambar ke basa_64
function getImg($path_img)
{
	$path = base_url($path_img);// 'images/your_img.png' Modify this part (your_img.png  
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	return $base64;
}

/**
 * cek angka merupakan heksadesimal atau tidak
 */

function is_hex($hex_code)
{
	return (@preg_match("/^[a-f0-9]{2,}$/i", $hex_code) && !(strlen($hex_code) & 1) && is_base64($hex_code));
}

function is_base64($code)
{
	return ( base64_encode(base64_decode($code, true)) === $code);
}

//MENGHITUNG BUNGA

function rateFlat($pokok,$rate,$tenor)
{
	$Bunga = $pokok * $tenor * $rate / 100;
	$hasil['bunga'] = $Bunga / $tenor;
	$hasil['pokok'] = $pokok / $tenor;
	$hasil['total']	= $hasil['pokok'] + $hasil['bunga'];
	return $hasil; 
}

function getCSVArray($query, string $delim = ',', string $newline = "\n", string $enclosure = '"')
{
	$out = '';

	foreach ($query['header'] as $name) {
		$out .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $name) . $enclosure . $delim;
	}

	$out = substr($out, 0, -strlen($delim)) . $newline;

	// Next blast through the result array and build out the rows
	while ($row = $query['dtrow']) {
		$line = [];

		foreach ($row as $item) {
			$line[] = $enclosure . str_replace(
				$enclosure,
				$enclosure . $enclosure,
				(string) $item
			) . $enclosure;
		}

		$out .= implode($delim, $line) . $newline;
	}

	return $out;
}