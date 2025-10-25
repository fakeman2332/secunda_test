<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('company_phone', function (Blueprint $table) {
            $table->foreignUuid('company_id')->constrained('companies');
            $table->foreignUuid('phone_id')->constrained('phones');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_phone');
    }
};
