<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//`id_skl`, `curr_id`, `id_prodi`, `skl`
//// `id_comp`, `id_kurikulum`, `nama_komponen`, `deskripsi`, `state`
?>

<div class="panel panel-success">
<div class="panel-heading"><?php echo $this->lang->line('curr_comp_list');?>
	<span class="pull-right"><?php echo $this->fungsi->ajx_link("akademik/add_comp/$currID","#add$currID",
			$this->lang->line('ico_add'));?></span>
</div>
<div class="panel-body">	
<table class="table small table-sortable">
	<tr class='bordered'>
	  	<th width="5%"><div align="center">No</div></th>
	  	<?php foreach($fhead as $key => $dt){ ?>
		<th width="<?php echo $dt; ?>%"><div align="center"><?php echo $this->lang->line($key);?> </div></th>
		<?php } ?>
		<th width="10%"><div align="center"><?php echo $this->lang->line('action');?></div></th>
	</tr> 
	 
 <?php
	$no=0;
	foreach ($Data as $data){
	$no++;
	$ids=$this->kriptograf->paramEncrypt($data['id_comp'],$keys);
?>
	<tr>
		<td align="center" valign="top"><?php echo $no; ?> &nbsp;</td>
		<?php 
		foreach($fhead as $key => $dt){ ?>
		<td class="wrapped" align="left">
			<?php echo (in_array($key,$hasRef))?$opsi[$key][$data[$key]]:$data[$key]; ?>
		</td>
		<?php }?>
		<td align="center">
			<a id="dialog_link" onclick="show(/academic/editcomp/<?=$ids;?>','#dtxpanel')" title="<?php echo $this->lang->line('actions_change');?>"><?php echo $this->lang->line('ico_edit');?></a>
			<a id="dialog_link" onclick="show('academic/delcomp/<?=$ids;?>','#dtxpanel')" title="<?php echo $this->lang->line('actions_delete');?>"><?php echo $this->lang->line('ico_trash-o');?></a>
		</td>
		
	</tr>
 <?php
  }
  ?>
</table>
<?php
	
	if(count($Data)==0)
	{
	  echo $this->lang->line('no_data_string');
	}
?>
</div>
</div>
<div id="dtxpanel"></div>
<div id="add<?php echo $currID;?>"></div>