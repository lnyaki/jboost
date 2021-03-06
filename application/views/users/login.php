<div class="container">
	
<div class="center-block logig-form">
	<h2 class="section-title no-margin-top">Are you registered?</h2>
	<div class="panel panel-primary">
		
		<div class="panel-heading">Login Form</div>
		<div class="panel-body">
					<?php $this->load->library('form_validation');
            		echo validation_errors(); ?>
		<form role="form" method="post" action="users/process/process_login">
			<div class="form-group">
				<div class="input-group login-input">
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
					<input type="text" class="form-control" name="email" placeholder="E-mail">
				</div>
				<br>
				<div class="input-group login-input">
					<span class="input-group-addon"><i class="fa fa-lock"></i></span>
					<input type="password" class="form-control" name="pass" placeholder="Password">
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox"> Remember me
					</label>
				</div>
				<button type="submit" class="btn btn-ar btn-primary pull-right">Login</button>
				<a href="#" class="social-icon-ar sm twitter animated fadeInDown animation-delay-2"><i class="fa fa-twitter"></i></a>
				<a href="#" class="social-icon-ar sm google-plus animated fadeInDown animation-delay-3"><i class="fa fa-google-plus"></i></a>
				<a href="#" class="social-icon-ar sm facebook animated fadeInDown animation-delay-4"><i class="fa fa-facebook"></i></a>
				<hr class="dotted margin-10">
				<a href="/register" class="btn btn-ar btn-success pull-right">Create Account</a>
				<a href="#" class="btn btn-ar btn-warning">Password Recovery</a>
				<div class="clearfix"></div>
			</div>
		</form>
		</div>
	</div>
</div>
</div>