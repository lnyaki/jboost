
<script>

	//get the game object
	var game			= new test.Flashcard();
	var quizz 			= new test.Quizz();
	var item			= $('#item');
	var card			= $('#card');
	var answer			= $('#quizz_answer');
	var answer2			= $('#quizz_input');
	var answer3			= '#'+game.DIRECT_INPUT_ID;
	var options			= $('#quizz_options');
	var options_button 	= $('#option_button');
	var restart			= $('#restart_button');
	var end_screen		= $('#quizz_end_screen');
	
	
	//ajax object
	var ajax	= new test.Ajax();
	//load game data

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
	};
	
	//set the click option for radio buttons
	$('input[type="radio"]').click(quizz.click_radio);
	
	var restart_function	= function(){
		//hidding the end screen
		$(end_screen).hide();
		
		//reinitializing the game
		
		//showing the start screen
		$(options).show();
	};
	
	//TODO : remove this button and generate it dynamically, depending
	// on the input type.
	$('#quizz_button').click(function(){
		quizz.validate($(answer3));
	});
	
	$(options_button).click(click_option);
	$(restart).click(restart_function);
	
</script>