<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function Mesa()
    {
        return $this->belongsTo(Mesa::class, 'mesa_id');
    }
}
