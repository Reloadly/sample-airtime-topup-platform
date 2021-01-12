
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
	$(info $(pink)Make ($(os)): Installing Reloadly Sample Topup Project...)
	$(info $(pink)------------------------------------------------------$(reset))
	@docker-compose build
	@docker-compose up -d
	@docker exec -it rstp_php cp .env.example .env
	@docker exec -it rstp_php composer install -vvv
	@docker exec -it rstp_php php artisan migrate
	@docker exec -it rstp_php php artisan db:seed
	@docker exec -it rstp_php php artisan passport:install
	@docker exec -it rstp_php php artisan sync:countries
	@docker-compose down
	@make -s start
update:
	$(info $(pink)------------------------------------------------------)
	$(info $(pink)Make ($(os)): Updating Reloadly Sample Topup Project...)
	$(info $(pink)------------------------------------------------------$(reset))
	@docker-compose down
	@docker-compose build
	@docker-compose up -d
	@docker-compose down
	@make -s start
start:
	$(info $(pink) Make ($(os)): Starting Reloadly Sample Topup Project.)
	@chmod -R 0777 storage
	@docker-compose up -d
	@docker exec -it rstp_php service cron start
	@docker exec -it rstp_php chmod -R 0777 storage
stop:
	$(info $(pink) Make ($(os)): Stopping Reloadly Sample Topup Project.)
	@docker-compose down
restart:
	$(info $(pink)Make ($(os)): Restarting Reloadly Sample Topup Project.)
	@make -s stop
	@make -s start
console:
	$(info $(pink)Make ($(os)): Starting Console for Reloadly Sample Topup Project.)
	@docker exec -it rstp_php /bin/bash
