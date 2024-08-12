<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('successful_emails', function (Blueprint $table) {
            $table->id();
            $table->mediumInteger('affiliate_id');
            $table->text('envelope');
            $table->string('from');
            $table->text('subject');
            $table->string('dkim')->nullable();
            $table->string('SPF')->nullable();
            $table->float('spam_score')->nullable();
            $table->longText('email');
            $table->longText('raw_text')->nullable();
            $table->string('sender_ip')->nullable();
            $table->text('to');
            $table->integer('timestamp');
            $table->boolean('processed')->default(false);
            $table->boolean('deleted')->default(false);
            $table->timestamps();
            $table->index('affiliate_id', 'affiliate_index');
        });
    }

    public function down()
    {
        Schema::dropIfExists('successful_emails');
    }
};
