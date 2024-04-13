<?= $this->extend($layout) ?>
  <?= $this->section('main') ?>
  <?php  
  	$dataTable = (isset($dataTable))?$dataTable:TRUE;
  ?> 
    <?php 
    if(isset($resume)){ ?>
        <?php 
        $dfield = $resume['descrip_field'];
        $addfields = $resume['AddOnFields'];
        $RData = $resume['data'];
        $subtitle = (array_key_exists('subtitle',$resume))?$resume['subtitle']:"Keterangan";
        ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-titler text-info"><?= $subtitle ?>:</h5>
                <p class="card-text"><?= $RData[$dfield] ?></p>

                <?php
                    if(count($addfields) > 0 && count($addfields) <=3){
                        //TAMBAHKAN BARIS DAN COLOM
                        echo '<div class="row">'; //AWAL DIV ROW
                        foreach($addfields as $fd => $R)
                        {
                            echo '<div class="col">';	//START COL
                            echo $R['label'].": ";
                            $input = $inputype[$R['type']];
                            if($input == 'form_dropdown'){
                                $option = $opsi[$fd];
                                echo $option[$RData[$fd]];
                            }else{
                                echo $RData[$fd];
                            }
                            echo '</div>'; //END COL
                        }
                        echo '</div>'; //BATAS DIV ROW
                    }
                ?>

            </div>
        </div>	
    <?php }  //END OF RESUME 
    
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
				<a class="<?= $class ?>" id="<?= $id ?>-tab" data-toggle="tab" href="#<?= $id ?>" role="tab" aria-controls="<?= $id ?>" aria-selected="<?= $selected ?>"><?= $vl['title'] ?></a>
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
				<div class="card">
					<div class="card-body">
						<?= $vl['title'] ?>
					</div>
				</div>
			</div>
    <?php } 
		echo "</div>";
	} ?>

 	<div id="xcontent"></div>
 
 <?= $this->endSection() ?>
 
 <?= $this->section('pageScripts') ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
	
	<script>
		$(document).ready(function() {
		   $('#table-result').DataTable({
		      "dom": 'flrtip',
		      "buttons": [],
		      "responsive": true, 
		      "paging": true,
		      "lengthMenu": [[5, 20, 25, 50, 100, 250, 500, -1], [5, 20, 25, 50, 100, 250, 500, "All"]],
		      "lengthChange": true, 
		      "autoWidth": false, 
		      "scrollX": true,
		    });
		  
		    $('#vdetail').on('hidden.bs.modal', function (e) {
			  // do clear data on dtviews
			  $('#dtviews').html = "";
			})
			
			<?php if(isset($addONJs)){ echo $addONJs ;} ?>
			
		});
	</script>
  <?= $this->endSection() ?>
  
  