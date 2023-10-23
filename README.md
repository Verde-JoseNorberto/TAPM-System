<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center"><img src="public\storageExample\tapm-logo.png" width="200" alt="TAPM Logo"></p>

## About TAPM

TAPM or Tracking Activit Project Management is a Project Tracker Web Application focusing on PBL (Project Based Learning) Projects that is made in Asia Pacific College.
This Project is made as a fullfilment for PBL course made by Group Abyss of BSCS-SS201 from Asia Pacific College S.Y. 2020-2024, with its client, Mr. Jayvee M. Cabardo, Director of Project Development Office

## How to Install

The Project is still currently on its Development Phase. To be able to use this, Follow the Instructions below:
Make sure that you have [XAMPP](https://www.apachefriends.org/download.html) and [Node.js](https://nodejs.org/en/download/current) Installed.
1. Open Visual Studio Code.
1. Clone the [Repository](https://github.com/Verde-JoseNorberto/TAPM-System) to /xampp/htdocs/repository_here
1. Once the repository has been saved locally to your system, look for the '.env.example' file on the files side bar and make a copy of that file in the same place (Right-click+Copy then Paste)
1. Remove '.example' from the copied file.
1. Make sure you have XAMPP active and its port is the same in the '.env' file.
1. Launch the terminal and execute 'composer install'
1. Then 'npm install'
1. Then 'php artisan key:generate'
1. Then 'php artisan migrate'
1. Then 'php artisan db:seed'
1. Then 'php artisan storage:link'
1. Then look for path public/storageExample and copy-paste its content to public/storage
1. Lastly, 'php artisan serve'. Activate a new terminal then type 'npm run dev'

If any error persists, please do contact the developers to solve the problems.
