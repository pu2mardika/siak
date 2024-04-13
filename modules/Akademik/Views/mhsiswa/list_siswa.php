<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<div style="float: left">
	<?php 
		if(isset($jml_mhs))
		{ 
		//	echo '<h3>Total user : '.$jml_mhs.'</h3>';
			if(isset($paging)){ echo $paging;}
		}
		
		$keys=$this->config->item('dynamic_key');
	?>
</div>	
<table id="hor-minimalist-b">
	<tr class='bordered'>
	  	<th width="4%"><div align="center">No</div></thd>
		<th width="15%"><div align="center"><?php echo $this->lang->line('mhs_id');?></div></th>
		<th width="15%"><div align="center"><?php echo $this->lang->line('mhs_name');?> </div></th>
		<th width="15%"><div align="center"><?php echo $this->lang->line('mhs_ttl');?></div></thd>
		<th width="15%"><div align="center"><?php echo $this->lang->line('mhs_sex');?></div></th>
		<th width="15%" ><div align="center"><?php echo $this->lang->line('mhs_program');?></div></th>
		<th width="15%" ><div align="center"><?php echo $this->lang->line('yoa_total_fee');?></div></th>
		<th width="6%"><div align="center"><?php echo $this->lang->line('action');?></div></th>
		
	</tr> 
 <?php
	$no=0;
	foreach ($siswa->result_array() as $data){
	$no++;
	
	$ids=$this->kriptograf->paramEncrypt($data['nim'],$keys);
	$aktif=$data['cur_status'];
	if($aktif==1){ $tr = '<tr class="bordered">';}else{ $tr='<tr class="inactive bordered">';}
	
	echo $tr;
?>
		<td align="right"><?php echo $no; ?> &nbsp;</td>
		<td class="wrapped">
			<a id="dialog_link" onclick='show("academic/mahasiswa/profil/<?=$ids;?>","#panel_editing")'>
			<?php echo $data['nim']; ?>
			</a>
		</td>
		<td class="wrapped"><?php echo $data['nama_mhs']; ?></td>
		<td class="wrapped"><?php echo  $data['temp_lahir']; ?>, <?php echo $this->date->tgl_eng2ind($data['tgl_lahir']); ?></td>
		<td class="wrapped" align="center">
			<?php 
				$sex=$this->lang->line('mhs_sex_part');
				echo $sex[$data['jk']]; 
			?>
		</td>
		<td class="wrapped"><?php echo $data['nm_prodi']; ?><br/><?php echo $data['nm_jurusan']; ?></td>
		<td class="wrapped"><?php echo $data['alamat']; ?></td>
	</a>
		<td align="center">
			<a id="dialog_link" onclick='show("academic/mahasiswa/edit_profil/<?=$ids;?>","#panel_editing")' title="<?php echo $this->lang->line('actions_change');?>"><img src="<?php echo base_url(); ?>assets/style/default/images/b_edit.png"></a>|
			<a id="dialog_link" onclick='show_konfirm("academic/mahasiswa/delete/<?=$ids;?>","#panel_editing","<?=$data['nama_mhs'];?>")' title="<?php echo $this->lang->line('actions_delete');?>"><img src="<?php echo base_url(); ?>assets/style/default/images/b_drop.png"></a>
		</td>
		
	</tr>
	
 <?php
  }
  ?>
  	
</table><br/>

<?php
	if(isset($paging)){ echo $paging;}
	if($siswa->num_rows()==0)
	{
	  echo $this->lang->line('no_data_string');
	}
?>
