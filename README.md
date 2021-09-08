# Common
1.repository pattern  
2.quickly make repository,service and helper  
3.simple dictionary type
## Installation
`composer require samchentw/common`

## Laravel
After updating composer, add the ServiceProvider to the providers array in config/app.php
```sh
Samchentw\Common\CommonProvider::class
```

## Feature
Samchentw\Common\Repositories\Base\Repository  
Samchentw\Common\Helpers\DictionaryHelper  
Samchentw\Common\Traits\HasEnable  
Samchentw\Common\Traits\HasSort  

## Generate repository
```sh
$ php artisan make:repository MyRepository
```
## Generate service
```sh
$ php artisan make:service MyService
```
## Generate helper
```sh
$ php artisan make:helper MyHelper
```
