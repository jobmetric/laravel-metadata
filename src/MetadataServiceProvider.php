<?php

namespace JobMetric\Metadata;

use Illuminate\Support\Facades\Blade;
use JobMetric\Metadata\View\Components\MetadataItems;
use JobMetric\PackageCore\Exceptions\MigrationFolderNotFoundException;
use JobMetric\PackageCore\Exceptions\ViewFolderNotFoundException;
use JobMetric\PackageCore\PackageCore;
use JobMetric\PackageCore\PackageCoreServiceProvider;

class MetadataServiceProvider extends PackageCoreServiceProvider
{
    /**
     * @throws MigrationFolderNotFoundException
     * @throws ViewFolderNotFoundException
     */
    public function configuration(PackageCore $package): void
    {
        $package->name('laravel-metadata')
            ->hasConfig()
            ->hasView()
            ->hasTranslation()
            ->hasMigration();
    }

    /**
     * After Boot Package
     *
     * @return void
     */
    public function afterBootPackage(): void
    {
        // add alias for components
        Blade::component(MetadataItems::class, 'metadata-items');
    }
}
