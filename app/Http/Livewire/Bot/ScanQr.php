<?php

namespace App\Http\Livewire\Bot;

use Exception;
use Livewire\Component;
use GuzzleHttp\Client;

class ScanQr extends Component
{
    public $imageQr;

    public function render()
    {
        return view('livewire.bot.scan-qr');
    }

    public function mount()
    {
        $this->getImageQr();
    }

    public function getImageQr()
    {
        try {
            $client = new Client();
            $botHost = config('app.BOT_HOST');
            $response = $client->request('GET', "{$botHost}/qr-base64");

            $contents = $response->getBody()->getContents();
            $data = json_decode($contents, true);
            $this->imageQr = $data['imageBase64'];
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $contents = $response->getBody()->getContents();
                $data = json_decode($contents, true);
                throw new Exception("Error al enviar el mensaje", $e->getMessage());
            }
            throw new Exception("Error al enviar el mensaje", 500);
        }
    }
}
