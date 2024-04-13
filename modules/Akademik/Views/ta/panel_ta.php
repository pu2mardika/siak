<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->session->set_userdata('page',$this->uri->uri_string());?>

<script type='text/javascript'>
	del_confirm_title = '<?=$this->lang->line('confirm_title');?>';
	del_confirm1 = '<?=$this->lang->line('confirm_del1');?>';
	del_confirm2 = '<?=$this->lang->line('confirm_del2');?>';	
</script>

<div id="panel_editing">
	<article>
		<div class="header">
			<img src="<?php echo base_url(); ?>assets/style/default/images/note_f2.png" width="50" height="50">
			<span class="bold"><?php echo $this->lang->line('yoa_manage');?></span>
		</div>		

		<div class="boxbordless">		

			<section>		
				<div id="divnav" class="mainav btn-toolbar"> 
			        <?php			
						echo $this->fungsi->ajx_link("academic/yoa/show_panel","#panel_editing",
						'<i class="icon-plus-sign icon-large"></i> '.$this->lang->line('yoa_add'))
					?>
				</div>
			</section>															
			
			<section>
				<div id="info">
					<?php if ($this->session->flashdata('message')){echo $this->session->flashdata('message');} ?>
				</div>
				
			    <div id="x_result"><?php $this->load->view('academic/ta/list_ta'); ?></div>
		    </section>
														
		</div>
												
	</article>
</div>
