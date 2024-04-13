<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php // $this->session->set_userdata('page',$this->uri->uri_string());?>

<script type='text/javascript'>
	del_confirm_title = '<?=$this->lang->line('confirm_title');?>';
	del_confirm1 = '<?=$this->lang->line('confirm_del1');?>';
	del_confirm2 = '<?=$this->lang->line('confirm_del2');?>';	
</script>

<div id="panel_editing">
	<article>
		<div class="header">
			<img src="<?php echo base_url(); ?>assets/style/default/images/curriculum-hero.png" width="60" height="40">
			<span class="bold"><?php echo $this->lang->line('curr_manajement');?></span>
		</div>	
		
		<div class="boxbordless">	
	
			<section>
	    		
				<div id="divnav" class="mainav btn-toolbar"> 
			        <?php			
						echo $this->fungsi->ajx_link("akademik/curriculum/v_trash","#panel_editing",$this->lang->line('trash'));
						echo $this->fungsi->ajx_link("akademik/curriculum/show_panel","#panel_editing",$this->lang->line('add'));
					?>
				</div>
			</section>															
		
			<section>
				<div id="info">
					<?php 
						if ($this->session->flashdata('message'))
						{
							echo $this->session->flashdata('message');
						}
					?>
					
				</div>
			    <div id="x_result" ><?php $this->load->view('akademik/skl/list_skl'); ?></div>
		    </section>											
		
		</div>
	</article>
</div>
