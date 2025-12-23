<?php

declare(strict_types=1);

namespace App\Views;

class VConductor
{
    public function showForm(array $conductores, array $conductor = []): void
    {
        $title = 'Datos del conductor';
        $content = '../templates/conductor/formulario.html';
        include '../templates/layouts/base.html';
    }
}
