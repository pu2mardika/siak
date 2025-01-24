<?php
$input = $inputype[$type];
$nilai = (isset($nilai))?$nilai:"";
$forID = $extra['id'];
$extra['class'] = 'form-control';
if($input == 'form_dropdown'){
    $option = $rdata;
    $formInput = form_dropdown($field,$option,$nilai,$extra);
}elseif($input == 'form_hidden'){
    $data = [
        'type'  => 'hidden',
        'name'  => $field,
        'id'    => $extra['id'],
        'value' => $nilai,
        'class' => $extra['class'],
    ];
    $label="";
    $formInput = form_input($data);
    //echo $input($fd,set_value($fd,$val[$fd]),$extra,$row['type']);
}else{
//	echo set_value($fd,$val[$fd]);
    $formInput = $input($field,set_value($field,$nilai),$extra,$type);
}
?>
    <label for="<?php echo $forID;?>"><?=$label?></label>
	<?=$formInput?>	    
