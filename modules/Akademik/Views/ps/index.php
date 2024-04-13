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
  
	    <table id="myTable" class="table small">
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
			foreach ($prodi->result_array() as $data){
			$no++;
			
			$ids=$data['id'];
			
			echo '<tr class="bordered">';
		?>
				<td align="center"><?php echo $no; ?> &nbsp;</td>
				<td class="nowrapped" align="left"><?php echo $data['nm_prodi']; ?></td>
				<td class="nowrapped" align="left"><?php echo $data['desc']; ?></td>
				<td class="nowrapped" align="left"><?php echo $jurdd[$data['id_jur']]; ?></td>
				<td class="nowrapped" align="left"><?php echo $egrid[$data['jenjang']]; ?></td>
				<?php 
					$sts=lang('Akademik.ico_state_arr');
					$vsts=$data['state'];
				?>
				
				<td class="wrapped" align="center">
					
					<?php echo $this->fungsi->ajx_link("akademik/togle_ps/".$ids."/".$vsts,"#x_result",$sts[$data['state']]);?>
				</td>
				<td align="center">
					<a id="dialog_link" onclick='show("akademik/edit_ps/<?=$ids;?>","#x_panel")' title="<?php echo lang('Akademik.actions_change');?>"><?php echo lang('Akademik.ico_edit');?></a>|
					<a id="dialog_link" onclick='show("akademik/delps/<?=$ids;?>","#xxx")' title="<?php echo lang('Akademik.actions_delete');?>"><?php echo lang('Akademik.ico_trash-o');?></a>
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
            // dataTables plugin
            $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings)
            {
                return {
                    "iStart": oSettings._iDisplayStart,
                    "iEnd": oSettings.fnDisplayEnd(),
                    "iLength": oSettings._iDisplayLength,
                    "iTotal": oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                    "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                };
            };
            // ====================================================================================================

            // Tampil Data ========================================================================================
            // ----------------------------------------------------------------------------------------------------
            // datatables serverside processing
            var table = $('#myTable').DataTable( {
                "bAutoWidth": false,
                "scrollY": '58vh',
                "scrollCollapse": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo site_url('docregister/dtlist') ?>",
                    "type": "POST"
                },"columnDefs": [ 
                    { "targets": 0, "data": null, "orderable": false, "searchable": false, "width": '30px', "className": 'center' },
                    { "targets": 1, "width": '130px', "className": 'center' },
                    { "targets": 2, "width": '80px', "className": 'center' },
                    { "targets": 3, "width": '170px' },
                    { "targets": 4, "width": '100px', "className": 'right' },
                    { "targets": 5, "width": '80px', "className": 'right' },
                    { "targets": 6, "width": '120px', "className": 'right' },
                    {
                      "targets": 7, "data": null, "orderable": false, "searchable": false, "width": '70px', "className": 'center',
                      "render": function(data, type, row) {
                          var btn = "<a style=\"margin-right:7px\" title=\"Ubah\" class=\"btn btn-info btn-sm getUbah\" href=\"#\"><i class=\"fas fa-edit\"></i></a><a title=\"Hapus\" class=\"btn btn-danger btn-sm btnHapus\" href=\"#\"><i class=\"fas fa-trash\"></i></a>";
                          return btn;
                      } 
                    } 
                ],
                "order": [[ 1, "desc" ]],           // urutkan data berdasarkan id_transaksi secara descending
                "iDisplayLength": 10,               // tampilkan 10 data
                "rowCallback": function (row, data, iDisplayIndex) {
                    var info   = this.fnPagingInfo();
                    var page   = info.iPage;
                    var length = info.iLength;
                    var index  = page * length + (iDisplayIndex + 1);
                    $('td:eq(0)', row).html(index);
                }
            } );
            
        });   
  </script>
  <?= $this->endSection() ?>
  
  