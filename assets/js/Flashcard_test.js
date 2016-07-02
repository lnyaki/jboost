
//****************************************************************************
//                           FLASHCARD
//
//****************************************************************************
	var Flashcard	= function(html_card){
		//root_card	= html_card;
	};
	
	Flashcard.prototype	= (function(){
	//constructor
		var constructor	= Flashcard;

	//attributes
		var quizz;				/* The instance of the quizz game                    							*/
		var root_card;			/* The flashcard html object                         							*/
		var answers;			/* */
		var input_method;		/* Input type ('direct input' or 'multiple answers') 							*/
		var quizz_direction;	/* Expresses the direction of the quizz (question to answer, or the opposite)	*/
		var answers_number;     /* The number of multiple answers 				     							*/
		var current_item;		/* The current object being quizzed     			 							*/
		var validated_item;		/* The item that was validated by the user 			 							*/
		
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
				id				: DIRECT_INPUT_ID
				,name 			: DIRECT_INPUT_ID
				,type			: 'text'
				,autocomplete	: 'off'
			});
		};
		
		
		//**********************************************
		//          PROCESSING FUNCTIONS
		//**********************************************
		var validate		= function(answer){
			console.log('*************** Flashcard.validate *************');
			console.log('*** Quizz direction : '+quizz_direction);
			console.log('*** answer : '+answer+'	item : '+current_item.answer);
			console.log(current_item);

			if(quizz_direction == "q2a"){
				return current_item.answer == answer;	
			}
			else if(quizz_direction == "a2q"){
				return current_item.item == answer;
			}
			
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
			
			//console.log("* Quantity : "+quantity);
			
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
			//console.log("DEBUG : dans get_multiple_answer_list. List size : "+list.length);
			return list;
		};
		
		
		//
		var get_random_elements		= function(list,quantity, blackList){
			var max_random 		= list.length;
			var boundary1 		= list.length - 1;
			var boundary2		= list.length - 1;
			var quantity_count 	= quantity;
			var i 				= 0;
			var tmp1, tmp2		= null;
			var elt				= null;
			
			//console.log('DEBUG : item list size : '+ list.length);
			//console.log('DEBUG : required quantity : '+quantity);
			//console.log(list);
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
			//console.log('Liste ('+t1+', '+t2+')');
			//console.log('Slice('+(boundary2+1-quantity)+', '+(boundary2+1)+')');
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
					//console.log("[DEBUG] Item "+element.item+" == "+elt.item);
				}
				else{
					i++;
				//	console.log("[DEBUG] Item "+element.item+" <> "+elt.item);
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
		
		//Handled arguments : q2a, a2q
		var set_quizz_direction	= function(direction){
			quizz_direction = direction;
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
			//console.log('--------------- the quizz is set -------------');
			//console.log(the_quizz);
			quizz = the_quizz;
		};
		
		/* Modify this function if we get more complex quizz items (like several possible answers)
		 * 
		 */
		//sets the items being quizzed
		var set_item			 = function(item){
			//Set the model
			set_item_model(item);
			
			//Set the view
			if(quizz_direction === "q2a"){
				set_item_view(item.item);
			}
			else if(quizz_direction === "a2q"){
				set_item_view(item.answer);
			}
			else{
				console.log("[Flashcard.set_item] ERR : Unknown quizz direction : "+quizz_direction);
			}
			
			console.log("##################### Current Item : ######################");
			console.log(current_item);
			console.log("Direction : "+quizz_direction);
		};
		
		var set_item_model		= function(item){
			current_item = item;
		};
		
		var set_item_view		= function(text){
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
					
					//save the clicked item here
			//		_.findWhere(items,{id : $(this).attr('id'), name : $(this).attr('name')});
					
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
			
			//console.log("INFO : INPUT_METHOD => "+input_method);
			//initialize the click function of the validation button(s)
			if(input_method === DIRECT_INPUT){
				console.log("INFO : append le textfield");
				console.log($(ANSWER_DIV).size());
				console.log("buttons :");
				console.log(buttons);
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
						//console.log("[DEBUG] DATA ITEM : "+data.item);
						$(button).attr('name',data.answer);
						$(button).attr('type', 'button');
						$(button).attr('id', data.id);
						

						//TODO: test the direction of the quizz : kana --> romaji or romaji --> kana
						if(quizz_direction == "q2a"){
							$(button).attr('value',data.answer);
							$(button).text(data.answer);
						}
						else if(quizz_direction == "a2q"){
							$(button).attr('value',data.item);
							$(button).text(data.item);
						}
						
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
		
		var get_quizz_direction = function(){
			return quizz_direction;
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
		
		var test = function(){
			alert("Découplage ok");
		};
		
		return {
			answer_validated				: answer_validated
			,validate						: validate
			,set_points						: set_points
			,set_answer_result				: set_answer_result
			,set_input_method				: set_input_method
			,set_answers_number				: set_answers_number
			,set_quizz_direction			: set_quizz_direction
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
			,get_quizz_direction			: get_quizz_direction
			,get_multiple_answers_list		: get_multiple_answers_list
			,get_existing_buttons			: get_existing_buttons
			,empty_input_element			: empty_input_element
			,test				: test
		};
	})();
	