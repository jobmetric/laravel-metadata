<?php

namespace JobMetric\Metadata;

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\Macroable;
use JobMetric\Metadata\Exceptions\MetadataKeyNotFoundException;
use JobMetric\Metadata\Exceptions\ModelMetaableKeyNotAllowedFieldException;
use JobMetric\Metadata\Exceptions\ModelMetaableTraitNotFoundException;
use Throwable;

class Metadata
{
    use Macroable;

    /**
     * The application instance.
     *
     * @var Application
     */
    protected Application $app;

    /**
     * The cache instance.
     *
     * @var CacheManager
     */
    protected CacheManager $cacheManager;

    /**
     * Create a new Metadata instance.
     *
     * @param Application $app
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->cacheManager = $app->make('cache');
    }

    /**
     * get metadata
     *
     * @param Model $model
     * @param string|null $key
     *
     * @return mixed
     * @throws Throwable
     */
    public function get(Model $model, string|null $key = null): mixed
    {
        // @todo config cache
        if (!in_array('JobMetric\Metadata\HasMeta', class_uses($model))) {
            throw new ModelMetaableTraitNotFoundException($model::class);
        }

        if (is_null($key)) {
            $data = collect();

            /**
             * @var Builder $builder
             */
            $builder = $model->metaable();
            foreach ($builder->get() as $item) {
                if ($item->is_json) {
                    $data->add(json_decode($item->value, true));
                } else {
                    $data->add($item->value);
                }
            }

            return $data;
        }

        $allowedFields = $model->metadataAllowFields();
        if (!(in_array('*', $allowedFields) || in_array($key, $allowedFields))) {
            throw new ModelMetaableKeyNotAllowedFieldException($model::class, $key);
        }

        $object = $model->metaableKey($key)->first();
        if ($object) {
            if ($object->is_json) {
                return json_decode($object->value, true);
            } else {
                return $object->value;
            }
        }

        throw new MetadataKeyNotFoundException($key);
    }

    /**
     * store metadata
     *
     * @param Model $model
     * @param string $key
     * @param string|array|null $value
     *
     * @return Model
     * @throws Throwable
     */
    public function store(Model $model, string $key, string|array|null $value = null): Model
    {
        if (!in_array('JobMetric\Metadata\HasMeta', class_uses($model))) {
            throw new ModelMetaableTraitNotFoundException($model::class);
        }

        $allowedFields = $model->metadataAllowFields();
        if (!(in_array('*', $allowedFields) || in_array($key, $allowedFields))) {
            throw new ModelMetaableKeyNotAllowedFieldException($model::class, $key);
        }

        $params = [
            'value' => $value,
            'is_json' => false
        ];

        if (is_array($value)) {
            $params = [
                'value' => json_encode($value, JSON_UNESCAPED_UNICODE),
                'is_json' => true
            ];
        }

        $model->metaable()->firstOrCreate([
            'key' => $key
        ], $params);

        return $model;
    }

    /**
     * delete metadata
     *
     * @param Model $model
     * @param string|null $key
     *
     * @return void
     * @throws Throwable
     */
    public function delete(Model $model, string|null $key = null): void
    {
        if (!in_array('JobMetric\Metadata\HasMeta', class_uses($model))) {
            throw new ModelMetaableTraitNotFoundException($model::class);
        }

        $builder = $model->metaable();

        if (!is_null($key)) {
            $allowedFields = $model->metadataAllowFields();
            if (!(in_array('*', $allowedFields) || in_array($key, $allowedFields))) {
                throw new ModelMetaableKeyNotAllowedFieldException($model::class, $key);
            }

            $builder->metaableKey($key);
        }

        $builder->get()->each(function ($item) {
            $item->delete();
        });
    }
}
