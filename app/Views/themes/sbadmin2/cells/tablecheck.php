<div class="card" style="height: 200px; overflow: auto;">
<?php if(count($resData)>0){?>
    <table class="table table-striped table-data small">
        <thead>    
            <tr>
                <?php foreach($fields as $key => $dt){ 
                    $head = ($dt['type']=='checkbox')?'<input type="checkbox" id="chkAll">':'<div align="center">'.$dt['label'].'</div>'
                ?>
                <th width="<?=$dt['width']?>%"><?=$head?></th>
                <?php } ?>
            </tr> 
        </thead>
        <tbody>
    <?php 
        //$keys=$this->config->item('dynamic_key');
        $no=0;  
        foreach ($resData as $data){
        $no++;  
        $idpd=$data[$keys];   
    ?>
        <tr class="bordered">
            <?php foreach($fields as $fd => $row){ 
                $extra = [];
                if(array_key_exists('extra', $row))
                {
                    $extra = $row['extra'];
                    $extra['id']= $extra['id'].$no;
                    $extra['class'] = 'form-control form-control-sm';
                }
                $nilai = (array_key_exists($fd, $data))?$data[$fd]:"";
                $input = (array_key_exists($row['type'], $inputype))?$inputype[$row['type']]:"display";
                $name = (array_key_exists("name",$extra))?$extra['name']:$fd."[]";

                if(array_key_exists('display', $row))
                {
                    $input = ($row['display']==1)?$input:'display';
                }
                 
                //cek apabila ada yang menggunakan referensi
                if($input == "display"){
                    $formInput = $nilai;
                }elseif($input == 'form_dropdown'){
                    $option = $opsi[$fd];
                    $formInput = form_dropdown($fd."[]",$option,$nilai,$extra);
                }elseif($input == 'form_hidden'){
                    $dinput = [
                        'type'  => 'hidden',
                        'name'  => $name,
                        'id'    => $extra['id'],
                        'value' => set_value($fd,$nilai),
                        'class' => $extra['class'],
                    ];
                    $formInput = form_input($dinput).$nilai;
                }elseif($input == 'form_checkbox'){
                    $chacked = (array_key_exists('check',$data))?"checked":"";
                    $value = set_value($fd,$nilai);
                    $fid = $extra['id'].$no;
                    $formInput = '<input type="checkbox" name="'.$name.'" class="chkbox" value="'.$value.'" id="'.$fid.'" '.$chacked.'>';
                }else{
                    $formInput = $input($name,set_value($fd,$nilai),$extra,$row['type']);
                }	
            ?>
            <td class="wrapped" valign="middle" align="left"><?= $formInput ?></td>
            <?php }?>	
        </tr>

        <?php }//batas foreach  ?>
        </tbody>
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