<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    /**
     * @var string
     */
    protected $table = 'versions';

    /**
     * @var array
     */
    protected $fillable = [
        'version', 'log', 'update', 'updateForce', 'updateLang'
    ];

    /**
     * Kullanıcının favorilerine eklediği medyaları getirir.
     * 
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    /**
     * PK ID numarasına göre son eklenen sürüm numarasına ait veriyi geri çevirir.
     */
    public function scopeLastVersion($query)
    {
        return $query->orderBy('id', 'desc')->limit(1)->first();
    }
}
