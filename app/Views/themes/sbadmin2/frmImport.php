<?= $this->extend($layout) ?>
<?= $this->section('main') ;?>
	<div class="card-header">
		<h5 class="card-title"><?= $title ?></h5>
	</div>
	
	<div class="card-body">
<?= form_open_multipart(current_url()) ?>
    <label class="col-sm-2 col-form-label" for="userfile" >File</label>
	<div class="col-sm-10">
		<input id="userfile" name="userfile" type="file" class="form-control" required="required">
	</div>
    
    <div class="form-group input-sm">
		<div class="col-sm-12 semibig">
			<br/>
			NOTICE:<br/>
			the file should be contain apropriate form. <a href="<?php echo $u_ri;?>">Klik Here</a> to download form_template
		</div>
	</div>
    <input type="submit" value="upload">
<?php echo form_close();?>
	</div>
	
<?= validation_list_errors() ?>
<?= $this->endSection() ?>