<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\MUsuario;
use App\Views\VUsuario;

class CUsuario
{
    private VUsuario $view;
    private MUsuario $model;

    public function __construct()
    {
        $this->view = new VUsuario();
        $this->model = new MUsuario();
    }

    public function login(): void
    {
        $this->view->showFormLogin();
    }

    public function userRegister(): void
    {
        $this->view->showFormUserRegister();
    }

    public function createUser(array $request): void
    {
        $this->model->setRequest($request);
        $model = $this->model->save();

        $error = array_key_exists('error', $model);

        if ($error) {
            $this->view->showFormUserRegister('Existe un usuario con ese correo', true);
            return;
        }

        CSession::getInstance()->setData([
            'id' => $model['id'],
            'usuario' => $model['nombre'],
            'rol' => $model['rol'],
        ]);

        header('Location: /');
    }

    public function authenticate(array $request): void
    {
        $redirectUrl = '/login';
        $inputUser = trim($request['username']);
        $inputPassword = trim($request['password']);

        $user = $this->model->fetchUser($inputUser);

        if ($user && $this->model->passwordVerify($inputPassword, $user['contrasenia'])) {
            CSession::getInstance()->setData([
                'id' => $user['id'],
                'usuario' => $user['nombre'],
                'rol' => $user['rol']
            ]);

            $redirectUrl = '/';
        }

        header('Location: ' . $redirectUrl);
    }

    public function logout(): void
    {
        CSession::getInstance()->closeSession();
        header('Location: /login');
    }
}
