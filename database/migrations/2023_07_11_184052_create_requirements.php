<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Company;
use App\Models\Endproduct;
use App\Models\User;
use App\Models\Project;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->id();
            $table->integer('updated_uid');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Company::class);
            $table->foreignIdFor(Project::class);
            $table->foreignIdFor(Endproduct::class)->nullable();
            $table->integer('requirement_no');
            $table->integer('revision')->default(1);
            $table->string('cross_ref_no')->nullable();
            $table->string('rtype');
            $table->string('source')->nullable();
            $table->text('text');
            $table->text('remarks')->nullable();
            $table->string('status')->default('Verbatim');
            $table->timestamps();
        });
    }






    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requirements');
    }
};
