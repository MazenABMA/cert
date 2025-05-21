<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id(); // Ensures AUTO_INCREMENT primary key
        $table->string('code')->unique();
        $table->string('model');
        $table->string('name');
        $table->decimal('price', 8, 2);
        $table->string('photo')->nullable();
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('products'); // Ensure table is properly dropped
}

};
