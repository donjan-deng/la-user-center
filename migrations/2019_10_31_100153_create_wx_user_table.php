<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateWxUserTable extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('wx_user', function (Blueprint $table) {
            $table->bigIncrements('wx_user_id');
            $table->bigInteger('user_id')->comment('user表user_id');
            $table->string('nick_name', 50);
            $table->string('avatar', 100)->comment('头像');
            $table->string('open_id', 50);
            $table->string('union_id', 50);
            $table->string('access_token', 100);
            $table->timestamp('access_token_expire_time')->nullable();
            $table->string('refresh_token', 100);
            $table->timestamp('refresh_token_expire_time')->nullable();
            $table->unique('open_id');
            $table->unique('union_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('wx_user');
    }

}
