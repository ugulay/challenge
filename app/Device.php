<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Device extends Authenticatable
{

    /**
     * @var string
     */
    protected $table = 'devices';

    /**
     * @var array
     */
    protected $fillable = [
        'token'
    ];

    /**
     * Kullanıcının favorilerine eklediği medyaları getirir.
     * 
     * @var array
     */
    protected $guarded = [];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function scopeToken($query, $token)
    {
        return $query->where('token', $token)->limit(1);
    }
}
