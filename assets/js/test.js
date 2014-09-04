
var test = function(){
	//Data types
	var Flashcard	= function(html_card){
		root_card	= html_card;
	};

	var Kana		= function(){};
	var Ajax		= function(){};
	var Quizz		= function(){};
	var List_Item	= function(item){};
	var List		= function(){};
	
//****************************************************************************
//                           FLASHCARD
//
//****************************************************************************
	Flashcard.prototype	= (function(){
	//constructor
		var constructor	= Flashcard;

	//attributes
		var quizz;				/* The instance of the quizz game                    */
		var root_card;			/* The flashcard html object                         */
		var answers;			/* */
		var input_method;		/* Input type ('direct input' or 'multiple answers') */
		var answers_number;     /* The number of multiple answers 				     */
		var current_item;		/* The current object being quizzed     			 */
		var validated_item;		/* The item that was validated by the user 			 */
		
	//html elements
		var POINTS	 			= '#points';
		var ANSWER_RESULT		= '#answer_label';
		var INPUT_DIV			= '#quizz_answer1';
		var ITEM_DIV			= '#item';
		var ANSWER_DIV			= '#quizz_input';
		var DIRECT_INPUT_ID 	= 'direct_input_id';
		var MULTIPLE_ANSWERS_ID	= 'multiple_answers_id';
		var MULT_ANS_GROUP		= 'mult_ans_group';
		var DIRECT_INPUT   		= 'direct_input';
		var MULTIPLE_ANSWERS	= 'multiple_answers';

		
		
		//**********************************************
		//          INITIALIZATION FUNCTIONS
		//**********************************************
		
		//create the textfield for direct input
		var create_direct_input		= function(){
			return $('<input/>', {
				id		: DIRECT_INPUT_ID
				,name 	: DIRECT_INPUT_ID
			});
		};
		
		
		//**********************************************
		//          PROCESSING FUNCTIONS
		//**********************************************
		var validate		= function(answer){
			console.log('*************** Flashcard.validate *************');
			console.log('*** answer : '+answer+'	item : '+current_item.answer);

			return current_item.answer == answer;
		};
		
		
		//**********************************************
		//              EVENT FUNCTIONS
		//**********************************************
		//when the user has validated his answer (event function)
		var answer_validated		= function(){
			//call the quizz to stop the timer
			quizz.answer_validated();
			
			//get the answer
			
			//send answer to quizz
			
		};
		
		var get_answer			= function(){
			var answer = '';
			if(input_method = DIRECT_INPUT){
				answer	= $.trim($('#'+DIRECT_INPUT_ID).val());
			}
			else if(input_method = MULTIPLE_ANSWERS){
				answer = validate_item;
			}
		};
		
		//**********************************************
		//                GETTERS
		//**********************************************
		var get_multiple_answers_buttons	= function(quantity){
			var tab = new Array();
			console.log("* Quantity : "+quantity);
			if(quantity>0){
				for(var i = 0; i<quantity; i++){
					tab[i]	= $('<button/>',{
						name	: 'ans'+i
						,text : 'totoans'+(i+1)
						,class	: 'qButton'
					});
				}
			}
			
			return tab;
		};
		
		//get 'quantity' elements from the list, but no elements that are in the blackList
		var get_multiple_answers_list	= function(quantity, blackList){
			var list = get_random_elements(quizz.get_items(),quantity,blackList);
			console.log("debug : dans get_multiple_answer_list");
			return list;
		};
		
		
		//
		var get_random_elements		= function(list,quantity, blackList){
			var max_random 	= list.length;
			var boundary1 	= list.length - 1;
			var boundary2	= list.length - 1;
			var quantity_count = quantity;
			var i 			= 0;
			var tmp1, tmp2	= null;
			var elt			= null;
			
			while(quantity_count>0){
				//get random elt between 0 and max_random, excluded
				i = (Math.floor(Math.random() * (max_random)));

				elt = list[i];
				
				//if elt not in blackList, normal processing
				if(!is_in(elt,blackList)){
				//swap element
					tmp1 			= list[boundary1];
					list[boundary1]	= elt;
					list[i]			= tmp1;	
			
				//console.log('--------------------');
				
					quantity_count--;
				}
				//if the element belongs to the blackList, we remove it from the list
				// by putting it at the very end
				else{
				//1. put the element in zone C
				//2. extend zone B and zone C
					tmp2				= list[boundary2];
					list[boundary2] 	= elt;
					
					tmp1				= list[boundary1];
					list[boundary1]		= tmp2;
					
					if(boundary1 > i){
						list[i]				= tmp1;
					}
					
					
					boundary2--;
					console.log(elt.item+" faisait partie de la blacklist");
				}
				
				boundary1--;
				max_random--;


			}
			var t1	= boundary2+1-quantity;
			var t2 	= (boundary2+1);
			console.log('Liste ('+t1+', '+t2+')');
			return list.slice((boundary2+1)-quantity,boundary2+1);
		};

		//returns true if elt belongs to list. Return false otherwise.
		var is_in 	= function(element, list){

			if(list == null){
				return false;
			}
			
			var max		= list.length;
			var sortie 	= false;
			var i		= 0;
			var elt 	= null;
			var answer 	= false;
			
			while(!sortie){

				elt = list[i];
				
				if(elt.item == element.item){
					sortie = true;
					answer = true;
					console.log("Item "+element.item+" == "+elt.item);
				}
				else{
					i++;
					console.log("Item "+element.item+" <> "+elt.item);
					if(i == max){
						sortie = true;
					}
				}
			}	

			return answer;
		};


		//return the buttons for multiple answers
		var get_existing_buttons 	= function(){
			return $(ANSWER_DIV).children('button');
		};
		
		//**********************************************
		//                SETTERS
		//**********************************************
		//set the points of the player in the view
		var set_points 			= function(points){
			$(POINTS).text(points);
		};
		
		//set the answer result (right/wrong in the view)
		var set_answer_result	= function(result){
			$(ANSWER_RESULT).text(result);
		};
		
		//set the input type (direct input, multiple questions) of the card
		var set_input_method	 = function(input_type){
			input_method	= input_type;
		};
		
		//set the number of multiple anwers in the card
		var set_answers_number	 = function(num){
			answers_number	= num;
		};
		
		//set the remaining time for the answer
		var set_time			 = function(the_time){
			time	= the_time;
		};
		
		var set_multiple_answers = function(items){
			answers = items;
		};
		
		var set_quizz			 = function(the_quizz){
			console.log('--------------- the quizz is set -------------');
			console.log(the_quizz);
			quizz = the_quizz;
		};
		
		//sets the items being quizzed
		var set_item			 = function(item){
			current_item = item;
			set_item_text(current_item.item);
			console.log("##################### Current Item : ######################");
			console.log(current_item);
		};
		
		var set_item_text		= function(text){
			$(ITEM_DIV).text(text);
		};
		
		//initialize the validation button (direct input) or the multiple
		//answers buttons (multiple answers)
		var create_validation_button = function(input_method, answers_number){
			var buttons = null;
			console.log("create_validation_button : ".input_method);
			if(input_method == DIRECT_INPUT){
				//create validation button
				buttons = get_direct_input_button('Validate test');
				
				
				//set the JS functions onClick
				//set_button_function(buttons,func);
				
				//put the button in its div
			}
			else if(input_method == MULTIPLE_ANSWERS){
				//create numerous buttons
				buttons = get_multiple_answers_buttons(answers_number);
				
				//set the names and values of the buttons
				
				
				//set the JS functions onClick
				//set_button_function(buttons,func);
				
				//put the button in its div
			}
			else{
				console.log('ERR : Unknown input method ('+input_method+')');
			}
			
			return buttons;
		};
		
		//get the click function for a button (or other element)
		var get_click_function	= function(elt_type){
			var click_function = null;
			
			if(elt_type == DIRECT_INPUT){
				click_function = function(){
					quizz.validate($('#'+DIRECT_INPUT_ID));
				};
			}
			else if(elt_type == MULTIPLE_ANSWERS){
				//var sound	= new Audio();
				//sound.src	= "beep2.mp3";
				
				click_function	= function(){
					quizz.validate($(this).attr('value'));
					//sound.play();
					//alert(document.location.pathname);
				};
			}
			return click_function;
		};
		
		//set the click function and content of validation buttons
		var initialize_validation_button	= function(buttons,data_list){
			var button 			= null;
			var click_function	= null;
			var data 			= null;
			
			
			//initialize the click function of the validation button(s)
			if(input_method === DIRECT_INPUT){
				$(ANSWER_DIV).append(create_direct_input());
				$(ANSWER_DIV).after(buttons[0]);
				
				click_function = get_click_function(DIRECT_INPUT);

				$('#quizz_button').click(click_function);
			}
			else if(input_method === MULTIPLE_ANSWERS){
				//get click function				
				click_function = get_click_function(MULTIPLE_ANSWERS);
				
				if(buttons.length == data_list.length){
					for(var i = 0; i<buttons.length; i++){
						button 	= buttons[i];
						data	= data_list[i];
						console.log("DATA ITEM : "+data.item);
						$(button).attr('name',data.answer);
						$(button).attr('value',data.answer);
						$(button).attr('type', 'button');
						$(button).text(data.item);
						
						//removing previous click function, if any. Otherwise, the previous
						//click function can be called along with the new one.
						$(button).unbind('click');
						//setting click function
						$(button).click(click_function);

						$(ANSWER_DIV).append($(button));
					}
					console.log(data_list);
				}
				else{
					console.log('********** Quizz/initialize_validation_button **********');
					console.log('*** CHK-ERROR :');
					console.log('*** number of items different than the number of data ('+buttons.length+'<>'+data_list.length+')');
				}
		
			}
			else{
				console.log('initialize_validation_button : Unknown input method ('+input_method+')');
			}
			
			return buttons;
		};
		
		//empty the text element
		var empty_input_element	= function(){
			$('#'+DIRECT_INPUT_ID).val('');
		};
		
		var get_item = function(){
			return current_item;
		};
		
		var get_input_method	= function(){
			return input_method;	
		};
		
		
		var get_direct_input_button = function(text){
			return $('<button/>', {
				id		: 'quizz_button'
				,name 	: 'validate_button'
				,type	: 'button'
				,text	: text
			});
		};
		
		var set_button_function	= function(){
			
		};
		
		var get_quizz			= function(){
			return quizz;
		};
		
		return {
			answer_validated				: answer_validated
			,validate						: validate
			,set_points						: set_points
			,set_answer_result				: set_answer_result
			,set_input_method				: set_input_method
			,set_answers_number				: set_answers_number
			,set_time						: set_time
			,set_multiple_answers			: set_multiple_answers
			,set_quizz						: set_quizz
			,get_quizz						: get_quizz
			,set_item						: set_item
			,get_item						: get_item
			,get_input_method				: get_input_method
			,DIRECT_INPUT					: DIRECT_INPUT
			,DIRECT_INPUT_ID				: DIRECT_INPUT_ID
			,MULTIPLE_ANSWERS				: MULTIPLE_ANSWERS
			,set_button_function			: set_button_function
			,create_validation_button		: create_validation_button
			,initialize_validation_button	: initialize_validation_button
			,get_random_elements			: get_random_elements
			,get_multiple_answers_list		: get_multiple_answers_list
			,get_existing_buttons			: get_existing_buttons
			,empty_input_element			: empty_input_element
		};
	})();
	
//****************************************************************************
//                           KANA
//
//****************************************************************************
	Kana.prototype	= (function(){
		var constructor	= Kana;
		
		var load_hiragana	= function(){};
		var load_katakana	= function(){};
		var load_kana		= function(){};
		
		return {
			load_hiragana	: load_hiragana
			,load_katakana	: load_katakana
			,load_kana		: load_kana
		};
	})();
	
//****************************************************************************
//                           QUIZZ
//
//****************************************************************************
	Quizz.prototype	=(function(){
		var constructor = Quizz;
		//number of elements to review
		//var review_size		= 3;
		var review_size;
		var remaining_elts;
		
		//index of the element to review
		//var item_index 		= 0;
		var item_index;
		
		//number of points of the player
		//var points			= 0;
		var points;
		
		//input method : direct input or multiple choice questions
		//var input_method	= '';
		var input_method;
		
		//in case of multiple choice questions, this describes the number
		//of possible answers
		//var answer_quantity	= 0;
		var answer_quantity;
		
		//allocated time for each answer
		//var response_time 	= 3;
		var response_time;
		
		//html flashcard reference
		var HTML_FLASHCARD	= '#card';
		
		//quizz card
		//var current_card 	= new Flashcard(HTML_FLASHCARD);
		var current_card;
		
		var item_list		= null;
		
		// when we'll be connected to a DB
		//var items = loadItems();
		
		var items		= new Array(
				 {id	: 1, item	: 'あ', answer	: 'a'}
				,{id	: 2, item	: 'い', answer	: 'i'}
				,{id	: 3, item	: 'う', answer	: 'u'}
				,{id	: 4, item	: 'え', answer	: 'e'}
				,{id	: 5, item	: 'お', answer	: 'o'}
				,{id	: 6, item	: 'か', answer 	: 'ka'}
				,{id	: 7, item	: 'き', answer 	: 'ki'}
				,{id	: 8, item	: 'く', answer 	: 'ku'}
				,{id	: 9, item	: 'け', answer 	: 'ke'}
				,{id	: 10, item	: 'こ', answer 	: 'ko'}
		);
		
		var sound	= new Audio();
		/*sound.src	= "beep2Test.mp3";
		
		console.log("ATTENTION : Le son ");
		console.log(sound);
		sound.play();
		console.log("Ca joue");*/
		
		var used_items	 = new Array();
		
		
		//============================================================//
		//                   Game initialization                      //
		//                                                            //
		//============================================================//
		var initialize	= function(){
		//load items from db
		//items = load_items();

		//create item list 
			//item_list 	= get_item_list(items);
		
		//initialize things that need to be reset to zero
			initialize_quizz_variables();
			
		//get options data from the user
			initialize_options();

		//after loading, create a list
			//create_item_list(items);
		
		//TODO : get 1 random element first			
		//	var item_list = current_card.get_multiple_answers_list(4, new Array({item : 'あ'}));

		//initialize the flashcard
			initialize_flashcard(this);
		
			console.log("******* Resultat ***********");
			console.log(test);
			
		//initialize the options data
			$('#time_label').text(response_time);
			$('#type_label').text(input_method);
			$('#repetitions_label').text(review_size);
			//build_card();
		};
		
		var initialize_quizz_variables	= function(){
			item_index 		= 0;
			points			= 0;
			input_method	= '';
			answer_quantity	= 0;
			response_time 	= 3;
			
			current_card	= new Flashcard(HTML_FLASHCARD);
		};
		
		//TODO : use constants instead of hard coded values.
		var initialize_options	= function(){
			//get repetitions
			var repetitions	= $('#menu_repetitions').find('[checked][name="option_repetitions"]');
			review_size = $(repetitions).attr("value");
			remaining_elts = review_size -1;
			console.log("* Répétitions : 		" + review_size);
			
			//get input type			
			var input_type	= $('#menu_input_type').find('[checked][name="input_type"]');
			if($(input_type).size() == 1){
				input_method = $(input_type).attr("value");	
				console.log("* input type : 		" + input_method);
			}
			else{
				console.log("ERR : [Input type] incorrect number of entries found : " + $(input_type).size());
			}
			
			//get the number of multiple answers
			if(input_method == 'multiple_answers'){
				var num_ans 		= $('#menu_multiple_answers').find('[checked][name="mult_answ"]');	
				answer_quantity 	= $(num_ans).attr("value");
			}
			
			
			//get time per answer
			var answer_time = $('#menu_time').find('[checked][name="option_time"]');
			if($(answer_time).size() == 1){
				response_time	= $(answer_time).attr('value');
				console.log("* Time : 			"+ response_time);
			}
			else{
				console.log("ERR: Answer time : incorrect number of entries found : "+ $(answer_time).size());
			}
			
		};
		
		var initialize_flashcard	= function(quizz){
			//set the quizz object in the card object
			console.log(quizz);
			current_card.set_quizz(quizz);
			
			//set elements to their initial values
			current_card.set_points(0);
			current_card.set_answer_result('');
			
			//set the number of possible answers
			current_card.set_answers_number(answer_quantity);
			
			//set the maximum response time
			current_card.set_time(response_time);
			
			//set the card input method
			current_card.set_input_method(input_method);
			
			//create the validation buttons depending on the input method
			var buttons = current_card.create_validation_button(input_method, answer_quantity);
			
			console.log("BOUTONS : ");
			console.log(buttons);
			
			
			var preselected;
			var item_list;
			var func;
			
			//get the next item (randomly)			
			var next_item = next_random_item();
			//set the next item
			current_card.set_item(next_item);
	
			
			console.log("################ Set Item ########################");
			console.log(next_item);
			console.log('ci dessus, le next item');
			
			
			//put the button in the right div
			if(input_method == current_card.DIRECT_INPUT){
			//validation button function 
				func = '';				
				
			}
			else if(input_method == current_card.MULTIPLE_ANSWERS){
				//set the list of preselected elements
				preselected = new Array(next_item);
				//get a list of answers, without the preselected elements
				item_list = current_card.get_multiple_answers_list(answer_quantity-preselected.length, preselected);
				//add the preselected item to the item list
				item_list[item_list.length] 	= next_item;
				
				func = '';
				
				//check the size of the item list
				if(item_list.length != answer_quantity){
					console.log('CHK-ERROR : List size different than expected number of answers ('+item_list.length+', '+answer_quantity+')');	
				}
			}
			
			
			if(buttons == undefined){
				console.log("*** Buttons is undefined ***");
				exit();
			}
			
			//initialize button text and values
			buttons = current_card.initialize_validation_button(buttons, item_list, func);
	
		};
		

		//============================================================//
		//                   Game mechanics                           //
		//                                                            //
		//============================================================//
		var add_points 		= function(the_points){
			console.log('###### Adding points ####');
			console.log(points + ' + '+the_points);
			points += the_points;
		};
		
		var calculate_points	= function(){
			var points	= 1;
			return points;
		};
		
	//search if the answer is in the list and matches the user answer
	//TODO : change that and locally save the current quizz elements
	//this will prevent searching through a whole array.
		var check_answer	= function(item, answer){
			var max			= items.length;
			var answer_ok	= false;
			var exit		= false;
			var elt			= null;
			var i			= 0;
			while(!exit){
				elt = items[i];
				//we find the right element in the list
				if(elt.item == item){
					//we compare answers
					//if(elt.answer == answer){
					if(current_card.validate(answer)){
						exit 		= true;
						answer_ok	= true;
					}
				}
				i++;
				//control to no go outside the bound of the array
				if(i == max){
					exit = true;
				}
			}
			return answer_ok;
		};
		
		//this function resets dom elements
		var reset_html_quizz_elements	= function(){
			//remove the buttons or/and input element
			$('#quizz_input').children().remove();
			$('#quizz_button').remove();			
		};
		
		var answer_validated	= function(){
			//stop the timer
			
			//check the answer
			
			//calculate points
			
			//update points
			
			//call the card to make an animation
		};
		
		//Check if the answer given by the user is correct
		var validate	= function(answer_elt1){
			console.log("****************  Quizz.validate  ******************");
			console.log("* Next element     : " + item_index);
			console.log("* Remaining elts   : " + remaining_elts);
			console.log("* Element courant  : " + current_card.get_item().item);
			console.log("* Input type   	: " + current_card.get_input_method());
			console.log("****************************************************");
			var answer_elt	= '';
			var tmp 		= current_card.get_input_method();
			var answer		= null;
			var item		= null;
			
			//fetch the right element
			if(current_card.get_input_method() == current_card.DIRECT_INPUT){
				answer_elt	= '#'+current_card.DIRECT_INPUT_ID;
				
				console.log("* "+current_card.DIRECT_INPUT);
				
				//var quizz	= new Quizz();
				answer		= $.trim($(answer_elt1).val());
				item		= $.trim($(item).text());
			}
			else if(current_card.get_input_method() == current_card.MULTIPLE_ANSWERS){
				console.log("* Quizz.validate : multiple answers : "+current_card.get_input_method());
				console.log("* "+current_card.MULTIPLE_ANSWERS);
				answer = answer_elt1;
				console.log("* answer : "+answer);
			}
			else{
				console.log("* Quizz.validate : unknown input method : "+current_card.get_input_method());
				console.log("* tmp (input method) "+tmp);
			}

			console.log('quizz.validate. Answer : '+answer);

			//TODO : use constants instead of hardcoded values.
			//validate the answer
			var validated	= current_card.validate(answer);
			
			console.log('** Validated : '+ validated);
			
		    var answer 		= $('#answer_label');
		    var points_elt	= $('#points');
			if(validated){
				add_points(calculate_points());
				current_card.set_answer_result('Right');
				current_card.set_points(points);
			}
			else{
				current_card.set_answer_result('Wrong');
			}	
			
			
            console.log("Quizz.validate. Rem. items : "+remaining_elts);
			if(remaining_elts > 0){
				//get next random elt
				var random_elt 		= next_random_item();
				
				//get new random answer set
				var random_answers 	= current_card.get_multiple_answers_list(answer_quantity-1, new Array(random_elt));
				//add the answer element to the random elements
				random_answers.push(random_elt);
				
				var buttons;
				
				if(input_method === current_card.MULTIPLE_ANSWERS){
					//get the existing buttons, to reinitialize them
					buttons 		= current_card.get_existing_buttons();
				
					//initialize buttons
					current_card.initialize_validation_button(buttons,random_answers);
				}		
				else if(input_method === current_card.DIRECT_INPUT){
					//empty the text input element
					current_card.empty_input_element();
					
					//get button element
					
					//initialize button element
				}		

				set_next_item(random_elt);
			}
			//END of the game, last screen
			else{
				$('#card').hide('slide');
				
				reset_html_quizz_elements();
				
				$('#quizz_end_screen').show('slide');
			}
			$('#quizz_answer').val('');
			
		};
		
		//display the next item by giving the dom parent element
		var set_next_item	= function(item){
			current_card.set_item(item);
			remaining_elts --;
			console.log('********************* Next random Item : '+item.item);
			console.log('********************* Remaining elements : '+remaining_elts);
		};
		
		var next_item		= function(){
			if(remaining_elts > 0){
				if(item_index >= items.length){
					item_index = 0;
				}
				
				return items[item_index++];	
			}
			else{
				return null;
			}
		};

		var next_random_item	= function(){
			if(remaining_elts > 0){
				var tmp = current_card.get_multiple_answers_list(1,null);
				return tmp[0];
			}
			else{
				return null;
			}
		};
		
		var build_card = function(){
			
		};
		
		var get_items	= function(){
			return items;
		};
		
		
		var get_item_list	= function(items){
			var list_size 	= items.length;
			var list 		= null;
			var temp_list 	= null;
			var elt 		= null;
			
			for(var i = 0; i<list_size;i++){
				//get an element from the array
				elt			= items[i];
				
				//create the list item
				temp_list =  new List_Item();
				temp_list.set_previous(previous);
				temp_list.set_item(elt);
				temp_list.set_reference(i);
			}
		};
		//============================================================//
		//                   Element managment                        //
		//                                                            //
		//============================================================//
		
		var get_selected_element	= function(parent){
			return $(parent).children('input[selected]');
		};
		
		var click_radio	= function(){
			console.log("Checked value : "+$(this).attr('checked'));
			if($(this).attr('checked') == undefined){
				var groupName	= $(this).attr('name');
				$(this).siblings("input[name='"+groupName+"']").removeAttr('checked');
				$(this).attr("checked","checked");
				console.log("elems trouvés : "+$(this).siblings("input[name='"+groupName+"']").size());
				console.log("* radio button : was not checked "+$(this).attr("value"));
			}
			else{
				console.log("* radio button : already checked "+$(this).attr("value"));
			}
		};
		
		return {
			check_answer				: check_answer
			,set_next_item				: set_next_item
			,validate					: validate
			,initialize					: initialize
			,click_radio				: click_radio
			,build_card					: build_card
			,get_items					: get_items
			,initialize_quizz_variables	: initialize_quizz_variables
			,reset_html_quizz_elements	: reset_html_quizz_elements
		};
	})();
	
//****************************************************************************
//                             Chained list (list of List_item)
//
//****************************************************************************
	List_Item.prototype = (function(){
		var constructor = List_Item;
		
		var item	 	= null;
		var previous	= null;
		var next   		= null;
		var reference	= '';
		
		//============================================================//
		//                   Getters                                  //
		//                                                            //
		//============================================================//
		var get_previous = function(){
			return this.previous;
		};
		
		var get_next	= function(){
			return this.next;	
		};
		
		
		var get_item = function(){
			return this.item;
		};
		
		var get_reference	= function(){
			return this.reference;
		};
		
		var length	= function(){
			var prev = 0;
			var lNext = 0;
			
			if(this.previous !== null){
				prev = previous.pLength(0);	
			}
			
			if(this.next !== null){
				lNext = this.next.nLength(0);
			}
			
			return prev + lNext + 1;
		};
		
		var pLength	= function(total){
			if(this.previous === null){
				return total +1;
			}
			else{
				return this.previous.pLength(total+1);
			}
		};
		
		var nLength	= function(total){
			if(this.next === null){
				return total + 1;
			}
			else{
				return this.next.nLength(total+1);
			}
		};
		
		//============================================================//
		//                   Setters                                  //
		//                                                            //
		//============================================================//		
		//sets the next element, erasing anything after (use with caution)
		var set_next		= function(next){
			this.next		= next;
			
			if(next !== null){
				next.previous = this;
			}
		};
		
		//sets the previous item, erasing anything before (use with caution)
		var set_previous 	= function(previous){
			this.previous	= previous;
			
			if(previous !== null){
				previous.next = this;
			}
		};
		
		//set the item of the list
		var set_item		= function(item){
			console.log('SET ITEM **************************************************************');
			console.log(item);
			this.item	= item;
		};
		
		
		//set the index that this object has in its related array
		var set_reference	= function(ref){
			reference	= ref;	
		};
		
		//insert an item just after another, in the list.
		var insert_after	= function(next){
			var tmp			= this.next;
			this.next		= next;
			this.size      += 1;
			
			if(next !== null){
				next.set_next(tmp);
				next.set_previous(this);
			}
		};
		
		//remove an item from the chained list.
		var remove		= function(){
			if(this.previous !== null){
				this.previous.set_next(this.next);
			}
			
			if(this.next !== null){
				this.next.set_previous(this.previous);
			}
			
			this.previous	= null;
			this.next		= null;
		};
		
		
		var pop		= function(){
			if(this.next === null){
				//console.log(this);
				var tmp = this;
				
				this.remove();
				return tmp;
			}
			else{
				return this.next.pop();
			}
		};
		
		return {
			get_previous	: get_previous,
			get_next		: get_next,
			get_item		: get_item,
			get_reference	: get_reference,
			length			: length,
			pLength			: pLength,
			nLength			: nLength,
			set_next		: set_next,
			set_previous	: set_previous,
			set_item		: set_item,
			set_reference	: set_reference,
			insert_after	: insert_after,
			remove			: remove,

		};

	})();
	
	List.prototype = (function(){
		var constructor = List;
		
		var root			= null;
		var tail 			= null;
		var last_element	= null;
		
		var get_root	= function(){
			return root;
		};
		
		var set_root	= function(root_list){
			root = root_list;
		};
		
		var get_tail	= function(){
			return root.get_next();
		};
		
		
		var push		= function(elt){
			last_element.set_next(elt);
			last_element = last_element.get_next();
		};
		
		var pop			= function(){
			var elt = last_element;
			
			last_element.remove();
			last_element = elt.get_previous();
			
			
			if(last_element == null){
				root = null;	
			}
			
			return elt;
		};
		
		return {
			
		};
	})();
//****************************************************************************
//                           AJAX
//
//****************************************************************************

	Ajax.prototype	= (function(){
		var constructor	= Ajax;
		//create an ajax request of type get
    	var ajaxGetRequest = function(path, responseHandler){
        	ajaxRequest(path, null, responseHandler, 'get');
    	};
    
    	//create an ajax request of type post
    	var ajaxPostRequest = function(path, data, responseHandler){
       	 	ajaxRequest(path, data, responseHandler, 'post');
    	};
    
    	//create an ajax request.
    	var ajaxRequest = function(path, data, responesHandler, type){
        	datatype = 'json';
        
        	if(type==='get'){
            	$.ajax({
                    url:path
                ,   datatype:datatype
                ,   type:'get'
                ,   success:function(data){
                        responesHandler(data);
                }
            });
        	}
        	else if(type==='post'){
            	$.ajax({
                    url:path
                ,   datatype : datatype
                ,   type:'post'
                ,   data:data
                ,   success : function(msg){
                        responesHandler(msg);
                	}
            	});    
        	}
    	};
		
		return {
			ajaxGetRequest		:ajaxGetRequest
			,ajaxPostRequest	:ajaxPostRequest	
		};
	})();

	
	return {
		Flashcard	: Flashcard
		,Kana		: Kana
		,Ajax		: Ajax
		,Quizz		: Quizz
		,List_Item	: List_Item
		};
}();
