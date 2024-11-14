<?php

namespace JobMetric\Metadata;

use Illuminate\Support\Facades\Blade;
use JobMetric\Metadata\View\Components\MetadataCard;
use JobMetric\PackageCore\Exceptions\AssetFolderNotFoundException;
use JobMetric\PackageCore\Exceptions\MigrationFolderNotFoundException;
use JobMetric\PackageCore\Exceptions\ViewFolderNotFoundException;
use JobMetric\PackageCore\PackageCore;
use JobMetric\PackageCore\PackageCoreServiceProvider;

class MetadataServiceProvider extends PackageCoreServiceProvider
{
    /**
     * @throws MigrationFolderNotFoundException
     * @throws ViewFolderNotFoundException
     * @throws AssetFolderNotFoundException
     */
    public function configuration(PackageCore $package): void
    {
        $package->name('laravel-metadata')
            ->hasConfig()
            ->hasView()
            ->hasAsset()
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
        Blade::component(MetadataCard::class, 'metadata-card');
    }
}
