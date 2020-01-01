<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

    /**
     * @var string
     */
    protected $table = 'media';

    /**
     * @var array
     */
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favorite()
    {
        return $this->belongsTo(Favorite::class, 'id', 'media_id');
    }
}
