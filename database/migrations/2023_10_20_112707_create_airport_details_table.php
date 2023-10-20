<?php

use Modules\V1\Languages\Enums\LanguageEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('airport_details', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('airport_id');
            $table->foreign('airport_id')
                ->references('id')
                ->on('airports')
                ->cascadeOnDelete();

            $table->enum('language', LanguageEnum::list());
            $table->string('name', 60);
            $table->longText('description');
            $table->longText('terms_and_conditions')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airport_details');
    }
};
