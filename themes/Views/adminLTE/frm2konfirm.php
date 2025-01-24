<?= $this->extend($layout) ?>
  <?= $this->section('main') ?>
   
	<div class="card-header">
		<h5 class="card-title"><?= $title ?></h5>
	</div>
	
	<div class="card-body"> 
		<?php
		if(count($fields)>0){
			if(isset($hidden)){$Hidden = $hidden ;}
			echo form_open($act,'',$Hidden);    
		    foreach($fields as $fd => $row){	
			?>
				<div class="row">
					<div class="col-3" ><?php echo $row['label'];?></div>
					<div class="col-9">:&nbsp;
					<?php 
						$input = $inputype[$row['type']];
						if($input == 'form_dropdown'){
							$option = $opsi[$fd];
							echo $option[$rsdata[$fd]];
						}else{
							echo $rsdata[$fd];
						}
					?>
					</div>	
				</div>    
			<?php } ?>
			<hr>
				<div class="row">
					<div class="col-9" >
						<div class="form-check">
						  <input name="confirm" class="form-check-input" type="checkbox" value="1" id="defaultCheck1">
						  <label class="form-check-label" for="defaultCheck1">
						    <?=$confirm_desc;?>
						  </label>
						</div>
					</div>
					<div class="col-2">
						<button type="submit" class="btn btn-primary"><i class="fa fa-arrow-alt-circle-right"></i>&nbsp;LANJUT</button>
					</div>
				</div>
			<?php echo form_close();
		}else{
			echo btn_label([
				'attr' => ['class' => 'btn btn-warning btn-xs'],
				'url' => $act,
				'icon' => 'fa fa-close',
				'label' => 'Kembali'
			]);
		}
		
		?>	 
	  </div>
 
 <?= $this->endSection() ?> 
 
 <?php if(isset($error)) { 
 	$this->section('pageScripts')
 ?>
	<script>
	  swal("Oops...", "<?php echo strip_tags($error); ?>","warning")
	</script>
<?php 
	$this->endSection();
} ?>