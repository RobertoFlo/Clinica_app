<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CategoriaAlergiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alergias = [
            'Alergias respiratorias' => ['Rinitis alérgica (fiebre del heno)', 'Asma alérgica', 'Alergia al polen'],
            'Alergias alimentarias' => ['Alergia a la leche', 'Alergia al huevo', 'Alergia al cacahuete', 'Alergia al marisco'],
            'Alergias en la piel' => ['Dermatitis atópica (eccema)', 'Urticaria de contacto', 'Dermatitis por níquel'],
            'Alergias a medicamentos' => ['Alergia a la penicilina', 'Alergia a la aspirina', 'Alergia a la codeína'],
            'Alergias a picaduras de insectos' => ['Alergia a la picadura de abeja', 'Alergia a la picadura de avispa', 'Alergia a la picadura de hormiga'],
            'Alergias oculares' => ['Conjuntivitis alérgica'],
            'Alergias de contacto' => ['Alergia al látex', 'Alergia a los cosméticos', 'Alergia a los perfumes'],
        ];

        foreach ($alergias as $categoriaNombre => $tiposAlergia) {
            // Insertar la categoría si no existe
            $categoria = DB::table('ctl_categoria_alergia')->where('nombre', $categoriaNombre)->first();
            if (!$categoria) {
                $categoriaId = DB::table('ctl_categoria_alergia')->insertGetId([
                    'nombre' => $categoriaNombre,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $categoriaId = $categoria->id;
            }
            // Insertar las alergias asociadas
            foreach ($tiposAlergia as $tipoNombre) {
                // Evitar duplicados
                $existe = DB::table('ctl_alergia')->where('nombre', $tipoNombre)->where('categoria_id', $categoriaId)->first();
                if (!$existe) {
                    DB::table('ctl_alergia')->insert([
                        'nombre' => $tipoNombre,
                        'categoria_id' => $categoriaId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
        DB::table('ctl_nvl_alergia')->insert([
            [
                'nombre' => 'Leve',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Moderada',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre' => 'Severa (Anafilaxia)',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
