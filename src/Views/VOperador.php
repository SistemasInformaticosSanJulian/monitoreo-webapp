<?php

declare(strict_types=1);

namespace App\Views;

class VOperador
{
    public function showForm(array $operadores, array $oficinas, array $operador = []): void
    {
        $title = 'Gestión de Operadores';
        $content = '../templates/operador/formulario.html';
        include '../templates/layouts/base.html';
    }
}
