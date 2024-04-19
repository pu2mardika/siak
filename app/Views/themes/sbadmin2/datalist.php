<?= $this->extend($layout) ?>
  <?= $this->section('main') ?>
   
	<div class="card-header">
		<h5 class="card-title"><?= $title ?></h5>
	</div>
	
	<div class="card-body">
		<?php
		$Acction = current_url(); 
		$allowAdd =TRUE;
		$allowAct =TRUE;
		
		if(isset($act)){$Acction = $act ;}
		if(isset($allowADD)){$allowAdd = $allowADD;}
		if(isset($allowACT)){$allowAct = $allowACT;}
			
		$datalist = $Acction.'dtlist';
		$hfield=[];
		helper ('html');
			if($allowAdd){
				echo btn_label([
					'attr' => ['class' => 'btn btn-success btn-xs'],
					'url' => $Acction . '/add',
					'icon' => 'fa fa-plus',
					'label' => 'Tambah Data'
				]);
			}
			if($allowimport){
				echo btn_label([
					'attr' => ['class' => 'btn btn-primary btn-xs'],
					'url' => $Acction . '/import',
					'icon' => 'fa fa-file-excel-o',
					'label' => 'Import dari Excel'
				]);
			}
			echo btn_label([
				'attr' => ['class' => 'btn btn-light btn-xs'],
				'url' => $Acction,
				'icon' => 'fa fa-arrow-circle-left',
				'label' => 'List Data'
			]);
		?>
		<hr/>
		  
	    <table id="table-result" class="table table-striped table-bordered" width="100%" cellspacing="0" 
	    data-order='[[ 0, "asc" ]]' data-page-length='25'>
	    	<thead class="thead-dark">
				<tr>
					<?php 
					$hasopt = [];
					foreach($fields as $k =>$row){
						$l = $row['width'];
						if($l > 0){
							$hfield[]=$k;
							if($row['type'] === 'dropdown')
							{
								$hasopt[]=$k;
							}
							echo '<th width="'.$l.'%"><div align="center">'.$row['label'].'</div></th>';
						}
					}		
					if($allowAct){
					?>
					<th width="9%"><div align="center">Aksi</div></th>
					<?php } ?>
				</tr> 
			</thead>
			<tbody>
		 <?php
			//$encrypter = \Config\Services::encrypter();
			
			$no=0;
			foreach ($rsdata as $data){
			$no++;
			$ids=  $data->$key;
		
			if(isset($isplainText)){$ids = encrypt($ids) ;}
		?>
				<tr>
					<?php 
					foreach($hfield as $hc){
						$Algn = 'left';
						
						$dtval = $data->$hc;
						if($fields[$hc]['type']=='date')
						{
							if(isset($ori)){$dtval = unix2Ind($data->$hc,'d-m-Y');}
						}
						if(in_array($hc, $hasopt)){$dtval = $opsi[$hc][$data->$hc];}
						
						if (is_integer($dtval)||is_float($dtval)||is_double($dtval)) {
							$Algn = "right";$dtval = format_angka($dtval);
						}
						echo '<td class="nowrapped" align="'.$Algn.'" valign="top">'.$dtval.'</td>';
					}
					$deturl = (isset($detail_url))?$detail_url:$Acction."/detail";
					
					if($allowAct){
					?>
					
					<td class="nowrapped" align ="center" >
					<?php
					if(isset($addOnACt)){
						foreach($addOnACt as $act)
						{
							echo "<a href='".base_url().$act['src'].$ids."' title='".$act['label']."'><i class='fa fa-".$act['icon']."'></i></a> ";
						}
					}
					
					if(isset($actions)){
						foreach($actions as $btn => $act)
						{
							echo "<a href='".base_url().$act['src'].$ids."' ".$act['extra']." title='".$act['label']."'><i class='fa fa-".$act['icon']."'></i></a> ";
							
						}
					}
								
					if(isset($condActDet))
						{
							$url = $condActDet[$data->state];
							foreach($url as $act)
							{
							//	$id= $ids;
								$href = ($act['src']=="#")?"#":base_url().$act['src'].$ids;
								echo "<a href='".$href."' title='".$act['label']."' ".
									 $act['attr']."><i class='fa fa-".$act['icon']."'></i></a> ";
							}
						}
					?>
					</td>
					<?php } ?>
				</tr>
			
		 <?php
		 	
		  }
		  ?>
		  	</tbody>
		</table>
		
		<?php
		  if(isset($resume)){
		  	$dfield = $resume['field'];
		  	
		  	echo '<div class="card w-50 "><div class="card-body"><h5 class="card-titler">Keterangan:</h5>';
		  	echo "<table class='table table-sm'>";
		  	foreach($resume['data'] as $k => $R)
		  	{
		  		echo "<tr><td>".$dfield[$k]['label']."</td>";
		  		echo "<td align='".$dfield[$k]['perataan']."'>".$R."</td></tr>";
		  	}
		  	echo '</table></div></div>';
		  }
		  ?>
	  </div>
	  
	  <div id="idviews">
	  	<div class="modal fade" id="vdetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div id="dtviews"  class="modal-dialog">
		  </div>
		</div>
	  </div>
	 
 
 <?= $this->endSection() ?>
 
 <?= $this->section('pageScripts') ?>
    <?php if($session->getFlashdata('sukses')) { ?>
	<script>
	  swal("Berhasil", "<?php echo $session->getFlashdata('sukses'); ?>","success")
	</script>
	<?php } ?>

	<?php if(isset($error)) { ?>
	<script>
	  swal("Oops...", "<?php echo strip_tags($error); ?>","warning")
	</script>
	<?php } ?>

	<?php if($session->getFlashdata('warning')) { ?>
	<script>
	  swal("Oops...", "<?php echo $session->getFlashdata('warning'); ?>","warning")
	</script>
	<?php } ?>
	
	<script>
		$(document).ready(function() {
		   $('#table-result').DataTable({
		      "dom": 'Bfltip',
		      "buttons": ["copy", "csv", "excel", "pdf", "print"],
		      "responsive": true, 
		      "paging": true,
		      "lengthMenu": [[5, 20, 25, 50, 100, 250, 500, -1], [5, 20, 25, 50, 100, 250, 500, "All"]],
		      "lengthChange": true, 
		      "autoWidth": false, 
		      "scrollX": true,
		      "sort":true,
		    });
		  
		    $('#vdetail').on('hidden.bs.modal', function (e) {
			  // do clear data on dtviews
			  $('#dtviews').html = "";
			})
			
		});
	</script>
  <?= $this->endSection() ?>
  
  