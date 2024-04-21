<h5><?= $title ?>
<span class="pull-right">
	<?php if(isset($menu)){ ?>
	<div class="btn-group">					  
		  <button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		 <?php // echo $this->lang->line('ico_add');?>	  
		  </button>
		  <ul class="dropdown-menu dropdown-menu-right">
	        <li>
	      	<a role="button" onclick="show('subjects/addgp/<?php echo $ids;?>','#addsubjx')">
	      		<div><?php echo $this->lang->line('ico_code').' &nbsp;'.$this->lang->line('add_grup');?>
		    	</div>
		    </a>
	        </li>
	        
	        <li>
	      	<a role="button" onclick="show('subjects/addmp/<?php echo $ids;?>','#addsubjx')">
	      		<div><?php echo $this->lang->line('ico_code').' &nbsp;'.$this->lang->line('add_subject');?>
		    	</div>
		    </a>
	        </li>
	        
		  </ul>		  
	</div>
	<?php }else{ ?>
	<a role="button" onclick="show('skl/add/<?php echo $id;?>','#xcontent')">
  		<i class="fa fa-plus-circle"></i>
    </a>
	<?php } ?>
</span>
</h5>

<?php
$Acction = current_url(); 
$allowAdd =TRUE;
$allowAct =TRUE;

if(isset($act)){$Acction = base_url($act) ;}
if(isset($allowADD)){$allowAdd = $allowADD;}
if(isset($allowACT)){$allowAct = $allowACT;}
	
$datalist = $Acction.'dtlist';
$hfield=[];
helper ('html');
?>
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
		//$encrypter = \Config\Services::encrypter();
		
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
				// 
				
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
