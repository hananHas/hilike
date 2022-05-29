<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('nickname',50);
            $table->text('about')->nullable();
            $table->text('looking_for')->nullable();
            $table->date('dob');
            $table->integer('origin_country_id');
            $table->integer('residence_country_id');
            $table->string('gender',20);
            $table->string('state',50)->nullable();
            $table->integer('religion_id')->nullable();
            $table->integer('social_type_id')->nullable();
            $table->integer('marriage_type_id')->nullable();
            $table->integer('education_id')->nullable();
            $table->integer('job_id')->nullable();
            $table->tinyInteger('children')->nullable();
            $table->tinyInteger('smoking')->nullable();
            $table->integer('height')->nullable();
            $table->integer('skin_color_id')->nullable();
            $table->integer('body_id')->nullable();
            $table->integer('plan_id');
            $table->decimal('latitude', 11, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('language',5);
            $table->tinyInteger('online');
            $table->integer('profile_progress');
            $table->date('last_visit')->nullable();
            $table->string('profile_image',100)->nullable();
            $table->tinyInteger('confirmed_image')->nullable();
            $table->integer('balance')->default(0);
            $table->tinyInteger('location')->default(1);
            $table->tinyInteger('visible')->default(1);

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
        Schema::dropIfExists('user_details');
    }
}
