## Installation

Add the ServiceProvider to the providers array in config/app.php

```php
Belt\Clip\BeltClipServiceProvider::class,
```

```
# publish
php artisan belt-clip:publish
composer dumpautoload

# migration
php artisan migrate

# seed
php artisan db:seed --class=BeltClipSeeder

# compile assets
npm run
```