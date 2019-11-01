<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsPropertiesTableMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('full_name')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('github_account')->nullable()->change();
            $table->string('viblo_link')->nullable()->change();
            $table->string('gmail')->nullable()->change();
            $table->string('chatwork_account')->nullable()->change();
            $table->string('company_email')->nullable()->change();
            $table->text('ssh_key')->nullable()->change();
        });
    }
}
