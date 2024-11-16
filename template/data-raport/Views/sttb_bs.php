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
	#bscontainer{
        /* The image used */
        background-image: url(<?=base_url()?>images/bg_mbc.png);
        /* Full height */
        height: 98%;
		padding:0 30px;
        /* Center and scale the image nicely */
        background-position: center;
        background-repeat: no-repeat;
        font-family: Arial, Helvetica, sans-serif;
    }

	.jhead{
		margin-top:10px;
		font-family: arial;
		font-size: 24px; 
		font-weight: bolder; 
		text-align: center;
		padding-top:60px;
        display:block;
	}

    .jhead .subjudul {
        font-size: 16px; 
        text-align: center;
    }
    .jhead hr{
        width: 45%;
        color:#0000ff; 
    }

    .bcontent{
		display: block;
		margin-top: 20px;
		padding: 0 130px;
	}

    #identitas{
        margin-top:14px;font-size: 16px; text-align: left; line-height: 150%;
    }

    #identitas .label{
        display: inline-block;
        width: 150px;
    }

    #identitas .dtteks{
        display: inline-block;
    }

	.bstext{
		text-align: justify;
        height:300px;
        margin-top:10px;
        display:block;
	}

    .bstext table{
        width: 100%;
        border-collapse: collapse;
        border: 2px solid #1E90FF;
    }

    table thead th{
        border: 1px solid #1E90FF;
        padding: 9px 2px;
        background-color: #F2F2F2; 
        border-bottom:3px double #1E90FF;
    }

    table tbody td{
        border: thin solid #1E90FF;
        padding: 6px 4px;
    }

    td .nomor{
        align:center;
    }

    td .mapel{
        padding-left:5px;
    }

    td .nilai{
        padding-right:15px;
    }

    tfoot{
        border-top:2px solid #1E90FF;
    }

    table tfoot td{
        border: thin solid #1E90FF;
        padding: 6px 4px;
    }

    .bsfootgrid{
        display: grid;
		grid-template-columns: auto auto;
		gap: 0;
	}
    
    .qrcode { 
		float:left;
		text-align: center; 
		width: 180px; 
		height:180px;
		display: block; 
		margin-top: 10px;
	}

	.qrcode img{
		width: 180px;
		height: 180px;
	}

	#bsotoritas{
		float: right; 
		text-align: center; 
		width: 320px; 
		display: block; 
		margin-top: 20px;
	}
</style>
</head>
<body>
<div id="bscontainer">
    <div class="jhead">
        DAFTAR NILAI EVALUASI AKHIR
        <div class="subjudul">
            PAKET PROGRAM <?=strtoupper($ID['program']); ?><br>
            TINGKAT <?=strtoupper($ID['grade'])?>
        </div>
        <hr>
    </div>

    <div class="bcontent">
		<div id="identitas">
			<span class="label">NAMA</span><span class="dtteks">:&nbsp;<?php echo strtoupper($ID['nama']); ?></span><br>
            <span class="label">NOMOR INDUK</span><span class="dtteks">:&nbsp;<?php echo strtoupper($ID['NIPD']); ?></span><br>
		</div>
		
		<div class="bstext">
			<table>
                <thead>
                    <tr>
                        <th width="10%">NO</th>
                        <th width="70%">MATA PELATIHAN</th>
                        <th width="20%">NILAI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; $rowMax=5; $jml=0;
                    foreach($mapel as $mp){ 
                    ?>
                        <tr>
                            <td align="center"><?=$no; ?></td>
                            <td><i><?= $mp['nama_mapel'];?></i></td>
                            <td align="right"><?= format_angka($mp['nilai'],2);?>&nbsp;</td>
                        </tr>
                    <?php  
                    $jml += $mp['nilai'];
                    $no++; } 
                    if(count($mp)< $rowMax){
                        for ($x = $no; $x <= $rowMax; $x++){
                            echo "<tr><td></td><td></td><td></td></tr>";
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">JUMLAH</td>
                        <td align="right"><?= format_angka($jml,2);?>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">RATA-RATA</td>
                        <td align="right"><?= format_angka($ID['avgn'],2);?>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="3">PREDIKAT : &nbsp;<em><strong><?=strtoupper($ID['predikat']);?></strong></em></td>
                    </tr>
                </tfoot>
            </table>
		</div>
        
        <div class="bsfootgrid">
            <div class="qrcode">
                <?php echo $qrcode ?>	
            </div>
            <div id="bsotoritas">
                <?php echo (isset($ID['city']))?$ID['city']:"Karangasem";?>, &nbsp;
                <?php echo (isset($ID['issued']))?$ID['issued']:format_date(date("Y-m-d")); ?><br>
                <strong>LKP Mandiri Bina Cipta</strong>
                <br><br><br><br><br>
                <strong>
                    <u><?php echo (isset($ID['otorized_by']))?$ID['otorized_by']:""; ?></u>
                </strong>
                <br>Direktur
            </div>
        </div>

	</div>
</div>
</body>
</html>