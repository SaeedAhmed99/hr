<?php

use App\Models\Branch;
use App\Models\Meeting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Meeting::class);
            $table->foreignIdFor(Branch::class);
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
        Schema::dropIfExists('meeting_branches');
    }
}
