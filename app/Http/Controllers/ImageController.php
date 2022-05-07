<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use App\Comment;
use App\Like;
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

        $image = Image::find($id);
        return view('image.detail', compact('image'));
    }

    public function delete($id){

        //obtener usuario autenticado
        $user = Auth::user();
        //obtener imagen
        $image = Image::find($id);

        if($user && $image && $image->user_id == $user->id){

            //obtener comentarios y likes
            $comments = Comment::where('image_id', $image->id)->get();
            $likes = Like::where('image_id', $image->id)->get();

            //eliminar comentarios
            if($comments && count($comments) >= 1){
                foreach($comments as $item){
                    $item->delete();
                }   
            }

            //eliminar likes
            if($likes && count($likes) >= 1){
                foreach($likes as $item){
                    $item->delete();
                }   
            }

            //eliminar imagenes de storage
            Storage::disk('images')->delete($image->image_path);

            //eliminar la imagenes
            $image->delete();

            //message de exito
            $message = ['message' => 'La imagen se elimino correctamente'];
        }else{
            
            //message de fallo
            $message = ['message' => 'Error al eliminar imagen'];
        }

        return redirect()->route('home')->with($message);

    }

    public function edit($id){
        
        //obtener usuario autenticado
        $user = Auth::user();
        //obtener imagen
        $image = Image::find($id);

        //verificar si eres propietario de la imagen
        if($user && $image && $image->user->id == $user->id){

            return view('image.edit', compact('image'));
            
        }else{
            return back()->with(['message-error' => 'No eres propietario de la imagen']);
        }    
        
    }

    public function update(Request $request){

        //validar campos
        $validate = $this->validate($request, [
            'description' => 'required',
        ]);

        //obtener usuario autenticado
        $user = Auth::user();
        //obtener imagen 
        $image = Image::find($request->image_id);
        //obtener imagen antigua
        $image_old = $image->image_path;

        //obtener valores
        $description = $request->description;
        $image_path = $request->image_path; 

        if($user && $image && $image->user_id == $user->id){

            if($image_path){

                //obtener el nuevo nombre para la imagen a guardar
                $image_path_name = time(). $image_path->getClientOriginalName();
                //guardar la imagen el storage/app/image - creada
                Storage::disk('images')->put($image_path_name, File::get($image_path));
                //borrar imagen antigua
                Storage::disk('images')->delete($image_old);
                //guardar el nombre a la base de datos
                $image->image_path = $image_path_name;
            }
            
            $image->description = $description;
            //actualizar en la bd
            $image->update();
                            
            return redirect()->route('image.detail', ['id' => $image])
                             ->with(['message' => 'Imagen actualizada correctamente']);

        }else{
            return back()->with(['message-error' => 'No eres propietario de la imagen']);
        }
    }


}
