
<script type="text/javascript">

	//get the game object
//	var game			= new test.Flashcard();
	var game			= new Flashcard(); 
	
	//var quizz 			= new test.Quizz();
	var quizz			= new Quizz();
	var item			= $('#item');
	var card			= $('#card');
	var answer			= $('#quizz_answer');
	var answer2			= $('#quizz_input');
	var answer3			= '#'+game.DIRECT_INPUT_ID;
	var options			= $('#quizz_options');
	var options_button 	= $('#option_button');
	var restart			= $('#restart_button');
	var end_screen		= $('#quizz_end_screen');
	var card_view		= $('#card-view');
	
	
	//ajax object
	var ajax	= new test.Ajax();
	//load game data

	//code to prevent problem with ajax and url
	//from : http://stackoverflow.com/questions/27420759/codeigniter-base-url-not-working-properly-for-ajax
    var BASE_URL = "<?php echo base_url();?>";

	$('#quizz_end_screen').hide();
	
	var click_function	= function(){
	//	alert('Bouton ok');
		var path	= 'ajax/quizz';
		var data	= {
			item	: 'aaaa'
			,answer	: 'bbbb'
		};
		var handler	= function(msg){
			alert(msg);
		};
		
		//ajax.ajaxPostRequest(path, data, handler);
	}
	
	var click_option	= function(){
		$(options).hide();
		quizz.initialize();
		
		$(card).show('slide');
		$(card_view).show('slide');
	};
	
	//set the click option for radio buttons, depending on radio button group
	//$('input[type="radio"]').click(quizz.click_radio);
	$('#menu_repetitions').find('input[type="radio"][name="option_repetitions"]').click(
			function(){
				quizz.click_radio($('#menu_repetitions'), this);
			}
	);
	
	$('#menu_input_type').find('input[type="radio"][name="input_type"]').click(
			function(){
				quizz.click_radio($('#menu_input_type'), this);
			}
	);

	$('#menu_multiple_answers').find('input[type="radio"][name="mult_answ"]').click(
			function(){
				quizz.click_radio($('#menu_multiple_answers'), this);
			}
	);
	
	$('#menu_time').find('input[type="radio"][name="option_time"]').click(
			function(){
				quizz.click_radio($('#menu_time'), this);
			}
	);
	
	var restart_function	= function(){
		//hidding the end screen
		$(end_screen).hide();
		
		//reinitializing the game
		
		//remove the stats from the html 'result' div
		$(end_screen).children('div#result').remove();
		
		//showing the start screen
		$(options).show();
	};
	
	//TODO : remove this button and generate it dynamically, depending
	// on the input type.
	$('#quizz_button').click(function(){
		quizz.validate($(answer3));
	});

	console.log($(options_button));
	console.log($('#option_button'));
	console.log($('#quizz_button'));
	$(options_button).click(click_option);
	$(restart).click(restart_function);
	
</script>