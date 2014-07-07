
var Quizz_Server = function(){
	var Quizz_server = function(){};
	
	
	
	Quizz_server.prototype = function(){
		var constructor = Quizz_server;
	
		var initialize_server 		= function(){
			
		};
	
	//when a user enters a lobby
		var player_enters_lobby 	= function(lobby_ref,user_ref){
			
		};
		
		var player_leaves_lobby		= function(lobby_ref, user_ref){
			
		};
		
		var player_creates_quizz	= function(lobby_ref, user_ref, option){
			
		};
		
		var player_joins_quizz		= function(lobby_ref, quizz_ref,user_ref){
			
		};
		
		var player_leaves_quizz 	= function(lobby_ref, quizz_ref,user_ref){
			
		};
		
		return{
			player_enters_lobby 	: player_enters_lobby
			,player_leaves_lobby	: player_leaves_lobby
			,player_creates_quizz 	: player_creates_quizz
			,player_joins_quizz 	: player_joins_quizz
			,player_leaves_quizz	: player_leaves_quizz
		};
	};
}();
