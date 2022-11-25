<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PerrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('perros')->insert([
            'raza' => 'Yorkshire Terrier',
            'size' => 'Pequeño',
            'descripcion' => 'El yorkshire terrier (a veces acortado yorkie) es una raza canina producto de la combinación de terrier escoceses e ingleses.',
            'imagen' => '1Yorkie.jpg',
        ]);
        DB::table('perros')->insert([
            'raza' => 'Chihuahua',
            'size' => 'Pequeño',
            'descripcion' => 'El chihuahua1​ o chihuahueño2​ es una raza de perro originaria de México. Es una de las razas de perros más antiguas del continente americano, además de ser el perro más pequeño del mundo.',
            'imagen' => 'Degaen.jpg',
        ]);
        DB::table('perros')->insert([
            'raza' => 'Lebrel afgano',
            'size' => 'Grande',
            'descripcion' => 'El Lebrel afgano es un perro de caza procedente de Afganistán. Tiene un pelaje característico, muy largo, fino y sedoso, que precisa de cuidados continuos ya que se enreda, llegando a perder su brillo. ',
            'imagen' => 'Biju2005a.jpg',
        ]);
        DB::table('perros')->insert([
            'raza' => 'Lebrel italiano',
            'size' => 'Pequeño',
            'descripcion' => 'El pequeño lebrel italiano o galgo italiano es una raza de galgo de pequeño tamaño originaria de Italia; es el galgo más pequeño.',
            'imagen' => 'Italian_Greyhound_standing_gray.jpg',
        ]);
        DB::table('perros')->insert([
            'raza' => 'Pit bull terrier americano',
            'size' => 'Mediano',
            'descripcion' => 'El Pit Bull Terrier Americano es una raza de perro, originaria de Estados Unidos, que surgió a partir de la raza de los bull-and-terriers, importados desde el Reino Unido en el siglo XIX.',
            'imagen' => 'White_Pitbull.jpg',
        ]);
        DB::table('perros')->insert([
            'raza' => 'Pastor alemán',
            'size' => 'Grande',
            'descripcion' => 'El pastor alemán (en alemán: Deutscher Schäferhund) es una raza de perro pastor originaria de Alemania.1​ La raza es relativamente nueva, ya que su origen se remonta a 1899.',
            'imagen' => '200px-Wrocławski_(owczarek_niemiecki).jpg',
        ]);
    }
}
