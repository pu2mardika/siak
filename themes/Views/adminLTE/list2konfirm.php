<?= $this->extend($layout) ?>
  <?= $this->section('main') ?>
   
	<div class="card-header">
		<h5 class="card-title"><?= $title ?></h5>
	</div>
	
	<div class="card-body"> 
	    <table id="table-result" class="table table-bordered" cellspacing="0">
	    	<thead>
				<tr>
				  	<th width="5%"><div align="center">No</div></th>
					
					<?php 
					$hfield=[];
					foreach($fields as $k =>$row){
						$l = $row['width'];
						if($l > 0){
							$hfield[]=$k;
							echo '<th ><div align="center">'.$row['label'].'</div></th>';
						}
					}		
					?>
				</tr> 
			</thead>
			<tbody>
		 <?php
			
			$no=0;
			foreach ($rsdata as $rs){
			$no++;
		//	$ids=  $rs[$key];
		?>
				<tr>
					<td align="center"><?php echo $no; ?> &nbsp;</td>
					<?php 
					foreach($hfield as $hc){
						echo '<td class="nowrapped" align="left">'.$rs[$hc].'</td>';
					}
					?>
				</tr>
			
		 <?php
		 	
		  }
		  ?>
		  	</tbody>
		</table>
	  </div>
	  
	  <div id="frViews"></div>
	  <div>
		<div class="pull-left"></div>
		<div class="pull-right">
			<?php
			helper ('html');
				echo btn_label([
					'attr' => ['class' => 'btn btn-success btn-xs'],
					'url' => current_url(). '/'.$actY,
					'icon' => 'fa fa-save',
					'label' => 'Simpan'
				]);
				
				echo btn_label([
					'attr' => ['class' => 'btn btn-light btn-xs'],
					'url' => current_url().'/'.$actN,
					'icon' => 'fa-window-close',
					'label' => 'Batal'
				]);
			?>
		</div>
	  </div>
 
 <?= $this->endSection() ?> 