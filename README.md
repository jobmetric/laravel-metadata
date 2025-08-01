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

# Metadata for Laravel

This package is designed to manage metadata in Laravel projects.

## Install via Composer

```bash
composer require jobmetric/laravel-metadata
```

## Documentation

This package offers a robust and flexible metadata system for Laravel Eloquent models, enabling you to attach dynamic key-value data through a `morphMany` relationship. It supports full control over metadata keys, validation, events, and batch operations.

### Migrate database

Before using the package, run:

```bash
php artisan migrate
```

## How to use

### Attach Trait to Model

Add the `HasMeta` trait to your model:

```php
use JobMetric\Metadata\HasMeta;

class User extends Model
{
    use HasMeta;
}
```

### Optional: Limit Allowed Metadata Keys

To restrict metadata keys, define a `protected array $metadata = [...]` in your model:

```php
class User extends Model
{
    use HasMeta;

    protected array $metadata = [
        'first_name',
        'last_name',
        'bio',
        'birthday',
    ];
}
```

If omitted or set as `['*']`, all keys are allowed.

## API Usage

### Store metadata

```php
$user = User::find(1);
$user->storeMetadata('phone', '1234567890');
```

### Store multiple metadata

```php
$user->storeMetadataBatch([
    'phone' => '1234567890',
    'address' => '123 Main St',
]);
```

### Retrieve a metadata value

```php
$phone = $user->getMetadata('phone');
```

### Retrieve all metadata

```php
$allMetadata = $user->getMetadata();
```

### Check if metadata exists

```php
$hasPhone = $user->hasMetadata('phone');
```

### Delete specific metadata

```php
$user->forgetMetadata('phone');
```

### Delete all metadata

```php
$user->forgetMetadata();
```

### Allow additional metadata keys at runtime

```php
$user->mergeMeta(['nickname', 'website']);
```

### Remove allowed metadata key

```php
$user->removeMetaKey('bio');
```

## Events

This package includes events for metadata operations:

| Event                   | Description                |
|-------------------------|----------------------------|
| `MetadataStoringEvent`  | Before metadata is stored  |
| `MetadataStoredEvent`   | After metadata is stored   |
| `MetadataDeletingEvent` | Before metadata is deleted |
| `MetadataDeletedEvent`  | After metadata is deleted  |

You may listen to these events to customize your logic.

## Advanced Notes

- If you define `$metadata` in the model, it overrides the default `['*']`.
- During model `saving`, metadata is validated against allowed keys.
- You can interact with the `metas()` relationship directly for advanced queries.
- All metadata values that are arrays are stored as JSON in the DB.

## Contributing

Thank you for considering contributing to Laravel Metadata! See the [CONTRIBUTING.md](https://github.com/jobmetric/laravel-metadata/blob/master/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). See the [License File](https://github.com/jobmetric/laravel-metadata/blob/master/LICENCE.md) for details.
