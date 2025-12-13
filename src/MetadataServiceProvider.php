<?php

namespace JobMetric\Metadata;

use Illuminate\Contracts\Container\BindingResolutionException;
use JobMetric\EventSystem\Support\EventRegistry;
use JobMetric\PackageCore\Exceptions\MigrationFolderNotFoundException;
use JobMetric\PackageCore\PackageCore;
use JobMetric\PackageCore\PackageCoreServiceProvider;

class MetadataServiceProvider extends PackageCoreServiceProvider
{
    /**
     * @throws MigrationFolderNotFoundException
     */
    public function configuration(PackageCore $package): void
    {
        $package->name('laravel-metadata')
            ->hasConfig()
            ->hasTranslation()
            ->hasMigration();
    }

    /**
     * after boot package
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function afterBootPackage(): void
    {
        // Register events if EventRegistry is available
        // This ensures EventRegistry is available if EventSystemServiceProvider is loaded
        if ($this->app->bound('EventRegistry')) {
            /** @var EventRegistry $registry */
            $registry = $this->app->make('EventRegistry');

            // Metadata Events
            $registry->register(\JobMetric\Metadata\Events\MetadataStoredEvent::class);
            $registry->register(\JobMetric\Metadata\Events\MetadataStoringEvent::class);
            $registry->register(\JobMetric\Metadata\Events\MetadataDeletedEvent::class);
            $registry->register(\JobMetric\Metadata\Events\MetadataDeletingEvent::class);
        }
    }
}
