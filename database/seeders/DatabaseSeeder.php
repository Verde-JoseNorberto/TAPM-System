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
               'email'=>'user@student.com',
               'type'=>0,
               'password'=> bcrypt('admin123'),
            ],
            [
               'name'=>'Faculty User',
               'email'=>'user@faculty.com',
               'type'=> 1,
               'password'=> bcrypt('admin123'),
            ],
            [
               'name'=>'Client User',
               'email'=>'user@client.com',
               'type'=>2,
               'password'=> bcrypt('admin123'),
            ],
            [
                'name'=>'Project Development Director',
                'email'=>'director@client.com',
                'type'=>2,
                'password'=> bcrypt('admin123'),
             ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
