<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class TipoConsultaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consultas = [
            'Consulta Médica General',
            'Consulta Pediátrica',
            'Consulta Dermatológica',
            'Consulta Ginecológica',
            'Consulta Oftalmológica',
            'Consulta de Nutrición',
            'Consulta Psicológica',
            'Consulta Odontológica',
            'Consulta Cardiológica',
            'Consulta de Fisioterapia',
            'Consulta de Alergología',
            'Consulta Urológica',
            'Consulta de Traumatología',
            'Consulta de Otorrinolaringología',
            'Consulta de Gastroenterología',
            'Consulta de Endocrinología',
            'Consulta de Neurología',
            'Consulta de Neumología',
            'Consulta de Reumatología',
            'Consulta de Cirugía General',
            'Consulta de Cirugía Plástica',
            'Consulta de Anestesiología',
            'Consulta de Acupuntura',
            'Consulta de Ginecología y Obstetricia',
            'Consulta de Fertilidad',
            'Consulta de Planificación Familiar',
            'Consulta de Medicina Estética',
            'Consulta de Cirugía Vascular',
            'Consulta de Hepatología',
            'Consulta de Geriatría',
            'Consulta de Hematología',
            'Consulta de Oncología',
            'Consulta de Cirugía Pediátrica',
            'Consulta de Nefrología',
            'Consulta de Infectología',
            'Consulta de Toxicología',
            'Consulta de Medicina del Deporte',
            'Consulta de Podología',
            'Consulta de Ortopedia',
            'Consulta de Audiología',
            'Consulta de Terapia del Lenguaje',
            'Consulta de Medicina Preventiva',
            'Consulta de Rehabilitación',
            'Consulta de Oftalmología Pediátrica',
            'Consulta de Psicología Infantil',
            'Consulta de Medicina Interna',
            'Consulta de Terapia Ocupacional',
            'Consulta de Cirugía Maxilofacial',
            'Consulta de Coloproctología',
            'Consulta de Medicina Familiar',
        ];

        $data = collect($consultas)->map(function ($consulta) {
            return [
                'nombre' => $consulta,
                'precio' => rand(30, 200) + rand(0, 99) / 100, // Precios entre $30 y $200
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        });

        DB::table('ctl_tipo_consulta')->insert($data->toArray());
    }
}
