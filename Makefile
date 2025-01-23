csDir = src/
csRuleset = cs-ruleset.xml
csIgnorePath = **/temp/**,**/log/**

cs:
	vendor/bin/phpcs $(csDir) --standard=$(csRuleset) --ignore=$(csIgnorePath)

cs-fix:
	vendor/bin/phpcbf $(csDir) --standard=$(csRuleset) --ignore=$(csIgnorePath)

phpstan:
	vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=1G --no-progress

phpstan-baseline:
	vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=1G --generate-baseline phpstan-baseline.neon

unit:
	vendor/bin/phpunit -c phpunit.xml
