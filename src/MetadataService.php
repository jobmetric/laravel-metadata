<?php

namespace JobMetric\Metadata;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class MetadataService
{
    /**
     * get metadata
     *
     * @param Model $model
     * @param string|null $key
     *
     * @return Collection|Model|null
     */
    public function get(Model $model, string|null $key = null): Collection|Model|null
    {
        /**
         * @var Builder $builder
         */
        $builder = $model->metaable();

        if(is_null($key)) {
            return $builder->get();
        } else {
            return $builder->metaableKey($key)->first();
        }
    }

    /**
     * store metadata
     *
     * @param Model $model
     * @param string $key
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
     * @param Model $model
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
