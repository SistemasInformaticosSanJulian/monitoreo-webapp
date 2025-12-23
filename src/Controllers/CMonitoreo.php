<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\MMonitoreo;
use App\Views\VMonitoreo;

class CMonitoreo
{
    private VMonitoreo $view;
    private MMonitoreo $model;

    public function __construct()
    {
        $this->view = new VMonitoreo();
        $this->model = new Mmonitoreo();
    }

    public function showForm(string $codigo = ''): void
    {
        $encomienda = $this->model->findEncomiendaByCodigo($codigo);
        $this->view->showForm($encomienda);
    }

    public function store(array $request): void
    {
        $this->model->setRequest($request);
        $monitoreo = $this->model->save();
        if (!array_key_exists('error', $monitoreo)) {
            header('Location: /monitoreo/' . $monitoreo['id']);
            return;
        }

        $monitoreos = $this->model->findAll();
        $this->view->showForm($monitoreos, $monitoreo);
    }

    public function findEncomiendaByCodigo(string $codigo): void
    {
        $encomienda = $this->model->findEncomiendaByCodigo($codigo);
        $this->view->showEncomienda($encomienda);
    }

    public function updatePosition(array $request): void
    {
        $this->model->updatePosition($request) ?
            http_response_code(200) : http_response_code(404);

    }
}
