<?= $this->extend($layout) ?>
  <?= $this->section('main') ;
//test_result($rsdata['attributes']);
$val = $rsdata;
if (empty($rsdata)) {
	foreach ($fields as $k => $v) {
		$val[$k] = '';
	}
}

if(isset($subtitle)){echo $subtitle;}

echo (isset($descripsi))?$descripsi."<hr/>":"";
	
$Hidden = [];

if(isset($hidden)){$Hidden = $hidden ;}
	
echo form_open(current_url(),'',$Hidden);

foreach($fields as $fd => $row){
	
?>

<div class="row mb-3">
	<label class="col-sm-3 col-form-label" for="<?php echo $fd;?>" ><?php echo $row['label'];?></label>
	<div class="col-sm-9">
	<?php 
		$extra = $row['extra'];
		$extra['class'] = 'form-control';
	//	$extra['placeholder'] = $row['label'];
		
		//chek nilai NULL atau tidak
		$nilai = (is_null($val[$fd]))?"":$val[$fd];
		
		$input = $inputype[$row['type']];
		
		if($input == 'form_dropdown'){
			$option = $opsi[$fd];
			//echo $input($fd,$option,set_select($fd,$val[$fd]),$extra);
			echo form_dropdown($fd,$option,$nilai,$extra);
		}elseif($input == 'form_hidden'){
			$data = [
			    'type'  => 'hidden',
			    'name'  => $fd,
			    'id'    => $fd,
			    'value' => set_value($fd,$nilai),
			    'class' => $extra['class'],
			];
			echo form_input($data);
			//echo $input($fd,set_value($fd,$val[$fd]),$extra,$row['type']);
		}else{
		//	echo set_value($fd,$val[$fd]);
			echo $input($fd,set_value($fd,$nilai),$extra,$row['type']);
		}
		
	?>
	</div>	    
</div>

<?php } ?>
<div class="text-center">
  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Simpan</button>
  <button type="reset" class="btn btn-secondary">Reset</button>
</div>
<?php echo form_close();?>
<?= validation_list_errors() ?>
<?= $this->endSection() ?>

<?php  if(isset($addONJs)){
	$this->section('pageScripts');
?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script> 
	$(document).ready(function() {
		<?= $addONJs ?>
	});			
</script>
<?php
	$this->endSection();
}
?>