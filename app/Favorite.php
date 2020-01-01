<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{

    /**
     * @var string
     */
    protected $table = 'favorites';

    /**
     * @var array
     */
    protected $guarded = [];

    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id', 'id');
    }

    public function scopeDevice($query, $device)
    {
        return $this->where('device_id', '=', $device);
    }
}
