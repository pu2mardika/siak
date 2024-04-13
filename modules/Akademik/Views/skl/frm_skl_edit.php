<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#idprodi").focus();
		$( 'textarea#skl' ).ckeditor();
    });
</script>
<?php 
	$row=(isset($skl)?$skl:array(); 
	$ids=$this->kriptograf->paramEncrypt($row->id_skl,$keys);
?>

<article>
	<div class="header">
		<img src="<?php echo base_url(); ?>assets/style/default/images/curriculum-hero.png" width="60" height="40">
		<span class="bold"><?php echo  $row->curr_name .' ['.$this->lang->line('curr_edit_skl');?>]</span>
	</div>

	<div class="container-fluid">	
		
		<section>
			<div id="divnav" class="mainav btn-toolbar"> 
			    <?php			
				echo $this->fungsi->ajx_link("academic/curriculum","#panel_editing",
				'<i class="icon-th"></i> '.$this->lang->line('curr_manaje_exiting'))
				?>
			</div>
		</section>
		
		<div id="info">
		<?php 
			if ($this->session->flashdata('message'))
			{
				echo $this->session->flashdata('message');
			}
		?>
		
		</div>								

		<div class='box container-fluid'>
			<span class="semibig yellow20"><?php echo $this->lang->line('fill_all_field');?></span>

			<?=$this->pquery->form_remote_tag(array(
				'url'=>site_url('academic/skl/edit/'.$ids), 
				'id'=>'skl_edit',
				'autocomp'=>'on',							
				'update'=>'#panel_editing',
				'multipart'=>'false',
				'type'=>'post'),TRUE);
			?>
			<table id='hor-minimalist-a'>
			<?php
			//'id_curriculum', 'curr_name', 'skl', 'id_prodi'
			//id_prodi
			echo '<tr>';
			echo "<td><label for='prodi'>". $this->lang->line('prodi')."</label></td><td>";
			echo form_dropdown('id_prodi',$cmb_prodi,$row->id_prodi); 
			echo form_error('id_prodi','<span class="error">','</span>')."</td></tr>";
			
					
			//skl
			echo '<tr>';
			echo "<td valign='top'><label for='desc'>". $this->lang->line('curr_skl')."</label></td><td>";
			echo '<textarea id="skl" name="skl" rows="10" required="required">'.$row->skl.'</textarea>';
			echo form_error('skl','<span class="error">','</span>')."</td></tr>";
			
			//state
			echo '<tr>';
			echo "<td valign='top'><label for='state'>". $this->lang->line('prodi')."</label></td><td>";
			$options=$this->lang->line('jur_state_type');
			echo form_dropdown('state',$options, $row->state); 
			echo form_error('state','<span class="error">','</span>')."</td></tr>";
			
			echo "<tr><td><label for='submit'></label></td><td>";
			echo form_submit('submit',$this->lang->line('save')).'<td></tr></table>';
			echo form_close();
			?>
			
		</div>																																	
	</div>
</article>