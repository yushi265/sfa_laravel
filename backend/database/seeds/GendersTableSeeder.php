<?php

use Illuminate\Database\Seeder;
use App\Gender;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->insert([
            'gender_id' => 1,
            'name' => '男'
        ]);

        DB::table('genders')->insert([
            'gender_id' => 2,
            'name' => '女'
        ]);

        DB::table('genders')->insert([
            'gender_id' => 9,
            'name' => 'その他'
        ]);


    }
}
