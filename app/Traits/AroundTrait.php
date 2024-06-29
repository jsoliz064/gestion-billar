<?php

namespace App\Traits;


trait AroundTrait
{
    public function around($cantidad_horas)
    {
        $horas = floor($cantidad_horas);
        $minutos = $cantidad_horas - $horas;

        if ($minutos <= 0.01) {
            return $cantidad_horas;
        }

        if ($minutos > 0.01 && $minutos <= 0.25) {
            $minutos = 0.25;
        } elseif ($minutos > 0.25 && $minutos <= 0.5) {
            $minutos = 0.5;
        } elseif ($minutos > 0.5 && $minutos <= 0.75) {
            $minutos = 0.75;
        } else {
            $horas += 1;
            $minutos = 0;
        }

        return $horas + $minutos;
    }
}
