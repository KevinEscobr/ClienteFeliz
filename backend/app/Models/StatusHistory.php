<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    protected $fillable = [
        'application_id',
        'status',
        'comment',
        'changed_by'
    ];

    // Relación: este historial pertenece a una aplicación
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    // Relación: quién hizo el cambio (usuario)
    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
