<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('mobile')->unique()->nullable();
            $table->string('img')->nullable();
            $table->string('password');
            $table->string('code_verified', 10)->nullable();
			$table->dateTime('expire_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum("job",["farm","merchant","source"]);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
