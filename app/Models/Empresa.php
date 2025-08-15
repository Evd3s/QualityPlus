<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    // Campos permitidos para atribuição em massa
    protected $fillable = ['nome', 'cnpj', 'sobre', 'imagem', 'status'];

}
