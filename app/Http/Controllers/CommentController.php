<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;

class CommentController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request){

        //validar campos
        $validate = $this->validate($request, [

            'content'  => 'required|string',
            'image_id' => 'required|int',

        ]);

        //obtener usuario autenticado
        $user = Auth::user();
        //obtener modelo comment
        $comment = new Comment();

        //obtener valores del fomulario
        $content = $request->content;
        $image_id = $request->image_id;

        //asignar valores al modelo
        $comment->content = $content;
        $comment->image_id = $image_id;
        $comment->user_id = $user->id;

        //guardar en la bd
        $comment->save();

        return redirect()->route('image.detail', ['id' => $image_id])
                         ->with(['message' => 'Has publicado un comentario correctamente']);
    }

    public function delete($id){

        //obtener usuario logueado
        $user = Auth::user();

        //obtener modelo de comentario
        $comment = Comment::findOrFail($id);

        //validar el eliminado (si es dueño del comentario o dueño de la imagen)
        if($user &&  ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            $comment->delete();
        }

        return redirect()->route('image.detail', ['id' => $comment->image_id])
                        ->with(['message' => 'El comentario fue eliminado correctamente']);
    }

}
