<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'email' => 'tender@mintrans.uz',
            'salary' => 25000,
            'logo' => '',
            'favicon' => '',
            'name' => 'O\'zbekiston Respublikasi Transport Vazirligi',
            'bank_number' => '2021000090074505063',
            'city' => 'Чиланзарский ф-л АКИБ "Ипотека-Банк"',
            'oked' => '84111',
            'mfo' => '00997',
            'inn' => '202811527',
            'phone' => '71-202-05-01',
            'address' => 'Ташкент, ул Зулфияхоним, 3',
            'created_by' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
