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

# Laravel Metadata

**Manage Metadata. Simply and Flexibly.**

Laravel Metadata simplifies storing dynamic key-value data for your Eloquent models. Stop modifying database schemas for every new field and start managing extensible data with ease. It provides a robust and flexible metadata system that enables you to attach dynamic key-value data to any model through a polymorphic relationship—perfect for storing custom fields, settings, options, and user-defined attributes without modifying your database schema. This is where powerful metadata management meets developer-friendly simplicity—giving you complete control over dynamic data without the complexity.

## Why Laravel Metadata?

### Dynamic Key-Value Storage

Laravel Metadata allows you to store arbitrary key-value pairs for any Eloquent model without modifying the model's table structure. This is perfect for storing custom fields, user preferences, product attributes, and any other extensible data.

### Polymorphic Relationships

The package uses Laravel's polymorphic relationships, allowing a single `metas` table to store metadata for multiple model types. This keeps your database schema clean and maintainable while providing maximum flexibility.

### Key Whitelisting

Control which metadata keys are allowed for each model. Define a whitelist of allowed keys to prevent typos and ensure data integrity, or use `['*']` to allow all keys.

### Automatic JSON Handling

Arrays and objects are automatically JSON-encoded when stored and decoded when retrieved. The package tracks which values are JSON, ensuring proper type handling.

## What is Metadata Management?

Metadata management is the process of storing and retrieving additional information about your models that doesn't fit into the main table structure. Traditional approaches often require:

- Adding columns to tables (inflexible)
- Creating separate tables for each model (redundant)
- Using JSON columns (limited querying)

Laravel Metadata solves these challenges by providing:

- **Polymorphic Storage**: One table for all metadata across all models
- **Dynamic Keys**: Add new metadata keys without schema changes
- **Type Safety**: Automatic JSON encoding/decoding
- **Query Support**: Filter and search by metadata
- **Key Control**: Whitelist allowed keys per model

Consider an e-commerce system where products need different attributes based on their category. With Laravel Metadata, you can store category-specific attributes dynamically, query products by these attributes, and manage them through a simple API. The power of metadata management lies not only in flexible storage but also in making it easy to query, filter, and manage throughout your application.

## What Awaits You?

By adopting Laravel Metadata, you will:

- **Store extensible data** - Add custom fields without schema changes
- **Simplify data management** - One table for metadata across all models
- **Improve flexibility** - Dynamic keys that adapt to your needs
- **Enhance querying** - Filter and search by metadata values
- **Maintain data integrity** - Key whitelisting prevents errors
- **Maintain clean code** - Simple, intuitive API that follows Laravel conventions

## Quick Start

Install Laravel Metadata via Composer:

```bash
composer require jobmetric/laravel-metadata
```

## Documentation

Ready to transform your Laravel applications? Our comprehensive documentation is your gateway to mastering Laravel Metadata:

**[📚 Read Full Documentation →](https://jobmetric.github.io/packages/laravel-metadata/)**

The documentation includes:

- **Getting Started** - Quick introduction and installation guide
- **HasMeta** - Core trait for adding metadata functionality to models
- **HasFilterMeta** - Dynamic filtering capabilities based on metadata
- **HasDynamicMeta** - Integration with custom field systems
- **Resources** - API response transformation
- **Events** - Hook into metadata lifecycle
- **Real-World Examples** - See how it works in practice

## Contributing

Thank you for participating in `laravel-metadata`. A contribution guide can be found [here](CONTRIBUTING.md).

## License

The `laravel-metadata` is open-sourced software licensed under the MIT license. See [License File](LICENCE.md) for more information.
