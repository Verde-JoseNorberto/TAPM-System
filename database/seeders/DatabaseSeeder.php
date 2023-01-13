<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
               'name'=>'Student User',
               'email'=>'jtverde@student.apc.edu.ph',
               'type'=>0,
               'password'=> bcrypt('admin123'),
            ],
            [
               'name'=>'Faculty User',
               'email'=>'jnverde.pogi@gmail.com',
               'type'=> 1,
               'password'=> bcrypt('admin123'),
            ],
            [
               'name'=>'Client User',
               'email'=>'user@itsolutionstuff.com',
               'type'=>2,
               'password'=> bcrypt('123456'),
            ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
