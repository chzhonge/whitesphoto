<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project', function ($table) {
            $table->foreign('ownerID')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('image', function ($table) {
            $table->foreign('projectID')
                ->references('id')->on('project')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project', function ($table) {
            $table->dropForeign('project_ownerID_foreign');
        });

        Schema::table('image', function ($table) {
            $table->dropForeign('image_projectID_foreign');
        });
    }
}
