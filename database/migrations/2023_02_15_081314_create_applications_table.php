<?php

use App\Models\Constituency;
use App\Models\Department;
use App\Models\District;
use App\Models\SubTrade;
use App\Models\Trade;
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
        Schema::create('applications', function (Blueprint $table) {

            $table->id();
            $table->string('head_of_family');
            $table->string('epic_no')->unique();
            $table->string('mobile')->nullable();
            $table->text('address')->nullable();
            $table->foreignIdFor(District::class);
            $table->foreignIdFor(Constituency::class);
            $table->foreignIdFor(Trade::class)->nullable();
            $table->foreignIdFor(SubTrade::class)->nullable();
            $table->foreignIdFor(Department::class);
            $table->enum('status', ['submitted', 'verified', 'disbursed', 'rejected']);
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
        Schema::dropIfExists('applications');
    }
};
