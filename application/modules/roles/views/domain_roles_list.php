<div>
	<?php
		if(isset($_roles)){
			$this->load->helper('my_array');
			$list = '';
			
			if(count($_roles)>0){
				echo '<h3>Domain : '.$_roles[0]->domain.'</h3>';
?>
<script>
	var domainID = "<?php echo $_roles[0]->domain_ref;?>";
</script>
<?php
				//get array  head
				$thead = html_table_head(array_keys((array)$_roles[0]));
				
				$links = array(base_url().'roles/',3);
				//get array body
				$tbody = html_table_body($_roles,null,null,$links);
				
				$table = html_table($thead,$tbody,'table table-hover');
				
				echo $table;
			}
			else{
				echo "<h3>Domain :</h3>";
				echo "<p>This domain is empty. It doesn't contain any role.";
			}
			
		}
	?>
</div>