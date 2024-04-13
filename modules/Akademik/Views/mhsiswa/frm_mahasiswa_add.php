<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url();?>assets/javascript/ajaxupload.3.5.js" type="text/javascript"></script>
<script type="text/javascript">
	var ur_i = '<?php echo site_url()?>staf/show_panel'
	$(function() {  
        var btnUpload=$('#buttonUpload');
		var status=$('#status');
		
		new AjaxUpload(btnUpload, {
			action: 'academic/mahasiswa/upload',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text(file);
				//Add uploaded file to list
				if(response==="success"){
					$('#filefoto').val(file);
					$('#status').val(file);
				} else{
					status.text('Error');
				}
			}
		});
	
    });
	
</script>

<script>
function myFunction()
{
alert("Thank you for visiting W3Schools!");
}
</script>
<div class="modal small hide fade" id="Modalbaru" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     
<div class="title"><?php echo $this->lang->line('mhs_create_new');?></div>
<div id="divnav" class="mainav"> 
    <?php			
	echo $this->fungsi->ajx_link("academic/mahasiswa","#panel_editing",$this->lang->line('mhs_manaje_exiting'))
	?>
</div>
<div id="info">
	<?php 
		if ($this->session->flashdata('message'))
		{
			echo $this->session->flashdata('message');
		}
	?>
	
</div>

<div class='box dverscrol'>
<span class="semibig yellow20"><?php echo $this->lang->line('fill_all_field');?></span>

<?=$this->pquery->form_remote_tag(array(
	'url'=>site_url('academic/mahasiswa/show_panel'), 
	'id'=>'mhs_add',
	'autocomp'=>'on',							
	'update'=>'#panel_editing',
	'multipart'=>'true',
	'type'=>'post'),TRUE);
?>
<?php

//PERSONAL INFORMATION------------------------------------------------------------------------------
echo "<label for='nim_id'>". $this->lang->line('mhs_id')."</label>";
echo '<input id="nim_id" type="text" required="required" name="nim" placeholder="'. 
	 $this->lang->line('mhs_id').'"title = "'.$this->lang->line('mhs_id').'"/>';
echo form_error('nim','<br><label></label><span class="error">','</span>')."<br/>"; 

echo "<label for='pname'>". $this->lang->line('mhs_name')."</label>";
echo '<input id="pname" type="text" required="required" name="nama_mhs" placeholder="'. 
	 $this->lang->line('mhs_name').'" title = "'.$this->lang->line('mhs_name').'"/>';
echo form_error('nama_mhs','<br><label></label><span class="error">','</span>')."<br/>"; 

echo "<label for='tmp_lahir'>". $this->lang->line('mhs_pob')."</label>";
echo '<input id="tmp_lahir" type="text" required="required" name="temp_lahir" placeholder="'. 
	 $this->lang->line('mhs_pob').'" title = "'.$this->lang->line('mhs_pob').'"/>';
echo form_error('tmp_lahir','<br><label></label><span class="error">','</span>')."<br/>"; 

echo "<label for='tgl_lahir'>".$this->lang->line('mhs_dob')."</label>";
$data = array('name'=>'tgl_lahir','id'=>'tgl_lahir','size'=>40, 'value'=>set_value('tgl_lahir'));
$th=date('Y')-17;
$thn=$th.'-'.date('m-d');
echo '<input id="tgl_lahir" type="date" required="required" name="tgl_lahir" max="'.$thn.'"/>';
echo form_error('tgl_lahir','<br><label></label><span class="error">','</span>')."<br/>";

echo "<label for='jk'>". $this->lang->line('mhs_sex')."</label>";
$options = array(''=>'['.$this->lang->line('mhs_sex').']','m'=>$this->lang->line('mhs_sex_m'), 'f'=>$this->lang->line('mhs_sex_f'));
echo form_dropdown('jk',$options);
echo form_error('jk','<br><label></label><span class="error">','</span>')."<br/>"; 

echo "<label for='agama'>". $this->lang->line('mhs_religi')."</label>";
$data = array('name'=>'tmp_lahir','id'=>'tmp_lahir','size'=>40);
echo '<input id="agama" type="text" required="required" name="agama" placeholder="'. 
	 $this->lang->line('mhs_religi').'" title = "'.$this->lang->line('mhs_religi').'"/>';
echo form_error('agama','<br><label></label><span class="error">','</span>')."<br/>"; 
 
echo "<label for='filefoto'>".$this->lang->line('mhs_pic')."</label>";
$data = array('name'=>'upload','id'=>'upload');
echo "<button class='upload' id='buttonUpload'><span>".$this->lang->line('choose_file')."</span></button>";
echo "<span id='status' ></span>";
echo "<input type='hidden' name='foto' id='filefoto' value=''><br/>";

echo "<label for='ayah'>". $this->lang->line('mhs_addr')."</label>";
$data = array('name'=>'alamat','id'=>'alamat','size'=>50, 'value'=>set_value('alamat'));
echo '<input id="ayah" type="text" required="required" name="alamat" placeholder="'. 
	 $this->lang->line('mhs_addr').'" title = "'.$this->lang->line('mhs_addr').'"/>'; 
echo form_error('alamat','<span class="error">','</span>')."<br/>";

echo "<label for='phone'>". $this->lang->line('mhs_phone')."</label>";
echo '<input id="phone" type="text" required="required" name="phone" placeholder="'. 
	 $this->lang->line('mhs_phone').'" title = "'.$this->lang->line('mhs_phone').'"/>'; 
