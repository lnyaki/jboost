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
	//With the blank page, we only load the main content (and scripts)
	echo isset($_content)?$_content:'';
	echo isset($_scripts)?$_scripts:'';
?>
</body>
</html>