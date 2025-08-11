<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    // php artisan make:migration add_profile_fields_to_users_table

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('job')->nullable();
            $table->string('company')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('avatar_url')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['job', 'company', 'phone', 'mobile', 'country', 'avatar_url']);
        });
    }
}


