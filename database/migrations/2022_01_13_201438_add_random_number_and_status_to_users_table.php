<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRandomNumberAndStatusToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table){
            if (!Schema::hasColumn('users', 'random_number'))
                $table->integer('random_number')->after('role')->nullable();

            if (!Schema::hasColumn('users', 'status'))
                $table->tinyInteger('status')->after('random_number')->default(0);
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
            if (Schema::hasColumn('users', 'random_number'))
                $table->dropColumn('random_number');

            if (Schema::hasColumn('users', 'status'))
                $table->dropColumn('status');
        });
    }
}
