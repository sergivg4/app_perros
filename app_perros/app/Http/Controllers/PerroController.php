<?php

namespace App\Http\Controllers;

use App\Perro;
use Image;
use Illuminate\Http\Request;

class PerroController extends Controller
{
    // Recibe todos los datos de perros de la BBDD y muestra hasta 500,
    // devuelve la información en formato json.
    public function getData() {

        $perro = Perro::paginate(500);

        return response()->json([
            'model'     => $perro
        ]);
    }

    // Añade la información recibida a la BBDD
    // Guarda la imagen recibida
    public function addData(Request $request) {

        $this->validate($request, [
           'raza'     => 'required',
           'size'   => 'required',
           'descripcion'     => 'required',
           'imagen'    => 'required|mimes:jpeg,jpg,png|max:5000'
        ]);

        $ruta = '/public';

        $imagenOriginal = $request->file('imagen');

        $temp_name = $this->random_string() . '.' . $imagenOriginal->getClientOriginalExtension();

        $path = $imagenOriginal->storeAs($ruta, $temp_name);

        $create = Perro::create([
            'raza' => $request->raza,
            'size' => $request->size,
            'descripcion' => $request->descripcion,
            'imagen' => $temp_name
        ]);

        return response()->json($create);
    }

    // Actualiza la información que llega a la BBDD
    public function editData(Request $request) {

        $perro = Perro::find($request->id);
        $perro->raza = $request->raza;
        $perro->size = $request->size;
        $perro->descripcion = $request->descripcion;
        $perro->imagen = $request->imagen;
        $perro->save();
    }

    // Elimina al perro de la BBDD según su ID
    public function removeData(Request $request) {

        $perro = Perro::find($request->id);

        $perro->delete();
    }

    // Crea una string aleatoria para usarlo en el nombre de las imágenes guardadas
    public function random_string(){
        $key = '';
        $keys = array_merge( range('a','z'), range(0,9) );

        for($i=0; $i<10; $i++){
            $key .=$keys[array_rand($keys)];
        }

        return $key;
    }
}
