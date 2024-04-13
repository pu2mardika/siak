<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?> 
<div style="float: left">
	<?php 
		if(isset($banyak))
		{ 
		//	echo '<h3>Total user : '.$jml_mhs.'</h3>';
			if(isset($paging)){ echo $paging;}
		}
		
		$sts_title=1;
		if($this->uri->uri_string()=='academic/jurusan/v_trash'){$sts_title=0;}
		
	?>
</div>
<?php if($jurusan->num_rows()>0){?>
<div class="panel panel-success">
<div class="panel-heading"><?php echo $this->lang->line('jur_list');?> 
	<span class="badge pull-right"><?php echo $banyak;?></span>
</div>	
<table class="table small">
	<tr class='bordered'>
	  	<th width="8%"><div align="center">No</div></th>
		<th width="30%"><div align="center"><?php echo $this->lang->line('jur_name');?> </div></th>
		<th width="35%"><div align="center"><?php echo $this->lang->line('jur_desc');?></div></th>
		<?php if($sts_title==1){?>
		<th width="12%"><div align="center"><?php echo $this->lang->line('jur_state');?></div></th>
		<th width="15%"><div align="center"><?php echo $this->lang->line('action');?></div></th>
		<?php }?>
	</tr> 
 <?php
	//'id_ta', 'thn_awl', 'thn_akh', 'u_semester', 'u_prakul', 'u_pendaf'
	$no=0;
	foreach ($jurusan->result_array() as $data){
	$no++;
	
	$ids=$this->kriptograf->paramEncrypt($data['id_jur'],$keys);
	
	echo '<tr class="bordered">';
?>
		<td align="center"><?php echo $no; ?> &nbsp;</td>
		<td class="wrapped" align="left"><?php echo $data['nm_jurusan']; ?></td>
		<td class="wrapped" align="left"><?php echo $data['desc']; ?></td>
		<?php 
			$sts=$this->lang->line('jur_sts');
			$vsts=$this->kriptograf->paramEncrypt($data['state'],$keys);
		?>
		<?php if($sts_title==1){?>
		<td class="wrapped" align="center">
			
			<?php echo $this->fungsi->ajx_link("academic/jurusan/togle_sts/".$ids."/".$vsts,"#panel_editing",$sts[$data['state']]);?>
		</td>
		
		<td align="center">
			<a id="dialog_link" onclick='show("akademik/editjur/<?=$ids;?>","#x_panel")' title="<?php echo $this->lang->line('actions_change');?>"><?php echo $this->lang->line('ico_edit');?></a>|
			<a id="dialog_link" onclick='show("akademik/deljur/<?=$ids;?>","#xxx")' title="<?php echo $this->lang->line('actions_delete');?>"><?php echo $this->lang->line('ico_trash-o');?></a>
		</td>
		<?php }?>
	</tr>
	
 <?php
  }
  ?>
  	
</table>

<?php	
}else{
  echo $this->lang->line('no_data_string');
}
?>

</div>
<?php if(isset($paging)){ echo $paging;} ?>