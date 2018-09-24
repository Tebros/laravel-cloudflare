# Cloudflare Trusted Proxy Service Provider for Laravel
The package is developed to provide Cloudflare trust proxies support for Laravel Framework requests.
List of IP ranges used by Cloudflare can be found here: (https://www.cloudflare.com/ips/).

## Installation
I. Install composer package using command:
```
composer install tebros/laravel-cloudflare
```
II. Run artisan command to load fresh IPs from Cloudflare:
```
php artisan cloudflare:reload
```

## Available commands
This package will not load Cloudflare IPs automatically. To do this you can use two registered commands:
* `cloudflare:reload` - this command loads list of current Cloudflare Proxy IPs and store in application cache forever,
* `cloudflare:view` - this command show list of loaded IPs from Cloudflare.

## Automatic reloading
If you want automatic refreshing of Cloudflare IP ranges you can schedule `cloudflare:reload` command in your app. To do this open `app/Console/Kernel.php` and modify `schedule` function like this:
```php
/**
 * Define the application's command schedule.
 *
 * @param \Illuminate\Console\Scheduling\Schedule $schedule
 * @return void
 */
protected function schedule(Schedule $schedule)
{
    $schedule->command('cloudflare:reload')
        ->daily();
}
```




