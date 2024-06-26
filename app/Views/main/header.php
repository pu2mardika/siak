<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?=$current_module['judul_module']?> | <?=$settingApp->app_title?></title>
<meta name="descrition" content="<?=$current_module['deskripsi']?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?=base_url('images/favicon.ico?r='.time());?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('vendors/font-awesome/css/all.css');?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('vendors/bootstrap/css/bootstrap.min.css?r='.time());?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('vendors/datatables/datatables.min.css?r='.time());?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('vendors/datatables/dist/css/dataTables.bootstrap4.min.css?r='.time());?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('vendors/iconpicker/css/bulma-iconpicker.min.css?r='.time());?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('themes/modern/builtin/css/bootstrap-custom.css?r=' . time());?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('vendors/sweetalert2/sweetalert2.min.css?r='.time());?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('vendors/overlayscrollbars/OverlayScrollbars.min.css?r='.time());?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('themes/modern/builtin/css/site.css?r='.time());?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('themes/modern/css/bootstrap-custom.css?r='.time());?>"/>

<link rel="stylesheet" id="style-switch" type="text/css" href="<?=base_url('themes/modern/builtin/css/color-schemes/'.$app_layout['color_scheme'].'.css?r='.time());?>"/>
<link rel="stylesheet" id="style-switch-sidebar" type="text/css" href="<?=base_url('themes/modern/builtin/css/color-schemes/'.$app_layout['sidebar_color'].'-sidebar.css?r='.time());?>"/>
<link rel="stylesheet" id="font-switch" type="text/css" href="<?=base_url('themes/modern/builtin/css/fonts/'.$app_layout['font_family'].'.css?r='.time());?>"/>
<link rel="stylesheet" id="font-size-switch" type="text/css" href="<?=base_url('themes/modern/builtin/css/fonts/font-size-'.$app_layout['font_size'].'.css?r='.time());?>"/>
<link rel="stylesheet" id="logo-background-color-switch" type="text/css" href="<?=base_url('themes/modern/builtin/css/color-schemes/'.$app_layout['logo_background_color'].'-logo-background.css?r='.time());?>"/>

<!-- Dynamic styles -->
<?php
if (@$styles) {
	foreach($styles as $file) {
		echo '<link rel="stylesheet" type="text/css" href="'.$file.'?r='.time().'"/>' . "\n";
	}
}

?>
<script type="text/javascript">
	var base_url = "<?=base_url()?>";
	var module_url = "<?=$module_url?>";
	var current_url = "<?=current_url()?>";
	var theme_url = "<?=base_url('themes/modern/builtin/')?>";
</script>
<script type="text/javascript" src="<?=base_url('vendors/jquery/jquery-3.4.1.js');?>"></script>
<script type="text/javascript" src="<?=base_url('vendors/bootstrap/js/bootstrap.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('vendors/bootbox/bootbox.min.js')?>"></script>
<!-- <script type="text/javascript" src="<?=base_url('vendors/zenscroll/zenscroll-min.js')?>"></script> -->
<script type="text/javascript" src="<?=base_url('vendors/iconpicker/js/bulma-iconpicker.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('vendors/sweetalert2/sweetalert2.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('vendors/overlayscrollbars/jquery.overlayScrollbars.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('vendors/datatables/datatables.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('themes/modern/builtin/js/functions.js?r='.time())?>"></script>
<script type="text/javascript" src="<?=base_url('themes/modern/builtin/js/site.js?r='.time());?>"></script>

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
}

//$user = $_SESSION['user'];

?>
</head>
<body>
	<header class="nav-header">
		<div class="nav-header-logo pull-left">
			<a class="header-logo" href="<?=base_url()?>" title="logoaplikasi">
				<img src="<?=base_url('images/' . $settingApp->logo_app)?>" height="50px"/>
			</a>
		</div>
		<div class="pull-left nav-header-left">
			<ul class="nav-header">
				<li>
					<a href="#" id="mobile-menu-btn">
						<i class="fa fa-bars"></i>
					</a>
				</li>
			</ul>
		</div>
		<div class="pull-right mobile-menu-btn-right">
			<a href="#" id="mobile-menu-btn-right">
				<i class="fa fa-ellipsis-h"></i>
			</a>
		</div>
		<div class="pull-right nav-header nav-header-right">
			
			<ul>
				<li><a class="icon-link" href="<?=base_url()?>builtin/setting"><i class="fas fa-cog"></i></a></li>
				<li>
					<?php 
					$img_url = !empty($user['avatar']) && file_exists(ROOTPATH . '/public/images/user/' . $user['avatar']) ? base_url('images/user/' . $user['avatar']) : base_url('images/user/default.png');
					$account_link = base_url() . 'user';
					?>
					<a class="profile-btn" href="<?=$account_link?>"><img src="<?=$img_url?>" alt="user_img"></a>
					<div class="account-menu-container">
						<?php
						if ($isloggedin) { 
							?>
							<ul class="account-menu">
								<li class="account-img-profile">
									<div class="avatar-profile">
										<a href="<?=base_url() . 'builtin/user/edit?id=' . $user['id'];?>">
											<img src="<?=$img_url?>" alt="user_img">
										</a>
									</div>
									<div class="card-content">
									<p><?=strtoupper($user['fullname'])?></p>
									<p><small>Email: <?=$user['email']?></small></p>
									</div>
								</li>
								<li><a href="<?=base_url()?>builtin/user/edit-password">Change Password</a></li>
								<li><a href="<?=base_url()?>login/logout">Logout</a></li>
							</ul>
						<?php } else { ?>
							<div class="float-login">
							<form method="post" action="<?=base_url()?>login">
								<input type="email" name="email" value="" placeholder="Email" required>
								<input type="password" name="password" value="" placeholder="Password" required>
								<div class="checkbox">
									<label style="font-weight:normal"><input name="remember" value="1" type="checkbox">&nbsp;&nbsp;Remember me</label>
								</div>
								<button type="submit"  style="width:100%" class="btn btn-success" name="submit">Submit</button>
								<?php
								$form_token = $auth->generateFormToken('login_form_token_header');
								?>
								<input type="hidden" name="form_token" value="<?=$form_token?>"/>
								<input type="hidden" name="login_form_header" value="login_form_header"/>
							</form>
							<a href="<?=base_url() . 'recovery'?>">Lupa password?</a>
							</div>
						<?php }?>
					</div>
				</li>
			</ul>
		
		</div>
	</header>
	<div class="site-content">
		<?php
		
		// MENU - SIDEBAR
		$list_menu = menu_list($menu);
	
		?>
		<div class="sidebar">
			<nav>
			<?php
			echo build_menu($current_module, $list_menu);
			?>
			</nav>
		</div>
		<div class="content">
		<?=!empty($breadcrumb) ? breadcrumb($breadcrumb) : ''?>
		<div class="content-wrapper">
		