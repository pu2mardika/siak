<header class="nav-header">
	<div class="nav-header-logo pull-left">
		<a class="header-logo" href="<?=$config->baseURL?>" title="logoaplikasi">
			<img src="<?=base_url('images/' . $settingWeb->logo_app)?>" height="50px"/>
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
			<li><a class="icon-link" href="<?=$config->baseURL?>builtin/setting"><i class="fas fa-cog"></i></a></li>
			<li>
				<?php 
				$img_url = !empty($user['avatar']) && file_exists(ROOTPATH . '/public/images/user/' . $user['avatar']) ? base_url('images/user/' . $user['avatar']) : base_url('images/user/default.png');
				$account_link = $config->baseURL . 'user';
				?>
				<a class="profile-btn" href="<?=$account_link?>"><img src="<?=$img_url?>" alt="user_img"></a>
				<div class="account-menu-container">
					<?php
					if ($isloggedin) { 
						?>
						<ul class="account-menu">
							<li class="account-img-profile">
								<div class="avatar-profile">
									<a href="<?=$config->baseURL . 'builtin/user/edit?id=' . $user['id'];?>">
										<img src="<?=$img_url?>" alt="user_img">
									</a>
								</div>
								<div class="card-content">
								<p><?=strtoupper($user['fullname'])?></p>
								<p><small>Email: <?=$user['email']?></small></p>
								</div>
							</li>
							<li><a href="<?=$config->baseURL?>builtin/user/edit-password">Change Password</a></li>
							<li><a href="<?=$config->baseURL?>login/logout">Logout</a></li>
						</ul>
					<?php } else { ?>
						<div class="float-login">
						<form method="post" action="<?=$config->baseURL?>login">
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
						<a href="<?=$config->baseURL . 'recovery'?>">Lupa password?</a>
						</div>
					<?php }?>
				</div>
			</li>
		</ul>
	
	</div>
</header>