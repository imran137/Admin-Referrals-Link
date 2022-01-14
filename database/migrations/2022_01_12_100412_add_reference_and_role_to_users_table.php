<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferenceAndRoleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'reference'))
                $table->integer('reference')->after('id')->default(0);

            if (!Schema::hasColumn('users', 'role'))
                $table->integer('role')->after('password')->default(0);
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
            if (Schema::hasColumn('users', 'reference'))
                $table->dropColumn('reference');

            if (Schema::hasColumn('users', 'role'))
                $table->dropColumn('role');
        });
    }
}
