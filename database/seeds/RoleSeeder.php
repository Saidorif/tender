<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'label' => 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'vilmoderator',
                'label' => 'Viloyat moderator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'resmoderator',
                'label' => 'Respublika moderator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'vilboshliq',
                'label' => 'Viloyat boshliq',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'resboshliq',
                'label' => 'Respublika boshliq',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'zamminister',
                'label' => 'Zam minister',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'vilkomissiya',
                'label' => 'Viloyat komissiya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'reskomissiya',
                'label' => 'Respublika komissiya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'tashuvchi',
                'label' => 'Tashuvchi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($roles as $key => $value) {
            DB::table('roles')->insert($value);
        }
    }
}
