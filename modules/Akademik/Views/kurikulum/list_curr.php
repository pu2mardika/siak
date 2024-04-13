<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<div style="float: left">
	<?php 
		if(isset($banyak))
		{ 
			if(isset($paging)){ echo $paging;}
		}
		
		$sts_title=1;
		
	?>
</div>

<?php if($curr->num_rows()>0){?>
	
<div class="panel panel-success">
<div class="panel-heading"><?php echo $this->lang->line('curr_list');?> 
	<span class="badge pull-right"><?php echo $banyak;?></span>
</div>	
<table class="table small">
	<tr class='bordered'>
	  	<th width="5%"><div align="center">No</div></th>
		<th width="20%"><div align="center"><?php echo $this->lang->line('curr_name');?> </div></th>
		<th width="55%"><div align="center"><?php echo $this->lang->line('curr_desc');?></div></th>
		<?php if($sts_title==1){?>
		<th width="10%"><div align="center"><?php echo $this->lang->line('is_active');?></div></th>
		<th width="10%"><div align="center"><?php echo $this->lang->line('action');?></div></th>
		<?php }?>
	</tr> 
	
 <?php
	//'id_curriculum', 'skl', 'id_prodi'
	$no=0;
	foreach ($curr->result_array() as $data){
	$no++;
	
	$ids=$this->kriptograf->paramEncrypt($data['id_curriculum'],$keys);
 ?>	
	<tr class="bordered">

		<td align="center" valign="top"><?php echo $no; ?> &nbsp;</td>
		<td class="wrapped" align="left"><?php echo $data['curr_name']; ?></td>
		<td><?php echo $data['curr_desc']; ?></td>
		<?php 
			$sts=$this->lang->line('ico_state_arr');
			$vsts=$this->kriptograf->paramEncrypt($data['state'],$keys);
		?>
		<?php if($sts_title==1){?>
		<td class="wrapped" align="center">
			<?php echo $this->fungsi->ajx_link("akademik/cur_tsts/".$ids."/".$vsts,"#x_panel",$sts[$data['state']]);?>
		</td>
		
		<td align="center">
			<a id="dialog_link" onclick='show("akademik/dtlcurr/<?=$ids;?>","#xboard")' title="<?php echo $this->lang->line('detail');?>"><?php echo $this->lang->line('ico_detail');?></a>|
			<a id="dialog_link" onclick='show("akademik/editcur/<?=$ids;?>","#x_panel")' title="<?php echo $this->lang->line('actions_change');?>"><?php echo $this->lang->line('ico_edit');?></a>|
			<a id="dialog_link" onclick='show("akademik/delcur/<?=$ids;?>","#xxx")' title="<?php echo $this->lang->line('actions_delete');?>"><?php echo $this->lang->line('ico_trash-o');?></a>
		</td>
		<?php }?>
	</tr>
	
 <?php
  }
  ?>
 
</table><br/>

<?php	
}else{
  echo $this->lang->line('no_data_string');
}
?>

</div>
<?php if(isset($paging)){ echo $paging;} ?>