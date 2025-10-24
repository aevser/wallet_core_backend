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
        // Типы транзакции
        Schema::create('transaction_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('transaction_types')->insert([
            [
                'name' => 'deposit',
                'type' => 'deposit',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'withdraw',
                'type' => 'withdraw',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'transfer_in',
                'type' => 'transfer_in',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'transfer_out',
                'type' => 'transfer_out',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Транзакции
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('related_user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('type_id')->constrained('transaction_types')->cascadeOnDelete();
            $table->decimal('amount')->default(0);
            $table->text('comment')->nullable();
            $table->timestamps();

            // Индексация
            $table->index(['user_id', 'related_user_id', 'type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_types');
        Schema::dropIfExists('transactions');
    }
};
