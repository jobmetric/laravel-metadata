[contributors-shield]: https://img.shields.io/github/contributors/jobmetric/laravel-metadata.svg?style=for-the-badge
[contributors-url]: https://github.com/jobmetric/laravel-metadata/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/jobmetric/laravel-metadata.svg?style=for-the-badge&label=Fork
[forks-url]: https://github.com/jobmetric/laravel-metadata/network/members
[stars-shield]: https://img.shields.io/github/stars/jobmetric/laravel-metadata.svg?style=for-the-badge
[stars-url]: https://github.com/jobmetric/laravel-metadata/stargazers
[license-shield]: https://img.shields.io/github/license/jobmetric/laravel-metadata.svg?style=for-the-badge
[license-url]: https://github.com/jobmetric/laravel-metadata/blob/master/LICENCE.md
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-blue.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/majidmohammadian

[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]

# Metadata for laravel

This package is for the metadata of different Laravel projects.

## Install via composer

Run the following command to pull in the latest version:
```bash
composer require jobmetric/laravel-metadata
```

## Documentation

Undergoing continuous enhancements, this package evolves each day, integrating an array of diverse features. It stands as an indispensable asset for enthusiasts of Laravel, offering a seamless way to harmonize their projects with metadata database models.

In this package, you can employ it seamlessly with any model requiring database metadata.

Now, let's delve into the core functionality.

>#### Before doing anything, you must migrate after installing the package by composer.

```bash
php artisan migrate
```

Meet the `HasMeta` class, meticulously designed for integration into your model. This class automates essential tasks, ensuring a streamlined process for:

In the first step, you need to connect this class to your main model.

```php
use JobMetric\Translation\HasMeta;

class User extends Model
{
    use HasMeta;
}
```

When you add this class, you will have to implement `MetaContract` to your model.

```php
use JobMetric\Metadata\Contracts\MetaContract;

class User extends Model implements MetaContract
{
    use HasMeta;
}
```

Now you have to use the metadataAllowFields function, and you have to add it to your model.

```php
use JobMetric\Translation\Contracts\MetaContract;

class User extends Model implements MetaContract
{
    use HasMeta;

    public function metaAllowFields(): array
    {
        return [
            'first_name',
            'last_name',
            'bio',
            'birthday',
        ];
    }
}
```

> This function is for you to declare what translation fields you need for this model, and you should return them here as an `array`.

## How is it used?
