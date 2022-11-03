# Server Requirements:
- Laravel Framework 8.
- PHP 7.3 or higher.
    + Configure `php.ini`:
    ```
    max_input_vars=100000
    ```
- MySQL 5.7 or higher.
# Add-on & Themes:
- Home: [OPhimCMS.Com](https://ophimcms.com)
- Free Movies Data: [OPhim1.CC](https://ophim1.cc)

- Add-on:
    - [OPhim Crawler](https://github.com/hacoidev/ophim-crawler)
- Theme:
    - [XIAO (New)](https://github.com/phantom0803/ophim-theme-xiao)
    - [PMC (New)](https://github.com/phantom0803/ophim-theme-pmc)
    - [HHTQ (New)](https://github.com/phantom0803/ophim-theme-hhtq)
    - [PNO (New)](https://github.com/phantom0803/ophim-theme-pno)
    - [IPC (New)](https://github.com/phantom0803/ophim-theme-ipc)
    - [PCC (New)](https://github.com/phantom0803/ophim-theme-pcc)
    - [F365 (New)](https://github.com/phantom0803/ophim-theme-f365)
    - [LEGEND (New)](https://github.com/phantom0803/ophim-theme-legend)
    - [BCCO (New)](https://github.com/phantom0803/ophim-theme-bcco)
    - [BPTV (New)](https://github.com/phantom0803/ophim-theme-bptv)
    - [Ripple](https://github.com/hacoidev/ophim-ripple)
    - [September](https://github.com/phantom0803/ophim-september)

# Installation:
1. CD to project root and run: `composer require hacoidev/ophim-core -W`
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

# Update:
1. CD to project root and run: `composer update hacoidev/ophim-core -W`
2. Then, run command: `php artisan ophim:install`
3. Run `php artisan optimize:clear`

# Note
- Configure a production environment file `.env`
    + `APP_ENV=production`
    + `APP_URL=https://your-domain.com`
- Configure timezone `/config/app.php`
    + `'timezone' => 'Asia/Ho_Chi_Minh'`
    
# Reset view counter:
- Setup crontab, add this entry:
```
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```
