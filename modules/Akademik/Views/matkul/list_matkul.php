<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<div style="float: left">
	<?php 
	//`id_skl`, `curr_id`, `id_prodi`, `skl`, 'state'
		if(isset($banyak))
		{ 
			if(isset($paging)){ echo $paging;}
		}
		
		$keys=$this->config->item('dynamic_key');
		$sts_title=1;
		
	?>
</div>

<?php if($matkul->num_rows()>0){?>
		
<table id="hor-light-a">
	<tr class='bordered'>
	  	<th width="5%"><div align="center">No</div></th>
		<th width="20%"><div align="center"><?php echo $this->lang->line('curr_kdmk');?> </div></th>
		<th width="35%"><div align="center"><?php echo $this->lang->line('curr_mk_name');?></div></th>
		<th width="5%"><div align="center"><?php echo $this->lang->line('curr_bobot');?></div></th>
		<th width="15%"><div align="center"><?php echo $this->lang->line('curr_syarat');?></div></th>
		<?php if($sts_title==1){?>
		<th width="10%"><div align="center"><?php echo $this->lang->line('state');?></div></th>
		<th width="10%"><div align="center"><?php echo $this->lang->line('action');?></div></th>
		<?php }?>
	</tr> 
	
 <?php
	//`kode_mk`, `nama_mk`, `bobot`, `semester`, `prasyarat`, `id_skl`, `cat_mk`, `sk`, `desk`, `materi`, `state`
	$no=0;
	foreach ($matkul->result_array() as $data){
	$no++;
	
	$ids=$this->kriptograf->paramEncrypt($data['id_skl'],$keys);
 ?>	
	<tr class="bordered">

		<td align="center" valign="top"><?php echo $no; ?>. &nbsp;</td>
		<td class="wrapped" align="left"><?php echo $n_prodi=$dt_prodi[$data['id_prodi']]; ?></td>
		<td><?php echo $data['skl']; ?></td>
		<?php 
			$sts=$this->lang->line('jur_sts');
			$vsts=$this->kriptograf->paramEncrypt($data['state'],$keys);
		?>
		<?php if($sts_title==1){?>
		<td class="wrapped" align="center">
			<?php echo $this->fungsi->ajx_link("academic/skl/togle_sts/".$ids."/".$vsts,"#x-add",$sts[$data['state']]);?>
		</td>
		
		<td align="center" valign="top">
			<a id="dialog_link" onclick='show("academic/matkul/edit/<?=$ids;?>","#panel_editing")' title="<?php echo $this->lang->line('actions_change');?>"><img src="<?php echo base_url(); ?>assets/style/default/images/b_edit.png"></a>
			<a id="dialog_link" onclick='show_konfirm("academic/matkul/delete/<?=$ids;?>","#panel_editing","<?=$this->lang->line('curr_skl');?> for <?=$n_prodi;?>")' title="<?php echo $this->lang->line('rem');?>"><img src="<?php echo base_url(); ?>assets/style/default/images/b_drop.png"></a>
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
	
if(isset($paging)){ echo $paging;}

?>
