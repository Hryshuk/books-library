start:
	@echo "\033[94mBuilding your docker containers\033[0m";
	docker-compose up --build -d
	@echo "\033[32mTo open the browser run : make openBrowser . This will open your application in http://localhost/\033[0m";

up:
	@echo "\033[94mBuilding your docker containers\033[0m";
	docker-compose up --build -d
	@echo "\033[32mTo open the browser run : make openBrowser . This will open your application in http://localhost/\033[0m";

stop:
	@echo "\033[94mShutting down you docker containers\033[0m";
	docker-compose down
	@echo "\033[32mShutting docker containers complete. To confirm run docker ps\033[0m";

down:
	@echo "\033[94mShutting down you docker containers\033[0m";
	docker-compose down
	@echo "\033[32mShutting docker containers complete. To confirm run docker ps\033[0m";
