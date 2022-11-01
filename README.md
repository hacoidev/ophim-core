# Server Requirements:
- Laravel Framework 8.
- PHP 7.3 or higher.
- MySQL 5.7 or higher.
# Add-on & Themes:
- Add-on:
    - [OPhim Crawler](https://github.com/hacoidev/ophim-crawler)
- Theme:
    - [Ripple](https://github.com/hacoidev/ophim-ripple)
    - [September](https://github.com/phantom0803/ophim-september)

# Installation:
1. CD to project root and run: `composer require hacoidev/ophim-core`
2. Then, run command: `php artisan ophim:install`
3. Change app\Models\User:
```php
use Ophim\Core\Models\User as OphimUser;

class User extends OphimUser {
    use HasApiTokens, HasFactory, Notifiable;
    // ...
}
```
4. Create new user by command: `php artisan ophim:user`

5. Remove this route definition in routes/web.php
```php
Route::get('/', function () {
    return view('welcome');
});
```
6. Run `php artisan optimize:clear`

# Note
 - Configure a production environment `.env`
    + `APP_ENV=production`
    + `APP_URL=https://your-domain.com`
    
# Reset view counter:
- Setup crontab, add this entry:
```
* * * * * /path/to/project/php artisan schedule:run
```
