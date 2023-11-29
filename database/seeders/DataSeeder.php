<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tasks;
use Faker;

class DataSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name'=>'Gallan',
                'email'=>'gallan@gmail.com',
                'password'=>bcrypt('gallan')
            ],
            [
                'name'=>'Stefan',
                'email'=>'stefan@gmail.com',
                'password'=>bcrypt('stefan')
            ],
            [
                'name'=>'Jaya',
                'email'=>'jaya@gmail.com',
                'password'=>bcrypt('jaya')
            ],
            [
                'name'=>'Kelana',
                'email'=>'kelana@gmail.com',
                'password'=>bcrypt('kelana')
            ],
        ];
        foreach ($data as $value) {
            $user = User::create($value);
            $faker = Faker\Factory::create();
            $data = [
                [
                    'user_id'=>$user->id,
                    'name'=>$user->name.' task 1',
                    'description'=> $faker->text(1500),
                ],[
                    'user_id'=>$user->id,
                    'name'=>$user->name.' task 2',
                    'description'=> $faker->text(2000),
                ],[
                    'user_id'=>$user->id,
                    'name'=>$user->name.' task 3',
                    'description'=> $faker->text(3000),
                ]
            ];
            foreach ($data as $result) {
                Tasks::create($result);
            }
        }     
    }
}
