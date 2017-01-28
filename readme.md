## Installation

```
# install assets & migrate
php artisan ohio-storage:publish
composer dumpautoload

# create additional faker images for file seeds
php artisan ohio-storage:faker

# migrate & seed
php artisan migrate
php artisan db:seed --class=OhioStorageSeeder

# compile assets
gulp
```

## Misc

```
# unit testing
phpunit -c ../storage/tests --bootstrap=bootstrap/app.php

phpunit --coverage-html=public/tests/ohio/storage/base   -c vendor/ohiocms/storage/tests/base   --bootstrap=bootstrap/autoload.php
phpunit --coverage-html=public/tests/ohio/storage/file    -c vendor/ohiocms/storage/tests/file    --bootstrap=bootstrap/autoload.php
```