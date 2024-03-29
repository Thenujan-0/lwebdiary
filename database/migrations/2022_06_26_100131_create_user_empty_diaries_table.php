<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("user_empty_diaries",function (Blueprint $table){
            $table->id(); 
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("diary_name_id");
            
            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");

            $table->foreign("diary_name_id")
                ->references("id")
                ->on("diary_names")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_empty_diaries');
    }
};
