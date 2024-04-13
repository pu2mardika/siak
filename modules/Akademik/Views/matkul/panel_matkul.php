<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->session->set_userdata('page',$this->uri->uri_string());?>
<script type="text/javascript">
    $(document).ready(function () {
        $("#search_box").focus();
		$("#search_box").change(function(){	
			var str=$("#search_box").val();
			load('academic/matkul/search_mk/'+str,'#x_result');
		});
    });
</script>

<script type='text/javascript'>
	del_confirm_title = '<?=$this->lang->line('confirm_title');?>';
	del_confirm1 = '<?=$this->lang->line('confirm_del1');?>';
	del_confirm2 = '<?=$this->lang->line('confirm_del2');?>';	
</script>


<?php 
	$row=$skl->row(); 
	$keys=$this->config->item('dynamic_key');
	$ids=$this->kriptograf->paramEncrypt($row->id_curriculum,$keys);
	$idskl=$this->kriptograf->paramEncrypt($row->id_skl,$keys);
	$curr_name=$dt_curr[$row->id_curriculum];
?>

<div id="panel_editing">
	<article>
		<header class="header">
			<img src="<?php echo base_url(); ?>assets/style/default/images/curriculum-hero.png">
			<span class="bold"><?php echo $curr_name.' ['.$this->lang->line('curr_mk_list').']';?></span>
		</header>	
		
		<div class="boxbordless">	
	
			<section>
	    		<div id="search" class="semibig">
					<?php echo $this->lang->line('prodi');?> 
					&raquo;
					<?php 
						//echo form_dropdown('search_box',$dt_prodi,$row->id_prodi,'id=search_box');
						echo $dt_prodi[$row->id_prodi];
					?>
				</div> 
				<div id="divnav" class="mainav btn-toolbar"> 
					<?php			
						echo $this->fungsi->ajx_link('academic/curriculum/view_curr/'.$ids,"#panel_editing",'<i class="icon-th"></i> '.
							 $this->lang->line('curr_manajement_skl').' '.$this->lang->line('skl'));
						echo $this->fungsi->ajx_link("academic/matkul/show_panel/".$idskl,"#panel_editing",'<i class="icon-plus-sign icon-large"></i> '.
						$this->lang->line('curr_mk_add'));
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
				 
			    <div id="x_result"><?php $this->load->view('academic/matkul/list_matkul'); ?></div>
		    </section>											
		
		</div>
	</article>
</div>
