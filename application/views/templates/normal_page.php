<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_title; ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php echo isset($_html_header)?$_html_header:''?>
	<script type="text/javascript">
    	var BASE_URL = "<?php echo base_url();?>";
	</script>
</head>

<body>
	
<?php 
	echo isset($_site_header)?$_site_header:'';
	echo isset($_content)?$_content:'';
	echo isset($_scripts)?$_scripts:'';
	echo isset($_footer)?$_footer:'';
	
?>
</body>
</html>