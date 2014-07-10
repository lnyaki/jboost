	var quizz_module	= require('quizz_module');
	var PORT			= 8080;
	var Server 			= new quizz_module.Quizz_Server();
	
	//initialize server
	Server.initialize_server(PORT);
	console.log("ok dans le prog");
	
	Server.create_lobby("Lobby 1");
	Server.create_lobby("Lobby 2");
	
	//handle events
	Server.events_handling();
	