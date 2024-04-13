<?= $this->extend('Theme\login_v18\layout') ?>
<?= $this->section('main') ?>

<div class="container-login100">
	<div class="wrap-login100">
		<?= view('Myth\Auth\Views\_message_block') ?>
		<form method="post" action="<?= route_to('login') ?>" class="contentform login100-form validate-form">
			<?= csrf_field() ?>
			<span class="login100-form-title p-b-43">
				<?=lang('Auth.loginTitle')?>
			</span>
		
<?php if ($config->validFields === ['email']): ?>
			<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
				<input class="input100 <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>" type="text" name="login">
				<span class="focus-input100"></span>
				<span class="label-input100"><?=lang('Auth.email')?></span>
			</div>
<?php else: ?>
			<div class="wrap-input100 validate-input" data-validate = "<?=lang('Auth.emailOrUsername')?>">
				<input class="input100 <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>" type="text" name="login">
				<span class="focus-input100"></span>
				<span class="label-input100"><?=lang('Auth.emailOrUsername')?></span>
			</div>
<?php endif; ?>
								
			<div class="wrap-input100 validate-input" data-validate="<?=lang('Auth.password')?>">
				<input class="input100 <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>" type="password" name="password">
				<span class="focus-input100"></span>
				<span class="label-input100"><?=lang('Auth.password')?></span>
			</div>

			<div class="flex-sb-m w-full p-t-3 p-b-32">
<?php if ($config->allowRemembering): ?>
				<div class="contact100-form-checkbox">
					<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember" <?php if(old('remember')) : ?> checked <?php endif ?>>
					<label class="label-checkbox100" for="ckb1">
						<?=lang('Auth.rememberMe')?>
					</label>
				</div>
<?php endif; ?>
<?php if ($config->activeResetter): ?>
				<div>
					<a href="<?= route_to('forgot') ?>"><?=lang('Auth.forgotYourPassword')?></a>
				</div>
<?php endif; ?>
<?php if ($config->allowRegistration): ?>
				<div>
					<a href="<?= route_to('register') ?>"><?=lang('Auth.needAnAccount')?></a>
				</div>
<?php endif; ?>
			</div>
	

			<div class="container-login100-form-btn">
				<button class="login100-form-btn">
					Login
				</button>
			</div>
			
			<div class="text-center p-t-46 p-b-20">
				<span class="txt2">
					or sign up using
				</span>
			</div>

			<div class="login100-form-social flex-c-m">
				<a href="#" class="login100-form-social-item flex-c-m bg1 m-r-5">
					<i class="fa fa-facebook-f" aria-hidden="true"></i>
				</a>

				<a href="#" class="login100-form-social-item flex-c-m bg2 m-r-5">
					<i class="fa fa-twitter" aria-hidden="true"></i>
				</a>
			</div>
		</form>

		<div class="login100-more" style="background-image: url('login_v18/images/bg-01.jpg');">
		</div>
		<div id="xboard"></div>
	</div>
</div>

<?= $this->endSection() ?>