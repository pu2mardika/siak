<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#tawal").focus();
    });
</script>

<article>
	<div class="header">
		<img src="<?php echo base_url(); ?>assets/style/default/images/note_f2.png" width="50" height="50">
		<span class="bold"><?php echo $this->lang->line('yoa_add');?></span>
	</div>

	<div class="container-fluid">	
		
		<section>
			<div id="divnav" class="mainav btn-toolbar">  
			    <?php			
				echo $this->fungsi->ajx_link("academic/yoa","#panel_editing",
				'<i class="icon-th"></i> '.$this->lang->line('yoa_manage'))
				?>
			</div>
		</section>
		
		
		<div id="info">
			<?php 
				if ($this->session->flashdata('message')){echo $this->session->flashdata('message');}
			?>
		</div>

		<div class='box container-fluid'>
			<span class="semibig yellow20"><?php echo $this->lang->line('fill_all_field');?></span>

			<?=$this->pquery->form_remote_tag(array(
				'url'=>site_url('academic/yoa/show_panel'), 
				'id'=>'ta_add',
				'autocomp'=>'on',							
				'update'=>'#panel_editing',
				'multipart'=>'false',
				'type'=>'post'),TRUE);
			?>
			<?php
			//'thn_awl', 'thn_akh', 'u_semester', 'u_prakul', 'u_pendaf'

			// periode tahun akademik
			echo "<label for='tawal'>". $this->lang->line('yoa')."</label>";
			echo '<input id="tawal" type="year" required="required" name="thn_awl" placeholder="'. 
				 $this->lang->line('yoa_begin').'" title = "'.$this->lang->line('yoa_begin').'"/><br>';
			echo "<label for='tawal'> </label>";
			echo '<input id="thn_akh" type="year" required="required" name="thn_akh" placeholder="'. 
				 $this->lang->line('yoa_end').'" title = "'.$this->lang->line('yoa_end').'"/>';
			echo form_error('thn_awl','<br><label></label><span class="error">','</span>');
			echo form_error('thn_akh','<br><label></label><span class="error">','</span>')."<br/>"; 

			//Uang Pendaftaran
			echo "<label for='ureg'>". $this->lang->line('yoa_reg_fee')."</label>";
			echo '<input id="ureg" type="number" required="required" name="u_pendaf" placeholder="'. 
				 $this->lang->line('yoa_reg_fee').'" title = "'.$this->lang->line('yoa_reg_fee').'"/>';
			echo form_error('u_pendaf','<br><label></label><span class="error">','</span>')."<br/>"; 

			//Uang Pra Perkuliahan 
			echo "<label for='prakul'>". $this->lang->line('yoa_prasch_fee')."</label>";
			echo '<input id="prakul" type="number" required="required" name="u_prakul" placeholder="'. 
				 $this->lang->line('yoa_prasch_fee').'" title = "'.$this->lang->line('yoa_prasch_fee').'"/>'; 
			echo form_error('u_prakul','<span class="error">','</span>')."<br/>";

			//u_semester
			echo "<label for='usmst'>". $this->lang->line('yoa_smst_fee')."</label>";
			echo '<input id="usmst" type="number" required="required" name="u_semester" placeholder="'. 
				 $this->lang->line('yoa_smst_fee').'" title = "'.$this->lang->line('yoa_smst_fee').'"/>'; 
			echo form_error('u_semester','<span class="error">','</span>')."<br/>";


			echo "<label for='submit'></label>";
			echo form_submit('submit',$this->lang->line('save'));
			echo form_close();
			?>
		</div>
	</div>
</article>

