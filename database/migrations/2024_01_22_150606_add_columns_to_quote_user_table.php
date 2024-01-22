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
        Schema::table('quote_user', function (Blueprint $table) {
            $table->enum('status', ['completed', 'skipped'])->nullable()->comment('completed => Quote task is completed, skipped => Quote task is not completed')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quote_user', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
