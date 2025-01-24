<?= $this->extend($layout) ?>
<?= $this->section('main') ?>
<div class="card-header">
	<h5 class="card-title">
		<?= $title ?>
		<?php if(isset($dtfilter)){ ?>
			<span class="float-right dropdown">
				<a role="button" class="btn btn-light border-light rounded-pill" title="<?=$dtfilter['title']?>" data-toggle="dropdown" aria-expanded="false">
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
			$parm="";
			if(array_key_exists("param",$aksi) && isset($dtparm))
			{
				$param=$aksi['param']; $getvar=[]; $postVar=[];
				foreach($param as $k => $p)
				{
					if(array_key_exists($p,$dtparm)){
						$getvar[]=$k."=".$dtparm[$p];
						$postVar[]=$dtparm[$p];
					}
				}
				$parm = "?".implode("&",$getvar);
				if(array_key_exists('method', $aksi))
				{
					if($aksi['method']=="POST")
					{
						$parm = "/".encrypt(implode($strdelimeter,$postVar));
					}
				}
			}
			$act="show('".$aksi['src'].$parm."','#xcontent')";
			echo '<a class="btn'.$aksi['btn_type'].'" href="javascript:" 
			onclick="'.$act.'" title="'.$aksi['label'].'"><i class="fa fa-'.$aksi['icon'].'"></i>&nbsp;'.$aksi['label'].'</a>';
		}
	} //END ajaxACt
	
	if(isset($panelAct)){
		foreach($panelAct as $aksi)
		{
			$parm="";
			if(array_key_exists("param",$aksi) && isset($dtparm))
			{
				$param=$aksi['param']; $getvar=[]; $postVar=[];
				foreach($param as $k => $p)
				{
					if(array_key_exists($p,$dtparm)){
						$getvar[]=$k."=".$dtparm[$p];
						$postVar[]=$dtparm[$p];
					}
				}
				$parm = "?".implode("&",$getvar);
				if(array_key_exists('method', $aksi))
				{
					if($aksi['method']=="POST")
					{
						$parm = "/".encrypt(implode($strdelimeter,$postVar));
					}
				}
			}
			echo "<a role='button' class='btn ".$aksi['btn_type']."'  href='".base_url().$aksi['src'].$parm.
				"' title='".$aksi['label']."'><i class='fa fa-".$aksi['icon']."'></i>&nbsp;".$aksi['label']."</a> ";
		}
	}
	?>
	<hr/>
	<div id="daccordion">
		<?php
	// $k=0;
		foreach($rsdata as $k => $row)
		{
			$show = ""; $expend="false";
			if($k == 1){
				$show = " show";
				$expend = "true";
			}
			$lv1=$k;
			$judul = $subtitle." ".$k;
		?>
		<div class="card">
			<div class="card-header" id="heading<?=$k?>">
				<h5 class="mb-0">
					<button class="btn btn-link" data-toggle="collapse" data-target="#xcollapse<?=$k?>" aria-expanded="<?=$expend?>" aria-controls="xcollapse<?=$k?>">
					<?=$judul?>
					</button>
				</h5>
			</div>
			<div id="xcollapse<?=$k?>" class="collapse<?=$show?>" aria-labelledby="heading<?=$k?>" data-parent="#daccordion">
				<?php foreach($row as $id => $rs){ 
						$lv2="";
				?>
					<div class="card">
						
						<?php if(array_key_exists("gtitle", $rs)){
						 $lv2=$strdelimeter.$id;
						?>
						<div class="card-header">
							<?=$rs['gtitle']?>
						</div>
						<?php }?>

						<div class="card-body">
							<table class="table table-bordered table-sm">
								<thead class="thead-light">
								<tr>
									<th width="5%"><div align="center">#</div></th>
									<?php foreach($fields as $k => $dt){ //MENYIAPKAN  JUDUL COLOM TABEL ?>
									<th width="<?=$dt['width']?>%"><div align="center"><?=$dt['label']?> </div></th>
									<?php } 
									if(isset($actions) && count($actions)>0)
									{
										echo '<th width="8%"><div align="center">Aksi</div></th>';
									}
									?>
								</tr>
								</thead><tbody>
								<?php //pengulangan isi tabel 
								$no=1;
							//	test_result($rs['detail']);
								foreach($rs['detail'] as $rc){
									$idx= (array_key_exists($key, $rc))?$rc[$key]:"";
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
									if(isset($actions) && count($actions)>0)
									{
										echo '<td width="8%" align="center">';
										$button=[];
										foreach($actions as $idm => $act)
										{
											$ids=$idx;
											if(isset($incUpActions)){
												$ids=(in_array($idm, $incUpActions))?$ids.$strdelimeter.$lv1.$lv2:$ids;
												$isplainText=TRUE;
											}
											if(isset($isplainText)){$ids = encrypt($ids) ;}
											$button[] = "<a href='".base_url().$act['src'].$ids."' ".$act['extra']." title='".$act['label']."'><i class='fa fa-".$act['icon']."'></i></a>";
										}
										echo implode(" | ",$button);
										echo '</td>';
									}
									echo "</tr>";
									$no++;
								}
								?>
								</tbody>
							</table>
							<?php
							if(array_key_exists('subfootnote', $rs))
							{
								$sfn = $rs['subfootnote'];
								echo $sfn['title'];
								foreach( $sfn['aksi'] as $K => $A) 
								{
									echo '<a class="btn btn-outline-primary"  href="'.base_url($A['src'].$sfn['param']).'" role="button">'.$A['label'].'</a> ';
								}
							}
							?>
						</div>
					</div>
				<?php } ?>
			</div>
	</div>
	<?php } ?><br>
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
  
  