## About Laravel luxscpace

Laravel luxspace

## Instalation
1. composer install
2. make new .env file and copy all content from .enx.example paste to .env
3. php artisan key:generate
4. php artisan storage:link
5. php artisan migrate

## setup db for testing
1. php artisan migrate --env=testing (look in the .env.testing file)

## run test
1. php artisan test --env=testing (for all test case)
2. php artisan test --filter _nametes_ --env=testing (for spesific test case)
