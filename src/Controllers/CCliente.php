<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\MCliente;
use App\Views\VCliente;

class CCliente
{
  private VCliente $view;
  private MCliente $model;

  public function __construct()
  {
    $this->view = new VCliente();
    $this->model = new MCliente();
  }

  public function showForm(): void
  {
    $usuario['id'] = CSession::getInstance()->getUserId();
    $usuario['nombre'] = CSession::getInstance()->getUserName();

    $cliente = $this->model->find($usuario['id'], 'usuario_id');
    $this->view->showForm($usuario, $cliente);
  }

  public function store(array $request): void
  {
    $this->model->setRequest($request);
    $cliente = $this->model->save();
    if (!array_key_exists('error', $cliente)) {
      header('Location: /cliente');
      return;
    }

    $usuario['id'] = CSession::getInstance()->getUserId();
    $usuario['nombre'] = CSession::getInstance()->getUserName();
    $this->view->showForm($usuario, $cliente);
  }
}
