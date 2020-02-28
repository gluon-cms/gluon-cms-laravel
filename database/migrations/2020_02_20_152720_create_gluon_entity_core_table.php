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

        Gluon::getParameterHelper('number')->createTable();
        Gluon::getParameterHelper('text')->createTable();
        Gluon::getParameterHelper('relationOne')->createTable();
        
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
        
    }
}
