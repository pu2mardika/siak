<div class="card" style="height: 200px; overflow: auto;">
<?php if(count($resData)>0){?>
    <table class="table table-striped table-data small">
        <tr>
            <th width="4%"><input type="checkbox" id="chkAll"></th>
            <?php foreach($fhead as $key => $dt){ ?>
            <th width="<?=$dt['width']?>%"><div align="center"><?=$dt['label']?> </div></th>
            <?php } ?>
        </tr> 
    <?php 
        //$keys=$this->config->item('dynamic_key');
        $no=0;
        foreach ($resData as $data){
        $no++;
        $idpd=$data[$keys];   
        $tr = '<tr class="bordered">';
        
        echo $tr;
    ?>
            <td align="center" valign="top">
            <input type="checkbox" name="pd[]" id="<?php echo $idpd;?> " class="chkbox" value="<?php echo $idpd;?>">
            </td>
            <?php foreach($fhead as $key => $dt){ 
                //cek apabila ada yang menggunakan referensi
                if(in_array($key,$has_ref)){
                    $clmn= $opsi[$key];
                    $data[$key]=$clmn[$data[$key]];
                }	
            ?>
            <td class="wrapped" align="left"><?php echo $data[$key]; ?></td>
            <?php }?>	
        </tr>
        <?php }//batas foreach  ?>
    </table>
        </tr>
        <?php
    }else{
        echo "Tidak ada yang ditemukan";
    } // end of if
        ?>
</div>
<script type="text/javascript">                   
jQuery(document).ready(function($) {
    $('#chkAll').change(function(){
        $(".chkbox").prop("checked",$(this).prop("checked"));
    });
    $('.chkbox').change(function(){
        if($(this).prop("cheked")==false){
            $("#chkAll").prop("checked",false);
        }
        if($(".chkbox:checked").lenght == $(".chkbox").lenght){
            $("#chkAll").prop("checked",true);
        }
    });
});
</script>