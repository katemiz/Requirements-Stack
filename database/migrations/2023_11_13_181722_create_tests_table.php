<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Company;
use App\Models\Counter;
use App\Models\Endproduct;
use App\Models\Requirement;
use App\Models\Project;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->integer('updated_uid');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Company::class);
            $table->foreignIdFor(Project::class);
            $table->foreignIdFor(Endproduct::class)->nullable();
            $table->integer('test_no');
            $table->text('title');
            $table->integer('revision')->default(1);
            $table->boolean('is_latest')->default(true);
            $table->string('test_type')->nullable();
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
        Schema::dropIfExists('tests');
    }
};
