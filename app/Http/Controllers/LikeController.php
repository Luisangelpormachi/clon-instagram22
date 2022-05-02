<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Like;
use App\Image;


class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        //obtener usuario autenticado
        $user = Auth::user();

        $likes = like::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(5);

        return view('like.index', compact('likes'));
    }

    public function save($image_id){

        //obtener usuario autenticado
        $user = Auth::user();

        //validar que no exista like
        $isset_like = Like::where('user_id', $user->id)
                            ->where('image_id', $image_id)->count();
        

        if($isset_like == 0){

            //obtener modelo de like
            $like = new like();

            //asignar valores
            $like->user_id = $user->id;
            $like->image_id = (int)$image_id;

            //guardar cambios en bd
            $like->save();

            return response()->json([
                'like' => $like,
                'message' => 'Has dado like correctamente',
            ]);

        }else{

            return response()->json([
                'message' => 'like ya existe'
            ]);
        }

    }

    public function delete($image_id){

        //obtener usuario autenticado
        $user = Auth::user();

        //validar que exista like
        $like = Like::where('user_id', $user->id)
                    ->where('image_id', $image_id)
                    ->first();

        
        if($like){

            //eliminar like
            $like->delete();

            return response()->json([
                'like' => $like,
                'message' => 'Has eliminado el like correctamente',
            ]);

        }else{

            return response()->json([
                'message' => 'like no existe'
            ]);
        }

    }
}
