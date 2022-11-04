<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('city_id')->default(1); // todo remove default value when not tbilisi only
            $table->unsignedInteger('profession_id')->nullable(); // todo edit if profession id required by id
            $table->string('name');
            $table->string('surname');
            $table->string('mobile_number');
            $table->string('material_status')->nullable();
            $table->date('birthday');
            $table->string('gender');
            $table->string('address_1')->default('');
            $table->string('address_2')->default('');
            $table->boolean('driving_license')->default(0);
            $table->text('personal_qualities_en')->nullable();
            $table->text('personal_qualities_ka')->nullable();
            $table->text('info_letter_en')->nullable();
            $table->text('info_letter_ka')->nullable();
            $table->string('video')->default('');
            $table->timestamps();

            $table->index('video');
            $table->index('gender');
            $table->index('birthday');
            $table->index('material_status');
            $table->index('mobile_number');
            $table->index('name');
            $table->index('surname');
        });

        Schema::table('resumes',function (Blueprint $table){
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("city_id")->references("id")->on("cities");
//            $table->foreign("profession_id")->references("id")->on("professions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resumes');
    }
}
