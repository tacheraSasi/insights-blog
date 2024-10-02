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
        // First, ensure that the categories table exists before creating the foreign key constraint.
        if (!Schema::hasTable('categories')) {
            throw new \Exception("Categories table must be created before Insights");
        }

        Schema::create('insights', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');  // Store the main content
            $table->string('slug')->unique(); // SEO-friendly URL
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // The author
            $table->string('banner_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insights');
    }
};
