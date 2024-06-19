<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $table = 'mesas';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function Pedido()
    {
        $pedido = Pedido::where('estado', 'iniciado')
            ->where('mesa_id', $this->id)
            ->orderby('created_at', 'desc')
            ->first();

        return $pedido;
    }
}
