## Installation

```
# install assets & migrate
php artisan belt-storage:publish
composer dumpautoload

# create additional faker images for file seeds
php artisan belt-storage:faker

# migrate & seed
php artisan migrate
php artisan db:seed --class=BeltStorageSeeder

# compile assets
gulp
```