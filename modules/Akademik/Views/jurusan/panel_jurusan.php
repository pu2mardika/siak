<article id="panel_editing">
	<header class="header"><?php echo get_logo('prodi.png','jur',true);?></header>
	<div id="x_panel" class="container-fluid">	
		<section class="row">
			<div class=" mainav">
				<div id="dsearch" class="col-md-8 col-lg-6 semibig"></div>
				<div id="divnav" class="col-md-4 col-lg-6"> 
					<div class="pull-right">
		        <?php			
					echo $this->fungsi->ajx_link("akademik/addjur","#x_panel",
					 $this->lang->line('ico_add').' '.$this->lang->line('add'),
						 'class="btn btn-default btn-sm" title="'.$this->lang->line('curr_add').'"');
				?>
					</div>
				</div>
			</div>
		</section>	
		<?php 
			if ($this->session->flashdata('message'))
			{
				$class='alert-info';
				if($this->session->flashdata('msgclass')){
					$class=$this->session->flashdata('msgclass');
				}
				echo '<div class="alert '.$class.'" id="info">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'.	$this->session->flashdata('message').'</div>';
			}

		?>														
		<section class="row">
		    <div id="x_result" class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
		    <?php echo (isset($list))?$list:''; ?>
		    </div>
	    </section>
	    <div id="xxx"></div>	
	
	</div>										
</article>