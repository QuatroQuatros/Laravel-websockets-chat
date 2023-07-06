<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function me(){
        $user = \Auth::user();
        return response()->json([
            'user' => $user
        ], Response::HTTP_OK);
    }

    public function index(){
        $users = User::where('id', '!=', \Auth::user()->id)->get();

        return response()->json([
            'users' => $users
        ], Response::HTTP_OK);
    }

    public function show($user){
        return response()->json([
            'user' => User::where('id', $user)->first(),
        ], Response::HTTP_OK);
    }
}
