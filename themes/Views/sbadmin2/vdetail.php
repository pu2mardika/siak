<?= $this->extend($layout) ?>
  <?= $this->section('main') ?>
<?php
//test_result($rsdata['attributes']);
$val = $rsdata;
if (empty($rsdata)) {
	foreach ($fields as $k => $v) {
		$val[$k] = '';
	}
}
?>
<!-- Modal -->
<div class="modal-content">
	<div class="modal-header bg-info text-white">
	<h5 class="modal-title" id="staticBackdropLabel">Data Detail</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
	</div>
	<div class="modal-body">
<?php
foreach($fields as $fd => $row){	
?>
	<div class="row">
		<div class="col" ><?php echo $row['label'];?></div>
		<div class="col-7">
		<?php 
			$input = $inputype[$row['type']];
			if($input == 'form_dropdown'){
				$option = $opsi[$fd];
				echo $option[$val[$fd]];
			}else{
				echo $val[$fd];
			}
		?>
		</div>	
	</div>    
<?php } ?>
	</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
	</div>
</div>
<?=$this->endSection() ?>