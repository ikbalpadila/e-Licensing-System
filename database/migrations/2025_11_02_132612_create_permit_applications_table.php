<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('permit_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('permit_type_id')->constrained('permit_types')->onDelete('cascade');
            $table->string('application_number')->unique();
            $table->string('status')->default('draft'); // draft, submitted, under_review, approved, rejected, payment_pending, paid, issued, expired, revoked
            $table->string('purpose')->nullable();
            $table->string('location')->nullable();
            $table->decimal('total_fee', 12, 2)->default(0);
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permit_applications');
    }
};
