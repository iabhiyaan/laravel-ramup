<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Content\Entities\Content;
use Modules\Folder\Entities\Folder;

class CreateContentFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_folders', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Content::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Folder::class)->nullable()->constrained()->cascadeOnDelete();

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
        Schema::dropIfExists('content_folders');
    }
}
