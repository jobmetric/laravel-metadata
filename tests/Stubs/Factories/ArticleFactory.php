<?php

namespace JobMetric\Metadata\Tests\Stubs\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JobMetric\Metadata\Tests\Stubs\Models\Article;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']),
            'metadata' => [],
        ];
    }

    /**
     * set title
     *
     * @param string $title
     *
     * @return static
     */
    public function setTitle(string $title): static
    {
        return $this->state(fn(array $attributes) => [
            'title' => $title,
        ]);
    }

    /**
     * set status
     *
     * @param string $status
     *
     * @return static
     */
    public function setStatus(string $status): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => $status,
        ]);
    }

    /**
     * set metadata
     *
     * @param array $metadata
     *
     * @return static
     */
    public function setMetadata(array $metadata): static
    {
        return $this->state(fn(array $attributes) => [
            'metadata' => $metadata,
        ]);
    }
}
