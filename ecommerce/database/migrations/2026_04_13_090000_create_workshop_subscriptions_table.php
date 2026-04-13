<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopSubscriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('workshop_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workshop_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->unsignedInteger('seats')->default(1);
            $table->string('status')->default('confirmed')->index();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('workshop_subscriptions');
    }
}
