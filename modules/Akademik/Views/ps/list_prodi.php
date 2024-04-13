<div>
	<?php 
		if(isset($jml_jur))
		{ 
		//	echo '<h3>Total user : '.$jml_mhs.'</h3>';
			if(isset($paging)){ echo $paging;}
		}
	?>
</div>	
<div class="panel panel-success">
<div class="panel-heading"><?php echo $this->lang->line('prodi_list');?> 
	<span class="badge pull-right"><?php echo $jml_jur;?></span>
</div>	
<table class="table small">
	<tr>
	  	<th width="5%"><div align="center">No</div></th>
		<th width="23%"><div align="center"><?php echo $this->lang->line('prodi_name');?> </div></th>
		<th width="28%"><div align="center"><?php echo $this->lang->line('prodi_desc');?></div></th>
		<th width="20%"><div align="center"><?php echo $this->lang->line('jur_name');?></div></th>
		<th width="8%"><div align="center"><?php echo $this->lang->line('prodi_grade');?></div></th>
		<th width="8%"><div align="center"><?php echo $this->lang->line('is_active');?></div></th>
		<th width="8%"><div align="center"><?php echo $this->lang->line('action');?></div></th>
	</tr> 
 <?php
	//``id_prodi`, `nm_prodi`, `desc`, `id_jur`, `jenjang`, `state``
	$no=0;
	foreach ($prodi->result_array() as $data){
	$no++;
	
	$ids=$this->kriptograf->paramEncrypt($data['id_prodi'],$keys);
	
	echo '<tr class="bordered">';
?>
		<td align="center"><?php echo $no; ?> &nbsp;</td>
		<td class="nowrapped" align="left"><?php echo $data['nm_prodi']; ?></td>
		<td class="nowrapped" align="left"><?php echo $data['desc']; ?></td>
		<td class="nowrapped" align="left"><?php echo $jurdd[$data['id_jur']]; ?></td>
		<td class="nowrapped" align="left"><?php echo $egrid[$data['jenjang']]; ?></td>
		<?php 
			$sts=$this->lang->line('ico_state_arr');
			$vsts=$this->kriptograf->paramEncrypt($data['state'],$keys);
		?>
		
		<td class="wrapped" align="center">
			
			<?php echo $this->fungsi->ajx_link("akademik/togle_ps/".$ids."/".$vsts,"#x_result",$sts[$data['state']]);?>
		</td>
		<td align="center">
			<a id="dialog_link" onclick='show("akademik/edit_ps/<?=$ids;?>","#x_panel")' title="<?php echo $this->lang->line('actions_change');?>"><?php echo $this->lang->line('ico_edit');?></a>|
			<a id="dialog_link" onclick='show("akademik/delps/<?=$ids;?>","#xxx")' title="<?php echo $this->lang->line('actions_delete');?>"><?php echo $this->lang->line('ico_trash-o');?></a>
		</td>
		
	</tr>
	
 <?php
  }
  ?>
  	
</table><br/>

<?php
	if($prodi->num_rows()==0)
	{
	  echo $this->lang->line('no_data_string');
	}
?>
</div>
<?php if(isset($paging)){ echo $paging;} ?>