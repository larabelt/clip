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