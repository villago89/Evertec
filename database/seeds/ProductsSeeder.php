<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $descriptions = array("ACTUALIZACION DE MODULO","CAPACITACION","SOPORTE TECNICO");
        foreach($descriptions as $description){
            $insert[] = array('descriptions'=>$description,
                    'price'=>rand(100000,2000000));
        }
        DB::table('products')->insert($insert);
    }
}
