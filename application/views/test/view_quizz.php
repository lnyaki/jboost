
<div>
	<?php
		$this->load->helper('form');
	?>
	<h3>Test du quizz</h3>
	<div id="quizz_otpions">
		<h1>hello quizz options</h1>
		<?php
		$options_button	= array('id'		=> 'option_button',
								'content'	=> 'Play !');
		//radio buttons for repetition options
		$fieldset_repetitions	= array('id'	=> 'menu_repetitions');
		$radio_10 		= array('name'		=> 'option_repetitions',
								'value'		=> '10',
								'checked'	=> true);
		$radio_20 		= array('name'		=> 'option_repetitions',
								'value'		=> '20');
		$radio_50 		= array('name'		=> 'option_repetitions',
								'value'		=> '50');
		$radio_infinite	= array('name'		=> 'option_repetitions',
								'value'		=> 'infinite');
		//data for 'input type' options
		$fieldset_input_type		= array('id'	=> 'menu_input_type');
		$fieldset_multiple_answers 	= array('id' => 'menu_multiple_answers');
		$fieldset_direct_input		= array('id' => 'menu_direct_input');
		
		$chk_input1 	= array('name' 	=> 'input_type',
								'value'	=> 'multiple_answers',
								'checked'	=> true);
		$chk_input2 	= array('name' 		=> 'input_type',
								'value'		=> 'direct_input');
		$mult_answ3 	= array('name'	=> 'mult_answ',
								'value'	=> '3');
		$mult_answ6 	= array('name'	=> 'mult_answ',
								'value'	=> '6',
								'checked'	=> true);
		$mult_answ9 	= array('name'	=> 'mult_answ',
								'value'	=> '9');						
		//radio buttons for time options
		$fieldset_time	= array('id'=> 'menu_time');
		$rad_time_3		= array('name'	=> 'option_time',
								'value'	=> '3');
		$rad_time_5		= array('name'	=> 'option_time',
								'value'	=> '5',
								'checked'	=> true);
		$rad_time_10	= array('name'	=> 'option_time',
								'value'	=> '10');
		
		//actual form
		echo form_open();
		//repetitions fieldset
		echo form_fieldset('Repetitions',$fieldset_repetitions);
		echo form_label('10');
		echo form_radio($radio_10);
		echo form_label('20');
		echo form_radio($radio_20);
		echo form_label('50');
		echo form_radio($radio_50);
		echo form_label('Inf.');
		echo form_radio($radio_infinite);
		echo form_fieldset_close();
		//'Input type' fieldset
		echo form_fieldset('Input type', $fieldset_input_type);
		echo form_radio($chk_input1);
		echo form_fieldset('Multiple answers', $fieldset_multiple_answers);
		echo form_label('3');
		echo form_radio($mult_answ3);
		echo form_label('6');
		echo form_radio($mult_answ6);
		echo form_label('9');
		echo form_radio($mult_answ9);
		echo form_fieldset_close();
		echo "<br/>";
		echo form_radio($chk_input2);
		echo form_label('Direct input', $fieldset_direct_input);
		echo form_fieldset_close();
		//'Time' fieldset
		echo form_fieldset('Time', $fieldset_time);
		echo form_label('3s');
		echo form_radio($rad_time_3);
		echo form_label('5s');
		echo form_radio($rad_time_5);
		echo form_label('10s');
		echo form_radio($rad_time_10);
		echo form_fieldset_close();
		echo form_button($options_button);
		echo form_close();
		?>
	</div>
	<div id="card">
		<div id="item" class="word"></div>
	<?php
	//initializing form elements data
		$input_data		= array('name'	=> 'quizz_answer'
								,'id'	=> 'quizz_answer'
		);
		$button_data	= array('name'		=>'b1',
								'content'	=> 'validate',
								'type'		=> 'button',
								'id'		=> 'quizz_button');
		
		echo form_open();
		echo "<div id='quizz_input'>";
		//echo form_input($input_data);
		echo "</div>";
		//echo form_button($button_data);
		echo form_close();
	?>
		
	</div>
	<div id="quizz_data">
		<div>Points      : <span id="points"></span></div>
		<div>Answer	     : <span id="answer_label"></span></div>
		<div>Time        : <span id="time_label"></span></div>
		<div>Repetitions : <span id="repetitions_label"></span></div>
		<div>Type        : <span id="type_label"></span></div>
	</div>
	
	<div id="quizz_end_screen">
		<h3>End screen</h3>
	<?php
		$button_restart	= array('id'		=> 'restart_button',
								'content'	=> 'Restart');
		echo form_open();
		echo form_button($button_restart);
		echo form_close();
	?>
	</div>
</div>