<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_title; ?></title>
	<meta charset="utf-8">
	<?php echo isset($_html_header)?$_html_header:''?>
</head>
<body>
	
<?php 
	echo isset($_site_header)?$_site_header:'';
	echo isset($_content)?$_content:'';
	echo isset($_footer)?$_footer:'';
	echo isset($_scripts)?$_scripts:'';
?>
</body>
</html>