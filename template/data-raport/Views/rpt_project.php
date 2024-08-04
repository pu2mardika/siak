<!DOCTYPE html>
<html>
<head>
<style>
	h3 {color: maroon;}

	table{width: 100%; border-collapse: collapse;}
	table{font-size: 14px; font-family: Arial, Helvetica, sans-serif;}
	table.data-raport th, table.data-raport td  {
		border: 1px solid;
		padding: auto;
        margin-left:5px;
        margin-right:5px;
		padding: 5px;
	}
	
    .deskripsi{
        margin-top:-15px;
    }
    .dimensi td{
		font-weight:bold;
		height: 30px;
	}
    .elemen td{
		height: 20px;
	}

	.identitas td{
		font-weight: normal;
	}
	.elemen td.xdata{
		font-weight: normal;
        background-color: gainsboro;
	}
	.subtitle{
		font-weight: bold;
		font-size: 18px;
	}
	.cproses{
        border: 1px solid;
		min-height: 40px;
		padding: 10px;
    }

</style>
</head>
<body>
	<table class="table-raport">
	<thead class="identitas">
		<tr>
			<td width="25%">Nama Satuan Pendidikan</td><td width="43%">: <?=$ID['SP']?></td>
			<td width="18%">Kelas</td><td width="14%">: <?=$ID['Kelas']?></td>
		</tr>
		<tr>
			<td>Alamat</td><td>: <?=$ID['alamat_sp']?></td>
			<td>Semester</td><td>: <?=$ID['subgrade']?></td>
		</tr>
		<tr>
			<td>Nama Peserta Didik</td><td>: <?=$ID['PD']?></td>
			<td>Fase</td><td>: <?=$ID['Fase']?></td>
		</tr>
		<tr>
			<td>Nomor Induk/NISN</td><td>: <?=$ID['NIPD'].'/'.$ID['NISN']?></td>
			<td>Tahun Pelajaran</td><td>:  <?=$ID['tapel']?></td>
		</tr>
		<tr><td colspan="4"><hr></tr>
	</thead>
	<tbody>
		<tr>
            <td colspan="4">
                <h3>Lembar Isi Capaian Dimensi Profil Pelajar Pancasila pada Program Pemberdayaan dan Keterampilan</h3>
            <?php 
                echo "<h4 class='subtitle'>".$project['nama_project']."</h4>";
                echo "<p class='deskripsi'>".$project['deskripsi']."</p>";
            ?>    
                <table class="data-raport">
                <?php foreach($propela as $d =>$dimensi){ ?>
                    <tr class="dimensi">
                        <td width="68%"><?=$dimensi['dimensi_title']?></td>
                        <td width="8%" colspan="4" align="center">PENILAIAN</td>
                    </tr>
                    <?php  
                        $detDimensi = $dimensi['dimensi_det'];
                        foreach($detDimensi as $ei => $elemen)
                        {
                    ?>
                        <tr class='elemen'>
                            <td width="68%" class="xdata"><?=$elemen['elemen']?></td>
                            <td width="8%" align="center">MB</td>
                            <td width="8%" align="center">SB</td>
                            <td width="8%" align="center">BSH</td>
                            <td width="8%" align="center">SAB</td>
                        </tr>
                    <?php  
                    $detP3 = $elemen['detail'];
                        foreach($detP3 as $di => $P3)
                        {
                            $Nilai = $nilai[$di];
                    ?>
                            <tr>
                                <td><?=$P3['deskripsi']?></td>
                                <td align="center"><?php echo ((int) $Nilai==1)?"v":"";?></td>
                                <td align="center"><?php echo ((int) $Nilai==2)?"v":"";?></td>
                                <td align="center"><?php echo ((int) $Nilai==3)?"v":"";?></td>
                                <td align="center"><?php echo ((int) $Nilai==4)?"v":"";?></td>
                            </tr>
                    <?php
                        } //tutup foreach <ke-3>
                    } //tutup foreach <ke-2>
                }//tutup foreach <ke-1>
                    ?>
            </table>
            <br>
            <span class='subtitle'>CATATAN PROSES</span>
            <div class="cproses"><?=$nilai[$AddMark]?></div>
		    </td>
        </tr>
	</tbody>
	</table>
    
	<table>
		<tr>
			<td width="50%" align="center">
				<br/><br/>
				Orang Tua / Wali
				<br/><br/><br/><br/>
				................................
			</td>
			<td width="50%" align="center">
				Karangasem, <?=$ID['issued']?><br/>
				Wali Kelas
				<br/><br/><br/><br/>
				<strong><?=$ID['wali']?></strong>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<br/>
				Mengetahui,<br>
				Kepala <?=$ID['SP']?>
				<br/><br/><br/><br/>
				<strong><?=$ID['otorized_by']?></strong>
			</td>
		</tr>
	</table>
</body>
</html>
