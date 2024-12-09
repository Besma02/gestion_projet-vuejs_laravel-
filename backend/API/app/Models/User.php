<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\DatabaseNotification;

class User extends Authenticatable implements JWTSubject 
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
    public function getJWTIdentifier()
    {
        return $this->getKey(); // retourne l'identifiant unique du modèle, typiquement l'ID
    }

    /**
     * Return a key-value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return []; // retourne un tableau de revendications supplémentaires, vide par défaut
    }
    public function roles(){
        return $this->belongsToMany(role::class) ;
    }
    public function isAdmin(){
        return $this->roles()->where('name','=','admin')->exists() ;
    }
    public function ManyRoles(array $roles){
        return $this->roles()->whereIn('name',$roles)->exists() ;
    }
    public function created_task(){
        return $this->hasMany(Task::class,'user_created_by') ;
    }
    public function assigned(): HasMany
    {
        return $this->hasMany(Task::class, 'user_assigned_to');
    }

}
