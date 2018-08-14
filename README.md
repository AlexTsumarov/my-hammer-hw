[![Build Status](https://travis-ci.org/AlexTsumarov/my-hammer-hw.svg?branch=master)](https://travis-ci.org/AlexTsumarov/my-hammer-hw)
# How to setup:
1. composer install
2. update files:
   - `.env.orig` to `.env` having updated db credentials: DATABASE_URL (live), TEST_DATABASE_URL (test)
   - rename `phpunit.xml.orig` to `phpunit.xml`
3. prepare db schema: 
   - php bin/console doctrine:database:create --no-interaction
   - php bin/console doctrine:migrations:migrate --no-interaction
   - php bin/console doctrine:fixtures:load --no-interaction
4. prepare functional test db schema:
   - php bin/console doctrine:database:create --env=test --no-interaction
   - php bin/console doctrine:migrations:migrate --env=test --no-interaction
   - php bin/console doctrine:fixtures:load --env=test --no-interaction
5. run functional tests:
   - vendor/bin/phpunit
6. run service:
   - php -S localhost:8000 -t public
7. use API:
   - in browser: start chrome http://localhost:8000/api/
   - by app: using formats described in config/packages/api_platform.yaml


# Not implemented:
1. Add code static analysis tools: php[cs|md|cpd] (Estimation - 2 hrs)
2. After any php code be added - create unit tests and add code coverage (Estimation for coverage - 1 hr)
3. Fix configuration to use default phpunit.xml.dist (Estimation - 1 hr)
4. Attach ELK (Estimation - 3 hrs)
