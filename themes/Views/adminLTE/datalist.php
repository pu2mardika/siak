<?= $this->extend($layout) ?>
  <?= $this->section('main') ?>
		<h5 class="card-header">
			<?php if(isset($dtfilter)){ ?>
					<?= $title ?>
					<span class="float-end dropdown">
						<a role="button" class="btn btn-light border-light rounded-pill" title="<?=$dtfilter['title']?>" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-ellipsis-v"></i>
						</a>
						<div class="dropdown-menu">
							<?php 
							$source=$dtfilter['source'] ;
							$filter=$$source;
							unset($filter[$dtfilter['cVal']]);
							foreach($filter as $k => $desc)
							{
								echo '<a class="dropdown-item" href="'.base_url($dtfilter['action'].$k).'">'.$desc.'</a>';
							}
							?>
						</div>
					</span>
			
			<?php } ?>
		</h5>
	
	<div class="card-body">
		<?php
		$Acction = current_url(); 
		$allowAdd =TRUE;
		$allowAct =TRUE;
		$dom = (isset($dom))?$dom:'Bfltip';
		if(isset($act)){$Acction = $act ;}
		if(isset($allowADD)){$allowAdd = $allowADD;}
		if(isset($allowACT)){$allowAct = $allowACT;}
			
		$datalist = $Acction.'dtlist';
		$hfield=[];
		helper ('html');
			if($allowAdd){
				$addAct = (isset($panelAct['add']))?$panelAct['add']:$Acction.'/add';
				echo btn_label([
					'attr' => ['class' => 'btn btn-success btn-xs'],
					'url' => $addAct,
					'icon' => 'fa fa-plus',
					'label' => 'Tambah Data'
				]);
			}
			if($allowimport){
				$ImportAct = (isset($panelAct['import']))?$panelAct['import']:$Acction.'/import';
				echo btn_label([
					'attr' => ['class' => 'btn btn-primary btn-xs'],
					'url' => $ImportAct,
					'icon' => 'fa fa-file-excel-o',
					'label' => 'Import dari Excel'
				]);
			}
		?>
		<hr/>
		
		<table id="table-result" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                        data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
	    	<thead class="thead-dark" data-page-length='25' data-order='[[ 0, "asc" ]]'>
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
			$plain =(isset($isplainText))?$isplainText:false;
			$no=0;
			foreach ($rsdata as $data){
			$no++;
			$ids=  $data->$key;
		
			if($plain){$ids = encrypt($ids) ;}
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

					if(isset($ajxAction))
					{
						foreach($ajxAction as $aksi)
						{
							if($aksi['extra']=="")
							{
								$act = 'onclick = "show(\''.$aksi["src"].$ids.'\',\'#idviews\')"';
								$href = "javascript:";
							}else{
								$act  = $aksi['extra'];
								$href = base_url().$aksi['src'].$ids;
							}
							//$act="show('".$aksi['src'].$ids."','#xcontent')";
							echo '<a href="'.$href.'" '.$act.' title="'.$aksi['label'].'"><i class="fa fa-'.$aksi['icon'].'"></i></a> ';
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
							$url = (array_key_exists($data->state,$condActDet))?$condActDet[$data->state]:[];
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

	<?php if($session->getFlashdata('konfirm')) { ?>
    <script>
      swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel plx!",
        closeOnConfirm: false,
        closeOnCancel: false
      })
	 .then((isConfirm) => {
        if (isConfirm) {
          swal("Deleted!", "Your imaginary file has been deleted.", "success");
        } else {
          swal("Cancelled", "Your imaginary file is safe :)", "error");
        }
      });
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
		      "dom": '<?=$dom?>',
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