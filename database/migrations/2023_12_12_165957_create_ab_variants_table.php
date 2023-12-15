<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ab_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ab_test_id')
                ->constrained('ab_tests')
                ->onDelete('cascade');
            $table->string('name');
            $table->float('targeting_ratio');
            $table->boolean('is_selected')->default(FALSE);
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
        Schema::dropIfExists('ab_variants');
    }
}
