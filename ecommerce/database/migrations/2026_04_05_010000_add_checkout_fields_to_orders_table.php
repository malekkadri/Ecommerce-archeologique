<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckoutFieldsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('billing_name')->nullable()->after('currency');
            $table->string('billing_email')->nullable()->after('billing_name');
            $table->string('billing_phone')->nullable()->after('billing_email');
            $table->string('billing_address')->nullable()->after('billing_phone');
            $table->string('shipping_name')->nullable()->after('billing_address');
            $table->string('shipping_phone')->nullable()->after('shipping_name');
            $table->string('shipping_address')->nullable()->after('shipping_phone');
            $table->text('notes')->nullable()->after('shipping_address');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'billing_name',
                'billing_email',
                'billing_phone',
                'billing_address',
                'shipping_name',
                'shipping_phone',
                'shipping_address',
                'notes',
            ]);
        });
    }
}
