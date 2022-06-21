<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiTokenController extends Controller{

    
    public function update(Request $request){

        $token = Str::random(60);
 
        \App\Models\User::orderby('created_at','desc')->first()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();
 
        return ['token' => $token];
    }
}
