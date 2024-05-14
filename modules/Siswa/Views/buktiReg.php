<!DOCTYPE html>  
<html lang="en">  

<head>  
    <meta charset="UTF-8">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>BUKTI PENDAFTARAN</title>
    <style>
        body { 
            background-image: url('images/bg_mbc.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center; 
        }
        .judul {
            border: 2px outset blue;
            background-color: lightblue;    
            text-align: center;
            width: 500px;
        }
        .myQR {
            border: 2px outset blue;
            background-color: lightblue;    
            text-align: center;
            width: 160px;
            height:160px;
        }
        .mybarcode{
            border: 2px outset blue;
            background-color: white;    
            text-align: center;
            padding:3px;
            max-widht:90%;
            min-width: 90px;
        }
        .barcode-text {
            letter-spacing: 7px;
            margin-top: 1px;
            display: block;
        }
        center h4{
            margin-top:-20px;
            text-decoration:none;
        }
        center h2 {
            text-decoration: underline;
        }
    </style>
</head>  

<body> 
    <center> 
        <img src="<?= $logo ?>" alt="LOGO"  height="60" width="180"/>
        <h2 style="font-weight: bold;">TANDA BUKTI PENDAFTARAN </h2>
        <h4>REG.No: <?php echo $rsdata['idreg'];?></h4>
    </center>
    <table border=0 width=100% cellpadding=2 cellspacing=0 style="margin-top: 5px; text-align:left">  
        <tr>
            <th align=left>&nbsp;</th> 
            <td colspan="2">&nbsp;</td>
            <td rowspan="3">
                <div class="mybarcode">
                    <?=$rsdata['barcode']?>
                    <span class="barcode-text"><?php echo $rsdata['noinduk'] ?></span>
                </div>
            </td>
        </tr>
        <tr>
            <th align=left>Program Pilihan</th> 
            <td colspan="2">: <?=$rsdata['nm_prodi']?></td>
        </tr>
        <tr>
            <th align=left>No Induk</th> 
            <td colspan="2">: <?=$rsdata['noinduk']?></td>
        </tr>
        <tr>  
            <th width="20%" bgcolor=silver></th>  
            <td width="1px" bgcolor=silver></td>  
            <td width="45%" bgcolor=silver></td>  
            <td width="35%" bgcolor=silver></td>  
        </tr> 
        <?php 
        foreach($fields as $fd => $dt){
        ?>
        <tr>
            <th align=left><?=$dt['label']?></th> 
            <?php 
            $val=$rsdata[$fd];
            if($dt['type'] === 'dropdown'){
                $val=$opsi[$fd][$rsdata[$fd]];
            }

            if($dt['type'] === 'date'){
                #unx time
            //  $Tgl=date_format(date_create($rsdata[$fd]),"Y-m-d");
            // $val=format_tanggal($rsdata[$fd]);
            $val = $rsdata[$fd];
            }
            ?>
            <td colspan="3">: <?=$val?></td>   
        </tr>
        <?php } ?> 

        <tr>
            <td colspan="2">
                <br>
                <div class="myQR"><?php echo $rsdata['qrcode'];?></div>
            </td>
            <td></td>
            <td>
                Karangaseam, <?php echo format_date($rsdata['created_at'])?>
                <br><span><?= ucwords(strtolower($instansi)) ?></span>
                <br><br><br><br><br>
                <?php echo $user;?>
            </td>
        </tr>
    </table> 
</body>  
</html>