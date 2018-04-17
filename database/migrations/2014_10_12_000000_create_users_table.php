<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });*/

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default("");
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('user_age')->default(0);
            $table->tinyInteger('user_sex')->default(1);
            $table->tinyInteger('user_measurement')->default(1);
            $table->unsignedInteger('user_startweight')->default(0);
            $table->unsignedInteger('user_startfat')->default(0);
            $table->unsignedInteger('user_height')->default(0);
            $table->unsignedInteger('user_weight')->default(0);
            $table->unsignedInteger('user_fat')->default(0);
            $table->double('user_fatpercent', 3, 2)->default(0.00);
            $table->unsignedInteger('user_goalweight')->default(0);
            $table->unsignedInteger('user_waist')->default(0);
            $table->double('user_profileprogress', 3, 2)->default(0.00);
            $table->date('user_birthday');
            $table->mediumText('user_bioinfo');
            $table->tinyInteger('user_status')->default(0);
            $table->tinyInteger('user_firstlogin')->default(0);
            $table->string('user_profilepicurl', 100)->default("");
            $table->date('user_startdate');
            $table->tinyInteger('user_type')->default(0);
            $table->rememberToken();
            $table->datetime('user_lastlogin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
