<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V18</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="<?=base_url("login_v18/images/icons/favicon.ico")?>"/>
<!--===============================================================================================-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url("login_v18/fonts/font-awesome-4.7.0/css/font-awesome.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url("login_v18/fonts/Linearicons-Free-v1.0.0/icon-font.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url("login_v18/vendor/animate/animate.css")?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?=base_url("login_v18/vendor/css-hamburgers/hamburgers.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url("login_v18/vendor/animsition/css/animsition.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url("login_v18/vendor/select2/select2.min.css")?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?=base_url("login_v18/vendor/daterangepicker/daterangepicker.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url("login_v18/css/util.css")?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url("login_v18/css/main.css")?>">
<!--===============================================================================================-->
<!-- Dynamic scripts -->
<?php
if (@$scripts) {
	foreach($scripts as $file) {
		if (is_array($file)) {
			if ($file['print']) {
				echo '<script type="text/javascript">' . $file['script'] . '</script>' . "\n";
			}
		} else {
			echo '<script type="text/javascript" src="'.$file.'?r='.time().'"></script>' . "\n";
		}
	}
}?>
</head>
<body style="background-color: #666666;">
	<?php //view('Myth\Auth\Views\_navbar') ?>
	<?= view('themes\login_v18\navbar') ?>
	<main role="main" class="container limiter">
		<?= $this->renderSection('content') ?>
	</main><!-- /.container -->
	
<!--===============================================================================================-->
	<script src="<?=base_url("login_v18/vendor/jquery/jquery-3.2.1.min.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url("login_v18/vendor/animsition/js/animsition.min.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url("login_v18/vendor/bootstrap/js/popper.js")?>"></script>
	<script src="<?=base_url("login_v18/vendor/bootstrap/js/bootstrap.min.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url("login_v18/vendor/select2/select2.min.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url("login_v18/vendor/daterangepicker/moment.min.js")?>"></script>
	<script src="<?=base_url("login_v18/vendor/daterangepicker/daterangepicker.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url("login_v18/vendor/countdowntime/countdowntime.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?=base_url("login_v18/js/main.js");?>"></script>
	<script src="<?=base_url("js/jquery.form.js");?>"></script>
	<script src="<?=base_url("js//bootbox.min.js");?>"></script>
	<script src="<?=base_url("js/app.js");?>"></script>
</body>
</html>