<?php

use Illuminate\Database\Seeder;

class CarreraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('carreras')->insert([
            'nombre' => "INGENIERIA EN AGRONOMIA",
            'jefe' => ""
        ]);

        DB::table('carreras')->insert([
            'nombre' => "INGENIERIA ELECTRONICA",
            'jefe' => ""
        ]);

        DB::table('carreras')->insert([
            'nombre' => "INGENIERIA INDUSTRIAL",
            'jefe' => ""
        ]);

        DB::table('carreras')->insert([
            'nombre' => "INGENIERIA EN SISTEMAS COMPUTACIONALES",
            'jefe' => ""
        ]);

        DB::table('carreras')->insert([
            'nombre' => "INGENIERIA EN GESTION EMPRESARIAL",
            'jefe' => ""
        ]);

        DB::table('carreras')->insert([
            'nombre' => "INGENIERIA PETROLERA",
            'jefe' => ""
        ]);



        DB::table('carreras')->insert([
            'nombre' => "CONTADOR PUBLICO",
            'jefe' => ""
        ]);

        DB::table('carreras')->insert([
            'nombre' => "MAESTRIA EN INGENIERÍA INDUSTRIAL",
            'jefe' => ""
        ]);

        DB::table('carreras')->insert([
            'nombre' => "INGENIERIA AMBIENTAL",
            'jefe' => ""
        ]);

        DB::table('carreras')->insert([
            'nombre' => "MAESTRIA EN AGROBIOTECNOLOGIA",
            'jefe' => ""
        ]);

        DB::table('carreras')->insert([
            'nombre' => "INGENIERIA MECATRÓNICA",
            'jefe' => ""
        ]);

        DB::table('carreras')->insert([
            'nombre' => "MAESTRIA EN PRODUCCION PECUARIA TROPICAL",
            'jefe' => ""
        ]);
    }
}
