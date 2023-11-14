<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Requirement;
use App\Models\Test;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requirement_test', function (Blueprint $table) {
            $table->unsignedBigInteger('requirement_id');
            $table->unsignedBigInteger('test_id');
            $table->foreign('requirement_id')->references('id')->on('requirements')->onDelete('cascade');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirement_test');
    }
};
