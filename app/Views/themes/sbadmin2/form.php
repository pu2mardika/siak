<?= $this->extend($layout) ?>
  <?= $this->section('main') ;
//test_result($rsdata['attributes']);

/*
$val = $rsdata;
if (empty($rsdata)) {
	foreach ($fields as $k => $v) {
		$val[$k] = '';
	}
}
*/
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
	$forID = $extra['id'];
	
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
		<label class="col-sm-3 col-form-label" for="<?php echo $forID;?>"><?php echo $row['label'];?></label>
		<div class="col-sm-9"><?=$formInput?></div>	    
	</div>

<?php } ?>
<div class="text-center">
  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Simpan</button>
  <button type="reset" class="btn btn-secondary">Reset</button>
</div>
<?php echo form_close();?>
<?= validation_list_errors() ?>
<?= $this->endSection() ?>

<?php  if(isset($addONJs)||isset($useCKeditor)){ ?>
	<?php $this->section('pageScripts'); ?>

	<?php  if(isset($addONJs)){ ?>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script> 
			$(document).ready(function() {
				<?= $addONJs ?>
			});			
		</script>
	<?php }	?>

	<?php  if(isset($useCKeditor)){ ?>
		<script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
		<style>
			.ck-editor__editable_inline{
				min-height: 200px;
			}
		</style>
		<script>
			ClassicEditor
				.create( document.querySelector( '#editor' ) )
				.catch( error => {
					console.error( error );
				} );
		</script>
	<?php } ?>

	<?php $this->endSection(); ?>
<?php } ?>