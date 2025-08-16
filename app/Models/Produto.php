<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'empresa_id',
        'nome',
        'preco',
        'quantidade',
        'categoria',   
        'descricao',
        'imagem',
    ];

    
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
