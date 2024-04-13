<!DOCTYPE HTML>
<html lang="en">
<head>
<title><?=$current_module['judul_module']?> | <?=$settingWeb->app_title?></title>
<meta name="descrition" content="<?=$current_module['deskripsi']?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="<?=base_url('images/favicon.ico?r='.time());?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('vendors/font-awesome/css/all.css');?>"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
$theme='themes/'.$settingWeb->theme.'/';
?>
<script type="text/javascript">
	var base_url = "<?=$config->baseURL?>";
	var module_url = "<?=$module_url?>";
	var current_url = "<?=current_url()?>";
	var theme_url = "<?=base_url($theme)?>";
</script>
<script type="text/javascript" src="<?=base_url('vendors/jquery/jquery-3.4.1.js');?>"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
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
//test_result($_SESSION);
//$user = $_SESSION['user'];
//echo $user;
?>
</head>
<body>
	<?= view('themes\modern\_navbar') ?>
	<div class="site-content" style="float: left;">
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
			<main role="main" class="container limiter">
				<?=  $this->renderSection('main') ?>
			</main>
		</div><!-- cotent-wrapper -->
		</div><!-- cotent -->
	</div><!-- site-content -->
	<?= view('themes\modern\_navbar') ?>
	<?= $this->renderSection('js') ?>	
</body>
</html>