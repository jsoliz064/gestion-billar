<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionArray;
use App\Models\Pedido;
use App\Traits\ServerTrait;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    use ServerTrait;
    public function index()
    {
        return view('cruds.pedido.index');
    }
    public function switch2($status)
    {
        // return [];
        try {
            $client = new Client();
            $response = $client->request('POST', "http://192.168.0.19:8081/zeroconf/switches", [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'deviceid' => "10017f4c2b",
                    'data' => [
                        "switches" => [
                            [
                                "switch" => $status,
                                "outlet" => 0
                            ]
                        ]

                    ],
                ]
            ]);

            $contents = $response->getBody()->getContents();
            $data = json_decode($contents, true);
            return $data;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $contents = $response->getBody()->getContents();
                $data = json_decode($contents, true);
                throw new ExceptionArray("Error al enviar el mensaje", 500, $data);
            }
            throw new ExceptionArray("Error al enviar el mensaje", 500);
        }
    }

    public function terminarPedido(Request $request, $pedido_id)
    {
        try {
            $pedido = Pedido::find($pedido_id);
            if ($pedido == null) {
                return response()->json(['message' => "Pedido {$pedido_id} no encontrado"], 400);
            }
            if ($pedido->estado == "terminado") {
                return response()->json(['message' => "Pedido {$pedido_id} ya se encuentra terminado"], 400);
            }

            $fecha_fin = $request->fecha_fin;
            if ($fecha_fin == null) {
                return response()->json(['message' => "fecha fin obligatorio"], 400);
            }

            $fecha_fin1 = new Carbon($pedido->fecha_fin);
            $fecha_fin2 = new Carbon($fecha_fin);
            if ($fecha_fin1->format('Y-m-d H:i:s') !== $fecha_fin2->format('Y-m-d H:i:s')) {
                return response()->json(['message' => "fecha fin ha sido renovada {$fecha_fin2} a {$fecha_fin1}"], 400);
            }
            $pedido->estado = "terminado";
            $total = $pedido->cantidad_horas * $pedido->Mesa->precio;
            $pedido->total = $total;
            $pedido->save();
            try {
                $this->switch($pedido->Mesa, "off");
            } catch (\Throwable $th) {
                return response()->json(['message' => "Pedido {$pedido_id} terminado, pero hubo un error al apagar la luz, mesa: {$pedido->Mesa->nombre}"], 200);
            }
            return response()->json(['message' => "Pedido {$pedido_id} terminado"], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => "Error al terminar el pedido"], 500);
        }
    }
}
