<div class="idsp" style="display: inline-block; width: 100%">
	<div style="padding-top: 80px;text-align: center;">
		<div style="font-family: arial;margin-bottom:-5px; font-size: 24px; font-weight: bolder; color:#0000ff;">
			RAPOR
		</div>
		<div style="margin-top:-5px;font-weight: bold;font-size: 18px"><?php echo strtoupper($PS['skl']); ?></div>
	</div>
	
	<div style="margin-top: 30px; padding: 30px;">
		<table width="100%" border="0">
			<tr>
				<td width="30%">Nama Satuan Pendidikan</td>
				<td width="3%">:</td>
				<td width="67%" style="border-bottom: dotted thin;">
					<strong>PKBM&nbsp;<?php echo strtoupper($SP['nm_satker']); ?></strong>
				</td>
			</tr>
			<tr>
				<td>NPSN</td>
				<td>:</td>
				<td style="border-bottom: dotted thin;">
					<?php echo (isset($SP['id_uo']))?$SP['id_uo']:""; 
						echo (isset($SP['akreditasi']))?" terakreditasi : ".$SP['akreditasi']:"";
					?>
				</td>
			</tr>
			<tr>
				<td>Alamat Satuan Pendidikan</td>
				<td>:</td>
					<td style="border-bottom: dotted thin;">
						<?php echo $SP['address1']; ?>
				</td>
			</tr>
			<?php if(! is_null($SP['address2'])) {?>
			<tr style="height: 30px;">
				<td></td>
				<td></td>
				<td style="border-bottom: dotted thin;">
						<?php echo (isset($SP['address2']))?$SP['address2']:"&nbsp;"; ?>
				</td>
			</tr>
			<?php } ?>
			<tr style="height: 40px;">
				<td>Telepon</td>
				<td>:</td>
				<td style="border-bottom: dotted thin;">
						<?php echo $SP['phone']; ?>
				</td>
			</tr>
			<tr style="height: 30px;">
				<td>Kelurahan</td>
				<td>:</td>
				<td style="border-bottom: dotted thin;">
					<?php echo (isset($SP['kelurahan']))?$SP['kelurahan']:""; ?>
				</td>
			</tr>
			<tr style="height: 30px;">
				<td>Kecamatan</td>
				<td>:</td>
				<td style="border-bottom: dotted thin;">
					<?php echo (isset($SP['kecamatan']))?$SP['kecamatan']:""; ?>
				</td>
			</tr>
			<tr style="height: 30px;">
				<td>Kabupaten/Kota</td>
				<td>:</td>
				<td style="border-bottom: dotted thin;">
					<?php echo (isset($SP['city']))?$SP['city']:""; ?>
				</td>
			</tr>
			<tr style="height: 30px;">
				<td>Provinsi</td>
				<td>:</td>
				<td style="border-bottom: dotted thin;">Bali</td>
			</tr>
			<tr style="height: 30px;">
				<td>Website</td>
				<td>:</td>
				<td style="border-bottom: dotted thin;">
					<?php echo strtolower($SP['website']); ?>
				</td>
			</tr>
			<tr style="height: 30px;">
				<td>Email</td>
				<td>:</td>
				<td style="border-bottom: dotted thin;">
					<?php echo strtolower($SP['email']); ?>
				</td>
			</tr>
			<tr style="height: 30px;">
				<td>Facebook</td>
				<td>:</td>
				<td style="border-bottom: dotted thin;">
					<?php echo (isset($SP['facebook']))?$SP['facebook']:""; ?>
				</td>
			</tr>
			<tr style="height: 30px;">
				<td>Twitter</td>
				<td>:</td>
				<td style="border-bottom: dotted thin;">
						<?php echo (isset($SP['twitter']))?$SP['twitter']:""; ?>
				</td>
			</tr>
			<tr style="height: 30px;">
				<td>Instagram</td>
				<td>:</td>
				<td style="border-bottom: dotted thin;">
				<?php echo (isset($SP['instagram']))?$SP['instagram']:""; ?>
				</td>
			</tr>
		</table>
	</div>
</div>
</body>
</html>