<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class ImageController extends Controller
{   
    
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function create(){
        
        return view('image.create');

    }

    public function save(Request $request){

        //validar campos
        $validate = $this->validate($request, [

            'description' => 'required',
            'image_path' => 'required|mimes:jpeg,png,jpg,gif',

        ]);

        //obtener el modelo de Imagen
        $image = new Image();
        //obtener el usuario logueado
        $user = Auth::user();

        //obtener valores de los campos del formulario
        $image_path = $request->image_path;
        $description = $request->description;

        //asignar valores al modelo image
        $image->description = $description;
        $image->user_id = $user->id;

        //verificar que exista imagen
        if($image_path){

            //obtener el nuevo nombre para la imagen a guardar
            $image_path_name = time(). $image_path->getClientOriginalName();
            //guardar la imagen el storage/app/image - creada
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            //guardar el nombre a la base de datos
            $image->image_path = $image_path_name;

        }

       $image->save();

       return redirect()->route('home')
                ->with(['message' => 'La imagen fue guardada correctamente']);
    }

    public function getImage($filename){

        if(Storage::disk('images')->exists($filename)){
            
            $filename = Storage::disk('images')->get($filename);
            return new Response($filename, 200);
        }
    }
    
    public function detail($id){

        $image = Image::findOrFail($id);
        return view('image.detail', compact('image'));
    }

}
