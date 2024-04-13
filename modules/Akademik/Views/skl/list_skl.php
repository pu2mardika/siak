<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//`id_skl`, `curr_id`, `id_prodi`, `skl`
////'grade', 'subgrade', 'skl'
	if(isset($banyak))
	{ 
	echo '<div style="float: left">';
		if(isset($paging)){ echo $paging;}
	echo '</div>';
	}
	$sts_title=1;
?>

<div class="panel panel-success">
<div class="panel-heading"><?php echo $this->lang->line('curr_skl_list');?>
	<span class="badge pull-right"><?php echo count($Data);?></span>
</div>	
<table class="table small table-sortable">
	<tr class='bordered'>
	  	<th width="5%"><div align="center">No</div></th>
	  	<?php foreach($fhead as $key => $dt){ ?>
		<th width="<?php echo $dt; ?>%"><div align="center"><?php echo $this->lang->line('curr_'.$key);?> </div></th>
		<?php } ?>
		<th width="10%"><div align="center"><?php echo $this->lang->line('action');?></div></th>
	</tr> 
	 
 <?php
	$no=0;
	foreach ($Data as $data){
	$no++;
	$ids=$this->kriptograf->paramEncrypt($data['id_skl'],$keys);
?>
	<tr>
		<td align="center" valign="top"><?php echo $no; ?> &nbsp;</td>
		<?php 
		foreach($fhead as $key => $dt){ ?>
		<td class="wrapped" align="left">
			<?php echo ($key=='skl')?$data[$key]."<div class='mapel' id='mp$ids'></div>":$this->lang->line('curr_'.$key)." ".$data[$key]; ?>
		</td>
		<?php }?>
		<td align="center">
			<a class="showmapel" data-value="<?=$ids;?>"><?php echo $this->lang->line('ico_detail');?></a>
			<a id="dialog_link" onclick="show(/academic/skl/edit/<?=$ids;?>','#x_panel')" title="<?php echo $this->lang->line('actions_change');?>"><?php echo $this->lang->line('ico_edit');?></a>
			<a id="dialog_link" onclick="show('academic/skl/delete/<?=$ids;?>','#xboard')" title="<?php echo $this->lang->line('actions_delete');?>"><?php echo $this->lang->line('ico_trash-o');?></a>
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
<div id=""></div>
<div id="<?php echo $token;?>"></div>
<?php if(isset($paging)){ echo $paging;} ?>

<script type="text/javascript">
var url="<?php echo base_url()?>mapel/simple_list";
jQuery(document).ready(function($) {
    $(".mapel").hide();
    $(".showmapel").click(function(){
 		var t=$(this).attr('data-value');
 		$(this).find('i').toggleClass('fa-plus-circle fa-minus-circle');
       // $("#mp"+t).html(t).slideToggle('900');
        $("#mp"+t).load(url+"/"+t).slideToggle('900');
    });
    return false;  
});
</script>