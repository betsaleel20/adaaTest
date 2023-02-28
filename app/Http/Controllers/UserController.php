<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Show the list of users.
     */
    public function index()
    {
        $all_users = User::all();
        return $all_users;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password'  => ['required', 'confirmed'],
        ]);
        if($validator->fails()){
            return response()->json(['message'=>"Echec de validation des donnees", "errors" => $validator->errors()],422);
        }
       
        $user = new User();
        $createdUser = $user->store($request);
        
        return response(["message"=>"Création reussit","user"=>$createdUser],201);
    }

    // Connexion d'un utilisateur
    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'password'  => ['string', 'max:255'],
            'email'     => ['string', 'email', 'max:255', 'exists:users,email']
        ]);
        
        if($validator->fails()){
            return response()->json(['message'=>"Echec de validation. Informations erronnes", "errors" => $validator->errors()],422);
        }

        //Check email
        $fields = $validator->validated();
        $user= User::where('email', $fields['email'])->first();
        
        if(!Hash::check($fields['password'], $user->password)){
            return response([
                'message'=>'Invalid Credentials'
            ], 401);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        $response= [
            'user' => $user,
            'token'=> $token
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $idUser)
    {
        $user = new User();
        $concernedUser = $user->findUser($idUser);
        return $concernedUser;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( int $idUser )
    {
        $user = new User();
        $findedUser = $user->findUser($idUser);
        return $findedUser;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $newUser, string $idUser)
    {
        $concernedUser = User::findOrFail($idUser);
        
        $concernedUser->name = $newUser->name;

        $concernedUser->save();

        return response()->json(["user"=>$concernedUser, 'message'=>"Modifications reussit"],200);
    }

    // 
}
