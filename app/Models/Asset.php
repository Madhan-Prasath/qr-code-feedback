<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
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
       });
       static::updating(function($model)
       {
           $user = Auth::user();
           $model->updated_by = $user->email;
       });
   }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'asset_id',
        'asset_name',
        'location',
        'link'
    ];

    public function activity_logs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}
