<header id="header-full-top" class="boxed header-full header-full-dark hidden-xs">
	<div class="container">
		<div class="header-full-title">
			<h1 class="animated fadeInRight">
				<a href="index.html">Japanese <span>Boost</span></a>
			</h1>
			<p class="animated fadeInRight">Learn japanese, the fun way</p>
		</div>
		<nav class="top-nav"></nav>
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
		<div class="pull-right">
			<!--<a href="#" class="sb-icon-navbar sb-toggle-right" data-toggle="collapse" data-target = '.navHeaderCollapse'>
						<i class="fa fa-bars"></i>				
			</a>-->
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
   		 <div class="collapse navbar-collapse navHeaderCollapse" id="bs-example-navbar-collapse-1">
      		<ul class="nav navbar-nav">
        	<?php
        	if(isset($_SESSION['id'])){
        		echo '<li><a href='.base_url().'users/'.$_SESSION['username'].'>Profile</a>';
        	}
        	?>
        		<li><a href='<?php echo base_url();?>lists'>Lists</a></li>
      		</ul>
      		<ul class="nav navbar-nav navbar-right" style="padding-top:16px;">
      			<li><p>
      		<?php if(isset($_SESSION['id'])){
					echo 'Welcome '.$_SESSION['username'];
					echo '<a href="'.base_url().'disconnect">Log out </a>';
				}
				else{
					echo "Welcome guest".'<a href="'.base_url().'login"> Log in </a>';
				} 
											
			?>
      			</p></li>
      		</ul>

      	</div>
   	</div>
</nav>
