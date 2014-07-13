	var PORT			= 8080;
	var quizz_module	= require('quizz_module');
	quizz_module.Lobby	= require('Lobby').Lobby;
	quizz_module.Game	= require('Game').Game;
	
	//quizz_module.lobby = Lobby.Lobby;
	console.log(quizz_module);
	//console.log(Lobby);
	var Server 			= new quizz_module.Quizz_Server();	
	var Lobby1 			= new quizz_module.Lobby("Lobby 1");
	var Lobby2			= new quizz_module.Lobby("Lobby 2");
	
	
	//initialize server
	Server.initialize_server(PORT);
	console.log("ok dans le prog");
	
	Server.create_lobby(Lobby1);
	Server.create_lobby(Lobby2);
	
	//handle events
	Server.events_handling();
	