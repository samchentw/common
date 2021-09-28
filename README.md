# Common
1.repository pattern  
2.quickly make repository,service and helper  
3.simple dictionary type
## Installation
`composer require samchentw/common`

## Laravel
After updating composer, add the ServiceProvider to the providers array in config/app.php
```sh
Samchentw\Common\CommonServiceProvider::class
```

Publish the config file by running: 
```sh
$ php artisan vendor:publish --provider="Samchentw\Common\CommonServiceProvider"
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
## Use Enable
In the migration. use ( $table->setEnable();)

```php
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->softDeletes();
            $table->setEnable();
            $table->timestamps();
        });
    }
```

In the model.
```php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Samchentw\Common\Traits\Supports\HasEnable;

    class Article extends Model
    {
        use HasFactory,
            SoftDeletes,
            HasEnable;
```


## Use Sort
In the migration. use ( $table->setSort();)

```php
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->softDeletes();
            $table->setSort();
            $table->timestamps();
        });
    }
```

In the model.
```php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Samchentw\Common\Traits\Supports\HasSort;

    class Article extends Model
    {
        use HasFactory,
            SoftDeletes,
            HasSort;

```

You can set the sorting method in the config/common.php


## Use Sort Or Enable in Controller

For example, make ArticleRepository,

```sh
$ php artisan make:repository ArticleRepository
```

```php
    namespace App\Repositories;

    use Samchentw\Common\Repositories\Base\Repository;
    use App\Models\Article;

    class ArticleRepository extends Repository
    {

        /**
         * @return string
         */
        public function model(): string
        {
            return Article::class;
        }

    }
```

In Controller

```php
    class ArticleController extends Controller
    {

        private $articleRepository;
        public function __construct(ArticleRepository $ArticleRepository)
        {
            $this->articleRepository = $ArticleRepository;
        }

        //for Front
        public function example1()
        {
            // get enable true data And sorted
            return $this->articleRepository->getAllForFront(); 
        }

        //for Front
        public function example2()
        {
            $query = $this->articleRepository->getAllForFrontQuery();
            // get enable true data And sorted
            return $query->where('title','=','test')->get(); 
        }
        
        //for Admin
        public function example3()
        {
            // get sorted data
            return $this->articleRepository->getAllForAdmin(); 
        }

        //for Admin
        public function example4()
        {
            $query = $this->articleRepository->getAllForAdminQuery();
            //  get sorted data
            return $query->where('title','=','test')->get(); 
        }
```
