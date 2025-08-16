<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'cnpj', 'imagem', 'sobre'];

    // Relacionamento 1:N com Produto
    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
