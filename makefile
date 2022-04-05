include .env
pink:=$(shell tput setaf 200)
blue:=$(shell tput setaf 27)
green:=$(shell tput setaf 118)
violet:=$(shell tput setaf 057)
reset:=$(shell tput sgr0)


ifeq ($(shell uname),Darwin)
  os=darwin
else
  os=linux
endif

install:
	$(info $(pink)------------------------------------------------------)
	$(info $(pink)Make ($(os)): Installing $(APP_NAME)...)
	$(info $(pink)------------------------------------------------------$(reset))
	@docker-compose build
	@docker-compose up -d
	@docker-compose down
	@make -s start
update:
	$(info $(pink)------------------------------------------------------)
	$(info $(pink)Make ($(os)): Updating $(APP_NAME)...)
	$(info $(pink)------------------------------------------------------$(reset))
	@docker-compose down
	@docker-compose build
	@docker-compose up -d
	@docker-compose down
	@make -s start
start:
	$(info $(pink) Make ($(os)): Starting $(APP_NAME).)
	@docker-compose up -d
	@docker exec -it $(DOCKER_PROJECT_CODE)_php service cron start
stop:
	$(info $(pink) Make ($(os)): Stopping $(APP_NAME).)
	@docker-compose down
restart:
	$(info $(pink)Make ($(os)): Restarting $(APP_NAME).)
	@make -s stop
	@make -s start
console:
	$(info $(pink)Make ($(os)): Starting Console for $(APP_NAME).)
	@docker exec -it $(DOCKER_PROJECT_CODE)_php /bin/bash
