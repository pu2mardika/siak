  <?= $this->extend($layout) ?>
  <?= $this->section('main') ?>
   
	<div class="card-header">
		<h5 class="card-title"><?= $title ?></h5>
	</div>
	
	<div class="card-body">
		<?php
	//	$url = current_url();
	//	echo $uri->se
		$datalist = current_url().'dtlist';
		$urisegment = $uri->getSegments();
		$url = base_url($urisegment[0]);
		$hfield=[];
		helper ('html');
			echo btn_label([
				'attr' => ['class' => 'btn btn-success btn-xs', "id"=>'cmdadd', 'data-toggle' => "modal", 'data-target'=>"#vdetail"],
				'url' => $url.'/add',
				'icon' => 'fa fa-plus',
				'label' => 'Tambah Data'
			]);
			
			if($allowimport){
				echo btn_label([
					'attr' => ['class' => 'btn btn-primary btn-xs', "id"=>'cmdimport'],
					'url' => $url. '/import',
					'icon' => 'fa fa-file-excel-o',
					'label' => 'Import dari Excel'
				]);
			}
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
					$deturl = (isset($detail_url))?$detail_url:"detail";
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
		  <div id="dtviews"  class="modal-dialog" role="document">
		  	<div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div id="cviews" class="modal-body">
		        ...
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		        <button type="button" class="btn btn-primary">Save changes</button>
		      </div>
		    </div
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
		  
		     
		    $('#cmdadd').click(function(){
		    	var k = $(this).prop('id');
		    	var ur = "/jabatan/add";
			//	load('lognilai/shwpd/'+k,'#x_result');
		    	show(ur,'#dtviews');
		    });
		    
		    $('#vdetail').on('hidden.bs.modal', function (e) {
			  // do clear data on dtviews
			  $('#cviews').html = "";
			})
			
		});
	</script>
  <?= $this->endSection() ?>
  
  