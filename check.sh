#!/bin/bash
./vendor/bin/phpunit ./tests
./vendor/bin/phpcs --standard=psr2 ./src
./vendor/bin/phpmd ./src/ text ./vendor/phpmd/phpmd/src/main/resources/rulesets/cleancode.xml