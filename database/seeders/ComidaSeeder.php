<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comida;

class ComidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/comida.json'));
        foreach ($data as $item){
            Comida::create(array(
                //'id' => $item->IdRol,
                'detalle' => $item->detalle,
                'idDepartamento' => $item->idDepartamento,
               
            ));
            }
    }
}
