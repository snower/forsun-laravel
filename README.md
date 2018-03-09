# forsun-laravel #

[![Software license][ico-license]](LICENSE)
[![Latest stable][ico-version-stable]][link-packagist]
[![Latest development][ico-version-dev]][link-packagist]
[![Monthly installs][ico-downloads-monthly]][link-downloads]

使用高性能的定时调度服务Forsun的Laravel组件。


## Main features ##

* 轻松支持千万级定时任务调度。
* 定时任务触发推送到Queue，轻松支持跨机器和共性能分布式。
* 支持任务到期触发command、Job、Shell和Event。
* 支持驱动原生Laravel Schedule运行。
* 支持创建延时任务和定时到期任务，和原生Laravel Schedule保持相同接口，轻松使用。

## Install ##

* 安装启动forsun服务，详情请看[forsun](https://github.com/snower/forsun)。
* composer安装forsun-laravel。

```
composer require "snower/forsun-laravel"
```

## Config ##

* 在 config/app.php 注册 ServiceProvider 和 Facade

```
'providers' => [
    // ...
    Snower\LaravelForsun\ServiceProvider::class,
],
'aliases' => [
    // ...
    'Forsun' => Snower\LaravelForsun\Facade::class,
],
```

* 创建配置文件

```
php artisan vendor:publish --provider="Snower\LaravelForsun\ServiceProvider"
```

* 修改应用根目录下的 config/forsun.php 中对应的参数即可。

## Used ##

### 定义调度

* Artisan 命令调度。

```

//不指定name是自动生成
Forsun::plan()->command('emails:send --force')->daily();

//指定name
Forsun::plan('email')->command(EmailsCommand::class, ['--force'])->daily();
```

* 队列任务调度

```
Forsun::plan()->job(new Heartbeat)->everyFiveMinutes();
```

* Shell 命令调度

```
Forsun::plan()->exec('node /home/forge/script.js')->daily();
```

* Event事件调度

```
Forsun::plan()->fire('testevent', [])->everyMinute();
```

注意：

* 每个任务只能设置一次调度频率。
* 不支持任务输出、任务钩子及维护模式。
* Forsun::plan是不指定任务名时自动生成，每个任务名必须唯一，相同任务名重复定义将会自动覆盖。

### 移除调度

```
$plan = Forsun::plan()->command('emails:send --force')->daily();
$plan->remove();

$plan = Forsun::plan()->command('emails:send --force')->daily();
$plan_name = $plan->getName();
Forsun::remove($plan_name);
```

### 调度频率设置

| 方法 | 描述 |
| ---------- | --- |
| ->hourly(); | 每小时运行 |
| ->hourlyAt(17); | 每小时的第 17 分钟执行一次任务 |
| ->daily(); | 每天午夜执行一次任务 |
| ->dailyAt('13:00'); | 每天的 13:00 执行一次任务 |
| ->monthly(); | 每月执行一次任务 |
| ->monthlyOn(4, '15:00'); | 在每个月的第四天的 15:00 执行一次任务 |
| ->everyMinute(); | 每分钟执行一次任务 |
| ->everyFiveMinutes(); | 每五分钟执行一次任务 |
| ->everyTenMinutes(); | 每十分钟执行一次任务 |
| ->everyFifteenMinutes(); | 每十五分钟执行一次任务 |
| ->everyThirtyMinutes(); | 每半小时执行一次任务 |
| ->at(strtoetime("2018-03-05 12:32:12")); | 在指定时间2018-03-05 12:32:12运行一次 |
| ->interval(10); | 从当前时间开始计算每10秒运行一次 |
| ->later(5); | 从当前时间开始计算稍后5秒运行一次 |
| ->delay(30); | 从当前时间开始计算稍后30秒运行一次 |

需要复杂定时控制建议生成多个定时任务或是在处理器中再次发起定时任务计划更简便同时也性能更高。

调度器应该尽可能使用Event或是Job通过Queue Work可以更高性能运行。

### 驱动原生Laravel Schedule运行

```
#注册
php artisan forsun:schedule:register

#取消注册
php artisan forsun:schedule:unregister
```

## Author ##

- [snower](mailto:sujian199@gmail.com) ([twitter](http://twitter.com/snower199))


## License ##

The code for Predis is distributed under the terms of the MIT license (see [LICENSE](LICENSE)).

[ico-license]: https://img.shields.io/github/license/snower/forsun-laravel.svg?style=flat-square
[ico-version-stable]: https://img.shields.io/packagist/v/snower/forsun-laravel.svg?style=flat-square
[ico-version-dev]: https://img.shields.io/packagist/vpre/snower/forsun-laravel.svg?style=flat-square
[ico-downloads-monthly]: https://img.shields.io/packagist/dm/snower/forsun-laravel.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/snower/forsun-laravel
[link-downloads]: https://packagist.org/packages/snower/forsun-laravel/stats
