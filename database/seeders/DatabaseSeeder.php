<?php

namespace Database\Seeders;

use App\Models\Url;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();

        Url::factory()->create();
        DB::table('urls')->insert([
            'url_id' => 'test-url-delete',
            'url' => fake()->url(),
        ]);
    }
}
