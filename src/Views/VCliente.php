<?php

declare(strict_types=1);

namespace App\Views;

class VCliente
{
    public function showForm(array $usuario, array $cliente): void
    {
        $title = 'Datos del cliente';
        $content = '../templates/cliente/formulario.html';
        include '../templates/layouts/base.html';
    }
}
