<?php

use Illuminate\Database\Seeder;

class EmployeeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'name'=>'DJESSOU 1',
            'adresse'=>'bohicon',
            'pays'=>'Benin',
            'email'=>'regisdjessou1@gmail.com',
        ]);

        DB::table('employees')->insert([
            'name'=>'DJESSOU 2',
            'adresse'=>'ctn',
            'pays'=>'Benin',
            'email'=>'regisdjessou2@gmail.com',
        ]);

        DB::table('employees')->insert([
            'name'=>'DJESSOU 3',
            'adresse'=>'lokossa',
            'pays'=>'Benin',
            'email'=>'regisdjessou3@gmail.com',
        ]);
    }
}
