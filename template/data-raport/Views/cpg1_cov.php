<!DOCTYPE html>
<html>
<head><style>
	
	.xborder{
		background: #fff;
		display: block;
		margin: 3px;
		padding: 9px;
		border: solid 1px #00007f;
	}
	.judul{
		font-family: arial;
		font-size: 24px;
		font-weight: bold;
		text-align: center;
	}

	.identitas{
		width: 100%;
		border: 0;
		background: #fff;
		border-collapse: collapse;
		font-family: Calibri, Arial, Trebuchet MS;
		table-layout: fixed;
		font-size: 16px;
		/*margin-top: 20px;*/
	}
	.idsp td{
		font-weight: normal;
		height: 30px;
	}

	.identitas td{
		font-weight: normal;
		height: 25px;
	}
	.identitas td.xdata{
		font-weight: normal;
		border-bottom: dotted thin;
	}
	.myQR {
		text-align: center;
	}

	.p-break-a{
		page-break-after: avoid;
	}

	#pastfoto{
		height: 60px;
		width: 60px;
		background-color: FloralWhite;
		border: 1px solid red;
 		padding: 15px 5px;
		border-radius: 10px;
		text-align: center;
	}
	@media print{
		.xborder {
			margin: 0 auto;
			page-break-before: always;
			border: 0;
			padding: 0;
		}
		.p-break{
			page-break-before: avoid;
		}
		.p-break-a{
			page-break-after: avoid;
		}
	}
</style>
</head>
<body>
<div style="text-align: center;">
	<div style="float: right; text-align: center; width: 200px; display: block; border: #1a0d1e">
		No. Raport: <?php echo $norpt;?>
	</div>
	<div style="clear: both;"></div>

	<div style="margin-top: 100px">
		<img src="<?=$SP['logo']?>" alt="LOGO"  height="60" width="180"/>
	</div>
	<div style="padding-top: 80px;">
		<div style="font-family: arial;margin-bottom:-5px; font-size: 24px; font-weight: bolder; color:#0000ff;">
			LAPORAN HASIL BELAJAR PESERTA DIDIK
		</div>
		<div style="margin-top:10px;font-weight: bold;font-size: 18px"><?php echo strtoupper($PS['nm_program']." ".$PS['nm_prodi']); ?></div>
		<div style="margin-top:8px;font-weight: bold;font-size: 14px"><?php echo strtoupper($PS['skl']); ?></div>
	</div>
	<div style="margin-top: 160px">
		<div style="margin-top:0px;font-weight: bold;font-size: 18px">
			NAMA PESERTA DIDIK
		</div>
		<div style="margin-top:0px;font-weight: bold;font-size: 20px">
			<span style="width: 400px; padding: 5px; border: 1px solid #0c0d44; display: inline-block;"><?php echo strtoupper($siswa['nama']); ?></span>
		</div>
	</div>
	<div style="margin-top: 30px">
		<div style="margin-top:0px;font-weight: bold;font-size: 18px">
			NOMOR INDUK / NISN
		</div>
		<div style="margin-top:0px;font-weight: bold;font-size: 20px">
			<span style="width: 400px; padding: 5px; border: 1px solid #0c0d44; display: inline-block;"><?php echo $siswa['noinduk']." / ".$siswa['nisn']; ?></span>
		</div>
	</div>
	<div style="margin-top: 300px">
		<div style="margin-top:0px;font-weight: bold;font-size: 24px">
			<?php echo strtoupper($SP['nm_satker']); ?>
		</div>
		<div>
			<span><?php echo $SP['address1']." ".$SP['address2']; ?></span><br>
			<span>
			Telp. <?php echo $SP['phone']." | Web: ".$SP['website']." email: ".$SP['email']; ?>
			</span>
		</div>
	</div>
</div>