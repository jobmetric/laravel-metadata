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
    public function test_store_autosaving(): void
    {
        // Create an article with metadata
        $article = Article::factory()->setMetadata([
            'phone' => '1234567890',
            'address' => '123 Main St',
        ])->create();

        $this->assertDatabaseHas('metas', [
            'metaable_type' => Article::class,
            'metaable_id' => $article->id,
            'key' => 'phone',
            'value' => '1234567890',
        ]);

        $this->assertDatabaseHas('metas', [
            'metaable_type' => Article::class,
            'metaable_id' => $article->id,
            'key' => 'address',
            'value' => '123 Main St',
        ]);

        // Update the article's metadata
        $article->metadata = [
            'phone' => '0987654321',
            'address' => '456 Elm St',
        ];
        $article->save();

        $this->assertDatabaseHas('metas', [
            'metaable_type' => Article::class,
            'metaable_id' => $article->id,
            'key' => 'phone',
            'value' => '0987654321',
        ]);
        $this->assertDatabaseHas('metas', [
            'metaable_type' => Article::class,
            'metaable_id' => $article->id,
            'key' => 'address',
            'value' => '456 Elm St',
        ]);

        // Delete the article
        $article->delete();

        $this->assertDatabaseMissing('metas', [
            'metaable_type' => Article::class,
            'metaable_id' => $article->id,
            'key' => 'phone',
            'value' => '0987654321',
        ]);

        $this->assertDatabaseMissing('metas', [
            'metaable_type' => Article::class,
            'metaable_id' => $article->id,
            'key' => 'address',
            'value' => '456 Elm St',
        ]);
    }

    /**
     * @throws Throwable
     */
    public function test_meta_key(): void
    {
        $article = Article::factory()->setMetadata([
            'phone' => '1234567890',
            'address' => '123 Main St',
        ])->create();

        $this->assertEquals('1234567890', $article->metaKey('phone')->first()->value);
        $this->assertEquals('123 Main St', $article->metaKey('address')->first()->value);
    }

    /**
     * @throws Throwable
     */
    public function test_has_metadata(): void
    {
        $article = Article::factory()->setMetadata([
            'phone' => '1234567890',
            'address' => '123 Main St',
        ])->create();

        $this->assertTrue($article->hasMetadata('phone'));
        $this->assertTrue($article->hasMetadata('address'));
        $this->assertFalse($article->hasMetadata('email'));
    }

    /**
     * @throws Throwable
     */
    public function test_get_metadata(): void
    {
        $article = Article::factory()->setMetadata([
            'phone' => '1234567890',
            'address' => '123 Main St',
        ])->create();

        // Check if metadata is correctly retrieved
        $this->assertEquals('1234567890', $article->getMetadata('phone'));
        $this->assertEquals('123 Main St', $article->getMetadata('address'));

        // Check if non-existing metadata returns null
        try {
            $this->assertNull($article->getMetadata('email'));
        } catch (ModelMetaableKeyNotAllowedFieldException $e) {
            $this->assertInstanceOf(ModelMetaableKeyNotAllowedFieldException::class, $e);
        }

        // Check if all metadata is correctly retrieved
        $this->assertEquals(collect([
            'phone' => '1234567890',
            'address' => '123 Main St',
        ]), $article->getMetadata());
    }

    /**
     * @throws Throwable
     */
    public function test_store_metadata(): void
    {
        $article = Article::factory()->create();

        $article->mergeMeta([
            'phone',
            'address',
        ]);

        $this->assertEquals([
            'phone',
            'address',
        ], $article->getMetaKeys());

        $article->storeMetadata('phone', '1234567890');

        $this->assertDatabaseHas('metas', [
            'metaable_type' => Article::class,
            'metaable_id' => $article->id,
            'key' => 'phone',
            'value' => '1234567890',
        ]);

        $article->storeMetadata('address', '123 Main St');

        $this->assertDatabaseHas('metas', [
            'metaable_type' => Article::class,
            'metaable_id' => $article->id,
            'key' => 'address',
            'value' => '123 Main St',
        ]);

        // Test storing invalid metadata key
        try {
            $article->storeMetadata('phone_number', '0987654321');
        } catch (Throwable $e) {
            $this->assertInstanceOf(ModelMetaableKeyNotAllowedFieldException::class, $e);
        }
    }

    /**
     * @throws Throwable
     */
    public function test_store_metadata_batch(): void
    {
        $article = Article::factory()->create();

        $article->storeMetadataBatch([
            'phone' => '1234567890',
            'address' => '123 Main St',
        ]);

        $this->assertDatabaseHas('metas', [
            'metaable_type' => Article::class,
            'metaable_id' => $article->id,
            'key' => 'phone',
            'value' => '1234567890',
        ]);

        $this->assertDatabaseHas('metas', [
            'metaable_type' => Article::class,
            'metaable_id' => $article->id,
            'key' => 'address',
            'value' => '123 Main St',
        ]);

        $article->mergeMeta([
            'phone',
            'address',
        ]);

        // Test storing invalid metadata key in batch
        try {
            $article->storeMetadataBatch([
                'phone_number' => '0987654321',
            ]);
        } catch (Throwable $e) {
            $this->assertInstanceOf(ModelMetaableKeyNotAllowedFieldException::class, $e);
        }
    }

    /**
     * @throws Throwable
     */
    public function test_forget_metadata(): void
    {
        $article = Article::factory()->setMetadata([
            'phone' => '1234567890',
            'address' => '123 Main St',
        ])->create();

        $article->forgetMetadata('phone');

        $this->assertDatabaseMissing('metas', [
            'metaable_type' => Article::class,
            'metaable_id' => $article->id,
            'key' => 'phone',
            'value' => '1234567890',
        ]);

        $this->assertDatabaseHas('metas', [
            'metaable_type' => Article::class,
            'metaable_id' => $article->id,
            'key' => 'address',
            'value' => '123 Main St',
        ]);
    }

    /**
     * @throws Throwable
     */
    public function test_forget_all(): void
    {
        $article = Article::factory()->setMetadata([
            'phone' => '1234567890',
            'address' => '123 Main St',
        ])->create();

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
}
