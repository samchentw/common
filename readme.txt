一、套件建立教學： https://medium.com/back-ends/laravel-5-%E6%92%B0%E5%AF%AB%E4%BD%A0%E7%9A%84package-458c93c279bc

二、引用套件方法：

1.先複製packages，然後在composer.json的autoload psr-4 加入以下文字：
        "Samchentw\\Settings\\": "packages/samchen/settings/src",
        "Samchentw\\Common\\": "packages/samchen/common/src",
        "Samchentw\\Permission\\": "packages/samchen/permission/src"
  
  在cmd執行=> composer dump-autoload

2.到config/app.php檔下 providers變數加入下列Provider：
        // 基本
        Samchentw\Common\Providers\CommonProvider::class, 
        // setting套件
        Samchentw\Settings\Providers\SettingProvider::class, 
        Samchentw\Settings\Providers\SettingEventServiceProvider::class,
        // 角色、權限套件  
        Samchentw\Permission\Providers\PermissionProvider::class,
        Samchentw\Permission\Providers\PermissionAuthServiceProvider::class,

3.在cmd執行
   加入setting指令： php artisan vendor:publish --provider="Samchentw\Settings\Providers\SettingProvider"
   加入permisssion指令： php artisan vendor:publish --provider="Samchentw\Permission\Providers\PermissionProvider"

4.在App\Models\User 引用HasRoles，如下範例：
        
        use Samchentw\Permission\Traits\Supports\HasRoles;
        class User extends Authenticatable
        {
                use HasApiTokens;
                use HasFactory;
                use HasProfilePhoto;
                use Notifiable;
                use TwoFactorAuthenticatable;
                use HasRoles;
