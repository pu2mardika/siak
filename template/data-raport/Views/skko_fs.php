<!DOCTYPE html>
<html>
<head><style>
	
	@font-face {
		font-family: myFirstFont;
		src: url(<?=base_url()?>font/FTLTLT.ttf);
	}
	@font-face {
		font-family: myndFont;
		src: url(<?=base_url()?>font/BRLNSDB.ttf);
	}
	@page { margin: 2px; }
	#container{
        /* The image used */
        background-image: url(<?=base_url()?>images/f_sttk.png);

        /* Full height */
        height: 99%;
		padding:-30px;
        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
		font-family: myFirstFont;
    }

	.fcontent{
		display: block;
		margin-top: 110px;
		padding: 0 130px;
	}

	.judul{
		margin-bottom:-5px; 
		font-family: arial;
		text-decoration: underline; 
		font-size: 24px; 
		font-weight: bolder; 
		color:#0000ff; 
		text-align: center;
		padding-top:20px;
	}

	.fnama{
		font-family: myndFont;
		font-weight:bold;
		font-size: 26px; 
		text-align: center; 
		text-decoration: underline;
		margin-top: 20px;
	}

	.isitext{
		margin-top: 40px; 
		text-align: center;
		line-height: 160%;
	}

	.dfield{
		border-style: none none dotted none; font-weight: bold;
		font-family: courier;
		padding: 0 10px;
		display: inline-block;
	}

	.noseri{
		float: right; text-align: center; 
		width: 250px; 
		display: block; border: #1a0d1e;
		margin-top: 20px;
	}
	.noseri::after {
		content: "";
		clear: both;
		display: table;
	}

	.footgrid{
		display: grid;
		grid-template-columns: auto auto;
		gap: 0;
	}

	.myQR {
		text-align: center;
	}


	#otoritas{
		float: right; 
		text-align: center; 
		width: 320px; 
		display: block; 
		margin-top: 60px;
	}

	.barcode { 
		float:left;
		text-align: center; 
		width: 270px; 
		height:160px;
		display: block; 
		margin-top: 60px;
	}

	.barcode-text {
		letter-spacing: 4px;
		margin-top: 1px;
		display: block;
	}

	.mybarcode{
		margin: 85px 0 5px 0;
		background:white;
		padding:3px;
		height: 70px;
		border: solid 1px blue;
	}

	.mybarcode img{
		max-width: 240px;
		height: 50px;
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
</style>
</head>
<body>
<div id="container">
	<div class="noseri">
		No. Reg: <?php echo $ID['NIPD'];?>
	</div>
	<div style="clear: both;"></div>

	<div style="margin-top: 88px; text-align: center">
		<div style="font-size: 10px;">Ijin Operasional No: <?=$legality['nomor'];?></div>
        <div style="font-size: 14px; font-weight: bold;">TERAKREDITASI B</div>
	</div>
	<div class="fcontent">
		<div style="font-size: 16px; text-align: center">
        Berdasarkan Undang-undang Nomor 20 Tahun 2003 tentang Sistem Pendidikan Nasional, Pimpinan <strong>Mandiri Bina Cipta [MBC]</strong><br>
        dengan ini menerangkan bahwa:
		</div>
		<div class="fnama">
			<?php echo strtoupper($ID['nama']); ?>
		</div>
		<div style="margin-top:10px; text-align: center">
            <span>Lahir di <span class="dfield"><?=$ID['tmp_lahir'];?></span></span> 
			<span> pada tanggal <span class="dfield"><?=$ID['tgl_lahir'];?></span></span>
		</div> 
		<div class="isitext">
			<span>dinyatakan <strong>TERAMPIL</strong> dalam bidang keterampilan</span>
			<span class="dfield"><?=$ID['program'];?></span> 
			<span>berdasarkan evaluasi yang dilaksanakan pada tanggal</span>
			<span class="dfield"><?=$ID['exam'];?></span> dengan predikat <span class="dfield"><?=$ID['predikat'];?></span>
		</div>

		<div class="footgrid">
			<div class="barcode">
				<div class="mybarcode">
				<?php echo $barcode ?>	
				<span class="barcode-text"><?php echo $dtbarcode ?></span>
				</div>
			</div>
			<div id="otoritas">
				<?php echo (isset($ID['city']))?$ID['city']:"Karangasem";?>, &nbsp;
				<?php echo (isset($ID['issued']))?$ID['issued']:format_date(date("Y-m-d")); ?><br>
				Ketua Lembaga Mandiri Bina Cipta 
				<br><br><br><br><br><br>
				<strong>
					<u>I NENGAH PUTU MARDIKA, S.Pd.,S.Akun</u>
				</strong>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
</div>
</body>
</html>