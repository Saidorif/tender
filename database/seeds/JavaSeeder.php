<?php

use Illuminate\Database\Seeder;

class JavaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Javoxir Amanullaev',
            'email' => 'java@mail.ru',
            'password' => Hash::make('java328'),
            'role_id' => 1,
            'gender' => 'male',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
