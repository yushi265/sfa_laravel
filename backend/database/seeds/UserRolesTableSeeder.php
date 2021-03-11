<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'role_id' => 1,
            'name' => 'システム管理者'
        ]);

        DB::table('user_roles')->insert([
            'role_id' => 5,
            'name' => '管理者'
        ]);

        DB::table('user_roles')->insert([
            'role_id' => 10,
            'name' => '一般'
        ]);
    }
}
