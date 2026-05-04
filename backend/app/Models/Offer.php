<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;

    protected $table = 'offers';

    protected $fillable = [
        'title',
        'description',
        'status',
        'created_by'
    ];

    // One offer has many applications
    public function applications()
    {
        return $this->hasMany(Application::class, 'offer_id');
    }

    // Belongs to a user (recruiter)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
