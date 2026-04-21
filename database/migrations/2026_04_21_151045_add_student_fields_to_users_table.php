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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('set null');
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusan')->onDelete('set null');
            $table->foreignId('tahun_ajaran_id')->nullable()->constrained('tahun_ajaran')->onDelete('set null');
            $table->string('photo_profile')->nullable();
            $table->string('nisn')->nullable()->unique();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['jurusan_id']);
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropColumn([
                'kelas_id',
                'jurusan_id',
                'tahun_ajaran_id',
                'photo_profile',
                'nisn',
                'address',
                'phone',
                'birth_date',
                'gender',
            ]);
        });
    }
};
