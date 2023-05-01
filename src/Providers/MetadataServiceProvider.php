<?php

namespace JobMetric\Metadata\Providers;

use Illuminate\Support\ServiceProvider;
use JobMetric\Metadata\MetadataService;

class MetadataServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('MetadataService', function ($app) {
            return new MetadataService($app);
        });
    }

    /**
     * boot provider
     *
     * @return void
     */
    public function boot(): void
    {
        // set translations
        $this->loadTranslationsFrom(realpath(__DIR__.'/../../lang'), 'metadata');

        // publish migration
        if (!$this->migrationMetaExists()) {
            $this->publishes([
                realpath(__DIR__.'/../../database/migrations/create_metas_table.php.stub') => database_path('migrations/'.date('Y_m_d_His', time()).'_create_metas_table.php')
            ], 'migrations');
        }
    }

    /**
     * check migration meta table
     *
     * @return bool
     */
    private function migrationMetaExists(): bool
    {
        $path = database_path('migrations/');
        $files = scandir($path);

        foreach ($files as &$value) {
            $position = strpos($value, 'create_metas_table');
            if ($position !== false) {
                return true;
            }
        }

        return false;
    }
}
