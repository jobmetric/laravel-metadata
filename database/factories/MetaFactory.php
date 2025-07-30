<?php

namespace JobMetric\Metadata\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JobMetric\Metadata\Models\Meta;

/**
 * @extends Factory<Meta>
 */
class MetaFactory extends Factory
{
    protected $model = Meta::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'metaable_type' => null,
            'metaable_id' => null,
            'key' => $this->faker->word,
            'value' => $this->faker->word,
            'is_json' => false
        ];
    }

    /**
     * set metaable
     *
     * @param string $metaable_type
     * @param int $metaable_id
     *
     * @return static
     */
    public function setMetaable(string $metaable_type, int $metaable_id): static
    {
        return $this->state(fn(array $attributes) => [
            'metaable_type' => $metaable_type,
            'metaable_id' => $metaable_id,
        ]);
    }

    /**
     * set key
     *
     * @param string $key
     *
     * @return static
     */
    public function setKey(string $key): static
    {
        return $this->state(fn(array $attributes) => [
            'key' => $key
        ]);
    }

    /**
     * set value
     *
     * @param string|array|bool|null $value
     *
     * @return static
     */
    public function setValue(string|array|bool|null $value): static
    {
        $is_json = false;

        if (is_array($value)) {
            $value = json_encode($value);
            $is_json = true;
        }

        return $this->state(fn(array $attributes) => [
            'value' => $value,
            'is_json' => $is_json
        ]);
    }
}
