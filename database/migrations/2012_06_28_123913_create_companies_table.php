<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->nullable();
            $table->unsignedInteger('city_id');
            $table->string('company_name');
            $table->string('email')->default('');
            $table->string('address_1')->default('');
            $table->string('address_2')->default('');
            $table->string('company_id_number')->default('');
            $table->string('mobile_number')->default('');
            $table->string('logo_url')->default('');
            $table->string('facebook_url')->default('');
            $table->string('linkedin_url')->default('');
            $table->string('twitter_url')->default('');
            $table->string('google_plus_url')->default('');
            $table->text('about_company')->nullable();
            $table->double('balance')->default(0);
            $table->boolean('verified')->default(false);
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
        Schema::dropIfExists('companies');
    }
}
