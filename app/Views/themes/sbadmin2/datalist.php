  <?= $this->extend($layout) ?>
  <?= $this->section('main') ?>
   
	<div class="card-header">
		<h5 class="card-title"><?= $title ?></h5>
	</div>
	
	<div class="card-body">
		<?php
		$datalist = current_url().'dtlist';
		$hfield=[];
		helper ('html');
			echo btn_label([
				'attr' => ['class' => 'btn btn-success btn-xs'],
				'url' => current_url() . '/add',
				'icon' => 'fa fa-plus',
				'label' => 'Tambah Data'
			]);
			if($allowimport){
				echo btn_label([
					'attr' => ['class' => 'btn btn-primary btn-xs'],
					'url' => current_url(). '/import',
					'icon' => 'fa fa-file-excel-o',
					'label' => 'Import dari Excel'
				]);
			}
			echo btn_label([
				'attr' => ['class' => 'btn btn-light btn-xs'],
				'url' => current_url(),
				'icon' => 'fa fa-arrow-circle-left',
				'label' => 'List Data'
			]);
		?>
		<hr/>
		  
	    <table id="table-result" class="table table-striped table-bordered" width="100%" cellspacing="0" 
	    data-order='[[ 1, "asc" ]]' data-page-length='25'>
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
					?>
					<th width="9%"><div align="center">Aksi</div></th>
				</tr> 
			</thead>
			<tbody>
		 <?php
			//$encrypter = \Config\Services::encrypter();
		
		//$ciphertext = $encrypter->encrypt($plainText);
			$no=0;
			foreach ($rsdata as $data){
			$no++;
			$ids=  $data->$key;
		?>
				<tr>
					<?php 
					foreach($hfield as $hc){
						$dtval = $data->$hc;
						if($fields[$hc]['type']=='date')
						{
							if(isset($ori)){$dtval = unix2Ind($data->$hc,'d-m-Y');}
						}
						if(in_array($hc, $hasopt)){$dtval = $opsi[$hc][$data->$hc];}
						echo '<td class="nowrapped" align="left">'.$dtval.'</td>';
					}
					$deturl = (isset($detail_url))?$detail_url:current_url()."/detail";
					?>
					
					<td class="nowrapped" align="center">
					<?php if($actions['detail']){?>
					<a id="<?=$ids ?>" class="btndetail" href="<?php echo $deturl.'/'.$ids; ?>"><i class="fa fa-list-alt"></i></a>	
					<?php } if($actions['edit']){?>
					<a href='<?php echo current_url().'/edit/'.$ids; ?>' title="Edit"><i class="fa fa-edit"></i></a> 
					<?php } if($actions['delete']){?>
					<a href='<?php echo current_url().'/hapus/'.$ids; ?>' onclick="confirmation(event)" title="Hapus"><i class="fa fa-trash"></i></a> 
					<?php } ?>
					</td>
				</tr>
			
		 <?php
		 	
		  }
		  ?>
		  	</tbody>
		</table>
	  </div>
	  <div id="idviews">
	  	<div class="modal fade" id="vdetail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		  <div id="dtviews"  class="modal-dialog">
		  </div>
		</div>
	  </div>
 
 <?= $this->endSection() ?>
 
 <?= $this->section('pageScripts') ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

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
		      "dom": 'Bflrtip',
		      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
		      "responsive": true, 
		      "paging": true,
		      "lengthMenu": [[5, 20, 25, 50, 100, 250, 500, -1], [5, 20, 25, 50, 100, 250, 500, "All"]],
		      "lengthChange": true, 
		      "autoWidth": false, 
		      "scrollX": true,
		    });
		  
		  /*   
		    $('.btndetail').click(function(){
		    	var k = $(this).prop('id');
		    	var ur = "/<?php echo strtolower($current_module['nama_module']);?>";
			//	load('lognilai/shwpd/'+k,'#x_result');
		    	show(ur+'/detail/'+k,'#dtviews');
		    	$('#vdetail').modal({
				  	keyboard: false
				}).modal('show');
		    });
		  */  
		    $('#vdetail').on('hidden.bs.modal', function (e) {
			  // do clear data on dtviews
			  $('#dtviews').html = "";
			})
			
		});
	</script>
  <?= $this->endSection() ?>
  
  