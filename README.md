# Lumen 5 Log Viewer

[![Badge](https://img.shields.io/badge/link-996.icu-%23FF4D5B.svg)](https://996.icu/#/zh_CN)
[![Build Status](https://www.travis-ci.org/maxsky/lumen-log-viewer.svg?branch=master)](https://www.travis-ci.org/maxsky/lumen-log-viewer)
[![codecov](https://codecov.io/gh/maxsky/lumen-log-viewer/branch/master/graph/badge.svg)](https://codecov.io/gh/maxsky/lumen-log-viewer)
[![Author](https://img.shields.io/badge/author-@rap2h-blue.svg)](https://twitter.com/rap2h)

## What is this?

Small log viewer for lumen. Looks like this:

![capture d ecran 2014-12-01 a 10 37 18](https://cloud.githubusercontent.com/assets/1575946/5243642/8a00b83a-7946-11e4-8bad-5c705f328bcc.png)

## Install

Install via composer
```
composer require maxsky/lumen-log-viewer
```

Add Service Provider to `app/Providers/AppServiceProvider.php`
```php
$this->app->register(\LumenLogViewer\Providers\LumenLogViewerServiceProvider::class);
```

Add a route in your web routes file, like this:
```php 
/** @var Laravel\Lumen\Routing\Router $router */
$router->group(['namespace' => '\LumenLogViewer\Controllers'], function () use ($router) {
    $router->get('logs', 'LogViewerController@index');
});
```

Go to `http://yourapp/logs` or some other route

**Optionally** copy `vendor/maxsky/lumen-log-viewer/views/logviewer.blade.php` into `/resources/views/vendor/lumen-log-viewer/` for view customization:

