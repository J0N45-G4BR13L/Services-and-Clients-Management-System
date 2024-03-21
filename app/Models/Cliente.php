<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'sobrenome',
        'user_id',
    ];

    protected $table= "clientes";

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function telefones()
    {
        return $this->hasMany(Telefone::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }

    public function servicos()
    {
        return $this->hasMany(Servico::class);
    }
}