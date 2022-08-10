<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employeeID');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('phone');
            $table->integer('age');
            $table->enum('gender',['male','female']);
            $table->enum('position',['manager','cashier','delivery']);
            $table->double('salary',8,2);
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
        Schema::dropIfExists('employees');
    }
};
