<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consult extends Model
{
    protected $fillable = [
        'profissional_id', 'paciente_id', 'day', 'month', 'year', 'hours', 'minutes','period',
    ];

    public function profissional()
    {
        return $this->belongsTo(User::class, 'profissional_id');
    }

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }
}