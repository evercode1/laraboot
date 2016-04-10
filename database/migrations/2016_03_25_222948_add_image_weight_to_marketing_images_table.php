<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageWeightToMarketingImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marketing_images', function(Blueprint $table)
        {
            $table->integer('image_weight')->default('100')->after('image_extension');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marketing_images', function ($table) {

            $table->dropColumn('image_weight');

        });
    }
}
