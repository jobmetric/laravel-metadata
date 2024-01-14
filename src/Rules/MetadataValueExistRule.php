<?php

namespace JobMetric\Metadata\Rules;

use JobMetric\Metadata\Models\Meta;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class MetadataValueExistRule implements Rule
{
    private string $class_name;
    private string $key;

    public function __construct(string $class_name, string $key)
    {
        $this->class_name = $class_name;
        $this->key = $key;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return !Meta::query()->whereHasMorph('metaable', $this->class_name, function (Builder $query) use ($value) {
            $query->where([
                'key' => $this->key,
                'value' => $value
            ]);
        })->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('metadata::base.rule.exist', ['field' => $this->key]);
    }
}
