<?= $this->extend('themes/'.$settingWeb->theme.'/layout') ?>
  <?= $this->section('main') ;
$row = $desc;

if (empty($row)) {
	foreach ($field as $val) {
		$$val = '';
	}
}
echo form_open(current_url(), array('class' => 'contentform form-horizontal', 'id'=>'formcurr'));

foreach($field as $fd){
?>
	<div class="form-group row">
		<label class="col-sm-3 col-md-2 col-lg-3 col-xl-2 col-form-label" for="<?php echo $fd;?>" ><?php echo lang($cname.".".$fd);?></label>
		<div class="col-sm-4">
		<?php 
		$wajib=(in_array($fd,$WAJIB))?"":'required="required"';
		if(in_array($fd,$TANGGAL))
		{
			$isTgl='isaTglx';
			$tgl=($$fd==""||$row[$fd]<1)?now():$row[$fd];
			$row[$fd]=nice_date(unix_to_human($tgl),"d-m-Y");
		}else{
			$isTgl='';
		}
		if(in_array($fd,$has_ref)){
				$colmn= $opsi[$fd];
				echo form_dropdown($fd,$colmn,$row[$fd],'class="form-control input-sm" required="required" id="jalur" title="'.lang($cname.".".$fd).'"'); 
			}else{
				$val=(array_key_exists($fd,$row))?$row[$fd]:"";
				echo '<input type="text" class="form-control input-sm '.$isTgl.'" value="'.$val.'" id="'.$fd.'" name="'.$fd.'" '.$wajib.'/>';
			}
		?>
		</div>	    
	</div>
<?php } echo form_close();?>
<form class="row g-3"><div class="col-md-12"><div class="form-floating"> <input type="text" class="form-control" id="floatingName" placeholder="Your Name"> <label for="floatingName">Your Name</label></div></div><div class="col-md-6"><div class="form-floating"> <input type="email" class="form-control" id="floatingEmail" placeholder="Your Email"> <label for="floatingEmail">Your Email</label></div></div><div class="col-md-6"><div class="form-floating"> <input type="password" class="form-control" id="floatingPassword" placeholder="Password"> <label for="floatingPassword">Password</label></div></div><div class="col-12"><div class="form-floating"><textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;"></textarea><label for="floatingTextarea">Address</label></div></div><div class="col-md-6"><div class="col-md-12"><div class="form-floating"> <input type="text" class="form-control" id="floatingCity" placeholder="City"> <label for="floatingCity">City</label></div></div></div><div class="col-md-4"><div class="form-floating mb-3"> <select class="form-select" id="floatingSelect" aria-label="State"><option selected="">New York</option><option value="1">Oregon</option><option value="2">DC</option> </select> <label for="floatingSelect">State</label></div></div><div class="col-md-2"><div class="form-floating"> <input type="text" class="form-control" id="floatingZip" placeholder="Zip"> <label for="floatingZip">Zip</label></div></div><div class="text-center"> <button type="submit" class="btn btn-primary">Submit</button> <button type="reset" class="btn btn-secondary">Reset</button></div></form>
<?= $this->endSection() ?>