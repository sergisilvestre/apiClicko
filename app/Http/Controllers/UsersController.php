<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use DB;

class UsersController extends Controller{


    public function index(){
        
        return response()->json(User::select('id','email','name')->get());
    }


    public function store(Request $request){
       
        $validator = Validator::make([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->password,
        ], [    
            'name'      => ['required', 'min:3', 'max:50'],
            'email'     => ['required', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password'  => ['required', 'min:8', 'max:50'],
        ]);
        
        if ($validator->fails()) { 

            return response()->json($validator->errors());
        }

        $user = User::create([
            'name'      => $request->name,    
            'email'     => $request->email,
            'password'  => Hash::make($request->password),  
            'api_token' => Str::random(60),  
        ]);

        return response()->json(User::select('id','email','name')->find($user->id));
    }


    public function show($id){
        
        return response()->json(User::select('id','email','name')->find($id));
    }


    public function update($id, Request $request){
        
        $validator = Validator::make([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => $request->password,
        ], [    
            'name'      => ['required', 'min:3', 'max:50'],
            'email'     => ['required', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password'  => ['required', 'min:8', 'max:50'],
        ]);
        
        if ($validator->fails()) { 

            return response()->json($validator->errors());
        }

        User::find($id)->update([
            'name'      => $request->name,    
            'email'     => $request->email,
            'password'  => Hash::make($request->password),    
        ]);

        return response()->json(User::select('id','email','name')->find($id));
    }


    public function destroy($id){
        
        User::destroy($id);

        return response()->json('Success');
    }


    public function dominios(){

        $users = \App\Models\User::select('email')->get();

        $dominios = [];

        foreach($users as $u){

            if( filter_var( $u->email, FILTER_VALIDATE_EMAIL ) ) {

                $tmp     = explode('@', $u->email);
                $dominio = array_pop($tmp);

                if( !in_array($dominio, $dominios) ){

                    array_push($dominios, $dominio);
                }
            }
        }

        $contador = [];

        foreach($dominios as $d){

            array_push($contador, [
                'nombre' => $d,
                'total'  => User::where('email', 'like', '%@'.$d)->count(),
            ]);
        }

        return response()->json($contador);
    }


}

