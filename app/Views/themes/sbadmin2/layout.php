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
    
    <!-- Custom fonts for this template -->
    <!--<link href="<?=base_url('themes/sbadmin2/vendor/fontawesome-free/css/all.min.css')?>" rel="stylesheet" type="text/css">
    --> 
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="<?=base_url('themes/sbadmin2/css/sb-admin-2.min.css')?>" rel="stylesheet">
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
			$class_a = ['nav-link depth-' . $val['depth']];
			$extra_a = "";
			if ($has_child) {
				$class_a[] = 'has-children collapsed';
				$extra_a = 'data-toggle="collapse" data-target="#collapse'.$key.'" '
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
                	$submenu .= '<a class="collapse-item" href="'. base_url($alink['url']).'/">';
                	$menu_icon = '';
                	if ($alink['class']) {
						$menu_icon = '<i class="sidebar-menu-icon ' . $alink['class'] . '"></i>';
					}
                	$submenu .= $menu_icon.'&nbsp;'. $alink['nama_menu'];
                	$submenu .= '</a>';
                	if ($current_module['nama_module'] == $alink['nama_module']) {$collapse = 'collapse show';}
				}
				
				$menu .= '<div id="collapse'.$key.'" class="'.$collapse.'" aria-labelledby="heading'.$key.'" 
						 data-parent="#accordionSidebar">
                    		<div class="bg-white py-2 collapse-inner rounded">
	                        	<h6 class="collapse-header">'.$val['nama_menu'].':</h6>';
			                //mengisi data children
			                
		        $menu .= $submenu.'</div>
		                </div>';
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
    <div id="wrapper">

        <!-- Sidebar -->
        
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
			
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=base_url()?>">
                <img src="<?=base_url().'images/' . setting()->get('MyApp.logo')?>" width="100px"/>
            </a>
			 
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            	
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
			<?php 
        		$list_menu = menu_list($menu);
        		echo set_menu($current_module,$list_menu,FALSE,FALSE,FALSE);
        	?>	
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
            
            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="<?= base_url()?>/themes/sbadmin2/img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong><?=$site_title?></strong> <?=setting()->get('MyApp.companyTagline')?></p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro"></a>
            </div>

        </ul>
        
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
				
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="<?= base_url()?>/themes/sbadmin2/img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="<?= base_url()?>/themes/sbadmin2/img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="<?= base_url()?>/themes/sbadmin2/img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $user['fullname'];?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?= base_url()?>/themes/sbadmin2/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                	<?=!empty($breadcrumb) ? breadcrumb($breadcrumb) : ''?>
					<?=  $this->renderSection('main') ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span><?=str_replace('{{YEAR}}', date('Y'), setting()->get('MyApp.footer'))?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current sessions.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?php echo base_url().'/logout';?>">Logout</a>
                </div>
            </div>
        </div>
    </div>
	
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<?=base_url('themes/sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>

    <!-- Core plugin JavaScript
    <script src="<?=base_url('themes/sbadmin2/vendor/jquery-easing/jquery.easing.min.js')?>"></script>
    -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=base_url('themes/sbadmin2/js/sb-admin-2.min.js')?>"></script>

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
    <!-- Page level custom scripts -->
    <!--<script src="<?=base_url('themes/sbadmin2/js/demo/datatables-demo.js')?>"></script>-->
	<script src="<?=base_url('js/app.js')?>"></script>
	<script src="<?=base_url('js/jquery.form.js'); ?>"></script>
	<script src="<?=base_url('js/jquery.easy-autocomplete.min.js'); ?>"></script>	
</body>

</html>