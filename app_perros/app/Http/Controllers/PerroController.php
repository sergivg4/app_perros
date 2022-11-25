<?php

namespace App\Http\Controllers;

use App\Perro;
use Image;
use Illuminate\Http\Request;

class PerroController extends Controller
{
    public function getData() {

        $perro = Perro::paginate(500);

        return response()->json([
            'model'     => $perro
        ]);
    }

    public function addData(Request $request) {

        $this->validate($request, [
           'raza'     => 'required',
           'descripcion'     => 'required',
           'imagen'    => 'required|mimes:jpeg,jpg,png|max:5000'
        ]);

        $ruta = '/public';

        $imagenOriginal = $request->file('imagen');

        $temp_name = $this->random_string() . '.' . $imagenOriginal->getClientOriginalExtension();

        $path = $imagenOriginal->storeAs($ruta, $temp_name);

        $create = Perro::create([
            'raza' => $request->raza,
            'descripcion' => $request->descripcion,
            'imagen' => $temp_name
        ]);

        return response()->json($create);
    }

    public function editData(Request $request) {

        $perro = Perro::find($request->id);
        $perro->raza = $request->raza;
        $perro->descripcion = $request->descripcion;
        $perro->save();
    }

    public function removeData(Request $request) {

        $perro = Perro::find($request->id);

        $perro->delete();
    }

    public function random_string(){
        $key = '';
        $keys = array_merge( range('a','z'), range(0,9) );

        for($i=0; $i<10; $i++){
            $key .=$keys[array_rand($keys)];
        }

        return $key;
    }
}
