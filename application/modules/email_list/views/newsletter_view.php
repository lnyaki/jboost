
<div class="panel panel-success-dark" style="margin-right:1em;">
	<div class="panel-heading">Newsletter</div>
	<div class="panel-body">
		<form method="post" action="<?php echo base_url().'email_list/add_email';?>">
			<input type="text" name="email" placeholder="E-mail"/>
			<input type="hidden" name="list" value="1"/>
			<input type="hidden" name="redirect" value="<?php echo uri_string(); ?>"/>
			<button type="submit" class="btn btn-primary"> Subscribe</button>
		</form>
	</div>
</div>