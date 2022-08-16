# OPHIM CORE
## Server Requirements:
- Laravel Framework 8x
- PHP 7.3 or higher.
- MySQL 5.7 or higher.

## Installation:
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

7. Run `php artisan storage:link`

## Run auto update: 
1. Add `movie:update` command to app\Console\Kernel.php
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('movie:update')->everyMinute();
}
```
2. Setup crontab, add this entry: 
```
* * * * * /path/to/project/php artisan schedule:run
```
