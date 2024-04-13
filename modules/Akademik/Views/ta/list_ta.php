<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<div style="float: left">
	<?php 
		if(isset($jml_ya))
		{ 
		//	echo '<h3>Total user : '.$jml_mhs.'</h3>';
			if(isset($paging)){ echo $paging;}
		}
		
		$keys=$this->config->item('dynamic_key');
	?>
</div>	
<table id="hor-minimalist-b">
	<tr class='bordered'>
	  	<th width="6%"><div align="center">No</div></th>
		<th width="15%"><div align="center"><?php echo $this->lang->line('yoa');?></div></th>
		<th width="15%"><div align="center"><?php echo $this->lang->line('yoa_reg_fee');?> </div></th>
		<th width="15%"><div align="center"><?php echo $this->lang->line('yoa_prasch_fee');?></div></th>
		<th width="15%"><div align="center"><?php echo $this->lang->line('yoa_smst_fee');?></div></th>
		<th width="15%" ><div align="center"><?php echo $this->lang->line('yoa_total_fee');?></div></th>
		<th width="5%"><div align="center"><?php echo $this->lang->line('action');?></div></th>
	</tr> 
 <?php
	//'id_ta', 'thn_awl', 'thn_akh', 'u_semester', 'u_prakul', 'u_pendaf'
	$no=0;
	foreach ($thn_akt->result_array() as $data){
	$no++;
	
	$ids=$this->kriptograf->paramEncrypt($data['id_ta'],$keys);
	
	echo '<tr class="bordered">';
?>
		<td align="right"><?php echo $no; ?> &nbsp;</td>
		<td class="wrapped" align="center"><?php echo $data['thn_awl']; ?>-<?php echo $data['thn_akh']; ?></td>
		<td class="wrapped" align="right"><?php echo $this->fungsi->pecah($data['u_pendaf']); ?></td>
		<td class="wrapped" align="right"><?php echo $this->fungsi->pecah($data['u_prakul']); ?></td>
		<td class="wrapped" align="right"><?php echo $this->fungsi->pecah($data['u_semester']); ?></td>
		<td class="wrapped" align="right"><?php echo $this->fungsi->pecah($data['u_pendaf']+$data['u_prakul']+$data['u_semester']); ?></td>
	</a>
		<td align="center">
			<a id="dialog_link" onclick='show("academic/yoa/edit/<?=$ids;?>","#panel_editing")' title="<?php echo $this->lang->line('actions_change');?>"><img src="<?php echo base_url(); ?>assets/style/default/images/b_edit.png"></a>|
			<a id="dialog_link" onclick='show_konfirm("academic/yoa/delete/<?=$ids;?>","#panel_editing","<?=$data['thn_awl'].'/'.$data['thn_akh'];?>")' title="<?php echo $this->lang->line('actions_delete');?>"><img src="<?php echo base_url(); ?>assets/style/default/images/b_drop.png"></a>
		</td>
		
	</tr>
	
 <?php
  }
  ?>
  	
</table><br/>

<?php
	if(isset($paging)){ echo $paging;}
	if($thn_akt->num_rows()==0)
	{
	  echo $this->lang->line('no_data_string');
	}
?>
