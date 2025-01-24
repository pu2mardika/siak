<?= $this->extend($layout) ?>
<?= $this->section('main') ;?>

<div class="row justify-content-md-center">
    <div class="col-md-auto text-info">
      <?php echo (isset($instruction))?$instruction:"";?>
    </div>
</div>
<?php
//tetapkan nilai masing-masing form
foreach ($fields as $k => $v) {
	if(key_exists($k, $rsdata))
	{
		$val[$k] = $rsdata[$k];
	}else{
		$val[$k] = '';
	}
}

if(isset($subtitle)){echo $subtitle;}

$Hidden = [];

if(isset($hidden)){$Hidden = $hidden ;}
	
echo form_open(current_url(),'',$Hidden);

foreach($fields as $fd => $row){
	//CEK KONDISI FIELDS
	$extra = $row['extra'];
	$extra['class'] = 'form-control';
//	$extra['placeholder'] = $row['label'];
	
	//chek nilai NULL atau tidak
	$nilai = (is_null($val[$fd]))?"":$val[$fd];
	
	$input = $inputype[$row['type']];
	
	if($input == 'form_dropdown'){
		$option = $opsi[$fd];
		//echo $input($fd,$option,set_select($fd,$val[$fd]),$extra);
		$formInput = form_dropdown($fd,$option,$nilai,$extra);
	}elseif($input == 'form_hidden'){
		$data = [
			'type'  => 'hidden',
			'name'  => $fd,
			'id'    => $fd,
			'value' => set_value($fd,$nilai),
			'class' => $extra['class'],
		];
		$row['label']="";
		$formInput = form_input($data);
		//echo $input($fd,set_value($fd,$val[$fd]),$extra,$row['type']);
	}else{
	//	echo set_value($fd,$val[$fd]);
		$formInput = $input($fd,set_value($fd,$nilai),$extra,$row['type']);
	}
?>
	<div class="row mb-3">
		<label class="col-sm-3 col-form-label" for="<?php echo $fd;?>"><?php echo $row['label'];?></label>
		<div class="col-sm-9"><?=$formInput?></div>	    
	</div>

<?php } ?>
<div class="text-right">
  <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i>&nbsp;Lanjut</button>
</div>
<?php echo form_close();?>
<?= validation_list_errors() ?>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<?php if($session->getFlashdata('warning')) { ?>
	<script>
	  swal("Oops...", "<?php echo $session->getFlashdata('warning'); ?>","warning")
	</script>
<?php } ?>
<?php if($session->getFlashdata('sukses')) { ?>
	<script>
	  swal("Berhasil", "<?php echo $session->getFlashdata('sukses'); ?>","success")
	</script>
<?php } ?>
<?php if($session->getFlashdata('errors')) { ?>
	<script>
	  swal("Oops...", "<?php echo $session->getFlashdata('errors'); ?>","warning")
	</script>
<?php } 
if(isset($addONJs)){	
?>
<script> 
	$(document).ready(function() {
		<?= $addONJs ?>
	});			
</script>



<?php
}
$this->endSection();
?>