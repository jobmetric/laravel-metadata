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

### Metaable trait

To make the above process easier, you can add the Metaable trait to the User class, which you can do as follows.

```php
use JobMetric\Metadata\Traits\Metaable;

class User extends Model
{
    use Metaable;
}
```

#### How does this trait work?

### setMeta

To set metadata, you can use the following code.

```php
$user = User::find(1);

$user->setMeta([
    'phone',
    'address'
]);
```

### getMeta

To get metadata, you can use the following code.

```php
$user = User::find(1);

$metadata = $user->getMeta();
```

> You can do this manually, this code is used when you want to write dynamic code.

### Store metadata

To store metadata, you can use the following code.

```php
$user = User::find(1);

$user->storeMetadata('phone', '1234567890');
```

### Forget metadata

To forget metadata, you can use the following code.

```php
$user = User::find(1);

$user->forgetMetadata('phone');
```

### Forget all metadata

To forget all metadata, you can use the following code.

```php
$user = User::find(1);

$user->forgetMetadata();
```

### Get metadata

To get metadata, you can use the following code.

```php
$user = User::find(1);

$metadata = $user->getMetadata('phone');
```

### Get all metadata

To get all metadata, you can use the following code.

```php
$user = User::find(1);

$metadata = $user->getMetadata();
```

### Has metadata

To check if metadata exists, you can use the following code.

```php
$user = User::find(1);

$checkMetadata = $user->hasMetadata('phone');
```

## Events

This package contains several events for which you can write a listener as follows

| Event                 | Description                                                                 |
|-----------------------|-----------------------------------------------------------------------------|
| `MetadataStoredEvent` | This event is called after storing the metadata.                            |
| `MetadataForgetEvent` | This event is called after forgetting the metadata.                         |

## Contributing

Thank you for considering contributing to the Laravel Metadata! The contribution guide can be found in the [CONTRIBUTING.md](https://github.com/jobmetric/laravel-metadata/blob/master/CONTRIBUTING.md).

## License

The MIT License (MIT). Please see [License File](https://github.com/jobmetric/laravel-metadata/blob/master/LICENCE.md) for more information.
