<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGluonEntityCoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gluon_entity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->index(); //gluon_entity_type.code ?

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('gluon_param_number', function (Blueprint $table) {
            $table->unsignedBigInteger('gluon_entity_id');
            $table->foreign('gluon_entity_id')->references('id')->on('gluon_entity');

            $table->string('key')->index();
            $table->float('value')->index();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('gluon_param_text', function (Blueprint $table) {
            $table->unsignedBigInteger('gluon_entity_id');
            $table->foreign('gluon_entity_id')->references('id')->on('gluon_entity');

            $table->string('key')->index();
            $table->text('value');

            $table->string('lang_code');
            $table->foreign('lang_code')->references('code')->on('lang');

            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('gluon_param_related', function (Blueprint $table) {
            $table->unsignedBigInteger('gluon_entity_id');
            $table->foreign('gluon_entity_id')->references('id')->on('gluon_entity');

            $table->string('key')->index();
            $table->unsignedBigInteger('related_entity_id');
            $table->foreign('related_entity_id')->references('id')->on('gluon_entity');

            $table->unsignedInteger('rank')->default(0);

            $table->softDeletes();
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
        Schema::dropIfExists('gluon_entity');
        Schema::dropIfExists('gluon_param_number');
        Schema::dropIfExists('gluon_param_text');
        Schema::dropIfExists('gluon_param_related');
        
    }
}
