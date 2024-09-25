<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //creo la colonna per la foregin key
            $table->unsignedBigInteger('type_id')->nullable()->after('id');

            //Creo la FK sulla colonna creata
            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                //quando cancello una categoria metterà null nella foregin key
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['type_id']);


            $table->dropColumn('type_id');
        });
    }
};
