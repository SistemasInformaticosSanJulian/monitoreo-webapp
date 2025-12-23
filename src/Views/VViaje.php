<?php

declare(strict_types=1);

namespace App\Views;

class VViaje
{
    public function showForm(array $moviles, array $viajes, array $viaje=[]): void
    {
        $title = 'Datos del viaje';
        $content = '../templates/viaje/formulario.html';
        include '../templates/layouts/base.html';
    }
}
