<?php
helper ('html');
$allowAct =TRUE;
if(isset($allowACT)){$allowAct = $allowACT;}
$Mact = $aksi['main']['uri'];
$act_title = $aksi['main']['title'];
$SubAct = $aksi['subAct']['uri'];
$SubAct_title = $aksi['subAct']['title'];
$act_title = $aksi['main']['title'];
$Adact  = $aksi['addOn']['uri'];	
$Adact_title  = $aksi['addOn']['title'];	
?>
<div class="accordion" id="A<?= $Mact.$id ?>">
	<div id="<?= $id ?>-content" class="card-body">
		<h5><?= $title ?>
			<span class="pull-right">
				<a role="button" onclick="show('<?php echo $Mact."/add/".$id;?>','#xcontent')" title="Tambah <?= $act_title?>">
			  		<i class="fa fa-plus-circle"></i>
			    </a>
			</span>
		</h5>
		<?php 
		$i = 0; $NO=0;
		foreach($dtview as $A => $dimensi){
			$SL = (array_key_exists("SubLevel",$dimensi))? $dimensi['SubLevel']:"";
			$idg =  encrypt($A.$strdelimeter.$id);
			$NO++;
			$dt_parent = "accordion".$Mact.$id.$A; 
		?>
			<div class="accordion border border-dark" id="<?= $dt_parent ?>">
				<h6 class="p-3 mb-2 bg-light text-dark font-weight-bold">#<?= $NO.'. '.$dimensi['title'] ?>
					<span class="pull-right">
						<a role="button" onclick="show('<?= $SubAct."/add/".$idg;?>','#xcontent')" title="Tambah <?= $SubAct_title?>">
							<i class="fa fa-calendar-plus-o"></i>
						</a>
						<a role="button" onclick="show('<?= $Mact."/edit/".$idg;?>','#xcontent')" title="Edit <?= $act_title?>">
							<i class="fa fa-pencil-square-o"></i>
						</a>
						<a role="button" href="<?= base_url().$Mact."/hapus/".$idg;?>" onclick="confirmation(event)" title="Hapus <?= $act_title?>">
							<i class="fa fa-trash-o"></i>
						</a>
					</span>
				</h6>

				<?php
				//SUB 
				$i=1;
				if(is_array($SL) || is_object($SL)){
				foreach($SL as $K => $dt)
				{ 
					$rsdata = $dt['rsdata'];
					$idg =  encrypt($K.$strdelimeter.$A.$strdelimeter.$id);
					$hfield=[];
					?>
					<div class="card">
						<?php 
						$target = $Mact.$id.$A.$K;
						$dt_target = "collapse".$target;
					
					 //	$colapseClass = "collapse show";  
						$colapseClass = "collapse";  
						$ariaexpanded =true;
						$ariaexpanded ='aria-expanded="true';
						if($i > 1){
							$colapseClass = 'collapse';
							$ariaexpanded ='aria-expanded="false';
						}
						$i++;
						?>
						<div class="card-header" id="heading<?= $target ?>">
							<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#<?= $dt_target?>" aria-expanded="<?= $ariaexpanded?>" aria-controls="<?= $dt_target?>">
								<?= $dt['title'] ?>
									<span class="pull-right">
										<a role="button" onclick="show('<?= $Adact."/add/".$idg;?>','#xcontent')" title="Tambah <?= $Adact_title?>">
											<i class="fa fa-calendar-plus-o"></i>
										</a>
										<a role="button" onclick="show('<?= $SubAct."/edit/".$idg;?>','#xcontent')" title="Edit <?= $act_title?>">
											<i class="fa fa-pencil-square-o"></i>
										</a>
										<a role="button" href="<?= base_url().$SubAct."/hapus/".$idg;?>" onclick="confirmation(event)" title="Hapus <?= $act_title?>">
											<i class="fa fa-trash-o"></i>
										</a>
									</span>
								</button>
							</h2>
						</div>
				
						<div id="<?php echo $dt_target;?>" class="<?php echo $colapseClass;?>" aria-labelledby="heading<?php echo $target ;?>" data-parent="#<?php echo $dt_parent;?>">
							<div class="table-responsive-sm">  
								<table id="table-result" class="table table-bordered table-sm" cellspacing="0">
									<thead class="thead-dark">
										<tr>
											<th width="5%"><div align="center">No</div></th>
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
													echo '<th width="'.$l.'%" valign="middle"><div align="center">'.$row['label'].'</div></th>';
												}
											}		
											if($allowAct){
											?>
											<th width="5%"><div align="center">Aksi</div></th>
											<?php } ?>
										</tr> 
									</thead>
									<tbody>
										<?php
										$no=0;
										
										foreach ($rsdata as $ID => $data){
										$no++;
									//	test_result($data);
										
										$idx =  $data->$key;
										$ids = $idx.$strdelimeter.$K.$strdelimeter.$A.$strdelimeter.$id;
										
										if(isset($isplainText)){$ids = encrypt($ids); $idx =  encrypt($idx); }
										?>
										<tr>
											<td valign="top" align="center">
												<div align="center"><?= $no?></div>
											</td>
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
												echo '<td class="nowrapped" align="'.$Algn.'" valign="top">'.$dtval;
												echo '</td>';
											}
											?>
											
											<?php 
											if($allowAct){ ?>
												<td class="nowrapped" align ="center" >
													<?php 
													if(isset($actions)){
														foreach($actions as $act)
														{
															if($act['extra']==''){
																$event 	= "show('".$act['src'].$ids."','#xcontent')";
																$button = '<a role="button" onclick="'.$event.'" title="'.$act['label'].'"><i class="fa fa-'.$act['icon'].'"></i></a>';
															}else{
																$button = "<a href='".base_url().$act['src'].$ids."' ".$act['extra']." title='".$act['label']."'><i class='fa fa-".$act['icon']."'></i></a> ";
															}
															echo $button;
														}
													} 
													if(isset($addOnACt)){
														foreach($addOnACt as $act)
														{
														?>	
															<a role="button" title='<?= $act['label'] ?>' onclick="show('<?= $act['src'].$ids;?>','<?= $target ?>')">
															<i class='fa fa-<?= $act['icon']?>'></i></a>
													<?php
														}
													}
													
													if(isset($condActDet))
													{
														$url = $condActDet[$data->state];
														foreach($url as $act)
														{
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
							</div>
						</div>
					</div>
				<?php } 
				}?>
			</div>
			<br>
		<?php } ?>
	</div>
</div>