
<script type="text/javascript">

	//get the game object
//	var game			= new test.Flashcard();
	var game			= new Flashcard(); 
	
	//var quizz 			= new test.Quizz();
	var quizz				= new Quizz();
	var item				= $('#item');
	var card				= $('#card');
	var answer				= $('#quizz_answer');
	var answer2				= $('#quizz_input');
	var answer3				= '#'+game.DIRECT_INPUT_ID;
	var options				= $('#quizz_options');
	var options_button 		= $('#option_button');
	var restart				= $('#restart_button');
	var end_screen			= $('#quizz_end_screen');
	var card_view			= $('#card-view');
	var btn_answer2question	= $('#btn-answer2question');
	var btn_question2answer	= $('#btn-question2answer');
	
	
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
	
	
	//test the attr function
	console.log($(btn_question2answer));
	console.log('Test sur l\'attribut "toto"');
	console.log('Toto présent : '+$(btn_question2answer).attr('toto'));
	console.log('HasAttr : '+document.getElementById("btn-question2answer").hasAttribute('toto'));
	if($(btn_question2answer).attr('toto') == true){
		console.log("Attribut est là");
	}
	else if($(btn_question2answer).attr('toto') == undefined){
		console.log("Attribut undefined");
	}
	else if(!!$(btn_question2answer).attr('toto') == false){
		console.log("False");
	}
	else if(!!$(btn_question2answer).attr('toto') == true){
		console.log("true");
	}
	else console.log("valeur inconnue");
	
	//USE RADIO INSTEAD OF BUTTONS
	
	//function for the 2 buttons which indicate the direction of the quizz (questions to answers, or answers to questions)
	//For this function to work, the 2 buttons must be initialized with one active, and one disabled.
	var quizz_direction_click = function(event){
		var target = event.target;
		var $button1 = $(btn_question2answer);
		var $button2 = $(btn_answer2question);
		var tmp;
		console.log("quizz_direction_click");
		
		if($(target)[0] !== $button1[0]){
			if($(target)[0] == $button2[0]){
				console.log("Click on Button2");
				tmp = $button1;
				$button1 = $button2;
				$button2 = tmp;	
			}
			else{
				console.log("ERR : Clicked button is different from the expected buttons");
				console.log($(target));
				console.log($button2);
			}
		}
		else{
			console.log("Click sur Button1")
		}

		//on click (if the element isn't clicked yet), we select the button and set
		//the class of btn-primary
		if(!($button1.attr('selected') == 'selected')){
			console.log("Bouton pas encore selected");
			//select the current button
			$button1.attr("selected","selected");
			$button1.removeClass("btn-default");
			$button1.addClass("btn-success");
			$button1.removeClass("directionNotSelected");
			$button1.addClass("directionSelected");
			
			//unselect the other button
			$button2.removeAttr("selected");
			$button2.removeClass("btn-success");
			$button2.addClass("btn-default");
			$button2.removeClass("directionSelected");
			$button2.addClass("directionNotSelected");
			
			//set the variables describing the direction of the quizz
			if($(target)[0] == $(btn_answer2question)[0]){
				
			}
		}
		else{
			console.log("Button is already selected : ["+$button1.attr('selected')+"]");
			console.log();
		}
	};
	
	var restart_function	= function(){
		//hidding the end screen
		$(end_screen).hide();
		
		//reinitializing the game
		
		//remove the stats from the html 'result' div
		$(end_screen).children('div#result').remove();
		
		//showing the start screen
		$(options).show();
	};
	
	//set the click option for the 2 buttons (question2answer and answer2question). These buttons
	// governate the direction of the quizz (ex : from kana to romaji, or romaji to kana)
	$(btn_question2answer).click(quizz_direction_click);
	$(btn_answer2question).click(quizz_direction_click);
	
	//TODO : remove this button and generate it dynamically, depending
	// on the input type.
	$('#quizz_button').click(function(){
		quizz.validate($(answer3));
	});

	$(options_button).click(click_option);
	$(restart).click(restart_function);
	
</script>