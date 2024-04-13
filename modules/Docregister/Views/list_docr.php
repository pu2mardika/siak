</div>
<div class="panel panel-success">
<div class="panel-heading"><?php echo $this->lang->line('data_docregister');?>
	<span class="badge pull-right"></span>
</div>	
<div class="panel-body">
<div class="form-group has-feedback">
	<div id="dsearch" class="col-xs-6 col-sm-4  col-md-4 col-lg-4 semibig">
		<div class="input-group input-group-sm">
		  <span class="input-group-addon"><?php echo $this->lang->line('tgl');?></span>	
	      <input id="search_tgl" class="form-control" value="<?php echo $ctgl;?>" aria-describedby="inputCalenderStatus">
	      <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
	      <span id="inputCalenderStatus" class="sr-only"></span>
	    </div>
	</div>
	
	<div id="dsearch" class="col-xs-6 col-sm-8  col-md-8 col-lg-8 semibig">
		<div class="pull-right">
			<label class="control-label">
				<?php echo $this->lang->line('no_kendali').": ".$no_kendali;?>
			</label>
		</div>
	</div>
	
</div>
<hr/>
<div class="panel panel-default table-responsive">
<table class="table table-condosed table-bordered small">
	<tr class='bordered'>
	  	<th width="2%"><div align="center">No</div></th>
	  	<?php foreach($fhead as $key => $dt){ ?>
		<th width="<?php echo $dt; ?>%"><div align="center"><?php echo $this->lang->line($key);?> </div></th>
		<?php } ?>
		<th width="5%"><div align="center"><?php echo $this->lang->line('action');?></div></th>
	</tr> 
 <?php	
	if(count($Data)==0)
	{
	  $ncol=count($fhead)+2;
	  echo '<tr><td colspan="'.$ncol.'">';
	  echo '<div align="center">'.$this->lang->line('no_data_string').'</div>';
	  echo '</td></tr>';
	}
 ?>
	 
 <?php
	$token= "d".isset($token)?$token:date("ymdhis");
	$no=0;
	foreach ($Data as $data){
	$no++;
	//$this->kriptograf->paramEncrypt($data['productid'],$keys);
	$ids=$this->kriptograf->paramEncrypt($data['id'],$keys);
	$data['no_surat']=formN0Surat($data['no_kendali'],$data['no_order'],$data['clascode'],$data['tgl']);
	$data['no_order']=formN0Surat($data['no_kendali'],$data['no_order'],$data['clascode'],$data['tgl'],FALSE);
	$data['tgl']=unix2Ind($data['tgl']);
	
?>
	<tr>
		<td align="center" valign="top"><?php echo $no; ?> &nbsp;</td>
		<?php 
		foreach($fhead as $key => $dt){ ?>
		<td class="wrapped" align="left"><?php echo $data[$key]; ?></td>
		<?php }?>
		<td align="center">
			<a id="dialog_link" onclick="show('docregister/edit/<?=$ids;?>','#dvs')" title="<?php echo $this->lang->line('actions_change');?>"><?php echo $this->lang->line('ico_edit');?></a> |
			<a id="dialog_link" onclick='show("docregister/rem/<?=$ids;?>","#<?=$token;?>")' title="<?php echo $this->lang->line('actions_delete');?>"><?php echo $this->lang->line('ico_trash-o');?></a>
		</td>
		
	</tr>
 <?php
  }
 
  ?>
</table>
</div>
<div id="dvs"><h4><span  class="info"><?php echo $this->lang->line('curNum')." : ".$curNum;?></span></h4></div>
</div>
</div>
<div id="<?php echo $token; ?>"></div>

<?php if(isset($paging)){ echo $paging;} echo (isset($addOns))?$addOns:"";?>
