<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->session->set_userdata('page',$this->uri->uri_string());
$row=$curriculum;
$target="#xcv".$token;
//$ids=$this->uriys);
?>
<article id="panel_editing">
	<header class="header"><?php echo get_logo('prodi.png','curr_manajement',true);?></header>
	<div id="x_panel" class="container-fluid">	

		<!-- page title -->
		<section class="row mainav">
		    <div class="col-lg-8 col-md-7 col-sm-6 col-xm-6"> 
		    <h4><strong><?php echo $row['curr_name']; ?></strong></h4>
		    </div>
			<div class="col-lg-4 col-md-5 col-sm-6 col-xm-6"> 
				<div class="pull-right">
				<button type="button" id="btn_manage" class="btn btn-default btn-sm" onclick='show("akademik/curriculum","#xboard")'><?php echo$this->lang->line('manage');?></button>
				<button type="button" id="btn_skl" class="btn btn-default btn-sm" onclick='show("akademik/addskl/<?php echo $ids;?>","<?php echo $target;?>")'><?php echo $this->lang->line('ico_detail').$this->lang->line('curr_add_skl');?></button>
				</div>
			</div>
		</section>

		<div  class="frmmsg"></div>

		<section class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">	
			<div class="panel">
				<div class="panel-heading"> 
					<span class="badge pull-right"><?php echo $options[$row['state']];?></span>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<?php echo '<strong>'.$this->lang->line('curr_desc').'</strong>'; 
							 echo '<span>'.$row['curr_desc'].'</span>';?>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-2 col-xs-12">
							<?php echo '<span>'.$this->lang->line('curr_issued').'&nbsp;: &nbsp;'. 
							format_tgl(unix_to_human($row['issued'],"d-m-Y")).'</span>';?>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-2 col-xs-12">
							<?php 
							if(!is_null($row['curr_system']) && key_exists($row['curr_system'],$curr_system_list))
							{ 
								$csy=$curr_system_list[$row['curr_system']];
							}else{
								$csy="<NO, SET YET>";
							}
							echo '<span>'.$this->lang->line('curr_l_duration').'&nbsp;: &nbsp;'. 
							$row['l_duration'].' '.$this->lang->line('curr_grade').'</span>';
							?>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-2 col-xs-12">
							<?php 
								 
								echo '<span>'.$this->lang->line('curr_system').'&nbsp;: &nbsp;'.$csy.'</span>';?>
						</div>
					</div>
				
				</div>
			</div>

			<div id="info">
			<?php 
				if ($this->session->flashdata('message'))
				{
					echo $this->session->flashdata('message');
				}
			?>
			</div>								
				
			<div id="x-add">
				<?php echo (isset($dskl))?$dskl:$this->lang->line('no_data_string'); ?>
				<div class="xcv" id="<?php echo $target;?>"></div>
			</div>
			
			<div id="x-ads">
				<?php echo (isset($dcomp))?$dcomp:$this->lang->line('no_data_string'); ?>
			</div>
		</section>
	</div>
</article>