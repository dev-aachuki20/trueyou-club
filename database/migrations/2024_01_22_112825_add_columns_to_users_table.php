<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_vip')->default(0)->comment('0 => User is not VIP, 1 => User is VIP')->after('is_active');
            $table->tinyInteger('star_no')->default(0)->comment('0 => No Star, 1 => After 9 Week Task Complete, 2 => After 18 Week Task Complete, 3 => After 27 Week Task Complete, 4 => After 36 Week Task Complete, 5 => After 45 Week Task Complete')->after('is_vip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_vip', 'star_no']);
        });
    }
};
