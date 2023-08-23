# Metadata for laravel

This package is for the metadata of different Laravel projects.

## Install via composer

Run the following command to pull in the latest version:
```bash
composer require jobmetric/metadata
```

### Add service provider

Add the service provider to the providers array in the config/app.php config file as follows:

```php
'providers' => [

    ...

    JobMetric\Metadata\MetadataServiceProvider::class,
]
```

### Publish Migrations

You need to publish the migration to create the `metas` table:

```php
php artisan vendor:publish --provider="JobMetric\Metadata\MetadataServiceProvider" --tag="metadata-migrations"
```

After that, you need to run migrations.

```php
php artisan migrate
```

## Documentation
