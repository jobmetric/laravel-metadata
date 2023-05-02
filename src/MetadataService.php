<?php

namespace JobMetric\Metadata;

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\Macroable;
use JobMetric\Metadata\Exceptions\MetadataKeyNotFoundException;

class MetadataService
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
     * @param Model       $model
     * @param string|null $key
     *
     * @return mixed
     * @throws MetadataKeyNotFoundException
     */
    public function get(Model $model, string|null $key = null): mixed
    {
        // @todo config cache
        // @todo exist has trait metaable -> class_uses

        if(is_null($key)) {
            $data = collect();

            /**
             * @var Builder $builder
             */
            $builder = $model->metaable();
            foreach($builder->get() as $item) {
                if($item->is_json) {
                    $data->add(json_decode($item->value));
                } else {
                    $data->add($item->value);
                }
            }

            return $data;
        }

        $object = $model->metaableKey($key)->first();
        if($object) {
            if($object->is_json) {
                return json_decode($object->value);
            } else {
                return $object->value;
            }
        }

        throw new MetadataKeyNotFoundException($key);
    }

    /**
     * store metadata
     *
     * @param Model             $model
     * @param string            $key
     * @param string|array|null $value
     *
     * @return Model
     */
    public function store(Model $model, string $key, string|array|null $value = null): Model
    {
        $params['key'] = $key;

        if(is_array($value)) {
            $params['value'] = json_encode($value, JSON_UNESCAPED_UNICODE);
            $params['is_json'] = true;
        } else {
            $params['value'] = $value;
            $params['is_json'] = false;
        }

        $model->metadata()->create($params);

        return $model;
    }

    /**
     * delete metadata
     *
     * @param Model       $model
     * @param string|null $key
     *
     * @return void
     */
    public function delete(Model $model, string|null $key = null): void
    {
        $builder = $model->metaable();

        if(!is_null($key)) {
            $builder->metaableKey($key);
        }

        $builder->get()->each(function (Builder $item) {
            $item->delete();
        });
    }
}
