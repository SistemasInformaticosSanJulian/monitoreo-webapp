<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\MConductor;
use App\Models\MMovil;
use App\Views\VMovil;

class CMovil
{
    private VMovil $view;
    private MMovil $model;
    private MConductor $modelConductor;

    public function __construct()
    {
        $this->view = new VMovil();
        $this->model = new MMovil();
        $this->modelConductor = new MConductor();
    }

    public function showForm(int $id = 0): void
    {
        $movil = $this->model->find($id);
        $moviles = $this->model->findAll();
        $conductores = $this->modelConductor->findAll();
        $this->view->showForm($conductores, $moviles, $movil);
    }

    public function store(array $request): void
    {
        $this->model->setRequest($request);
        $movil = $this->model->save();
        if (!array_key_exists('error', $movil)) {
            header('Location: /movil/' . $movil['id']);
            return;
        }

        $movil = $request;
        $moviles = $this->model->findAll();
        $conductores = $this->modelConductor->findAll();
        $this->view->showForm($conductores, $moviles, $movil);
    }
}
