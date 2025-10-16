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
        Schema::table('tarefas', function (Blueprint $table) {
            $table->date('data_vencimento')->nullable()->after('descricao');
            $table->enum('prioridade', ['baixa', 'media', 'alta'])->default('media')->after('data_vencimento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tarefas', function (Blueprint $table) {
            $table->dropColumn(['data_vencimento', 'prioridade']);
        });
    }
};
