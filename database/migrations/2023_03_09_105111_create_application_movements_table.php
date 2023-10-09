<?php

use App\Models\Application;
use App\Models\User;
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
        Schema::create('application_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Application::class);

            $table->foreignIdFor(User::class, 'sender_id');
            $table->foreignIdFor(User::class,'recipient_id');

            $table->dateTime('received_at')->nullable();
            $table->dateTime('sent_at')->nullable();

            $table->string('type')->default('normal');
            $table->string('remark')->nullable();

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
        Schema::dropIfExists('application_movements');
    }
};
