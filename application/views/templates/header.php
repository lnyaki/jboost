
<nav id="header" class="navbar navbar-default navbar-static-top navbar-header-full navbar-dark" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Japanese Boost</a>
		</div>
		<div class="pull-right">
			<a href="#" class="sb-icon-navbar sb-toggle-right" data-toggle="collapse" data-target = '.navHeaderCollapse'>
				<i class="fa fa-bars"></i>
			</a>
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
