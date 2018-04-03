<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinmarketcalEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coinmarketcal_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id');
            $table->string('coin_name', 100);
            $table->string('source_url', 150);
            $table->text('content_event');
            $table->text('content_event_jp');
            $table->string('image_url', 150);
            $table->string('date');
            $table->string('date_convert');
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
        Schema::dropIfExists('coinmarketcal_events');
    }
}
