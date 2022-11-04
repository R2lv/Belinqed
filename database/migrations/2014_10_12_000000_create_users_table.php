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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->nullable(); // connected to company table
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->unsignedInteger('city_id');
            $table->string('password');
            $table->string('mobile_number');
            $table->string('personal_id'); // todo company and personal id number (pcid)
            $table->boolean('email_verified')->default(false);
            $table->boolean('mobile_verified')->default(false);
            $table->boolean('resume_submitted')->default(false);
            $table->boolean('resume_accepted')->default(false);
            $table->boolean('resume_rejected')->default(false);
            $table->string('profile_picture_url')->nullable();
            $table->string('gender')->default('');
            $table->date('birthday');
            $table->boolean('banned')->default(false);
            $table->tinyInteger('deleted')->default(false);
            $table->rememberToken();
            $table->timestamps();

            $table->index('name');
            $table->index('surname');
            $table->index('email');
            $table->index('mobile_number');
            $table->index('email_verified');
            $table->index('mobile_verified');
            $table->index('banned');
        });



        Schema::table('companies',function (Blueprint $table){
            $table->foreign("admin_id")->references("id")->on("users");
            $table->foreign("city_id")->references("id")->on("cities");

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
