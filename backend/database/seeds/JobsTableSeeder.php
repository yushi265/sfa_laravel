<?php

use Illuminate\Database\Seeder;
use App\Job;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert([
            'job_id' => 1,
            'name' => '会社員'
        ]);

        DB::table('jobs')->insert([
            'job_id' => 2,
            'name' => '会社役員'
        ]);

        DB::table('jobs')->insert([
            'job_id' => 3,
            'name' => '自営業'
        ]);

        DB::table('jobs')->insert([
            'job_id' => 4,
            'name' => '学生'
        ]);

        DB::table('jobs')->insert([
            'job_id' => 5,
            'name' => '無職／退職された方'
        ]);
    }
}
