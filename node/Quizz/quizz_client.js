
var Quizz_Client = function(){
	
	var Lobby = function(){};
	var Quizz = function(){};
	
	
	/************************************************************************
	 *                    Lobby
	 *************************************************************************/
	Lobby.prototype = (function(){
		var constructor = Lobby;
		
		//Connect to a given lobby
		var enter_lobby		= function(lobby_ref, user_ref){
			
		};
		
		var leave_lobby		= function(lobby_ref, user_ref){
			
		};
		
		var join_game		= function(lobby_ref,game_ref,user_ref){
			
		};
		
		var create_game		= function(lobby_ref,user_ref,options){
			
		};
		
		return {
			enter_lobby		: enter_lobby
			,leave_lobby 	: leave_lobby
			,join_game 		: join_game
			,create_game	: create_game
		};
		
	})();
	
	
	/************************************************************************
	 *                    QUIZZ
	 *************************************************************************/
	Quizz.prototype = (function(){
		var constructor = Quizz;
		
		var connect 	= function(){
			
		};
		
		var disconnect	= function(){
			
		};
		
		var send_answer	= function(){
			
		};
		
		return{
			connect			: connect
			,disconnect 	: disconnect	
			,send_answer	: send_answer
		};
		
	})();
	
	
	return {
		Lobby	: Lobby
		,Quizz	: Quizz	
	};
}();
