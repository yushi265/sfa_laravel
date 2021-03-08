<?php

use Illuminate\Database\Seeder;
use App\Contract_type;

class Contract_typesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contract_types')->insert([
            'contract_type_id' => 2,
            'name' => '普通預金'
        ]);

        DB::table('contract_types')->insert([
            'contract_type_id' => 6,
            'name' => '定期預金'
        ]);

        DB::table('contract_types')->insert([
            'contract_type_id' => 9,
            'name' => '融資'
        ]);
    }
}
