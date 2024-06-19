<?php

namespace App\Http\Livewire\Oferta\Modals;

use App\Exceptions\ExceptionArray;
use App\Models\Cliente;
use App\Models\ProductoOferta;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class EnviarOfertaModal extends Component
{

    protected $listeners = ['openEnviarOfertaModal'];

    public $modalSend = false;
    public $oferta;
    public $selectedClientes = [];
    public $descripcion = "";

    public function render()
    {
        $clientes = Cliente::all();
        return view('livewire.oferta.modals.enviar-oferta-modal', compact('clientes'));
    }

    public function openEnviarOfertaModal($id)
    {
        $this->oferta = ProductoOferta::find($id);
        $oferta = $this->oferta;
        $producto = $oferta->Producto;
        $this->descripcion = "{$producto->nombre} ({$producto->descripcion}) {$oferta->descripcion}. Cantidad: {$oferta->cantidad}, Precio: {$oferta->precio} Bs";
        $this->modalSend = true;
    }

    public function send()
    {
        $clientes = Cliente::whereIn('id', $this->selectedClientes)->get();
        $oferta = $this->oferta;
        $producto = $oferta->Producto;
        // $descripcion = "{$producto->nombre} ({$producto->descripcion}) {$oferta->descripcion}. Cantidad: {$oferta->cantidad}, Precio: {$oferta->precio} Bs";
        $descripcion = $this->descripcion;
        $base64 = $this->convertImageToBase64($oferta->imagen_path);
        foreach ($clientes as $cliente) {
            $this->sendMessage($cliente->telefono, $descripcion, $base64);
        }
        // $this->emit('updateOfertaTable');
        $this->limpiar();
    }

    public function cancelar()
    {
        $this->limpiar();
    }

    public function limpiar()
    {
        $this->oferta = null;
        $this->modalSend = false;
        $this->descripcion = "";
        $this->selectedClientes = [];
    }

    public function sendMessage($phoneNumber, $message, $base64 = null)
    {
        try {
            $client = new Client();
            $botHost = config('app.BOT_HOST');
            $response = $client->request('POST', "{$botHost}/sendMessage", [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'phoneNumber' => $phoneNumber,
                    'message' => $message,
                    'fileBase64' => $base64,
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

    public function convertImageToBase64($imagePath = "")
    {
        // Verifica que el archivo exista
        $imagePath = ltrim($imagePath, '/storage');
        if (Storage::disk('public')->exists($imagePath)) {
            $fileContent = Storage::disk('public')->get($imagePath);
            $base64 = base64_encode($fileContent);
            // Opcional: sirve pero sale error de sintaxi
            // $mimeType = Storage::disk('public')->mimeType($imagePath);
            $fullPath = storage_path('app/public/' . $imagePath);
            $mimeType = mime_content_type($fullPath);
            $base64WithMime = 'data:' . $mimeType . ';base64,' . $base64;
            return $base64WithMime;
        } else {
            return null;
        }
    }
}
