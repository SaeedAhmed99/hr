<?php

use App\Models\Branch;
use App\Models\Announcement;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Announcement::class);
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
        Schema::dropIfExists('announcement_branches');
    }
}
