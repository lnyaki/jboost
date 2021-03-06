//****************************************************************************
//                           QUIZZ
//
//****************************************************************************
var Quizz		= function () {
//We initialize the variables out of the prototype      
        this.item_index 		= 0;
        this.points				= 0;
        this.input_method		= '';
        this.answer_quantity	= 0;
        this.response_time 		= 3;
        this.current_card		= {};
        this.list_name			= '';
	};
	
Quizz.prototype	= (function () {
    "use strict";
	var constructor = Quizz;
	
	var review_size,          	//number of elements to review
        remaining_elts,
        item_index,           	//index of the element to review
	    points,               	//number of points of the player
        input_method,         	//input method : direct input or multiple choice questions
		list_name,				//this is the name of the list that we must load.
		list_loaded = false,	//If the list has been correctly loaded.
	//in case of multiple choice questions, this describes the number
	//of possible answers
	    answer_quantity,
	//The direction of the answers : questions --> answers, or answers --> questions
	    answer_direction,
	//allocated time for each answer
	    response_time,
	//html flashcard reference
	    HTML_FLASHCARD	= '#card',
	
	//quizz card
    //var current_card 	= new Flashcard(HTML_FLASHCARD);
	    current_card,
	    item_list		= null,
	    self = null,
		
	//the variable containing the questions and answers
        items              = [],
        //sound              = new Audio(),
        used_items         = [],
        current_results    = [],
        stats              = [];
		//============================================================//
		//                   Game initialization                      //
		//                                                            //
		//============================================================//
		//load the items that will be used in the quizz
    var load_items		= function (listname) {
		var ajax        = new Ajax(),
		//var path		= 'ajax/quizz/load_items';
		//var path 		= 'http://localhost/codeigniter/ajax/quizz/load_items';
			
		//the BASE_URL is used to prevent an issue with the handling of the url
		//with Ajax. See http://stackoverflow.com/questions/27420759/codeigniter-base-url-not-working-properly-for-ajax
			//path          = BASE_URL + 'ajax/quizz/load_items',
			path          = BASE_URL + 'ajax/quizz/load_items',
			data          = {'list_name' : listname};
			
		//function for handling the list returned from the database
		var responseHandler	= function(msg){
        	console.log('--Database response --');
           // console.log(msg);
			var parsed = JSON.parse(msg);
			//var parsed = msg;
			//If the returned (parsed) content is an empty array
			if(parsed.length > 0){
				set_list_items(parsed);
				//console.log("THIS");
				///console.log(get_this());
				after_loading_items(self);
				list_loaded = true;
				console.log("LIST OK!");
				//console.log(parsed);
			}
			//If the list recieved is empty
			else{
				console.log('ERR: List recieved is either empty, or doesn\'t exist ('+listname+')');
				list_loaded = false;
				
				throw "List recieved is either empty or doesn't exist ("+listname+")"
			}
        };
		
		console.log('loading the items for list '+listname);
		console.log(data);
		ajax.setError(function(){console.log('Une erreur ajax s est produite');});
		ajax.ajaxPostRequest(path,data,responseHandler);
    };
		
	var after_loading_items	= function(itself){
		//console.log("XXXXXXXX This : XXXXXX");
		//console.log(itself);
		initialize_flashcard(itself);
	};

	var initialize		= function(){
	//load items from db
	console.log("THIS : ");
	console.log(this);
		self = this;
		
		//initialize things that need to be reset to zero
		initialize_quizz_variables();
			
		//get options data from the user (from the html form actually)
		initialize_options();
		
		//initialize the options data
		$('#time_label').text(response_time);
		$('#type_label').text(input_method);
		$('#repetitions_label').text(review_size);
		//build_card();
		
		//load list items
		load_items(list_name);
    };

	var get_this				= function(){
		return self;
	};

	var initialize_quizz_variables	= function(){
		self.current_card		= new Flashcard(HTML_FLASHCARD);
		
        self.item_index 		= 0;
        self.points				= 0;
        self.input_method		= '';
        self.answer_quantity	= 0;
        self.response_time 		= 3;
        self.current_card		= new Flashcard(HTML_FLASHCARD);
        self.list_name			= '';
    };
		
	//TODO : use constants instead of hard coded values.
	var initialize_options	= function(){
		//Get the name of the list to load
		var list_element = $('#list_choice').children('button[selected="selected"]').get(0);
		console.log("List element :");
		console.log(list_element);
		list_name = $(list_element).text();
		
		
		//get repetitions
		var repetitions	= $('#menu_repetitions').find('input[checked="checked"][name="option_repetitions"]');
			review_size = $(repetitions).attr("value");
			remaining_elts = review_size -1;
			
			
		//get input type			
		var input_type	= $('#menu_input_type').find('input[checked="checked"][name="input_type"]');
		console.log(input_type);
		
		if ($(input_type).size() == 1) {
			input_method = $(input_type).attr("value");	
			console.log("* input type : 		" + input_method);
		}
		else{
			console.log("ERR : [Input type] incorrect number of entries found : " + $(input_type).size());
		}
			
		//get the number of multiple answers
		if(input_method == 'multiple_answers'){
			var num_ans 		= $('#menu_multiple_answers').find('input[checked="checked"][name="mult_answ"]');
			console.log("number of answers :");
			console.log(num_ans);	
			answer_quantity 	= $(num_ans).attr("value");
			console.log(answer_quantity);		
		}
			
		//set the direction of the answer/response
		//answer_direction = 
		if($('#btn-question2answer').attr('selected')== 'selected'){
			answer_direction = 'q2a';
		}
		else if ($('#btn-answer2question').attr('selected')== 'selected'){
			answer_direction = 'a2q';
		}
		else{
			console.log('ERR : None of the buttons for selecting the quizz direction are selected.');	
		}
	
		console.log("S\* : answer_direction = "+answer_direction);
		console.log("* Répétitions : 		" + review_size);
		console.log("*** List name : "+list_name);
	
		//get time per answer
		/*
		var answer_time = $('#menu_time').find('[checked="checked"][name="option_time"]');
		if($(answer_time).size() == 1){
			response_time	= $(answer_time).attr('value');
			console.log("* Time : 			"+ response_time);
		}
		else{
			console.log("ERR: Answer time : incorrect number of entries found : "+ $(answer_time).size());
		}
		*/
			
	};
		
	var initialize_flashcard	= function(quizz){
		var current_card = quizz.current_card;
		//set the quizz object in the card object
		current_card.set_quizz(quizz);
		
		//set elements to their initial values
		current_card.set_points(0);
		current_card.set_answer_result('');		
			
		console.log("Answer quantity : "+answer_quantity);
		//set the number of possible answers
		current_card.set_answers_number(answer_quantity);
			
		//set the maximum response time
		current_card.set_time(response_time);
			
		//set the card input method
		current_card.set_input_method(input_method);
			
		//set the direction of questions/answers
		current_card.set_quizz_direction(answer_direction);
			
		//create the validation buttons depending on the input method
		var buttons = current_card.create_validation_button(input_method, answer_quantity);
			
		console.log("BOUTONS : ");
		console.log(answer_quantity);
		console.log(buttons);
				
		var preselected,
		    item_list,
		    func,
		    shuffled_list;
			
		//get the next item (randomly)			
		var next_item = next_random_item();
		//set the next item
		current_card.set_item(next_item);
				
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
			
			//shuffle the list
			shuffled_list = _.shuffle(item_list);
			
			func = '';
				
				//console.log('DEBUG: answer quantity : '+answer_quantity);
				//console.log('DEBUG: preselected length :'+preselected.length);
				//console.log('DEBUG: difference : '+(answer_quantity - preselected.length));
				
			//check the size of the item list
			if(shuffled_list.length != answer_quantity){
				console.log('CHK-ERROR : List size different than expected number of answers ('+shuffled_list.length+', '+answer_quantity+')');	
			}
		}
			
			
		if(buttons == undefined){
			console.log("*** Buttons is undefined ***");
			exit();
		}
		//console.log("INFO : avant initialize validation button");
		//initialize button text and values
		buttons = current_card.initialize_validation_button(buttons, shuffled_list, func);
	};
		

	//============================================================//
	//                   Game mechanics                           //
	//                                                            //
	//============================================================//
	//add 'the_points' points to the current number of points
	var add_points 		= function(the_points){
		//	console.log('###### Adding points ####');
		//	console.log(points + ' + '+the_points);
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
				if(self.current_card.validate(answer)){
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
		console.log("* Element courant  : " + self.current_card.get_item().item);
		console.log("* Input type   	: " + self.current_card.get_input_method());
		console.log("****************************************************");
		var answer_elt	= '';
		var tmp 		= self.current_card.get_input_method();
		var answer		= null;
		var item		= null;
			
		//fetch the right element
		if(self.current_card.get_input_method() == self.current_card.DIRECT_INPUT){
			answer_elt	= '#'+self.current_card.DIRECT_INPUT_ID;
			
			console.log("* "+self.current_card.DIRECT_INPUT);
			
			//var quizz	= new Quizz();
			answer		= $.trim($(answer_elt1).val());
			item		= $.trim($(item).text());
		}
		else if(self.current_card.get_input_method() == self.current_card.MULTIPLE_ANSWERS){
			console.log("* Quizz.validate : multiple answers : "+self.current_card.get_input_method());
			console.log("* "+self.current_card.MULTIPLE_ANSWERS);
			answer = answer_elt1;
			console.log("* answer : "+answer);
		}
		else{
			console.log("* Quizz.validate : unknown input method : "+self.current_card.get_input_method());
			console.log("* tmp (input method) "+tmp);
		}

		console.log('quizz.validate. Answer : '+answer);
		//TODO : use constants instead of hardcoded values.
		//validate the answer
		var validated	= self.current_card.validate(answer);
			
		console.log('** Validated : '+ validated);
		var current_item	= self.current_card.get_item();
	    var answer 			= $('#answer_label');
	    var points_elt		= $('#points');
		    
/************************************************************************
 * 
 *  Write this more properly.
 * 
 ***********************************************************************/
	    console.log("-------------- SIZE OF STATS : "+stats.length);
	    console.log(stats);
		if(validated){
			//must get the card that was clicked, and not the current card
			add_stats(current_item.id,current_item.item,true);
			add_points(calculate_points());
		
			self.current_card.set_answer_result('Right');
			self.current_card.set_points(points);
		}
		else{
			add_stats(current_item.id,current_item.item,false);
			self.current_card.set_answer_result('Wrong');
		}	
			
			
		console.log("Quizz.validate. Rem. items : "+remaining_elts);
		if(remaining_elts > 0){
			//First, we choose the next random quizz element.
			//Then we obtain other elements, to fill the list of multiple possible answers
				
			//get next random elt
			var random_elt 		= next_random_item();
			var buttons;
			var shuffled_list;
				
			if(input_method === self.current_card.MULTIPLE_ANSWERS){
				//get new random answer set
				var random_answers 	= self.current_card.get_multiple_answers_list(answer_quantity-1, new Array(random_elt));
				//add the answer element to the random elements
				random_answers.push(random_elt);
				
				//randomize the array of answers
				shuffled_list = _.shuffle(random_answers);

				//get the existing buttons, to reinitialize them
				buttons 		= self.current_card.get_existing_buttons();
				
				//initialize buttons
				self.current_card.initialize_validation_button(buttons,shuffled_list);
			}		
			else if(input_method === current_card.DIRECT_INPUT){
				//empty the text input element
				self.current_card.empty_input_element();
				
				//get button element
					
				//initialize button element
			}		

			set_next_item(random_elt);
		}
		//If there is no more remaining elements : END of the game, last screen
		else{
		//TODO : display end of game screen (result as charts and all)
			var result = result_screen(stats);
			console.log("#### Print de l'ecran de fin");
			console.log(result);
			$('#quizz_end_screen').prepend(result);
				
			sleep(display_endgame,1000);
			
			//send result to server
			send_result(stats);
			//reset the stats object
			console.log("DEBUG : reset stats.");
			console.log(stats);
			console.log("DEBUG : reset ok");
			stats = new Array();
		}

		$('#quizz_answer').val('');		
	};
		
	//correct_answer is a boolean describing if the answer was right or wrong
	var add_stats		= function(itemID,item,isAnswerOK){
		console.log("----- Dans add stats ------");
		var element = _.findWhere(stats,{id : itemID, item : item});
		
	//if there is already an entry for this element, we increment the count
	//of right and wrong answers
		if (element !== undefined){
			console.log('-- Element found : '+element.item);
			if(isAnswerOK){
				element.right += 1;
			}
			else{
				element.wrong += 1;
			}
			console.log(element);
		}
		//else, we create the element and initialize 'right' and 'wrong' depending on isAnswerOK
		else{
			console.log('-- Element not found. We create '+item);
			var new_stat = null;
			if(isAnswerOK){
				new_stat	= {id : itemID, item : item, right : 1, wrong : 0};
			}
			else{
				new_stat 	= {id : itemID, item : item, right : 0, wrong : 1};
			}
				
			console.log(new_stat);
			stats.push(new_stat);				
		}
	};
		
	//generate the html representing the result of the quizz (with progress bars)
	var result_screen	= function(result){
		console.log("#### Dans result screen");
		var length = result.length;
		var $result = $('<div>',{id	: 'result'});
		var $rowContainer;
		var $label;
		var $progressbar;
		var total = 0;
		var answer = '';
			
		_.forEach(result,function(elt){
			if(answer_direction == "q2a"){
				answer = elt.item;
			}
			else if(answer_direction == "a2q"){
				answer = elt.answer;
			}
			
			total = elt.right+elt.wrong;
			$rowContainer	= $('<div>',{class	: 'elt_stat'});
			$label			= $('<label style="margin-left : 1em;">'+elt.item+' ('+elt.right+'/'+total+')</label>');
			$progressbar	= $('<progress>',{
				 max	: elt.right+elt.wrong
				,value	: elt.right
			});
			
			$rowContainer.append($($progressbar));
			$rowContainer.append($($label));
				
			$result.append($($rowContainer));
		});
			
		return $result;
	};
		
	var display_endgame	= function(){
		//$('#card').hide('slide');
		$('#card-view').hide('slide');
		
		reset_html_quizz_elements();
			
		$('#quizz_end_screen').show('slide');
			
			//console.log(stats);
	};
		
	var sleep			= function(callback,time){
		setTimeout(function(){
				callback();
			},time);
	};
		
	//send the quizz result to the server
	var send_result		= function(stats){
		console.log("stat !!!!!!!!!!!!!!!!!!!!!!");
		console.log(stats);
		//the BASE_URL is used to prevent an issue with the handling of the url
		//with Ajax. See http://stackoverflow.com/questions/27420759/codeigniter-base-url-not-working-properly-for-ajax
		var path	= BASE_URL +'ajax/quizz/add_stats';
		var data 	= {'stats' 	: stats};
		
		$(document).ajaxError(function(event, jqxhr, settings, thrownError){
			console.log("-----------======== AJAX error =======-------------");
			console.log(event);
			console.log(jqxhr);
			console.log(settings);
			console.log(thrownError);
			console.log("-----------======== AJAX error =======-------------");
		});
			
		var responseHandler	= function(msg){
			console.log("--- Add stats result(js) : "+msg);
		};
		ajax.ajaxPostRequest(path,data,responseHandler);
	};
		
	//display the next item by giving the dom parent element
	var set_next_item	= function(item){
		self.current_card.set_item(item);
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
			var tmp = self.current_card.get_multiple_answers_list(1,null);
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
		
		
	var set_list_items	= function(new_items){
		if(new_items.length>0){
			items	= new_items;
		}
		else{
			items 	= [];
			console.log('ERR : Setting an empty list of items.');	
		}
		
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
		
	//click function for radio buttons in the option form of the quizz
	var click_radio	= function($parent,element){
		//console.log("Checked value : "+$(element).attr('value'));
		
		if($(element).attr('checked') == undefined){
			var groupName	= $(element).attr('name');
				
			//Old version
			//$('#menu_multiple_answers').find("input[name='"+groupName+"'][checked='checked']").removeAttr('checked');
			$parent.find("input[name='"+groupName+"'][checked='checked']").removeAttr('checked');
			//check the current element
			$(element).attr("checked","checked");
			//console.log("elems trouvés ["+groupName+"]: "+$(element).parent().parent().find("input[name='"+groupName+"'][checked='checked']").size());
			console.log("* radio button : was not checked "+$(element).attr("value"));
		}
		else{
			console.log("* radio button : already checked "+$(element).attr("value"));
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
		,list_loaded				: list_loaded
	//		,BASE_URL					: BASE_URL
		
		//Expose private functions for test purpose
		,load_items					: load_items
		,item_index					: item_index
		,points						: points
		,input_method				: input_method
		,answer_quantity			: answer_quantity
		,response_time				: response_time
		,list_name					: list_name
	};
})();
	