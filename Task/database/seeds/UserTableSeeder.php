<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();

        for($i=0;$i <= 999; $i++)
        {
            \App\User::create([
            'firstname'=>$faker->firstname,
            'lastname'=>$faker->lastname,
                'email' => $faker->unique()->email,
            'phone'=>$faker->phoneNumber,
            'password'=>bcrypt($faker->password),
            'profile'=>'user-profile.png',
            'profile_path'=>$path = public_path().'/profile/',
            'email_token'=> base64_encode($faker->unique()->email),
            'verified' =>0
            ]);
        }
    }
}
