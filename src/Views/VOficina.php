<?php

declare(strict_types=1);

namespace App\Views;

class VOficina
{
    public function showForm(array $oficinas, array $oficina = []): void
    {
        $title = 'Datos de la oficina';
        $content = '../templates/oficina/formulario.html';
        include '../templates/layouts/base.html';
    }
}
