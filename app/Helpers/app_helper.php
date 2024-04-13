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

/**
* OBJEK to ARRAY
* @param {object} $tgl
* 
* @return
*/
function object_to_array($object) {
    if(is_object($object)) {
        $object = get_object_vars($object);
    }
    if(is_array($object)) {
        return array_map(__FUNCTION__, $object);
    } else {
        return $object;
    }
}

/**
* Format tanggal sesuai dengan bahasa yang digunakan
* @param string $tgl (format "Y-m-d")
* 
* @return
*/
function format_tgl($tgl) {
	$CI =& get_instance();
	$d=substr($tgl,8,2);
	$m=substr($tgl,5,2);
	$y=substr($tgl,0,4);
	$q_bln=$CI->lang->line('month_names');
	
	$tgl_ind=$d." ".$q_bln[$m]." ".$y;
	return $tgl_ind;
}

function tgl2indo($tgl) {
	$CI =& get_instance();
	$d=substr($tgl,8,2);
	$m=substr($tgl,5,2);
	$y=substr($tgl,0,4);
	
	$tgl_ind=$d."-".$m."-".$y;
	return $tgl_ind;
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
		['0','0'], ['H','U'], ['I','V'], ['J','W'], ['K','X'], 
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
	$t=date("Y") - $y;
	return $T[$t].$B[$m][rand(0,1)].$d.$J[date('G')].strtoupper(random_string('alnum',3));
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

function nextTgl($time_sekarang, $n, $format="d F Y",$ofset=1)
{
	$N=$n - $ofset;
	
	return date($format, strtotime("+$N days", $time_sekarang));
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