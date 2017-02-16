## Installation

```
# install assets & migrate
php artisan belt-clip:publish
composer dumpautoload

# create additional faker images for file seeds
php artisan belt-clip:faker

# migrate & seed
php artisan migrate
php artisan db:seed --class=BeltClipSeeder

# compile assets
gulp
```