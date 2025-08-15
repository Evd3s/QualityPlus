<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'birth_date')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('birth_date')->nullable();
            });
        }

        if (!Schema::hasColumn('users', 'contact_email')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('contact_email')->nullable();
            });
        }

        if (!Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone')->nullable();
            });
        }

        if (!Schema::hasColumn('users', 'about')) {
            Schema::table('users', function (Blueprint $table) {
                $table->text('about')->nullable();
            });
        }

        if (!Schema::hasColumn('users', 'profile_image')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('profile_image')->nullable();
            });
        }
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['birth_date', 'contact_email', 'phone', 'about', 'profile_image']);
        });
    }
};
