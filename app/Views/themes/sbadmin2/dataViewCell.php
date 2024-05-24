<?= $this->extend($layout) ?>
  <?= $this->section('main') ?>
  <?php  
    //ISI TAB JIKA ADA
	/**
	 * KOMPONEN TABS $tabs['home'=>['state'=>'active', 'data'=>$data]]
	 * 
	 */
    if(isset($tabs)){ 
		echo '<ul class="nav nav-tabs" id="myTab" role="tablist">';
		//pengulangan NAVIGASI TABS
		foreach($tabs as $id => $vl){	
		//$TABS['subject'] = ['active'=>1, 'data'=>[]];
			$class =  'nav-link'; $selected = "false";
			if($vl['active']==1){
				$class 	  = 'nav-link active';
				$selected = 'true';
			}
	?>
			<li class="nav-item">
				<a class="<?= $class ?>" id="<?= $id ?>-tab" data-toggle="tab" href="#<?= $id ?>" role="tab" aria-controls="<?= $id ?>" aria-selected="<?= $selected ?>"><?= strtoupper($vl['title']) ?></a>
			</li>
		<?php } 
		echo "</ul>"; 
		
		//BARIS TAB CONTENT
		echo '<div class="tab-content" id="myTabContent">';
			//pengulangan TABS CONTENT
			foreach($tabs as $id => $vl){	
				//$TABS['subject'] = ['active'=>1, 'data'=>[]];
					$class =  'tab-pane fade'; $selected = "false";
					if($vl['active']==1){
						$class 	  = 'tab-pane fade show active';
						$selected = 'true';
					}
			?>
			<div class="<?= $class ?>" id="<?= $id ?>" role="tabpanel" aria-labelledby="<?= $id ?>-tab">
				<div class="card"><?= $vl['vcell'] ?></div>
			</div>
    <?php } 
		echo "</div>";
	} ?>

 	<div id="xcontent"></div>
 
 <?= $this->endSection() ?>
 
 <?= $this->section('pageScripts') ?>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

	<?php if($session->getFlashdata('sukses')) { ?>
	<script>
	  swal("Berhasil", "<?php echo $session->getFlashdata('sukses'); ?>","success")
	</script>
	<?php } ?>

	<?php 
	if(isset($error)) { 
		if(is_array($error))
		{
			$error = (count($error)==0)?"":implode("<br/> ",$error); 
		}
		if(strlen($error)){
	?>
		<script>
		  swal("Oops...", "<?php echo strip_tags($error); ?>","warning")
		</script>
	<?php }
	 } ?>

	<?php if($session->getFlashdata('warning')) { ?>
	<script>
	  swal("Oops...", "<?php echo $session->getFlashdata('warning'); ?>","warning")
	</script>
	<?php } ?>
	
	<?php if($error = $session->getFlashdata('errors')) { 
		if(is_array($error))
			{
				$error = (count($error)==0)?"":implode(" ",$error); 
			}
			if(strlen($error)){
	?>
				<script>
				  swal("Oops...", "<?php echo $error; ?>","warning")
				</script>
	<?php   }
	   } ?>
  <?= $this->endSection() ?>
  
  