<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_admin')->default(false)->after('password');
            });

            User::whereIn('role', ['admin', '1'])->update(['is_admin' => true]);

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user')->after('password');
            });

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_admin');
            });
        });
    }
};
