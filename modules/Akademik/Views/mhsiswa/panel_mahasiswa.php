<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->session->set_userdata('page',$this->uri->uri_string());?>

<script type='text/javascript'>
	del_confirm_title = '<?=$this->lang->line('confirm_title');?>';
	del_confirm1 = '<?=$this->lang->line('confirm_del1');?>';
	del_confirm2 = '<?=$this->lang->line('confirm_del2');?>';	
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#search_box').livesearch({
            searchCallback: searchFunction,
            queryDelay: 250,
            innerText: "masukkan nama, username, kabupaten atau previleges",
            minimumSearchLength: 3
        });
        $("#search_box").focus();
    });
    
	function searchFunction(str) {
        load('academic/mahasiswa/search/'+str,'#x_result');
    }
	
</script>

<div id="panel_editing">
	<article>
		<div class="header">
			<img src="<?php echo base_url(); ?>assets/ribbon/Ribbon/images/mhsiswa.png" width="42" height="42">
			<span class="bold"><?php echo $this->lang->line('mhs_manajement');?></span>
		</div>	
		
	<section class="boxbordless">		
		<div id="search" class="semibig">
			<?php echo $this->lang->line('searching')." "
			.$this->lang->line('mhs_info');?> 
			&raquo;  <input type="search" id="search_box" style="width:200px" />
		</div> 
		
		<div id="divnav" class="mainav"> 
	        <a href="<?= site_url('admin/siswa/pesertatoexcel/');?>">EXPORT2EXCEL</a>
			<a href="<?= site_url('admin/siswa/pesertatoexcel/');?>"><?php echo $this->lang->line('import');?></a>
			<?php			
				echo $this->fungsi->ajx_link("academic/mahasiswa/show_panel","#panel_editing",$this->lang->line('staf_create_new'))
			?>
		</div>
	</section>															
		
	<section class="box">
		<div id="info">
			<?php 
				if ($this->session->flashdata('message'))
				{
					echo $this->session->flashdata('message');
				}
			?>
			
		</div>
	    <div id="x_result"><?php $this->load->view('academic/mhsiswa/list_siswa'); ?></div>
    </section>											
	</article>
</div>
