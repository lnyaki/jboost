<?php $this->load->helper('language');?>

<?php $i=0; foreach ($results as $result): ?>
	<li>
	<?php if ($result[lang('ut_result')] == lang('ut_passed')): ?>
		<div class="pas">

			[<?php echo strtoupper(lang('ut_passed')); ?>] <?php echo $result[lang('ut_test_name')]; ?>
			
			<!-- LNY -->
			<div style="display : inline-block;">
				<span>[Expected value : <?php echo $result[lang('ut_expected')];?>&nbsp;(<?php echo $result[lang('ut_test_datatype')];?>)]&nbsp;&nbsp;</span><span>[Obtained value : <?php echo $result[lang('ut_obtained')];?> &nbsp; (<?php echo $result[lang('ut_test_datatype')]; ?>)]&nbsp;&nbsp;</span>
			</div>
			<!-- -->
			
			<?php if ( ! empty($messages[$i])): ?>
			<div class="detail" style="display : inline-block;">
				
				<?php echo $messages[$i]; ?>&nbsp;
			</div>
			<?php endif; ?>

		</div>
	<?php else: ?>
		<div class="err">

			[<?php echo strtoupper(lang('ut_failed')); ?>] <?php echo $result[lang('ut_test_name')]; ?>

			<!-- LNY -->
			<div style="display : inline-block;">
				<span>[Expected value : <?php echo $result[lang('ut_expected')];?>&nbsp;(<?php echo $result[lang('ut_test_datatype')];?>)]&nbsp;&nbsp;</span><span>[Obtained value : <?php echo $result[lang('ut_obtained')];?> &nbsp; (<?php echo $result[lang('ut_test_datatype')]; ?>)]&nbsp;&nbsp;</span>
			</div>
			<!-- -->

			<?php if ( ! empty($messages[$i])): ?>
			<div class="detail" style="display : inline-block;">
				<?php echo $messages[$i]; ?>&nbsp;
			</div>
			<?php endif; ?>

		</div>
	<?php endif; ?>
	</li>
<?php $i++; endforeach; ?>
