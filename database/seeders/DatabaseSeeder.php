<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'=>'Jayvee Cabardo',
                'email'=>'user@office.com',
                'type'=>0,
                'password'=> bcrypt('admin123'),
            ],
            [
                'name'=>'Manuel Sebastian Sanchez',
                'email'=>'sanchez@faculty.com',
                'type'=>1,
                'password'=> bcrypt('admin123'),
            ],
            [
                'name'=>'Juan Dela Cruz',
                'email'=>'cruz@faculty.com',
                'type'=> 1,
                'password'=> bcrypt('admin123'),
            ],
            [
                'name'=>'Jose Norberto Verde',
                'email'=>'verde@student.com',
                'type'=>2,
                'password'=> bcrypt('admin123'),
            ],
            [
                'name'=>'Noreen Keziah Sioco',
                'email'=>'sioco@student.com',
                'type'=>2,
                'password'=> bcrypt('admin123'),
            ],
            [
                'name'=>'Mark Gerald Giba',
                'email'=>'giba@student.com',
                'type'=>2,
                'password'=> bcrypt('admin123'),
            ],
            [
                'name'=>'Bea Angeline Cruz',
                'email'=>'cruz@student.com',
                'type'=>2,
                'password'=> bcrypt('admin123'),
            ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
