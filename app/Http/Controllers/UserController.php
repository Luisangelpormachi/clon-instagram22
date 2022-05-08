<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
Use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use App\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($search = null){

        if(isset($search)){
            $users = User::where('nick', 'LIKE', "%$search%")
                        ->orWhere('name', 'LIKE', "%$search%")
                        ->orWhere('surname', 'LIKE', "%$search%")
                        ->orderBy('id', 'desc')
                        ->paginate(5);
        }else{
            $users = User::orderBy('id', 'desc')->paginate(5);
        }

        return view('user.index', compact('users'));
    }

    public function config(){

        return view('user.config');
    }

    public function update(Request $request){

        //obtener usuario autenticado
        $user = Auth::user();

        //Agregar validaciones al formualario
        $validate = $this->validate($request, [

            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,

        ]);

        //obtener campos del formulario con request
        $name = $request->name;
        $surname = $request->surname;
        $nick = $request->nick;
        $email = $request->email;

        //asignar valores al usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //obtener la imagen del formulario y subirlo
        $image_path = $request->file('image_path');

        if(isset($image_path)){

            //poner nombre unico
            $image_path_name = time().$image_path->getClientOriginalName();
            //guardar en la carpeta storage/app/users - creada
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            //guardar el nombre en el obj
            $user->image = $image_path_name;
        }
        

        //confirmar los cambios del usuario en base de datos
        $user->update();

        return redirect()->route('user.config')
                         ->with(['message' => 'usuario actualizado correctamente']);
    }

    public function getImage($filename){

        $file = Storage::disk('users')->get($filename); 
        return new Response($file, 200);
    }

    public function profile($id){

        $user = User::find($id);

        return view('user.profile', compact('user'));
    }

}
