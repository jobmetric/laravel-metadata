<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * Creates a polymorphic metadata table that allows dynamic key-value
     * storage for any Eloquent model. Useful for extensible data systems
     * such as settings, options, custom fields, or user-defined attributes.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config('metadata.tables.meta'), function (Blueprint $table) {
            $table->id();

            $table->morphs('metaable');
            /**
             * Polymorphic relation columns:
             * Stores the target model's class name and ID.
             * Example: metaable_type = 'App\Models\Post', metaable_id = 5
             */

            $table->string('key')->index();
            /**
             * Metadata key (indexed for performance).
             * Example: 'seo_title', 'custom_color', etc.
             */

            $table->text('value')->nullable();
            /**
             * Metadata value.
             * Accepts any arbitrary data (usually stringified).
             * May contain plain text, JSON, serialized data, etc.
             */

            $table->boolean('is_json')->default(false);
            /**
             * Indicates whether the value field contains a JSON-encoded array/object.
             * Helps with casting and proper decoding at runtime.
             */

            $table->timestamps();

            $table->index([
                'metaable_type',
                'metaable_id',
                'key'
            ], 'METAABLE_KEY_INDEX');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Drops the metadata table if it exists.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('metadata.tables.meta'));
    }
};
