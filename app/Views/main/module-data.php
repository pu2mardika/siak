<?= $this->extend($layout) ?>
<?= $this->section('main') ?>
<div class="card">
	<div class="card-header">
		<h5 class="card-title">Daftar Module</h5>
	</div>
	
	<div class="card-body">
		<?php
		
		helper ('xhtml');
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
		<?php 
		if (!$result) {
			show_message('Data tidak ditemukan', '', false);
		} else {
			if (!empty($msg)) {
				show_alert($msg);
			}
			?>
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
			<thead>
			<tr>
				<th>ID</th>
				<th>Nama Module</th>
				<th>Judul Module</th>
				<th>Deskripsi</th>
				<th>File</th>
				<th>Login</th>
				<th>Aktif</th>
				<th>Aksi</th>
			</tr>
			</thead>
			<tbody>
			<?php
			$no = 1;
			$login = ['Y' => 'Ya', 'N' => 'Tidak', 'R' => 'Restrict'];
			foreach ($result as $key => $val) {
				if ($val['id_module_status'] == 1) {
					//$id_module_status = 0;
					$checked = 'checked';
					$btn_class = 'btn-danger';
					$btn_text = 'Non Aktifkan';
				} elseif ($val['id_module_status'] != 1) {
					//$id_module_status = 1;
					$checked = '';
					$btn_class = 'btn-success';
					$btn_text = 'Aktifkan';
				}
				
				$checked_login = $val['login'] == 1 ? 'checked' : '';
				
				$disabled = $current_module['nama_module'] == $val['nama_module'] ? ' disabled' : '';
				
				$file_exists = in_array( str_replace('-', '_', $val['nama_module']) . '.php', $file_module) ? 'Ada' : 'Tidak Ada';
				echo '<tr>
						<td>' . $val['id_module'] . '</td>
						<td>' . $val['nama_module'] . '</td>
						<td>' . $val['judul_module'] . '</td>
						<td>' . $val['deskripsi'] . '</td>
						<td>' . $file_exists . '</td>
						<td>' . $login[ $val['login'] ] . '</td>
						<td>
							<input data-switch="aktif" id="switch-'.$val['id_module'].'" type="checkbox" data-module-id="'.$val['id_module'].'" name="aktif" class="switch is-rounded is-info is-small" '.$checked. $disabled .'>
							<label for="switch-'.$val['id_module'].'"></label>
						</td>
						<td>
							<div class="btn-action-group">
								<a href="' . current_url() . '/edit?id=' . $val['id_module'] .'" class="btn btn-success btn-xs mr-1"><i class="fa fa-edit"></i>&nbsp;Edit</a>
								<form method="post" action="'.current_url().'">
									<button data-action="delete-data" data-delete-title="Hapus Module?" type="submit" class="btn btn-danger btn-xs" name="delete"><i class="fas fa-times"></i>&nbsp;Delete</button>
									<input type="hidden" name="id" value="'.$val['id_module'].'"/><input type="hidden" name="delete" value="delete"/>
								</form>
							</div>
						</td>
					</tr>';
				$no++;
			}
			?>
			</tbody>
			</table>
			<?php 
		} ?>
		
	</div>
</div>
 <?= $this->endSection() ?>
 
 <?= $this->section('pageScripts') ?>
 
 <?= $this->endSection() ?>