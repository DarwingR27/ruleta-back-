<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Relieve;

class RelieveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/relieve.json'));
        foreach ($data as $item){
            Relieve::create(array(
                //'id' => $item->IdRol,
                'detalle' => $item->detalle,
                'idDepartamento' => $item->idDepartamento,
               
            ));
            }
    }
}
