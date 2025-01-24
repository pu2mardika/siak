<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$current_module['judul_module']?> | <?=$site_title?></title>
	<link rel="shortcut icon" href="<?=base_url('images/favicon.ico?r='.time());?>"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url('vendors/sweetalert2/sweetalert2.min.css?r='.time());?>"/>
	<link rel="stylesheet" type="text/css" href="<?=base_url('vendors/overlayscrollbars/OverlayScrollbars.min.css?r='.time());?>"/>
    
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    
    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="<?=base_url()?>themes/nice/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?=base_url()?>themes/nice/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?=base_url()?>themes/nice/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?=base_url()?>themes/nice/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?=base_url()?>themes/nice/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?=base_url()?>themes/nice/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?=base_url()?>themes/nice/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url()?>themes/nice/css/data-table/bootstrap-table.css">
    <link rel="stylesheet" href="<?=base_url()?>themes/nice/css/data-table/bootstrap-editable.css">

    <!-- =======================================================
    * Template Name: NiceAdmin - v2.5.0
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
    
    <!-- Custom styles for this page -->
    <link href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.3/b-2.3.5/b-html5-2.3.5/b-print-2.3.5/datatables.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Dynamic styles -->
    <?= $this->renderSection('pageStyles') ?>
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
    </script>
    <!-- Dynamic scripts -->
    <script type='text/javascript'>var base_url = '<?=base_url();?>'</script>
	<?php
	function set_menu( $current_module, $arr_menu, $submenu = false, $startMenu = TRUE, $endMenu = TRUE)
	{
		$menu = "\n";
		if($startMenu){ $menu .= '<ul'.$submenu.'>'."\r\n";}
		
		//dashboard Menu
		$active = "";
		if(current_url() == base_url()){
			$active = " active";
		}
		$menu .= '<li class="nav-item'.$active.'">
	                <a class="nav-link" href="'.base_url().'">
	                    <i class="fas fa-fw fa-tachometer-alt"></i>
	                    <span>Dashboard</span></a>
	             </li>';
	             
		foreach ($arr_menu as $key => $val) 
		{
			// Check new
			$new = '';
			if (key_exists('new', $val)) {
				$new = $val['new'] == 1 ? '<span class="menu-baru">NEW</span>' : '';
			}
			$arrow = key_exists('children', $val) ? '<span class="pull-right-container">
									<i class="fa fa-angle-left arrow"></i>
								</span>' : '';
			$has_child = key_exists('children', $val) ? 'has-children' : '';
			
			if ($has_child) {
				$url = '#';
				$onClick = ' onclick="javascript:void(0)"';
			} else {
				$onClick = '';
				$url = $val['url'].'/';
			}
			
			// class attribute for <li>
			$class_li = [];	
			$class_li[] = 'nav-item';
			$area_exp = 'aria-expanded="false"';
			if ($current_module['nama_module'] == $val['nama_module']) {
				$class_li[] = 'tree-open active';
				$area_exp = 'aria-expanded="true"';
			}
			
			if ($val['highlight']) {
				$class_li[] = 'highlight tree-open active';
			}
			
			if ($class_li) {
				$class_li = ' class="' . join(' ', $class_li) . '"';
			} else {
				$class_li = '';
			}
			
			// Class attribute for <a>, children of <li>
			$class_a = ['nav-link depth-'. $val['depth']];
			$extra_a = "";
			if ($has_child) {
				$class_a[] = ' collapsed';
				$extra_a = 'data-bs-toggle="collapse" data-bs-target="#collapse'.$key.'" '
						   .$area_exp.' aria-controls="collapse'.$key.'"';
			}
			
			$class_a = ' class="' . join(' ', $class_a) . '"';
			
			// Menu icon
			$menu_icon = '';
			if ($val['class']) {
				$menu_icon = '<i class="sidebar-menu-icon ' . $val['class'] . '"></i>';
			}

			if (substr($url, 0, 4) != 'http') {
				$uri = base_url($url);
                $url = preg_replace('#//+#', '/', $uri);
			}
			
			$menu .= '<li'. $class_li . '>
						<a '.$class_a.' href="'. $url . '"'.$onClick.' '.$extra_a.'>'.
							$menu_icon.'<span>'.
							$val['nama_menu'] .
							'<span>
						</a>'.$new;
			
			if (key_exists('children', $val))
			{ 	
				$child = $val['children'];
				$submenu = '';
				$collapse = 'collapse';
                foreach($child as $ksub => $alink){
                	$submenu .= '<li><a class="collapse-item" href="'. base_url($alink['url']).'/">';
                	$menu_icon = '';
                	if ($alink['class']) {
						$menu_icon = '<i class="sidebar-menu-icon ' . $alink['class'] . '"></i>';
					}
                	$submenu .= $menu_icon.'&nbsp;'. $alink['nama_menu'];
                	$submenu .= '</a></li>';
                	if ($current_module['nama_module'] == $alink['nama_module']) {$collapse = 'collapse show';}
				}
				
				$menu .= '<ul id="collapse'.$key.'" class="nav-content '.$collapse.'" aria-labelledby="heading'.$key.'" 
						 data-bs-parent="#sidebar-nav">';			                
		        $menu .= $submenu.'</ul>';
				//$menu .= set_menu($current_module, $val['children'], ' class="submenu"');
			} 
			$menu .= "</li>\n";
			$menu .= '<hr class="sidebar-divider d-none d-md-block">';
		}
		if($endMenu){$menu .= "</ul>\n";}
		
		return $menu;
	}

	
	?>
	<!--<link rel="stylesheet" href="https://kit.fontawesome.com/98eda8a12b.css" crossorigin="anonymous">-->
	<script type='text/javascript'>var base_url = '<?=base_url();?>'</script>
	<script type = "text/javascript" >
	//	function preventBack(){window.history.forward();}
	//	setTimeout("preventBack()", 0);
		window.onunload=function(){null};
	</script>
	<script>
	    if ( window.history.replaceState ) {
	  //      window.history.replaceState( null, null, window.location.href );
	    }
	</script>
	<?= $this->renderSection('pageStyles') ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="<?=base_url().'images/' . setting()->get('MyApp.logo')?>" alt="">
        <span class="d-none d-lg-block"><?=setting('MyApp.appName')?></span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="<?=base_url()?>themes/nice/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="<?=base_url()?>themes/nice/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="<?=base_url()?>themes/nice/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="<?=base_url()?>themes/nice/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Kevin Anderson</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <?php 
           $list_menu = menu_list($menu);
           echo set_menu($current_module,$list_menu,FALSE,FALSE,FALSE);
      ?>

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1><?= $title ?></h1>
      <nav>
      <?=!empty($breadcrumb) ? breadcrumb($breadcrumb) : ''?>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
      <?=  $this->renderSection('main') ?>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
        <span><?=$appDesc?></span> &copy; Copyright <strong><span><?=str_replace('{{YEAR}}', date('Y'), setting()->get('MyApp.footer'))?></span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Theme Nice Admin Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js"></script>

    <!-- Page level plugins 
    <script src="<?=base_url('themes/sbadmin2/vendor/datatables/jquery.dataTables.min.js')?>"></script>
    <script src="<?=base_url('themes/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>
    -->

	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	
	<script src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.3/b-2.3.5/b-html5-2.3.5/b-print-2.3.5/datatables.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<?=  $this->renderSection('pageScripts') ?>
	<?php
	if (@$scripts) {
		foreach($scripts as $file) {
			if (is_array($file)) {
				if ($file['print']) {
					echo '<script type="text/javascript">' . $cile['script'] . '</script>' . "\n";
				}
			} else {
				echo '<script type="text/javascript" src="'.$file.'?r='.time().'"></script>' . "\n";
			}
		}
	}
	?>

    

    <!-- Vendor JS Files -->
    <script src="<?=base_url();?>themes/nice/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="<?=base_url();?>themes/nice/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url();?>themes/nice/vendor/chart.js/chart.umd.js"></script>
    <script src="<?=base_url();?>themes/nice/vendor/echarts/echarts.min.js"></script>
    <script src="<?=base_url();?>themes/nice/vendor/quill/quill.min.js"></script>
    <script src="<?=base_url();?>themes/nice/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="<?=base_url();?>themes/nice/vendor/tinymce/tinymce.min.js"></script>
    <script src="<?=base_url();?>themes/nice/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="<?=base_url();?>themes/nice/js/main.js"></script>

    <!-- Page level custom scripts -->
	<script src="<?=base_url('js/app.js')?>"></script>
	<script src="<?=base_url('js/jquery.form.js'); ?>"></script>
	<script src="<?=base_url('js/jquery.easy-autocomplete.min.js'); ?>"></script>	
</body>

</html>