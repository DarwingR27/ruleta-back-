<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Baile;


class BaileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/baile.json'));
        foreach ($data as $item){
            Baile::create(array(
                //'id' => $item->IdRol,
                'detalle' => $item->detalle,
                'idDepartamento' => $item->idDepartamento,
               
            ));
            }
    }
}
