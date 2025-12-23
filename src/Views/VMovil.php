<?php

declare(strict_types=1);

namespace App\Views;

class VMovil
{
    public function showForm(array $conductores, array $moviles, array $movil = []): void
    {
        $title = 'Datos del movil';
        $content = '../templates/movil/formulario.html';
        include '../templates/layouts/base.html';
    }
}
