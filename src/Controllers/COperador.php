<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\MOperador;
use App\Models\MOficina;
use App\Views\VOperador;

class COperador
{
    private VOperador $view;
    private MOperador $model;
    private MOficina $modelOficina;

    public function __construct()
    {
        $this->view = new VOperador();
        $this->model = new MOperador();
        $this->modelOficina = new MOficina();
    }

    public function showForm(int $id = 0): void
    {
        $operador = $this->model->find($id);
        $operadores = $this->model->findAll();
        $oficinas = $this->modelOficina->findAll();
        $this->view->showForm($oficinas, $operadores, $operador);
    }

    public function store(array $request): void
    {
        $this->model->setRequest($request);
        $operador = $this->model->save();
        if (!array_key_exists('error', $operador)) {
            header('Location: /operador/' . $operador['id']);
            return;
        }

        $operadores = $this->model->findAll();
        $oficinas = $this->modelOficina->findAll();
        $this->view->showForm($operadores, $oficinas, $operador);
    }
}
