<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#idprodi").focus();
		$( 'textarea#desk' ).ckeditor();
    });
</script>

<article>
	<div class="header">
		<img src="<?php echo base_url(); ?>assets/style/default/images/curriculum-hero.png" width="60" height="40">
		<span><?php echo $this->lang->line('curr_mk_add');?></span>
	</div>

	<div class="container-fluid">	
		
		<section>
			<div id="divnav" class="mainav btn-toolbar"> 
			    <?php
				$pages=$this->session->userdata('page');			
				echo $this->fungsi->ajx_link($pages,"#icontent",
				'<i class="icon-th"></i> '.$this->lang->line('curr_mng_exis_subject'))
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
				'url'=>site_url('academic/matkul/show_panel'), 
				'id'=>'matkul_add',
				'autocomp'=>'on',							
				'update'=>'#panel_editing',
				'multipart'=>'false',
				'type'=>'post'),TRUE);
			?>
			<table id='hor-minimalist-a'>
			<?php
			/*--------------------------------------------------------------------------------------------------------
			FIELDS: `kode_mk`, `nama_mk`, `sks`, `semester`, `prasyarat`, `id_skl`, `cat_mk`, `sk`, `desk`, `materi`, `state`
			----------------------------------------------------------------------------------------------------------*/
			
			//id_prodi
			echo '<tr>';
			echo "<td><label for='prodi'>". $this->lang->line('prodi')."</label></td><td>";
			$options=$this->lang->line('jur_state_type');
			echo form_dropdown('id_prodi',$cmb_prodi); 
			echo form_error('id_prodi','<span class="error">','</span>')."</td></tr>";
			
			//skl
			echo '<tr>';
			echo "<td valign='top'><label for='desk'>". $this->lang->line('curr_skl')."</label></td><td>";
			echo '<textarea id="desk" name="desk" rows="10" required="required"></textarea>';
			echo form_error('skl','<span class="error">','</span>')."</td></tr>";
			
			//state
			echo '<tr>';
			echo "<td valign='top'><label for='state'>". $this->lang->line('prodi')."</label></td><td>";
			$options=$this->lang->line('jur_state_type');
			echo form_dropdown('state',$options); 
			echo form_error('state','<span class="error">','</span>')."</td></tr>";
			
			echo "<tr><td><label for='submit'></label></td><td>";
			echo form_submit('submit',$this->lang->line('save')).'<td></tr></table>';
			
			//curr_id
			echo form_hidden('curr_id',$ids);
			echo form_close();
			echo $pages;
			?>
			
		</div>																																	
	</div>
</article>