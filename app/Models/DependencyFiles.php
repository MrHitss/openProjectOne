<?php

namespace App\Models;

use App\Notifications\FilesNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DependencyFiles extends Model
{
    use HasFactory;

    const STATUS = ['pending' => 0, 'process' => 1, 'uploaded' => 2, 'failed' => 3];

    protected $fillable = ['user_id','file','status','upload_response','status_response'];

    protected static function booted()
    {
        static::updating(function ($model) {
            if ($model->isDirty('status') && (in_array($model->status,[1,3]))) {
                $model->load('user');
                $model->user->notify(new FilesNotification($model));
            }
        });
    }

    public function getStatusNameAttribute()
    {
        return $this->status == 0 ? 'Pending' : ($this->status == 1 ? 'Upload in Process' : ($this->status == 2 ? 'Uploaded' : 'Failed'));
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
