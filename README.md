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
    'default-template' => 'breadcrumb::template',
    'ignore-undefined-breadcrumb' => false
];
```

## Base Usage

1. Create the breadcrumb file in the **"breadcrumb-file-path"**.

2. Define breadcrumbs in the breadcrumb file.

    Without parameters:

    ```php
    // Home
    Breadcrumb::define('home', function ($breadcrumb) {
        $breadcrumb->add('Home', action('HomeController@index'));
    });
    ```
    With a parameter:

    ```php
    // Home > $category->title
    Breadcrumb::define('category', function ($breadcrumb, $category) {
        $breadcrumb->add('Home', action('HomeController@index'));
        $breadcrumb->add($category->title, $category->url);
    });
    ```
    With parameters:

    ```php
    // Home > $category['title'] > $content->title
    Breadcrumb::define('content', function ($breadcrumb, $category, $content) {
        $breadcrumb->add('Home', action('HomeController@index'));
        $breadcrumb->add($category['title'], $category['id']);
        $breadcrumb->add($content->title, $content->url);
    });
    ```

3. Render breadcrumbs.

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

1. The breadcrumb use the special template.

    ```php
    {!! Breadcrumbs::setTemplate('template2')->render('home') !!}
    ```