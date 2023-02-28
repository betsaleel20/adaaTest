<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Ecriture des methodes
     */
    public function store(Request $request)
    {
        $user = $this::create([
            'name'     => htmlspecialchars($request->name),
            'email'    => htmlspecialchars($request->email),
            'password' => bcrypt($request->password),
        ]);

        return $user;
    }

    // Retourner tous les utilisteurs enregistrés
    public function usersList()
    {
        $users = $this::all();
        return $users;
    }

    // Rechercher un utilisateur a partir de son ID
    public function findUser(int $idUser)
    {
        $user = $this::findOrFail($idUser);
        return $user;
    }


    // Modifier les informations d'un utilisateur
    public function updateUser(Request $user, int $idUser)
    {
        $concernedUser = $this::findOrFail($idUser);
        
        $concernedUser->name = $user->fn;

        $concernedUser->save();

        return $concernedUser;
    }

    
}
