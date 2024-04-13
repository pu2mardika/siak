  <?= $this->extend('themes/'.$settingWeb->theme.'/layout') ?>
  <?= $this->section('main') ?>
  <div class="card">
	<div class="card-header">
		<h5 class="card-title">Daftar Siswa</h5>
	</div>
	
	<div class="card-body">
		<?php
		
		helper ('html');
			echo btn_label([
				'attr' => ['class' => 'btn btn-success btn-xs'],
				'url' => current_url() . '/add',
				'icon' => 'fa fa-plus',
				'label' => 'Tambah Data'
			]);
			
			echo btn_label([
				'attr' => ['class' => 'btn btn-light btn-xs'],
				'url' => current_url(),
				'icon' => 'fa fa-arrow-circle-left',
				'label' => 'Daftar Siswa'
			]);
		?>
		<hr/>
		<?php $locale = service('request')->getLocale();
		//echo $locale;?>
  
	    <table id="table-result" class="table table-bordered" width="100%" cellspacing="0">
	    	<thead>
				<tr>
				  	<th width="5%"><div align="center">No</div></th>
					<th width="20%"><div align="center">NIK / No. KTP</div></th>
					<th width="25%"><div align="center">Nama Lengkap</div></th>
					<th width="20%"><div align="center">NISN</div></th>
					<th width="21%"><div align="center">Alamat</div></th>
					<th width="11%"><div align="center">No. HP</div></th>
					<th width="9%"><div align="center">Aksi</div></th>
				</tr> 
			</thead>
			<tbody>
		 <?php
			//``id_prodi`, `nm_prodi`, `desc`, `id_jur`, `jenjang`, `state``
			$no=0;
			foreach ($dtsiswa as $data){
			$no++;
			
			$ids=$data->id;
			
			echo '<tr class="bordered">';
		?>
				<td align="center"><?php echo $no; ?> &nbsp;</td>
				<td class="nowrapped" align="left"><?php echo $data->nik; ?></td>
				<td class="nowrapped" align="left"><?php echo $data->nama; ?></td>
				<td class="nowrapped" align="left"><?php echo $data->nisn; //$jurdd[$data->id_jur]; ?></td>
				<td class="nowrapped" align="left"><?php echo $data->alamat; //$egrid[$data->jenjang]; ?></td>
				<td class="nowrapped" align="left"><?php echo $data->nohp; //$egrid[$data->jenjang]; ?></td>
				<td class="nowrapped" align="center"><a href='<?php echo base_url('siswa/edit/'.$data->nik) ?>' class='btn-warning btn-sm'><i class="fa fa-edit"></a>|<a href='<?php echo base_url('siswa/hapus/'.$data->nik) ?>' class='btn-danger btn-sm' onclick="confirmation(event)"><i class="fa fa-trash"></i></a></td>
			</tr>
			
		 <?php
		  }
		  ?>
		  	</tbody>
		</table>
	  </div>
  </div>
 
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
                    "url": "<?php echo site_url('siswa/dtlist') ?>",
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
  
  