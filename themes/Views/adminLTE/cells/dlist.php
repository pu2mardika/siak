<?php
helper ('html');
$allowAct =TRUE;
if(isset($allowACT)){$allowAct = $allowACT;}
$Mact = $aksi['main']['uri'];
$act_title = $aksi['main']['title'];
$Adact  = $aksi['addOn']['uri'];	
$Adact_title  = $aksi['addOn']['title'];	
?>
<div class="accordion" id="accordion<?= $Mact.$id ?>">
	<div id="<?= $id ?>-content" class="card-body">
		<h5><?= $title ?>
			<span class="float-end">
				<a role="button" onclick="show('<?php echo $Mact."/add/".$id;?>','#xcontent')" title="Tambah <?= $act_title?>">
			  		<i class="fa fa-plus-circle"></i>
			    </a>
			</span>
		</h5>
<?php 
$i = 0;
foreach($dtview as $A => $dt){
	$rsdata = $dt['rsdata'];
	$idg =  encrypt($A.$strdelimeter.$id);
	$hfield=[];
?>
	<div class="card">
		<?php 
		
		if(array_key_exists('title',$dt)){ 
			//$Mact = (is_array($act))?implode("",$act):$act;
			
			$target = $Mact.$id.$A;
			$dt_target = "collapse".$target;
			
			//$colapseClass = ($i === 0)?"collapse show":"collapse";  $i++;
			$colapseClass = "collapse show";  
			$ariaexpanded =true;
			$ariaexpanded ='aria-expanded="true';
			if($i > 0){
				$colapseClass = 'collapse';
				$ariaexpanded ='aria-expanded="false';
			}
			$i++;
		?>
		<div class="card-header" id="heading<?= $target ?>">
	       <h6 class="link-success" role="button" data-bs-toggle="collapse" data-bs-target="#<?= $dt_target?>" aria-expanded="<?= $ariaexpanded?>" aria-controls="<?= $dt_target?>">
	            <?= $dt['title'] ?>
	            <span class="float-end">
					<a role="button" onclick="show('<?= $Adact."/add/".$idg;?>','#xcontent')" title="Tambah <?= $Adact_title?>">
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
	    </div>
	    <?php 
	    
	    echo '<div id="'.$dt_target.'" class="'.$colapseClass.'" aria-labelledby="heading'.$target.'" data-bs-parent="#accordion'.$Mact.$id.'">';
     //	echo '<div class="card-body">';
		}else{ ?>
		<div>
		<?php } ?>
				<div class="accordion-body table-responsive-sm">  
					<table id="table-result" class="table table-striped table-bordered table-sm" cellspacing="0">
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
					foreach ($rsdata as $data){
					$no++;
					$idx =  $data->$key;
					$ids = $idx.$strdelimeter.$id.$strdelimeter.$A;
					
					if(isset($isplainText)){$ids = encrypt($ids); $idx =  encrypt($idx); }
				?>
						<tr>
							<td valign="top" align="center"><div align="center"><?= $no?></div></td>
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
								if(array_key_exists('hasChild',$fields[$hc])){
									$target = "child".$ids;
									echo "<div id='".$target."'></div>";
								}
								echo '</td>';
							}
					
							if($allowAct){
							?>
							
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
				</table><br>
				</div>
			</div>
		</div>
	
<?php } ?>
	</div>
</div>