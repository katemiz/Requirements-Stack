<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('endproducts', function (Blueprint $table) {
            $table->id();
            $table->integer('updated_uid');
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Company::class);
            $table->foreignIdFor(Project::class);
            $table->string('code');
            $table->string('title');
            $table->text('description')->nullable();

            $table->boolean('use_parent_phases')->default(true);
            $table->boolean('use_parent_gates')->default(true);
            $table->boolean('use_parent_mocs')->default(true);
            $table->boolean('use_parent_pocs')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endproducts');
    }
};
