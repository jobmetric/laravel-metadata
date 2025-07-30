<?php

namespace JobMetric\Metadata\Tests\Feature;

use JobMetric\Metadata\Exceptions\ModelMetaableKeyNotAllowedFieldException;
use JobMetric\Metadata\Tests\Stubs\Models\Article;
use JobMetric\Metadata\Tests\TestCase as BaseTestCase;
use Throwable;

class HasMetadataTest extends BaseTestCase
{
    /**
     * @throws Throwable
     */
    public function testStore(): void
    {
        $article = Article::factory()->create();

        $article->setMeta([
            'phone',
            'address',
        ]);

        $this->assertEquals([
            'phone',
            'address',
        ], $article->getMeta());

        $article->storeMetadata('phone', '1234567890');

        $this->assertDatabaseHas('metas', [
            'metaable_id' => $article->id,
            'metaable_type' => Article::class,
            'key' => 'phone',
            'value' => '1234567890',
        ]);

        $article->storeMetadata('address', '123 Main St');

        $this->assertDatabaseHas('metas', [
            'metaable_id' => $article->id,
            'metaable_type' => Article::class,
            'key' => 'address',
            'value' => '123 Main St',
        ]);

        try {
            $article->storeMetadata('phone_number', '0987654321');
        } catch (Throwable $e) {
            $this->assertInstanceOf(ModelMetaableKeyNotAllowedFieldException::class, $e);
        }
    }

    /**
     * @throws Throwable
     */
    public function testForget(): void
    {
        $article = Article::factory()->create();

        $article->setMeta([
            'phone',
            'address',
        ]);

        $article->storeMetadata('phone', '1234567890');
        $article->storeMetadata('address', '123 Main St');

        $article->forgetMetadata('phone');

        $this->assertDatabaseMissing('metas', [
            'metaable_id' => $article->id,
            'metaable_type' => Article::class,
            'key' => 'phone',
            'value' => '1234567890',
        ]);

        $this->assertDatabaseHas('metas', [
            'metaable_id' => $article->id,
            'metaable_type' => Article::class,
            'key' => 'address',
            'value' => '123 Main St',
        ]);
    }

    /**
     * @throws Throwable
     */
    public function testForgetAll(): void
    {
        $article = Article::factory()->create();

        $article->setMeta([
            'phone',
            'address',
        ]);

        $article->storeMetadata('phone', '1234567890');
        $article->storeMetadata('address', '123 Main St');

        $article->forgetMetadata();

        $this->assertDatabaseMissing('metas', [
            'metaable_id' => $article->id,
            'metaable_type' => Article::class,
            'key' => 'phone',
            'value' => '1234567890',
        ]);

        $this->assertDatabaseMissing('metas', [
            'metaable_id' => $article->id,
            'metaable_type' => Article::class,
            'key' => 'address',
            'value' => '123 Main St',
        ]);
    }

    /**
     * @throws Throwable
     */
    public function testGet(): void
    {
        $article = Article::factory()->create();

        $article->setMeta([
            'phone',
            'address',
        ]);

        $article->storeMetadata('phone', '1234567890');
        $article->storeMetadata('address', '123 Main St');

        $this->assertEquals('1234567890', $article->getMetadata('phone'));
        $this->assertEquals('123 Main St', $article->getMetadata('address'));
    }

    /**
     * @throws Throwable
     */
    public function testGetAll(): void
    {
        $article = Article::factory()->create();

        $article->setMeta([
            'phone',
            'address',
        ]);

        $article->storeMetadata('phone', '1234567890');
        $article->storeMetadata('address', '123 Main St');




        $data = collect();

        $data->add([
            'address' => '123 Main St',
        ]);

        $data->add([
            'phone' => '1234567890',
        ]);

        $this->assertEquals($data, $article->getMetadata());
    }
}
