<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class insert_records_in_users_table extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=[
                [
                    'name'=>'A',
                    'email'=>'a@gmail.com',
                    'password'=>bcrypt('123456')
                ],
                [
                    'name'=>'B',
                    'email'=>'b@gmail.com',
                    'password'=>bcrypt('123456')
                ],
                [
                    'name'=>'C',
                    'email'=>'c@gmail.com',
                    'password'=>bcrypt('123456')
                ],
            ];
            User::insert($users);
    }
}
