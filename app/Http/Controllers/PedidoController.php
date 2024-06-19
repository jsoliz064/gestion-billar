<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionArray;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\Producto;
use App\Traits\ResponseTrait;
use App\Traits\ReverseGeocodeTrait;
use App\Traits\ValidateRequestTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class PedidoController extends Controller
{
    use ResponseTrait, ValidateRequestTrait, ReverseGeocodeTrait;

    public function create(Request $request)
    {
        try {
            $this->ValidatorRequest($request->all(), [
                'telefono' => 'required|numeric|digits:11',
                'fecha_entrega' => 'required|date|date_format:Y-m-d',
                'descripcion' => 'nullable|string',
                'latitud' => 'required|numeric',
                'longitud' => 'required|numeric',
                'detalles' => 'required|array'
            ]);

            $telefono = $request->telefono;
            $client = Cliente::where('telefono', $telefono)->first();
            if ($client == null) {
                throw new ExceptionArray("Cliente no registrado");
            }

            $pedido = DB::transaction(function () use ($request, $client) {
                $pedido = Pedido::create([
                    'fecha_entrega' => $request->fecha_entrega,
                    'descripcion' => $request->descripcion,
                    'latitud' => $request->latitud,
                    'longitud' => $request->longitud,
                    'cliente_id' => $client->id
                ]);
                $total = 0;
                foreach ($request->detalles as $detalle) {

                    $this->ValidatorRequest($detalle, [
                        'id' => 'required|numeric',
                        'cantidad' => 'required|numeric',
                    ], "Error de parametros en detalles");

                    $producto = Producto::find($detalle['id']);
                    if ($producto) {
                        $subtotal = $producto->precio * $detalle['cantidad'];
                        $total = $total + $subtotal;
                        PedidoDetalle::create([
                            'cantidad' => $detalle['cantidad'],
                            'precio' => $producto->precio,
                            'subtotal' => $subtotal,
                            'producto_id' => $producto->id,
                            'pedido_id' => $pedido->id
                        ]);
                    }
                }

                $pedido->update([
                    'subtotal' => $total,
                    'total' => $total,
                ]);

                $client->addAddress($request->latitud, $request->longitud);

                return $pedido;
            });

            return response()->json(['message' => 'Pedido registrado exitosamente', 'pedido' => $pedido], 200);
        } catch (ExceptionArray $th) {
            return $this->ResponseThrow($th);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function switch($status)
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

    public function reverseGeocode(Request $request)
    {
        try {
            $this->ValidatorRequest($request->all(), [
                'lat' => 'required|numeric',
                'lng' => 'required|numeric',
            ]);

            $lat = $request->lat;
            $lng = $request->lng;

            $data = $this->getAddress($lat, $lng);
            return response()->json(['address' => $data], 200);
        } catch (ExceptionArray $th) {
            return $this->ResponseThrow($th);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
