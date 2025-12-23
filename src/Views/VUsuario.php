<?php

declare(strict_types=1);

namespace App\Views;

class VUsuario
{
    public function showFormLogin(): void
    {
        $title = 'Módulo Tecnológico Productivo | BTH San Julián';
        $content = '../templates/auth/login.html';
        include '../templates/layouts/base-login.html';
    }

    public function showFormUserRegister(string $message = '', bool $isAnError = false): void
    {
        $scripts = ['/assets/js/register.js'];
        $title = 'Registro de Usuario';
        $content = '../templates/usuario/form.html';
        include '../templates/layouts/base-login.html';
    }
}
