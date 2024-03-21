<?php

namespace App\Models;

use App\Enums\ServicoStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'preco',
        'arquivos',
        'cliente_id',
        'user_id',
    ];

    protected $casts = [
        'arquivos' => 'array',
        'status' => ServicoStatus::class,
    ];

    

    public function cliente():  BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function arquivos()
    {
        return $this->hasMany(Arquivo::class);
    }
}