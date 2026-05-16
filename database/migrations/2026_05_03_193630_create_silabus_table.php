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
        Schema::create('silabus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->text('tujuan_pembelajaran');
            $table->enum('kategori', ['formatif', 'sumatif']);
            $table->enum('status', ['pending', 'aktif', 'non_aktif', 'reject'])->default('pending');
            $table->enum('approval_status', ['draft', 'pending_approval', 'approved', 'rejected'])->default('draft');

            // Approval tracking
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();

            // Ordering and metadata
            $table->integer('urutan')->default(0);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();

            // Indexes for performance
            $table->index(['mata_pelajaran_id', 'status', 'approval_status']);
            $table->index(['created_by']);
            $table->index(['approved_by']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('silabus');
    }
};
