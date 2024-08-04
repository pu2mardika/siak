<!DOCTYPE html>
<html>
<head>
<style>
	h3 {color: maroon; text-align: center;}

	table{width: 100%; border-collapse: collapse;}
	table{font-size: 14px; font-family: Arial, Helvetica, sans-serif;}
	table.data-raport th, table.data-raport td  {
		border: 1px solid;		
	}
	
	table.dt-ekstra th, table.dt-ekstra td  {
		border: 1px solid;	
	}
	table.dt-presensi{width: 40%;}
	table.dt-presensi th, table.dt-presensi td  {
		border: 1px solid;	
	}
	.subtitle{font-weight: bold;}
	.rkiri{ text-align: left;}
	.rcenter{ text-align: center;}

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
		<tr><td colspan="4"><h3>LAPORAN HASIL PENDIDIKAN</h2></td></tr>
		<tr><td colspan="4">
		<table class="data-raport">
			<thead>
				<tr>
					<th width="8%">No</th>
					<th width="28%">Nama Mata Pelajaran</th>
					<th width="10%">Nilai Akhir</th>
					<th width="54%">Capaian Kompetensi</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($GrupMapel as $gmp)
					{
						$MaPel = (array_key_exists($gmp['grup_id'], $mapel))?$mapel[$gmp['grup_id']]:[];
						if(count($MaPel)>0){echo '<tr><td colspan="4" class="subtitle">'.$gmp['nm_grup']."</td></tr>";}
						$no = 1;
						foreach($MaPel as $sub)
						{
							echo "<tr>";
							echo "<td class='rcenter'>".$no."</td>";
							echo "<td>".$sub['nama_mapel']."</td>";
							echo "<td class='rcenter'>".$sub['nilai']."</td>";
							echo "<td>".$sub['Desc']."</td>";
							echo "</tr>";
							$no++;
						}
					}
				?>
			</tbody>
		</table>
		<br>
		<table class="dt-ekstra">
			<tr>
				<th width="8%">NO</th>
				<th width="30%">Kegiatan Ekstrakurikuler</th>
				<th width="12%">Predikat</th>
				<th width="40%">Keterangan</th>
			</tr>
			<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>
			<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>
			<tr><td>&nbsp;</td><td></td><td></td><td></td></tr>
		</table>
		<br>
		<table class='dt-presensi'>
			<tr><td class="rcenter" colspan="3">Ketidakhadiran</td></tr>
			<tr>
				<td width="8%" align="center">1</td>
				<td width="52%">Ijin</td>
				<td width="40%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;hari</td>
			</tr>
			<tr>
				<td align="center">2</td>
				<td>Sakit</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;hari</td>
			</tr>
			<tr>
				<td align="center">3</td>
				<td>Alpa</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;hari</td>
			</tr>
		</table>
		</td></tr>
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
