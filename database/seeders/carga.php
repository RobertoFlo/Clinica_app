<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class carga extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $jsonPath = database_path('seeders/data.json');
        $jsonData = File::get($jsonPath);
        $departamentos = json_decode($jsonData, true);


        foreach ($departamentos as $departamentoData) {
            $departamentoId = DB::table('ctl_departamento')->insertGetId([
                'nombre' => $departamentoData['nombre'],
            ]);

            foreach ($departamentoData['municipios'] as $municipioData) {
                $municipioId = DB::table('ctl_municipio')->insertGetId([
                    'nombre' => $municipioData['nombre'],
                    'departamento_id' => $departamentoId,
                ]);

                foreach ($municipioData['distritos'] as $distritoData) {
                    DB::table('ctl_distrito')->insert([
                        'nombre' => $distritoData['nombre'],
                        'municipio_id' => $municipioId,
                    ]);
                }
            }
        }
    }
}
