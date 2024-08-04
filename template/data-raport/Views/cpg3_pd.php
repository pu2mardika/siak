<table class="identitas">
	<tr>
		<td colspan="4">	
			<h2 class="judul"> IDENTITAS PESERTA DIDIK</h2>
			<br>
		</td>
	<tr>
		<td width="5%">1.</td>
		<td width="30%">Nama Peserta Didik</td>
		<td width="3%">:</td>
		<td class="xdata" width="62%">
			<?php echo strtoupper($PD['nama']);?>
		</td>
	</tr>
	<tr>
		<td>2.</td>
		<td>NIS/NISN</td>
		<td>:</td>
		<td class="xdata">
			<?php echo (isset($PD['noinduk']))?$PD['noinduk']:""; ?>/
			<?php echo (isset($PD['nisn']))?$PD['nisn']:""; ?>
		</td>
	</tr>
	<tr>
		<td>3.</td>
		<td>Tempat, Tgl. Lahir</td>
		<td>:</td>
		<td class="xdata">
			<?php echo (isset($PD['tmp_lahir']))?$PD['tmp_lahir']:""; ?>,
			<?php echo (isset($PD['tgl_lahir']))?format_tgl(unix2Ind($PD['tgl_lahir'],"Y-m-d")):""; ?>
		</td>
	</tr>
	<tr>
		<td>4.</td>
		<td>Jenis Kelamin</td>
		<td>:</td>
		<td class="xdata">
			<?php 
			$JK=$opsi['jk'];
				echo (isset($PD['jk']))?strtoupper($JK[$PD['jk']]):""; 
			?>
		</td>
	</tr>
	<tr>
		<td>5.</td>
		<td>Agama</td>
		<td>:</td>
		<td class="xdata">
			<?php echo (isset($PD['agama']))?strtoupper($PD['agama']):""; ?>
		</td>
	</tr>
	<tr>
		<td>6.</td>
		<td>Status Dalam Keluarga</td>
		<td>:</td>
		<td class="xdata">
			<?php 
			//$sts=$this->lang->line('sts_dlm_keluarga_list');
			//echo (isset($PD['sts_dlm_keluarga']))?strtoupper($sts[$PD['sts_dlm_keluarga']]):""; 
			?>
		</td>
	</tr>
	<tr>
		<td>7.</td>
		<td>Anak ke-</td>
		<td>:</td>
		<td class="xdata">
			<?php //echo (isset($PD['anak_ke']))?$PD['anak_ke']:""; ?>
		</td>
	</tr>
	<tr>
		<td>8.</td>
		<td>Alamat Peserta Didik</td>
		<td>:</td>
		<td class="xdata">
			<?php 
			echo strtoupper($PD['alamat']);
			?>
		</td>
	</tr>
	<tr>
		<td>9.</td>
		<td>Nomor Telepon</td>
		<td>:</td>
		<td class="xdata">
			<?php echo (isset($PD['nohp']))?$PD['nohp']:""; ?>
		</td>
	</tr>
	<tr>
		<td>10.</td>
		<td>Satuan Pendidikan Asal</td>
		<td>:</td>
		<td class="xdata">
			<?php echo (isset($PD['asal_sekolah']))?$PD['asal_sekolah']:""; ?>
		</td>
	</tr>
	<tr>
		<td>11.</td>
		<td colspan="3">Diterima di PKBM ini</td>
	</tr>
	<tr>
		<td></td>
		<td>a. Tingkat/Kelas</td>
		<td>:</td>
		<td class="xdata">
			<?php //echo (isset($raport['grade']))?strtoupper($raport['grade']):""; ?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>b. Tanggal</td>
		<td>:</td>
		<td class="xdata">
			<?php echo (isset($PD['tgl_diterima']))?$PD['tgl_diterima']:""; ?>
		</td>
	</tr>
	<tr>
		<td>12.</td>
		<td>Orang Tua</td>
	</tr>
	<tr>
		<td></td>
		<td>a. Nama Ayah</td>
		<td>:</td>
		<td class="xdata">
			<?php echo (isset($PD['nama_ayah']))?strtoupper($PD['nama_ayah']):""; ?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>b. Nama Ibu</td>
		<td>:</td>
		<td class="xdata">
			<?php echo (isset($PD['nama_ibu']))?strtoupper($PD['nama_ibu']):""; ?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>c. Alamat</td>
		<td>:</td>
		<td class="xdata">
			<?php echo (isset($PD['alamat_ortu']))?strtoupper($PD['alamat_ortu']):""; ?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>d. No Telepon/HP</td>
		<td>:</td>
		<td class="xdata">
			<?php echo (isset($PD['nohp_ayah']))?$PD['nohp_ayah']:""; ?>
		</td>
	</tr>
	
	<tr>
		<td>13.</td>
		<td>Pekerjaan Orang Tua</td>
	</tr>
	<tr>
		<td></td>
		<td>a. Ayah</td>
		<td>:</td>
		<td class="xdata">
			<?php 
			// echo (isset($PD['pekerjaan_ayah']))?strtoupper($job[$PD['pekerjaan_ayah']]):""; 
			?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>b. Ibu</td>
		<td>:</td>
		<td class="xdata">
			<?php //echo (isset($PD['pekerjaan_ibu']))?strtoupper($job[$PD['pekerjaan_ibu']]):""; ?>
		</td>
	</tr>
	<tr>
		<td>14.</td>
		<td>Wali Peserta Didik</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td>a. Nama</td>
		<td>:</td>
		<td class="xdata">
			<?php echo (isset($PD['nm_wali']))?strtoupper($PD['nm_wali']):""; ?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>b. No Telepon/HP</td>
		<td>:</td>
		<td class="xdata">
			<?php echo (isset($PD['telp_wali']))?$PD['telp_wali']:""; ?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>c. Alamat</td>
		<td>:</td>
		<td class="xdata">
			<?php echo (isset($PD['alamat_wali']))?strtoupper($PD['alamat_wali']):""; ?>
		</td>
	</tr>
	<tr>
		<td></td>
		<td>d. Pekerjaan</td>
		<td>:</td>
		<td class="xdata">
			<?php //echo (isset($PD['pekerjaan_wali']))?strtoupper($job[$PD['pekerjaan_wali']]):""; ?>
		</td>
	</tr>
	<tr><td colspan="4"><br></td></tr>
	<tr>
		<td colspan="4">
			<table class="identitas">	
				<tr>
					<td width="20%">
					<div class="myQR"><?php echo  $PD['qrcode']; ?></div>
					</td>
					<td width="13%"></td>
					<td width="15%">
						<div id="pastfoto">foto <br> 3 x 4</div>
					</td>
					<td width="13%"></td>
					<td width="49%">
						<?php echo strtoupper((isset($SP['city']))?$SP['city']:"Karangasem");?>, &nbsp;
						<?php echo strtoupper((isset($raport['issued']))?$raport['issued']:format_date(date("Y-m-d"))); ?> 
						<br><br><br><br>
						<strong>
							<u><?php echo (isset($raport['otorized_by']))?$raport['otorized_by']:""; ?></u>
						</strong><br>NIP.
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>
</html>