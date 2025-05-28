<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dateTime('end_date')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->date('end_date')->nullable()->change();
        });
    }
};
