<?= $this->extend('layout/page_layout')?>
<?= $this->section('content')?>
<div id="loginformdiv" class="signin-card clearfix">
<br />
<img class="profile-img" src="<?php echo base_url();?>assets/images/profil/avatar_2x.png" alt="">

<?php 
echo form_open('login/proses',  array('id' => 'loginform', 'name' => 'loginform','autocomplete' => 'off', 'onsubmit' => 'return ceklogin();'));

if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or User Id';
} else if ($login_by_username) {
	$login_label = 'User Id';
} else {
	$login_label = 'Email';
}

//echo form_input($login,'','Autofocus');
echo '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>';
echo '<input type="text" class="form-control" required="required" name="username" placeholder="Put Your '.$login_label.' Here" title = "'.$login_label.'" Autofocus></div>';

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);

echo '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>';
echo '<input type="password" class="form-control" required="required" name="password" placeholder="login_password" title = "login_password"></div>';

$thnA = array(
	'name'	=> 'thn_anggaran',
	'id'	=> 'thn_anggaran',
	'size'	=> 4,
);

echo '<div class="input-group"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>';

$submit=array(
	'value'	=> 'login',
	'id'	=> 'login',
	'class'	=> 'btn btn-primary',
	'data-loading-text'=>"Loading..."
);
echo "<br/>";	
echo form_submit($submit);

echo "<br/>";
$attributes = array(
    'class' => 'btn btn-link btn-xs',
    'type'=>'button'
);/*
echo form_label('<a href=\'javascript:void(0)\' 
								onclick=\'show("auths/forgot_password","#xboard");\'>'.$this->lang->line('login_forgot_password').'</a>','forget',$attributes); 
if ($this->config->item('allow_registration')) echo form_label('<a href=\'javascript:void(0)\' 
								onclick=\'show("auths/register","#xboard");\'>'.$this->lang->line('login_register').'</a>','registrasi',$attributes); 
echo form_label('<a href=\'javascript:void(0)\' 
								onclick=\'show_anim("absensi/show_absensi","#icontent");\'>Absen</a>','do_absen',$attributes); */
echo "<br/><br/>";		 
echo form_close();	
?>  
</div>
<p>
	Page rendered in <strong>{elapsed_time}</strong> seconds.
	<?php echo (ENVIRONMENT === 'development') ? ' Version <strong>' . 'app_version' . '</strong>' : '' ?>
</p>
<?= $this->endSection()?>
