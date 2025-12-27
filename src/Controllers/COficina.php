<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\MOficina;
use App\Views\VOficina;

class COficina
{
    private VOficina $view;
    private MOficina $model;

    public function __construct()
    {
        $this->view = new VOficina();
        $this->model = new MOficina();
    }

    public function showForm(int $id = 0): void
    {
        $oficina = $this->model->find($id);
        $oficinas = $this->model->findAll();
        $this->view->showForm($oficinas, $oficina);
    }

    public function store(array $request): void
    {
        $this->model->setRequest($request);
        $oficina = $this->model->save();
        if (!array_key_exists('error', $oficina)) {
            header('Location: /oficina/' . $oficina['id']);
            return;
        }

        $oficinas = $this->model->findAll();
        $this->view->showForm($oficinas, $oficina);
    }
}
