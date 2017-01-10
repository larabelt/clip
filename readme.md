## Installation

```
# install assets & migrate
php artisan ohio-storage:publish
composer dumpautoload

# migrate & seed
php artisan migrate
php artisan db:seed --class=OhioStorageSeeder

# compile assets
gulp
```

## Misc

```
# unit testing
phpunit --coverage-html=public/tests/ohio/storage/base   -c vendor/ohiocms/storage/tests/base   --bootstrap=bootstrap/autoload.php
phpunit --coverage-html=public/tests/ohio/storage/file    -c vendor/ohiocms/storage/tests/file    --bootstrap=bootstrap/autoload.php
```