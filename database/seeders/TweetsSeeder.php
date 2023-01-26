<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// テキストp057の内容
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// テキストp065の内容
use App\Models\Tweet;

class TweetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('tweets')->insert([
        //     'content' => Str::random(100),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        /**
         * テキストp065の内容
         */
        Tweet::factory()->count(10)->create();
    }
}
