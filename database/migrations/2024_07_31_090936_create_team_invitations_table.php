<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('team_invitations', static function (Blueprint $table): void {
            $table->ulid('id')->primary();

            $table->string('email');
            $table->string('role')->nullable();

            $table
                ->foreignUlid('team_id')
                ->index()
                ->constrained('teams')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['team_id', 'email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_invitations');
    }
};
