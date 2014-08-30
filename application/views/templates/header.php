
<header id="header" class="header-full header-full-dark hidden-xs">
	<p>Hi! I'm the header</p>
	<div style="float:right;"><?php echo (isset($_SESSION['id']))? 'Welcome '.$_SESSION['username']: "Welcome guest"?></div>
</header>
<nav class="navbar navbar-default navbar-static-top navbar-header-full navbar-dark" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="#">Navbar Header</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="#">Link 1</a></li>
        <li><a href="#">Link 2</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> My Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Anime</a></li>
            <li><a href="#">Manga</a></li>
            <li><a href="#">Series</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
        <li><a href='/users/storm'>Profile</a>
      </ul>
      
      </div>
	</div>
	
</nav>