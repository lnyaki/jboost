
<section>
	<?php
		$this->load->helper('form');
	?>
	<h3>Test du quizz</h3>

	<div id="quizz_options" class="panel panel-default" style="width : 45%;margin-left: auto;margin-right: auto;">
		<h1>Quizz options</h1>
		<?php
		$options_button	= array('id'		=> 'option_button',
								'content'	=> 'Play !',
								'type'		=> 'button',
								'class'		=> 'btn btn-primary center-block',
								'style'		=> 'font-size:1.5em;');
	
		//data for 'input type' options
		$fieldset_input_type		= array('id'	=> 'menu_input_type');
		$fieldset_multiple_answers 	= array('id' => 'menu_multiple_answers');
		$fieldset_direct_input		= array('id' => 'menu_direct_input');
		

						
		//radio buttons for time options
		$fieldset_time	= array('id'=> 'menu_time');
		
		$form_attributes	= array('role' => 'form');
		//actual form
		echo form_open('#',$form_attributes);


?>
	<fieldset id="menu_repetitions">
		<legend>Repetitions</legend>
		<div class="radio">
  			<label class="radio-inline">
    			<input type="radio" name="option_repetitions" value="10" checked="checked">
    			10
 	 		</label>
	
  			<label class="radio-inline">
    			<input type="radio" name="option_repetitions" value="20">
    			20
 	 		</label>

  			<label class="radio-inline">
    			<input type="radio" name="option_repetitions" value="50">
    			50
 	 		</label>

  			<label class="radio-inline">
    			<input type="radio" name="option_repetitions" value="infinite">
    			infinite
 	 		</label>
		</div>
	</fieldset>

	<fieldset id="menu_input_type">
		<legend>Input type</legend>
		<div class="radio">
  			<label >
    			<input type="radio" name="input_type" value="multiple_answers" checked="checked">
    			Multiple answers
 	 		</label>
		</div>

		<fieldset id="menu_multiple_answers" style="padding-left: 3em;">
			<legend>Multiple answers</legend>
			<div class="radio">
  				<label class="radio-inline">
    				<input type="radio" name="mult_answ" value="3">
    				3
 	 			</label>
  				<label class="radio-inline">
    				<input type="radio" name="mult_answ" value="6" checked="checked">
    				6
 	 			</label>
  				<label class="radio-inline">
    				<input type="radio" name="mult_answ" value="9">
    				9
 	 			</label>
			</div>
			<div>
				<button type="button" id="btn-question2answer" class="btn btn-success directionSelected" selected='selected' >あ　--> a</button>
				<button type="button" id="btn-answer2question" class="btn btn-default directionNotSelected">a -->　あ</button>
			</div>
		</fieldset>

		<div class="radio">
  			<label >
    			<input type="radio" name="input_type" value="direct_input">
    			Direct input
 			</label>
		</div>
	</fieldset>
<!--
	<fieldset id="menu_time">
		<legend>Time limit</legend>
		<div class="radio">
  			<label class="radio-inline">
    			<input type="radio" name="option_time" value="3" checked="checked"> 3 seconds
 			</label>
  			<label class="radio-inline">
    			<input type="radio" name="option_time" value="5"> 5 seconds
 			</label>
  			<label class="radio-inline">
    			<input type="radio" name="option_time" value="10"> 10 seconds
 			</label>
		</div>
	</fieldset>
-->
	<?php
		echo form_button($options_button);
		echo form_close();
	?>
	</div>
	<div id="card-view" class="container" style="width : 100%;">
		<div class="row" style="width : 100%;">
			<div class="col-md-6">
				<div id="card" >
					<div id="item" class="word"></div>	
					<div id="quizz_input"></div>	
				</div>
			</div>
			<div class="col-md-4">
				<div id="quizz_data">
					<div>Points      : <span id="points"></span></div>
					<div>Answer	     : <span id="answer_label"></span></div>
					<div>Time        : <span id="time_label"></span></div>
					<div>Repetitions : <span id="repetitions_label"></span></div>
					<div>Type        : <span id="type_label"></span></div>
				</div>
			</div>
		</div>
	</div>
	<div id="quizz_end_screen">
		<!-- <h3>End screen</h3> -->
	<?php
		$button_restart	= array('id'		=> 'restart_button',
								'content'	=> 'Restart',
								'class'		=> 'btn btn-primary');
		echo form_open();
		echo form_button($button_restart);
		echo form_close();
	?>
	</div>
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	
	<?php /*<script src="http://127.0.0.1:8080/socket.io/socket.io.js"></script>
	<script>
	 var socket = io.connect('http://127.0.0.1:8080');
	 socket.emit('message', 'Quizz adaptation : start ok!');
	</script>
	*/?>
</section>