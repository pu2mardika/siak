<center> 
    <img src="<?=$rsdata['logo']?>" alt="LOGO"  height="60" width="180"/>
    <h2 style="line-height: 1.3; font-weight: bold;">TANDA BUKTI PENDAFTARAN </h2>
    <h4> 
        <div><?php echo $rsdata['judul'];?></div>
        <div>REG.No: <?php echo $rsdata['idreg'];?></div>
    </h4>
</center>
<table border=0 width=100% cellpadding=2 cellspacing=0 style="margin-top: 5px; text-align:left">  
    <tr>  
        <th width="25%" bgcolor=silver></th>  
        <td width="1px" bgcolor=silver></td>  
        <td width="40%" bgcolor=silver></td>  
        <td width="35%" bgcolor=silver></td>  
    </tr> 
    
    <tr>
        <th align=left>Reg. No</th> 
        <td colspan="3">: <?=$rsdata['idreg']?></td>
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
            $Tgl=date_format(date_create($rsdata[$fd]),"Y-m-d");
            $val=format_tanggal($Tgl);
        }
        ?>
        <td colspan="3">: <?=$val?></td>   
    </tr>
    <?php } ?> 

    <tr>
        <td colspan="2">
            <br>
            <div class="myQr"><?php echo $rsdata['qrcode'];?></div>
        </td>
        <td></td>
        <td>
            Karangaseam, <?php echo format_tanggal($Tgl)?>
            <br><br><br><br><br>
            <?php echo $rsdata['nama'];?>
        </td>
    </tr>
</table> 