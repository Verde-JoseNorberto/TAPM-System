<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\GroupProject;

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
                'name'=>'Project Development Office',
                'email'=>'user@office.com',
                'type'=>2,
                'password'=> bcrypt('admin123'),
             ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }

        $group_projects = [
            [
                'project_title'=>'Test Title 1',
                'project_category'=>'Test Category 1',
                'subject'=>'SNTSDEV',
                'year_term'=>'2nd Year 3rd Term',
                'section'=>'SS201',
                'team'=>'Abyss',
                'advisor'=>'Jayvee Cabardo',
            ],
            [
                'project_title'=>'Test Title 2',
                'project_category'=>'Test Category 2',
                'subject'=>'SCSPROG',
                'year_term'=>'2nd Year 3rd Term',
                'section'=>'SS201',
                'team'=>'Abyss',
                'advisor'=>'Jayvee Cabardo'
            ],
        ];

        foreach ($group_projects as $key => $group_projects) {
            GroupProject::create($group_projects);
        }
    }
}
