<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'rating'];

    // Relacionamento com o Item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
