<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'ciente_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}