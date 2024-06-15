<?php

namespace JobMetric\Metadata\Tests;

use App\Models\User;
use JobMetric\Metadata\Exceptions\ModelMetaableKeyNotAllowedFieldException;
use Tests\BaseDatabaseTestCase as BaseTestCase;
use Throwable;

class MetadataTest extends BaseTestCase
{
    /**
     * @throws Throwable
     */
    public function testStore(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $user->setMeta([
            'phone',
            'address',
        ]);

        $this->assertEquals([
            'phone',
            'address',
        ], $user->getMeta());

        $user->storeMetadata('phone', '1234567890');

        $this->assertDatabaseHas('metas', [
            'metaable_id' => $user->id,
            'metaable_type' => User::class,
            'key' => 'phone',
            'value' => '1234567890',
        ]);

        $user->storeMetadata('address', '123 Main St');

        $this->assertDatabaseHas('metas', [
            'metaable_id' => $user->id,
            'metaable_type' => User::class,
            'key' => 'address',
            'value' => '123 Main St',
        ]);

        try {
            $user->storeMetadata('phone_number', '0987654321');
        } catch (Throwable $e) {
            $this->assertInstanceOf(ModelMetaableKeyNotAllowedFieldException::class, $e);
        }
    }

    /**
     * @throws Throwable
     */
    public function testForget(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $user->setMeta([
            'phone',
            'address',
        ]);

        $user->storeMetadata('phone', '1234567890');
        $user->storeMetadata('address', '123 Main St');

        $user->forgetMetadata('phone');

        $this->assertDatabaseMissing('metas', [
            'metaable_id' => $user->id,
            'metaable_type' => User::class,
            'key' => 'phone',
            'value' => '1234567890',
        ]);

        $this->assertDatabaseHas('metas', [
            'metaable_id' => $user->id,
            'metaable_type' => User::class,
            'key' => 'address',
            'value' => '123 Main St',
        ]);
    }

    /**
     * @throws Throwable
     */
    public function testForgetAll(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $user->setMeta([
            'phone',
            'address',
        ]);

        $user->storeMetadata('phone', '1234567890');
        $user->storeMetadata('address', '123 Main St');

        $user->forgetMetadata();

        $this->assertDatabaseMissing('metas', [
            'metaable_id' => $user->id,
            'metaable_type' => User::class,
            'key' => 'phone',
            'value' => '1234567890',
        ]);

        $this->assertDatabaseMissing('metas', [
            'metaable_id' => $user->id,
            'metaable_type' => User::class,
            'key' => 'address',
            'value' => '123 Main St',
        ]);
    }

    /**
     * @throws Throwable
     */
    public function testGet(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $user->setMeta([
            'phone',
            'address',
        ]);

        $user->storeMetadata('phone', '1234567890');
        $user->storeMetadata('address', '123 Main St');

        $this->assertEquals('1234567890', $user->getMetadata('phone'));
        $this->assertEquals('123 Main St', $user->getMetadata('address'));
    }

    /**
     * @throws Throwable
     */
    public function testGetAll(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $user->setMeta([
            'phone',
            'address',
        ]);

        $user->storeMetadata('phone', '1234567890');
        $user->storeMetadata('address', '123 Main St');

        $data = collect();

        $data->add([
            'phone' => '1234567890',
        ]);

        $data->add([
            'address' => '123 Main St',
        ]);

        $this->assertEquals($data, $user->getMetadata());
    }
}
