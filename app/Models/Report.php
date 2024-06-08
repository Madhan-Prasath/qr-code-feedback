<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    public static function boot()
    {
       parent::boot();
       static::creating(function($model)
       {
           $user = Auth::user();
           $model->created_by = $user->email;
           $model->updated_by = $user->email;
           $model->status     = "Open";
       });
       static::updating(function($model)
       {
           $user = Auth::user();
           $model->updated_by = $user->email;
       });
   }

    // Need this for Nova Date field
    protected $casts = [
        'created_at'        => 'datetime',
        'closed_date'       => 'date'
    ];


   public function assets(){
        return $this->belongsTo(Asset::class, 'asset_id');
   }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [

        'feedback',
        'asset_id',
        'created_by',
        'image',
        'status',
        'remarks',
        'closed_date'

    ];
}
