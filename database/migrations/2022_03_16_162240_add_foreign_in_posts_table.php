<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignInPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('slug');

            // indico che user_id è una foreign key e che fa riferimento 
            // alla colonna id sulla tabella users
            $table->foreign('user_id')->references('id')->on('users');

            $table->foreignId('category_id')->nullable()->after('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // tolgo il collegamento foreign della colonna e poi la cancello.
            $table->dropForeign('posts_user_id_foreign');
            $table->dropColumn('user_id');
            // tolgo il collegamento foreign della colonna e poi la cancello.
            $table->dropForeign('posts_category_id_foreign');
            $table->dropColumn('category_id');
        });
    }
}
