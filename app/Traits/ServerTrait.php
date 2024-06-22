<?php

namespace App\Traits;

use App\Exceptions\ExceptionArray;
use App\Models\Mesa;
use Exception;
use GuzzleHttp\Client;

trait ServerTrait
{
    public function switch(Mesa $mesa, $status)
    {
        $this->sendSwitchRequest($mesa, $status, null);
    }

    public function scheduleSwitch(Mesa $mesa, $status, $datetime, $pedido_id = null)
    {
        if ($datetime) {
            $this->sendSwitchRequest($mesa, $status, $datetime, $pedido_id);
        } else {
            throw new Exception('Por favor, selecciona una fecha y hora.');
        }
    }

    private function sendSwitchRequest(Mesa $mesa, $status, $datetime, $pedido_id = null)
    {
        try {
            $host_luces = "http://localhost:3000";
            $client = new Client();
            $device_id = $mesa->device_id;
            $host = $mesa->host;
            $port = $mesa->port;
            $endpoint = $datetime ? 'schedule-switch' : 'switch';

            $response = $client->request('POST', "{$host_luces}/{$endpoint}", [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'ip' => $host,
                    'port' => $port,
                    'deviceid' => $device_id,
                    'outlet' => 0,
                    'action' => $status,
                    'datetime' => $datetime,
                    'pedido_id' => $pedido_id
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
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
