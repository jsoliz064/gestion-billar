<?php

namespace App\Traits;

use App\Exceptions\ExceptionArray;
use App\Models\Mesa;
use GuzzleHttp\Client;

trait ServerTrait
{
    public function switch(Mesa $mesa, $status)
    {
        $this->sendSwitchRequest($mesa, $status, null);
    }

    public function scheduleSwitch(Mesa $mesa, $status, $datetime)
    {
        if ($datetime) {
            $this->sendSwitchRequest($mesa, $status, $datetime);
        } else {
            session()->flash('error', 'Por favor, selecciona una fecha y hora.');
        }
    }

    private function sendSwitchRequest(Mesa $mesa, $status, $datetime)
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
}
