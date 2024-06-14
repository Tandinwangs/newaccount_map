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
        Schema::create('account_details', function (Blueprint $table) {
            $table->id();
            $table->string('branch_code');
            $table->string('cust_no');
            $table->string('new_account');
            $table->string('old_account');
            $table->string('customer_name1'); 
            $table->string('cid')->nullable();
            $table->string('mobile');
            $table->string('customer_type');
            $table->string('account_class');
            $table->string('account_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_details');
    }
};
