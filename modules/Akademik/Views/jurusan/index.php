  <?= $this->extend('themes/'.$settingWeb->theme.'/layout') ?>
  <?= $this->section('main') ?>
  <div class="card">
	<div class="card-header">
		<h5 class="card-title">Daftar Module</h5>
	</div>
	
	<div class="card-body">
		<?php
		
		helper ('html');
			echo btn_label([
				'attr' => ['class' => 'btn btn-success btn-xs'],
				'url' => current_url() . '/add',
				'icon' => 'fa fa-plus',
				'label' => 'Tambah Module'
			]);
			
			echo btn_label([
				'attr' => ['class' => 'btn btn-light btn-xs'],
				'url' => current_url(),
				'icon' => 'fa fa-arrow-circle-left',
				'label' => 'Daftar Module'
			]);
		?>
		<hr/>
		<?php $locale = service('request')->getLocale();
		echo $locale;?>
  
	    <table id="table-result" class="table table-bordered" width="100%" cellspacing="0">
	    	<thead>
				<tr>
				  	<th width="5%"><div align="center">No</div></th>
					<th width="23%"><div align="center"><?php echo lang('Akademik.prodi_name');?> </div></th>
					<th width="28%"><div align="center"><?php echo lang('Akademik.prodi_desc');?></div></th>
					<th width="20%"><div align="center"><?php echo lang('Akademik.jur_name');?></div></th>
					<th width="8%"><div align="center"><?php echo lang('Akademik.prodi_grade');?></div></th>
					<th width="8%"><div align="center"><?php echo lang('Akademik.is_active');?></div></th>
					<th width="8%"><div align="center"><?php echo lang('Akademik.action');?></div></th>
				</tr> 
			</thead>
			<tbody>
		 <?php
			//``id_prodi`, `nm_prodi`, `desc`, `id_jur`, `jenjang`, `state``
			$no=0;
			foreach ($jurusan as $data){
			$no++;
			
			$ids=$data->id;
			
			echo '<tr class="bordered">';
		?>
				<td align="center"><?php echo $no; ?> &nbsp;</td>
				<td class="nowrapped" align="left"><?php echo $data->nm_prodi; ?></td>
				<td class="nowrapped" align="left"><?php echo $data->desc; ?></td>
				<td class="nowrapped" align="left"><?php echo $data->id_jur; //$jurdd[$data->id_jur]; ?></td>
				<td class="nowrapped" align="left"><?php echo $data->jenjang; //$egrid[$data->jenjang]; ?></td>
				<?php 
					$sts=lang('Akademik.ico_state_arr');
					$vsts=$data->state;
				?>
				
				<td class="wrapped" align="center">
					
					<?php // echo $this->fungsi->ajx_link("akademik/togle_ps/".$ids."/".$vsts,"#x_result",$sts[$data->state]);?>
				</td>
				<td align="center">
					
				</td>
				
			</tr>
			
		 <?php
		  }
		  ?>
		  	</tbody>
		</table>
	  </div>
  </div>
 
 <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h3 class="modal-title">Book Form</h3>
      </div>
      <div class="modal-body form">
        <form action="#" id="form" class="form-horizontal">
          <input type="hidden" value="" name="book_id"/>
          <div class="form-body">
            <div class="form-group">
              <label class="control-label col-md-3">Book ISBN</label>
              <div class="col-md-9">
                <input name="book_isbn" placeholder="Book ISBN" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Book Title</label>
              <div class="col-md-9">
                <input name="book_title" placeholder="Book_title" class="form-control" type="text">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">Book Author</label>
              <div class="col-md-9">
								<input name="book_author" placeholder="Book Author" class="form-control" type="text">

              </div>
            </div>
						<div class="form-group">
							<label class="control-label col-md-3">Book Category</label>
							<div class="col-md-9">
								<input name="book_category" placeholder="Book Category" class="form-control" type="text">

							</div>
						</div>

          </div>
        </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
 
 
 <?= $this->endSection() ?>
 
 <?= $this->section('js') ?>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

  <script>
    var site_url = "<?php echo site_url(); ?>";	
	$(document).ready(function() {
            var table = $('#myTable').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?php echo site_url('jurusan/dtlist') ?>",
                    "type": "POST"
                },
                "columnDefs": [{
                    "targets": [],
                    "orderable": false,
                }, ],
            });
        }); 
  </script>
  <?= $this->endSection() ?>
  
  