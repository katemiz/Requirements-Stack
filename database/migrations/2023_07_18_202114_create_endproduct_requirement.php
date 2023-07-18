<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Requirement;
use App\Models\EndProduct;



return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('endproduct_requirement', function (Blueprint $table) {
            $table->foreignIdFor(Requirement::class);
            $table->foreignIdFor(EndProduct::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endproduct_requirement');
    }
};
