<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
        });

        // Backfill: split existing name on last space
        foreach (DB::table('users')->select('id', 'name')->get() as $user) {
            $parts = explode(' ', $user->name, 2);
            if (count($parts) === 2) {
                $lastSpacePos = strrpos($user->name, ' ');
                $firstName = substr($user->name, 0, $lastSpacePos);
                $lastName = substr($user->name, $lastSpacePos + 1);
            } else {
                $firstName = $user->name;
                $lastName = '';
            }
            DB::table('users')->where('id', $user->id)->update([
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->default('');
        });

        // Backfill: combine first_name and last_name
        DB::table('users')->update([
            'name' => DB::raw("TRIM(CONCAT(first_name, ' ', last_name))"),
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name']);
        });
    }
};
