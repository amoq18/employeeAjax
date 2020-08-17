<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i<= 5; $i++) {
            DB::table('products')->insert([
            'nom'=>'Haricot '.$i,
            'description'=>'Vente de haricot',
            'prix'=> 500,
            'quantite'=> 0,
            'montant'=> 0
        ]);
    }

    }
}
