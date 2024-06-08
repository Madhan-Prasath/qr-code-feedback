<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var string[]
    */
    protected $fillable = [
        'name',
        'email',
        'description',
        'date_time',
        'location',
        'asset_id'
    ];

    public function assets(){
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
