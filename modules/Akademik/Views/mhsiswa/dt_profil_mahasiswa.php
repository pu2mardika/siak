<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $hari= $this->fungsi->hari_ini();?>
<?php $row=$profil->row(); ?>
<div id="foto">
	<?php
		if(!strlen($row->foto)){
			$pic= base_url().'assets/style/default/images/d_silhouette.gif';
		}else{
			$pic=base_url().$this->config->item('mhsw_foto_path').$row->foto;
		}	
	?>
	
	<img src="<?php echo $pic; ?>" alt="<?=$row->nama_mhs;?>" name="foto" width="120" height="125">
</div>

<article>
<header>
	<h1><?php echo $this->lang->line('mhs_profile');?></h1>
	<br><div class="semibig bold yellow20"><?php echo $row->nama_mhs." [".$row->nim."]";?></div>
</header>
<div id="divnav" class="mainav"> 
    <?php			
	echo $this->fungsi->ajx_link("academic/mahasiswa","#panel_editing",$this->lang->line('mhs_manaje_exiting'))
	?>
</div>
<div class='box dverscrol'>

<table id="ver-minimalist">
<?php

echo "<tr><th>". $this->lang->line('mhs_name')."</th>";
echo '<td>: &nbsp;'.$row->nama_mhs.'</td></tr>';

echo "<tr><th>". $this->lang->line('mhs_id')."</th>";
echo '<td>: &nbsp;'.$row->nim.'</td></tr>'; 

echo "<tr><th>". $this->lang->line('mhs_pob')."</th>";
echo '<td>: &nbsp;'.$row->temp_lahir.'</td></tr>';

echo "<tr><th>".$this->lang->line('mhs_dob')."</th>";
echo '<td>: &nbsp;'.$row->tgl_lahir.'</td></tr>';

echo "<tr><th>". $this->lang->line('mhs_sex')."</th>";
$options = array(''=>'['.$this->lang->line('mhs_sex').']','m'=>$this->lang->line('mhs_sex_m'), 'f'=>$this->lang->line('mhs_sex_f'));
echo '<td>: &nbsp;'.$options[$row->jk].'</td></tr>'; 

echo "<tr><th>". $this->lang->line('mhs_religi')."</th>";
echo '<td>: &nbsp;'.$row->agama.'</td></tr>';

echo "<tr><th>". $this->lang->line('mhs_addr')."</th>";
echo '<td>: &nbsp;'.$row->alamat.'</td></tr>'; 

echo "<tr><th>". $this->lang->line('mhs_phone')."</th>";
echo '<td>: &nbsp;'.$row->phone.'</td></tr>'; 

echo "<tr><th>";
echo 'e-mail';
echo "</th>";
echo '<td>: &nbsp;'.$row->email.'</td></tr>';

echo "<tr><th>". $this->lang->line('mhs_program')."</th>";
echo '<td>: &nbsp;'.$cmb_prodi[$row->kode_prodi].'</td></tr>';

echo "<tr><th>". $this->lang->line('mhs_school')."</th>";
echo '<td>: &nbsp;'.$row->kode_asal_sek.'</td></tr>';

echo "<tr><th>". $this->lang->line('mhs_pre_status')."</th>";
echo '<td>: &nbsp;'.$row->sts_awl_mhs.'</td></tr>'; 

echo "<tr><th>".$this->lang->line('mhs_date_of_reg')."</th>";
echo '<td>: &nbsp;'.$row->tgl_masuk.'</td></tr>';

echo "<tr><th>". $this->lang->line('staf_em_state')."</th>";
$options = array('0'=>'Inactive', '1'=>'Active', '2' => 'tamat', '3'=>'cuti', '4'=>'berhenti', '5'=>'drop out');
echo '<td>: &nbsp;'.$options[$row->cur_status] ."</td></tr>";

/*----------------------------------------------------------------------------------------------------
|  PARENTs INFORMATIONS
------------------------------------------------------------------------------------------------------*/
echo "<tr><th>". $this->lang->line('mhs_father_name')."</th>";
echo '<td>: &nbsp;'.$row->nm_ayah.'</td></tr>';

echo "<tr><th>". $this->lang->line('mhs_father_job')."</th>";
echo '<td>: &nbsp;'.$row->pek_ayah.'</td></tr>';

echo "<tr><th>". $this->lang->line('mhs_mother_name')."</th>";
echo '<td>: &nbsp;'.$row->nm_ibu.'</td></tr>';

echo "<tr><th>". $this->lang->line('mhs_mother_job')."</th>";
echo '<td>: &nbsp;'.$row->pek_ibu.'</td></tr>';

echo "<tr><th>". $this->lang->line('mhs_parents_addr')."</th>";
echo '<td>: &nbsp;'.$row->alamat_ortu.'</td></tr>';

?>
</table>
</div>
</article>
