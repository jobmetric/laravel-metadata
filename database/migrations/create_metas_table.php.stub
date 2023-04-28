<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('metas', function (Blueprint $table) {
            $table->id();

            $table->morphs('metaable');
            /**
             * metaable for any tables for any data
             */

            $table->string('key')->index();
            $table->text('value')->nullable();

            $table->boolean('is_json')->default(false);
            /**
             * If the array was in the value field -> is_json = true
             */

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('metas');
    }
};
