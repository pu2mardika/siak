<?php
$allowAct =TRUE;
if(isset($allowACT)){$allowAct = $allowACT;}
$hfield=[];
helper ('html');
$gact = $aksi['main'];
$act  = (count($dtview)<=1))?$gact:$aksi['addOn'];	
?>
<div class="accordion" id="accordion<?= $act.$id ?>">
<?php 

foreach($dtview as $A => $dt){
	$rsdata = $dt['rsdata'];
?>
	<div class="card">
		<?php 
		$i = 0;
		if(array_key_exists('title',$dt)){ 
			$target = $act.$id.$A;
			$dt_target = "collapse".$target;
		?>
		<div class="card-header" id="heading<?= $target ?>">
	      <h2 class="mb-0">
	        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#<?= $dt_target?>" aria-expanded="true" aria-controls="<?= $dt_target?>">
	          <?= $dt['title'] ?>
	            <span class="pull-right">
					<a role="button" onclick="show('<?php echo $gact."/add/".$id;?>','#xcontent')">
				  		<i class="fa fa-plus-circle"></i>
				    </a>
				</span>
	        </button>
	      </h2>
	    </div>
	    <?php 
	    $colapseClass = ($i === 0)?"collapse show":"collapse";
	    echo '<div id="'.$dt_target.'" class="collapse show" aria-labelledby="heading'.$target.'" data-parent="#accordion'.$act.$id.'">
     		 <div class="card-body">';
		}else{ ?>
		<div>
			<div id="<?= $id ?>-content" class="card-body">
				<h5><?= $title ?>
					<span class="pull-right">
						<a role="button" onclick="show('<?php echo $act."/add/".$id;?>','#xcontent')">
					  		<i class="fa fa-plus-circle"></i>
					    </a>
					</span>
				</h5>
			<?php } ?>
				<div class="table-responsive-sm">  
					<table id="table-result" class="table table-striped table-bordered table-sm" cellspacing="0">
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
									echo '<th width="'.$l.'%" valign="middle"><div align="center">'.$row['label'].'</div></th>';
								}
							}		
							if($allowAct){
							?>
							<th width="9%"><div align="center">Aksi</div></th>
							<?php } ?>
						</tr> 
					</thead>
					<tbody>
				 <?php
					$no=0;
					foreach ($rsdata as $data){
					$no++;
					$idx =  $data->$key;
					$ids = $idx.$strdelimeter.$id;
					
					if(isset($isplainText)){$ids = encrypt($ids); $idx =  encrypt($idx); }
				?>
						<tr>
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
				</table>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
</div>