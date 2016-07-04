<header id="header-full-top" class="boxed header-full header-full-dark hidden-xs">
	<div class="container">
		<div class="header-full-title">
			<h1 class="animated fadeInRight">
				<a href="/">Japanese <span>Boost</span></a>
			</h1>
			<p class="animated fadeInRight">Learn japanese, the fun way</p>
		</div>		
      	
		<div class="navbar-right">
			<p style="padding-top:10px;">
      		<?php 
      		
      			$this->load->library('roles/Security');
				if($this->security->is_logged_in()){
					$this->load->library('session');
					$username = $this->session->userdata('username');
					echo 'Welcome '.$username;
					echo '<a href="'.base_url().'disconnect">Log out </a>';
				}
				else{
					echo "Welcome guest".'<a href="'.base_url().'login"> Log in </a>';
				?>
				<form class="inline" action="/login" method="post">		
					<button type="submit"  id="login-button" class="btn btn-success">Login</button>
				</form>
				<form class="inline" action="/register" method="post">
					<button type="submit" id="register-button" class="btn btn-primary">Register</button>
				</form>
				<?php
				} 
											
			?>
			
      		</p>	
      		
		</div>
		<!--<nav class="top-nav">Hello, just saying</nav>-->
	</div>
</header>
<nav id="header" class="navbar navbar-default navbar-static-top navbar-header-full navbar-dark" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand hidden-lg hidden-md hidden-sm" href="#">Japanese Boost</a>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
				<i class="fa fa-bars"></i>
			</button>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
   		 <div class="collapse navbar-collapse navHeaderCollapse" id="bs-example-navbar-collapse-1">
      		<ul class="nav navbar-nav">
        	<?php
        	if($this->security->is_logged_in()){
        		echo '<li><a href='.base_url().'users/'.$username.'>Profile</a>';
        	}
        	?>
        		<li><a href='<?php echo base_url();?>lists'>Lists</a></li>
        		<li><a href='http://www.japanese-boost.com/blog'>Blog</a></li>
        	<?php
        	if($this->security->has_privilege('Website_administration','consult')){
        		echo "<li><a href='".base_url()."administration/'>Administration</a></li>";
        	}
        	?>
      		</ul>

      	</div>
   	</div>
</nav>
