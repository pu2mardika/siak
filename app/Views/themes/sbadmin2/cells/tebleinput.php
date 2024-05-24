<div class="card" style="height: 200px; overflow: auto;">
<?php if(count($resData)>0){?>
    <table class="table table-striped table-data small">
        <tr>
            <th width="5%">#</th>
            <?php foreach($fields as $key => $dt){ ?>
            <th width="<?=$dt['width']?>%"><div align="center"><?=$dt['label']?> </div></th>
            <?php } ?>
        </tr> 
    <?php 
        $no=0;
        foreach ($resData as $data){
        $no++;
        
        $tr = '<tr class="bordered">';
        echo $tr;
    ?>
            <td align="center" valign="middle"><?=$no?></td>
            <?php foreach($fields as $fd => $row){ 
                $extra = $row['extra'];
                $extra['id']= $extra['id'].$no;
                $extra['class'] = 'form-control form-control-sm';
                $nilai = (array_key_exists($fd, $data))?$data[$fd]:"";
                $input = (array_key_exists($row['type'], $inputype))?$inputype[$row['type']]:"display";
            //    $input = $inputype[$row['type']];
                //cek apabila ada yang menggunakan referensi
                if($input == "display"){
                    $formInput = $nilai;
                }elseif($input == 'form_dropdown'){
                    $option = $opsi[$fd];
                    $formInput = form_dropdown($fd."[]",$option,$nilai,$extra);
                }elseif($input == 'form_hidden'){
                    $dinput = [
                        'type'  => 'hidden',
                        'name'  => $fd."[]",
                        'id'    => $extra['id'],
                        'value' => set_value($fd,$nilai),
                        'class' => $extra['class'],
                    ];
                    $formInput = form_input($dinput).$nilai;
                    //echo $input($fd,set_value($fd,$val[$fd]),$extra,$row['type']);
                }else{
                    $formInput = $input($fd."[]",set_value($fd,$nilai),$extra,$row['type']);
                }	
            ?>
            <td class="wrapped" valign="middle" align="left"><?= $formInput ?></td>
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