# Laravel Translatable BootForms

[![Build Status](https://travis-ci.org/Propaganistas/Laravel-Translatable-Bootforms.svg?branch=master)](https://travis-ci.org/Propaganistas/Laravel-Translatable-Bootforms)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Propaganistas/Laravel-Translatable-BootForms/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Propaganistas/Laravel-Translatable-BootForms/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/Propaganistas/Laravel-Translatable-Bootforms/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Propaganistas/Laravel-Translatable-Bootforms/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/propaganistas/laravel-translatable-bootforms/v/stable)](https://packagist.org/packages/propaganistas/laravel-translatable-bootforms)
[![Total Downloads](https://poser.pugx.org/propaganistas/laravel-translatable-bootforms/downloads)](https://packagist.org/packages/propaganistas/laravel-translatable-bootforms)
[![License](https://poser.pugx.org/propaganistas/laravel-translatable-bootforms/license)](https://packagist.org/packages/propaganistas/laravel-translatable-bootforms)

Make [BootForms](https://github.com/adamwathan/bootforms) work flawlessly with [Laravel Translatable](https://github.com/astrotomic/laravel-translatable)!

By importing this package, generating translatable forms using BootForms is a breeze.

### Installation

1. Run the Composer require command to install the package

    ```bash
    composer require fienta/laravel-translatable-bootforms
    ```

2. In your app config, add the Service Provider in the `$providers` array **after** `BootFormsServiceProvider` and `TranslatableServiceProvider`

    ```php
    'providers' => [
        Galahad\BootForms\BootFormsServiceProvider::class,
        Astrotomic\Translatable\TranslatableServiceProvider::class,
        ...
        TypiCMS\LaravelTranslatableBootForms\TranslatableBootFormsServiceProvider::class,
    ],
    ```
3. In your app config, add the Facade to the `$aliases` array

    ```php
    'aliases' => [
        ...
        'TranslatableBootForm' => Propaganistas\LaravelTranslatableBootForms\Facades\TranslatableBootForm::class,
    ],
    ```

4. Publish the configuration file

    ```bash
    php artisan vendor:publish --provider="TypiCMS\LaravelTranslatableBootForms\TranslatableBootFormsServiceProvider" --tag="config"
    ```

### Usage

Simply use the `TranslatableBootForm` Facade as if it were `BootForm`! That's it. Multiple form inputs will now be generated for the locales set in Translatable's configuration file. They will have the corresponding value for each language and will save all of the translations without any code manipulation.

Please review [BootForms' documentation](https://github.com/adamwathan/bootforms#using-bootforms) if you're unsure how to use it.

Example:

```php
// View
{!! BootForm::text('Name', 'name')
            ->placeholder('My placeholder') !!}

// Output
<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" placeholder="My Placeholder" />
</div>

// Controller
public function postEdit($request)
{
    $someModel->save($request->all());
}
```

```php
// View
{!! TranslatableBootForm::text('Name', 'name')
                        ->placeholder('My placeholder') !!}

// Output
<div class="form-group form-group-translation">
    <label for="en[name]">Name (en)</label>
    <input type="text" name="en[name]" class="form-control" placeholder="My Placeholder" data-language="en" />
</div>
<div class="form-group form-group-translation">
    <label for="nl[name]">Name (nl)</label>
    <input type="text" name="nl[name]" class="form-control" placeholder="My Placeholder" data-language="nl" />
</div>

// Controller
public function postEdit($request)
{
    $someModel->save($request->all());
}
```

You can use the `%name` and `%locale` placeholders while specifying parameters. The placeholder will be replaced with the corresponding input name or locale.
This can be useful for two-way data binding libraries such as Angular.js or Vue.js. E.g.
```php
{!! TranslatableBootForm::text('Title', 'title')
                        ->attribute('some-attribute', 'Name: %name')
                        ->attribute('another-attribute', 'Locale: %locale') !!}

// Output
<div class="form-group form-group-translation">
    <label for="en[title]">Title (en)</label>
    <input type="text" name="en[title]" class="form-control" some-attribute="Name: en[title]" another-attribute="Locale: en" data-language="en" />
</div>
<div class="form-group form-group-translation">
    <label for="nl[title]">Title (nl)</label>
    <input type="text" name="nl[title]" class="form-control" some-attribute="Name: nl[title]" another-attribute="Locale: nl" data-language="nl" />
</div>
```

To render a *form element only for some chosen locales*, explicitly call `renderLocale()` as the final method and pass the locale or an array of locales as the first parameter:
```php
TranslatableBootForm::text('Name','name')
                    ->renderLocale('en')
```

If you need to apply a *method only for certain locales*, suffix the method with `ForLocale` and pass the locale or an array of locales as the first parameter:

```php
TranslatableBootForm::text('Name','name')
                    ->dataForLocale('en', 'attributeName', 'attributeValue')
                    ->addClassForLocale(['en', 'nl'], 'addedClass')
```

In case you need to construct name attributes other than `en[name]`, e.g. `item.en.name`, manually insert the `%locale` placeholder in your name attribute. Note that model binding will **break** for these inputs.

```php
TranslatableBootForm::text('Name','item.%locale.name')

// Output
<div class="form-group form-group-translation">
    <label for="item.en.name">Name (en)</label>
    <input type="text" name="item.en.name" class="form-control" data-language="en" />
</div>
```

For customizing the locale indicator in the label (and several other settings), please take a look at the configuration file.
