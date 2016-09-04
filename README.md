# Laravel-Breadcrumb

A simple breadcrumbs generator.

## Installation

    composer require yasiao/laravel-breadcrumb

## Configuration

### config/app.php

providers:

```php
Yasiao\Breadcrumb\BreadcrumbServiceProvider::class
```
aliases:

```php
'Breadcrumb' => Yasiao\Breadcrumb\BreadcrumbFacade::class
```

### config/breadcrumb.php

    php artisan vendor:publish

```php
return [
    'breadcrumb-file-path' => app_path('Http/breadcrumb.php'),
    'default-template' => 'breadcrumb::template'
];
```

## Base Usage

### Create the breadcrumb file in breadcrumb-file-path.

### Register breadcrumbs

in breadcrumb-file-path

Without parameters:

```php
// Home
Breadcrumb::register('home', function ($breadcrumb, $category, $content) {
    $breadcrumb->push('Home', action('HomeController@index'));
});
```
With a parameter:

```php
// Home > $category->title
Breadcrumb::register('category', function ($breadcrumb, $content) {
    $breadcrumb->push('Home', action('HomeController@index'));
    $breadcrumb->push($category->title, $category->url);
});
```
With parameters:

```php
// Home > $category['title'] > $content->title
Breadcrumb::register('content', function ($breadcrumb, $category, $content) {
    $breadcrumb->push('Home', action('HomeController@index'));
    $breadcrumb->push($category['title'], $category['id']);
    $breadcrumb->push($content->title, $content->url);
});
```

### Render the breadcrumbs

Without parameters:

```php
{!! Breadcrumbs::render('home') !!}
```
With a parameter:

```php
{!! Breadcrumbs::render('home', $category) !!}
```
With parameters:

```php
{!! Breadcrumbs::render('home', $category, $content) !!}
```

## Advanced Usage

### The breadcrumb use special template.

```php
{!! Breadcrumbs::setTemplate('template2')->render('home') !!}
```