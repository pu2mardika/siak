<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="panel_editing" class="boxbordless">
	<article>
		<div class="header">
			<img src="<?php echo base_url(); ?>assets/style/default/images/dept.jpg" width="60" height="40">
			<span class="bold"><?php echo $this->lang->line('jur');?></span>
		</div>		

		<div class="container-fluid">	

			<section>
				<div id="divnav" class="mainav btn-toolbar"> 
			        <?php			
						echo $this->fungsi->ajx_link("academic/jurusan","#panel_editing",'<i class="icon-th"></i> '
						.$this->lang->line('jur_manage'))
					?>
				</div>
			</section>															
				
			<section class="row-fluid">
				<div id="info">
					<?php 
						if ($this->session->flashdata('message'))
						{
							echo $this->session->flashdata('message');
						}
					?>
					
				</div>
			    <div id="x_result"><?php $this->load->view('academic/jurusan/list_jurusan'); ?></div>
		    </section>	
		</div>										
	</article>
</div>
