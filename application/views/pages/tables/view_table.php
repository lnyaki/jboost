<h3>ok, view table</h3>
<div>
<?php echo isset($_table)? $_table: '';?>
</div>
<br/>
<div>
<?php echo isset($_fieldgroups)?$_fieldgroups:'';?>
</div>

<?php echo isset($_unique_table)? $_unique_table: '';?>

<?php echo isset($_generation_form)? $_generation_form:'';?>

<?php echo isset($_foreign_key_table)? $_foreign_key_table: '';?>

<?php echo isset($_index_table)? $_index_table: '';?>