echo form_error('phone','<span class="error">','</span>')."<br/>";

echo "<label for='email'>e-mail</label>";
echo '<input id="email" type="email" required="required" name="email" placeholder="email@example.com" title = "e-mail"/>';
echo form_error('email','<span class="error">','</span>')."<br/>";

echo "<label for='prodi'>". $this->lang->line('mhs_program')."</label>";
//echo '<input id="prodi" type="text" required="required" name="kode_prodi" placeholder="'. 
//	 $this->lang->line('mhs_program').'" title = "'.$this->lang->line('mhs_program').'"/>'; 
echo form_dropdown('kode_prodi',$cmb_prodi);
echo form_error('kode_prodi','<span class="error">','</span>')."<br/>";


//----------------------------SCHOOL INFORMATION--------------------------------------
echo "<label for='asal_sek'>". $this->lang->line('mhs_school')."</label>";
echo '<input id="asal_sek" type="text" required="required" name="kode_asal_sek" placeholder="SMA N 1 Amlapura" title = "'.$this->lang->line('mhs_school').'"/>'; 
echo form_error('kode_asal_sek','<span class="error">','</span>')."<br/>";

echo "<label for='ijazah'>". $this->lang->line('mhs_ijazah_no')."</label>";
echo '<input id="ijazah" type="text" name="no_ijazah" placeholder="'.$this->lang->line('mhs_ijazah_no').'" title = "'.$this->lang->line('mhs_ijazah_no').'"/>'; 
echo form_error('no_ijazah','<span class="error">','</span>')."<br/>";

echo "<label for='tgl_ijz'>".$this->lang->line('mhs_ijazah_tgl')."</label>";
echo '<input id="tgl_ijz" type="date" name="tgl_ijazah" placeholder="'. 
	 $this->lang->line('mhs_ijazah_tgl').'" title = "'.$this->lang->line('mhs_ijazah_tgl').'"/>';
echo form_error('tgl_ijazah','<br><label></label><span class="error">','</span>')."<br/>";

echo "<label for='stsawal'>". $this->lang->line('mhs_pre_status')."</label>";
$options = $this->lang->line('mhs_pre_sts_part');
echo form_dropdown('stsawal',$options);
echo form_error('sts_awl_mhs','<span class="error">','</span>')."<br/>";

echo "<label for='tgl_reg'>".$this->lang->line('mhs_date_of_reg')."</label>";
echo '<input id="tgl_reg" type="date" required="required" name="tgl_masuk" placeholder="'. 
	 $this->lang->line('mhs_date_of_reg').'" title = "'.$this->lang->line('mhs_date_of_reg').'"/>';
echo form_error('tgl_masuk','<br><label></label><span class="error">','</span>')."<br/>";

echo "<label for='status'>". $this->lang->line('staf_em_state')."</label>";
$options = array('0'=>'Inactive', '1'=>'Active', '2' => 'tamat', '3'=>'cuti', '4'=>'berhenti', '5'=>'drop out');
echo form_dropdown('cur_status',$options) ."<br/>";

/*----------------------------------------------------------------------------------------------------
|  PARENTs INFORMATIONS
------------------------------------------------------------------------------------------------------*/
echo "<label for='ayah'>". $this->lang->line('mhs_father_name')."</label>";
echo '<input id="ayah" type="text" required="required" name="nm_ayah" placeholder="'. 
	 $this->lang->line('mhs_father_name').'" title = "'.$this->lang->line('mhs_father_name').'"/>';
echo form_error('nm_ayah','<span class="error">','</span>')."<br/>"; 

echo "<label for='payah'>". $this->lang->line('mhs_father_job')."</label>";
echo '<input id="payah" type="text" required="required" name="pek_ayah" placeholder="'. 
	 $this->lang->line('mhs_father_job').'" title = "'.$this->lang->line('mhs_father_job').'"/>';
echo form_error('pek_ayah','<span class="error">','</span>')."<br/>"; 

echo "<label for='ibu'>". $this->lang->line('mhs_mother_name')."</label>";
echo '<input id="ibu" type="text" required="required" name="nm_ibu" placeholder="'. 
	 $this->lang->line('mhs_mother_name').'" title = "'.$this->lang->line('mhs_mother_name').'"/>';
echo form_error('nm_ibu','<span class="error">','</span>')."<br/>"; 

echo "<label for='pibu'>". $this->lang->line('mhs_mother_job')."</label>";
echo '<input id="pibu" type="text" required="required" name="pek_ibu" placeholder="'. 
	 $this->lang->line('mhs_mother_job').'" title = "'.$this->lang->line('mhs_mother_job').'"/>';
echo form_error('pek_ibu','<span class="error">','</span>')."<br/>"; 

echo "<label for='almt_ortu'>". $this->lang->line('mhs_parents_addr')."</label>";
$data = array('name'=>'alamat','id'=>'alamat','size'=>50, 'value'=>set_value('alamat'));
echo '<input id="almt_ortu" type="text" required="required" name="alamat_ortu" placeholder="'. 
	 $this->lang->line('mhs_parents_addr').'" title = "'.$this->lang->line('mhs_parents_addr').'"/>';
echo form_error('alamat_ortu','<span class="error">','</span>')."<br/>"; 

echo "<label for='submit'></label>";
echo form_submit('submit','Create New Profil');
echo form_close();
?>
</div>

</div>