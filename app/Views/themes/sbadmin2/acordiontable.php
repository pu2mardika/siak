<?= $this->extend($layout) ?>
<?= $this->section('main') ?>
<div class="card-header">
	<h5 class="card-title">
		<?= $title ?>
		<?php if(isset($dtfilter)){ ?>
			<span class="float-right dropdown">
				<a type="button" title="<?=$dtfilter['title']?>" data-toggle="dropdown" aria-expanded="false">
					<i class="fa fa-ellipsis-v"></i>
				</a>
				<div class="dropdown-menu">
					<?php 
					$source=$dtfilter['source'] ;
					$filter=$$source;
					unset($filter[$dtfilter['cVal']]);
					foreach($filter as $k => $desc)
					{
						//$k = encrypt($k);
						echo '<a class="dropdown-item" href="'.base_url($dtfilter['action'].$k).'">'.$desc.'</a>';
					}
					?>
				</div>
			</span>
		<?php } ?>
	</h5>
</div>
<div class="card-body">
<?php
	$Acction = current_url(); 
	if(isset($act)){$Acction = $act ;}
	if(isset($ajaxAct)){
		$n++;
		foreach($ajaxAct as $aksi)
		{
			$act="show('".$aksi['src']."','#xcontent')";
			echo '<a class="btn'.$aksi['btn_type'].'" href="javascript:" 
			onclick="'.$act.'" title="'.$aksi['label'].'"><i class="fa fa-'.$aksi['icon'].'"></i>&nbsp;'.$aksi['label'].'</a>';
		}
	} //END ajaxACt
	
	if(isset($panelAct)){
		foreach($panelAct as $aksi)
		{
			echo "<a role='button' class='btn ".$aksi['btn_type']."'  href='".base_url().$aksi['src'].
				"' title='".$aksi['label']."'><i class='fa fa-".$aksi['icon']."'></i>&nbsp;".$aksi['label']."</a> ";
		}
	}
	echo btn_label([
		'attr' => ['class' => 'btn btn-light btn-xs'],
		'url' => $Acction,
		'icon' => 'fa fa-arrow-circle-left',
		'label' => 'List Data'
	]);
	?>
	<hr/>
	<div id="accordion">
		<?php
	// $k=0;
		foreach($rsdata as $k => $row)
		{
			$show = ""; $expend="false";
			if($k == 1){
				$show = " show";
				$expend = "true";
			}
			$judul = $subtitle." ".$k;
		?>
		<div class="card">
			<div class="card-header" id="heading<?=$k?>">
				<h5 class="mb-0">
					<button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?=$k?>" aria-expanded="<?=$expend?>" aria-controls="collapse<?=$k?>">
					<?=$judul?>
					</button>
				</h5>
			</div>
			<div id="collapse<?=$k?>" class="collapse<?=$show?>" aria-labelledby="heading<?=$k?>" data-parent="#accordion">
				<?php foreach($row as $id => $rs){ ?>
					<div class="card">
						<div class="card-header">
							<?=$rs['gtitle']?>
						</div>
						<div class="card-body">
							<table class="table table-bordered table-sm">
								<thead class="thead-light">
								<tr>
									<th width="5%">#</th>
									<?php foreach($fields as $key => $dt){ //MENYIAPKAN  JUDUL COLOM TABEL ?>
									<th width="<?=$dt['width']?>%"><div align="center"><?=$dt['label']?> </div></th>
									<?php } ?>
								</tr>
								</thead><tbody>
								<?php //pengulangan isi tabel 
								$no=1;
								foreach($rs['detail'] as $rc){
									echo "<tr>";
									echo '<td valign="top" align="center"><div align="center">'.$no.'</div></td>';
									foreach($fields as $fd =>$val)
									{
										$Algn = 'left';
										$dtval = $rc[$fd];
										if($val['type']=='date')
										{
											if(isset($ori)){$dtval = unix2Ind($rc[$fd],'d-m-Y');}
										}

										if (is_integer($dtval)||is_float($dtval)||is_double($dtval)) {
											$Algn = "right";$dtval = format_angka($dtval);
										}
										echo '<td class="nowrapped" align="'.$Algn.'" valign="middle">'.$dtval.'</td>';
									}
									echo "</tr>";
									$no++;
								}
								?>
								</tbody>
							</table>
						</div>
					</div><br>
				<?php } ?>
			</div>
	</div>
	<?php } ?>
	</div> 
</div>
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
  
  