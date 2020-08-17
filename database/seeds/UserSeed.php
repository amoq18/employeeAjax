<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i<= 5; $i++) {
            DB::table('users')->insert([
            'name'=>'user '.$i,
            'username'=>'cl',
            'email'=> 'user'.$i.'@mail.com',
            ]);
        }
    }
}
