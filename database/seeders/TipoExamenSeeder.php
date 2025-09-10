<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class TipoExamenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $examenes = [
            'Hemograma Completo',
            'Perfil Lipídico',
            'Glucosa en Ayunas',
            'Prueba de Embarazo hCG',
            'Creatinina',
            'Ácido Úrico',
            'Prueba de Función Hepática (TGO, TGP)',
            'Perfil Renal',
            'Electroforesis de Proteínas',
            'Hormona Tiroidea (TSH)',
            'Vitamina D',
            'Vitamina B12',
            'Ácido Fólico',
            'Ferritina',
            'Examen General de Orina',
            'Coproparasitológico',
            'Cultivo de Orina',
            'Cultivo de Secreción',
            'Prueba de Paternidad',
            'Grupo Sanguíneo y Factor Rh',
            'Frotis de Sangre Periférica',
            'Prueba de Coagulación (TP, TTPa)',
            'Prueba de Antígenos de Hepatitis B',
            'Prueba de Anticuerpos de Hepatitis C',
            'Prueba de VIH (4ta Generación)',
            'Prueba de Sífilis (VDRL/RPR)',
            'Examen de LCR',
            'Prueba de Tuberculosis (Quantiferon)',
            'PCR para COVID-19',
            'Antígenos para COVID-19',
            'Perfil de Embarazo',
            'Perfil Prenatal',
            'Perfil de Adolescentes',
            'Examen de Próstata (PSA)',
            'Prueba de Sensibilidad a Alérgenos',
            'Biopsia de Tejido',
            'Papanicolau (Citología)',
            'Densitometría Ósea',
            'Electrocardiograma (ECG)',
            'Monitoreo Holter',
        ];

        $data = collect($examenes)->map(function ($examen) {
            return [
                'nombre' => $examen,
                'precio' => rand(50, 500) + rand(0, 99) / 100, // Precio aleatorio entre 50 y 500
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        });
        DB::table('ctl_tipo_examen')->insert($data->toArray());
    }
}
