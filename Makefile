.PHONY: help
.DEFAULT_GOAL := help

## Show help
help:
	@echo ""
	@echo "###############################"
	@echo "##    Advent Of Code 2024    ##"
	@echo "###############################"
	@echo ""
	@echo "Commands:"
	@awk '/^[a-zA-Z\-\_0-9]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")-1); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf "  %-20s %s\n", helpCommand, helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)
	@echo ""

## Install needed dependencies
install:
	composer install

## Run the tests
test:
	vendor/bin/phpunit