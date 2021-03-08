<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            'status_id' => 1,
            'name' => '有効情報'
        ]);

        DB::table('statuses')->insert([
            'status_id' => 5,
            'name' => '進捗'
        ]);

        DB::table('statuses')->insert([
            'status_id' => 9,
            'name' => '契約成立'
        ]);
    }
}
