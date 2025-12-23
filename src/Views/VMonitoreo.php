<?php

declare(strict_types=1);

namespace App\Views;

class VMonitoreo
{

    public function showForm(array $encomienda): void
    {
        $title = 'Datos del monitoreo';
        $content = '../templates/monitoreo/formulario.html';
        include '../templates/layouts/base.html';
    }
}
