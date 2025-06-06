<?= $this->extend($layout) ?>
  <?= $this->section('main') ?>
  <?php  
  	$dataTable = (isset($dataTable))?$dataTable:TRUE;
	if(isset($title)){ 
  ?> 
	<div class="card-header">
		<h5 class="card-title"></h5>
	</div>
<?php } ?>
	<div class="card-body">
		<div class="row">
			<?php 
			//	$colm = (isset($actionform)||isset($alerts))?"col":"col-50";
				$colm = "col";
			if(isset($resume)){ ?>
				<div class="<?= $colm ?>">
					<?php 
					$dfield = $resume['field'];
					$RData = $resume['data'];
					$subtitle = (array_key_exists('subtitle',$resume))?$resume['subtitle']:"";
					?>
					<div class="card text-dark bg-transparent">
						<div class="card-body">
							<h5 class="card-titler text-info"><?= $subtitle ?></h5>
							<table class='table table-sm'>
								<?php
								
								foreach($dfield as $k => $R)
								{
									echo "<tr><td>".$R['label']."</td><td width='2px'>:</td>";
									echo "<td align='".$R['perataan']."'>".$RData[$k]."</td></tr>";
								}
								?>
							</table>
						</div>
					</div>		
				</div>	  	
	  		<?php } // END OF RESUME
	  	
			//ACTION FORM
			if(isset($actionform)){
				$formField = $actionform['fields'];
				$formData  = $actionform['data'];
				//	$formtitle = $actionform['subtitle'];
				
				foreach ($formField as $k => $v) {
					if(key_exists($k, $formData))
					{
						$val[$k] = $formData[$k];
					}else{
						$val[$k] = '';
					}
				}

				$Hidden = [];
				$Acction = current_url();

				if(isset($act)){$Acction = $act ;}
					
				if(isset($hidden)){$Hidden = $hidden ;}
				?>		
				<div class="col">
					<?php echo form_open($Acction,'',$Hidden); ?>
					<div class="card">
						<div class="card-body">
							<?php if(array_key_exists('subtitle',$actionform)){ ?>
							<h5 class="card-titler text-warning"><?=$actionform['subtitle']?>:</h5>'
							<?php }
							
							foreach($formField as $fd => $row){
								//CEK KONDISI FIELDS
								$extra = $row['extra'];
								$extra['class'] = 'form-control form-control-md';
							//	$extra['placeholder'] = $row['label'];
								
								//chek nilai NULL atau tidak
								$nilai = (is_null($val[$fd]))?"":$val[$fd];
								
								$input = $inputype[$row['type']];
								
								if($input == 'form_dropdown'){
									$option = $opsi[$fd];
									//echo $input($fd,$option,set_select($fd,$val[$fd]),$extra);
									$formInput = form_dropdown($fd,$option,$nilai,$extra);
								}elseif($input == 'form_hidden'){
									$data = [
										'type'  => 'hidden',
										'name'  => $fd,
										'id'    => "h".$fd,
										'value' => set_value($fd,$nilai),
										'class' => $extra['class'],
									];
									$row['label']="";
									$formInput = form_input($data);		
								}else{
									$formInput = $input($fd,set_value($fd,$nilai),$extra,$row['type']);
								}
							?>
							<div class="row mb-3">
								<label class="col-sm-4 col-form-label" for="<?php echo $fd;?>"><?php echo $row['label'];?></label>
								<div class="col-sm-8"><?=$formInput?></div>	    
							</div>
							<?php }  //END FOREACH
									$btn = (array_key_exists('btnAction', $actionform))?$actionform['btnAction']:['icon'=>'save', 'label'=>'Simpan'];
							?>
							<div class="row mb-3">
								<label class="col-sm-4 col-form-label"></label>
								<div class="col-sm-8">
								<button type="submit" class="btn btn-success"><i class="fa fa-<?=$btn['icon']?>"></i>&nbsp;<?=$btn['label']?></button>
								</div>	    
							</div>
						</div>
					</div>
					<?php echo form_close();
					echo validation_list_errors();
					?>
				</div>
			<?php } //END IF FORM ACTION?>
		
			<?php if(isset($alerts))
			{
				$class="alert alert-".$alerts['contextual'];
				?>	
				<div class="col">
					<div class="<?=$class?>">
						<strong><?=$alerts['subtitle']?></strong> <?=$alerts['text']?>.
					</div>
				</div>
			<?php
			} //END FI ALERTS ?>
		</div>
		<br>
		<?php
		if(isset($rsdata)){
			$Adact="";
		?>
			<div class="card " id="History">
				<h5 class="card-header accordion-header bg-light">
					<button class="btn btn-outline-primary btn-sm" role="button" data-bs-toggle="collapse" data-bs-target="#dtHistory" aria-expanded="true" aria-controls="dtHistory">
						Show\Hide Detail
					</button>
					<?php if(isset($addOnACt)||isset($condAddOnAct)){?>
					<span class="float-end dropdown">
						<a role="button" class="btn btn-outline-secondary border-light rounded-pill" title="menu" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa fa-ellipsis-v"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
							<?php
							$ids = (isset($keys) && array_key_exists($keys,$RData))?encrypt($RData[$keys]):"";
							$n=1;
							if(isset($isplainText) && $isplainText){$ids = encrypt($ids) ;}
							if(isset($addOnACt)){
								$n++;
								foreach($addOnACt as $aksi)
								{
									$act="show('".$aksi['src'].$ids."','#xcontent')";
									echo '<a class="dropdown-item" href="javascript:" 
									onclick="'.$act.'" title="'.$aksi['label'].'"><i class="fa fa-'.$aksi['icon'].'"></i>&nbsp;'.$aksi['label'].'</a>';
								}
							} //END ADDONACT
							
							if(isset($condAddOnAct)){
								
								$caddOnACt = $condAddOnAct[$dataStated];
								
								foreach($caddOnACt as $aksi)
								{
									$ACT = (strlen($ids)>0)?$aksi['src'].$ids:$aksi['src'];
									echo "<a class='dropdown-item'  href='".base_url().$ACT.
										"' ".$aksi['extra']."  title='".$aksi['label']."'><i class='fa fa-".$aksi['icon']."'></i>&nbsp;".$aksi['label']."</a> ";
								}
							}
							?>
						</div>
					</span>
					<?php }?>
				</h5>
				
				<div id="dtHistory" class="width card-body text-dark bg-transparent overflow-auto">
					<?php $hfield=[]; ?>
					<table id="<?php echo ($dataTable)?"table-result":"dtable";?>" class="table table-striped table-bordered" width="100%" cellspacing="0" 
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
								
								//CEK IS CONDITIONAL ACTION DETAIL IS PRESENT
					
								if(isset($detAction)|| isset($addOnActDet) || isset($ddOnActDet) || isset($condActDet))
								{
									echo '<th width="4%"><div align="center">Aksi</div></th>';
								}	
								?>
							</tr> 
						</thead>
						<tbody>
					<?php
						//$encrypter = \Config\Services::encrypter();
						
						$no=0;
						foreach ($rsdata as $data){
						$no++;
					?>
							<tr>
								<?php 
								foreach($hfield as $hc){
									$Algn = 'left';
									
									$dtval = $data[$hc];
									if($fields[$hc]['type']=='date')
									{
										if(isset($ori)){$dtval = unix2Ind($data[$hc],'d-m-Y');}
									}
									if(in_array($hc, $hasopt)){$dtval = $opsi[$hc][$data[$hc]];}
									
									if(is_integer($dtval)||is_float($dtval)||is_double($dtval)){$Algn = "right";$dtval = format_angka($dtval);}	
									echo '<td class="nowrapped" align="'.$Algn.'">'.$dtval.'</td>';
								}
								//$deturl = (isset($detail_url))?$detail_url:current_url()."/detail";
								
								//CEK CONDITIONAL ACTION
								$ids= encrypt($data[$key]);
								if(isset($detAction) || isset($addOnActDet) ||isset($condActDet)){
									echo '<td align="center">';
									if(isset($detAction))
									{
										foreach($detAction as $aksi)
										{
											if($aksi['extra']=="")
											{
												$act = 'onclick = "show(\''.$aksi["src"].$ids.'\',\'#xcontent\')"';
												$href = "javascript:";
											}else{
												$act  = $aksi['extra'];
												$href = base_url().$aksi['src'].$ids;
											}
											//$act="show('".$aksi['src'].$ids."','#xcontent')";
											echo '<a href="'.$href.'" '.$act.' title="'.$aksi['label'].'"><i class="fa fa-'.$aksi['icon'].'"></i></a> ';
										}
									}
									if(isset($addOnActDet)){										
										foreach($addOnActDet as $act)
										{
											echo "<a href='".base_url().$act['src'].$ids."' ".$act['extra']." title='".$act['label']."'><i class='fa fa-".$act['icon']."'></i></a> ";
										}
									}
								
									if(isset($condActDet))
									{
										$fkey = $condActDet['field'];
										$state = $condActDet['state'];
										$aksi = $condActDet['actdet'];
										$url = $aksi[$data[$state]];
										
										foreach($url as $act)
										{
											$lebel = ($act['useRow'])?$data[$fkey]:"<i class='fa fa-".$act['icon']."'></i>";
											$href = ($act['src']=="#")?"#":base_url().$act['src'].$ids;
											echo "<a href='".$href."' title='".$act['label']."' ".
												$act['attr'].">$lebel</a> ";
										}
									}
									echo "</td>";	
								}
								?>
							</tr>
					<?php }  ?>
						</tbody>
					</table>
					
					<?php 
					if(isset($subtotal)){
						echo '<div class="row"><div class="col-sm-9 col-md-10">Total : '.$subtotal.'</div><div>';
						if(isset($finalAction)){
							$mode = (isset($mode))?$mode:""; 
							if($mode == 'ajax'){
								echo '<button id="btnfinal" class="btn btn-outline-primary" type="button">
									<i class="fa fa-'.$finalAction['icon'].'"></i>&nbsp;'.$finalAction['label'].'</button>';
							}else{
								echo "<a role='button' id='btnfinal' class='btn btn-outline-primary'  href='".base_url().$finalAction['src'].
								"' title='".$finalAction['label']."'><i class='fa fa-".$finalAction['icon']."'></i>&nbsp;".$finalAction['label'].
								"</a> ";
							}
						}
						echo '</div>';
					} //END IF SUBTOTAL
					?>
				</div>
			</div>
		<?php } //END OF RSDATA ?>
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
	
	<script>
		$(document).ready(function() {
		   $('#table-result').DataTable({
		      "dom": 'flrtip',
		      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
		      "responsive": true, 
		      "paging": true,
		      "lengthMenu": [[5, 20, 25, 50, 100, 250, 500, -1], [5, 20, 25, 50, 100, 250, 500, "All"]],
		      "lengthChange": true, 
		      "autoWidth": false, 
		      "scrollX": true,
		    });
		  
			<?php if(isset($addONJs)){ echo $addONJs ;} ?>
			
		});
	</script>
  <?= $this->endSection() ?>