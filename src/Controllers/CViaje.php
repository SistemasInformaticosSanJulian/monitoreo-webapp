<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\MMonitoreo;
use App\Models\MMovil;
use App\Models\MViaje;
use App\Utils\Ulid;
use App\Views\VViaje;

class CViaje
{
    private VViaje $view;
    private MViaje $model;
    private MMovil $modelMovil;
private MMonitoreo $modelMonitoreo;

    public function __construct()
    {
        $this->view = new VViaje();
        $this->model = new MViaje();
        $this->modelMovil = new MMovil();
        $this->modelMonitoreo = new MMonitoreo();
    }

    public function showForm(int $id = 0): void
    {
        $moviles = $this->modelMovil->findAll();
        $viaje = $this->model->find($id);
        $viajes = $this->model->findAll();
        $this->view->showForm($moviles, $viajes, $viaje);
    }

    public function store(array $request): void
    {
        if ($request['id'] == 0){
            $request['codigo'] = Ulid::generate(6);
        }

        $this->model->setRequest($request);
        $viaje = $this->model->save();
        if (!array_key_exists('error', $viaje)) {
            $monitoreo = [
              'latitud' => 0,
                'longitud' => 0,
                'codigo' => $viaje['codigo'],
                'viaje_id' => $viaje['id']
            ];

            $this->modelMonitoreo->setRequest($monitoreo);
            $this->modelMonitoreo->save();
            header('Location: /viaje/' . $viaje['id']);
            return;
        }
        $viaje = $request;
        $moviles = $this->modelMovil->findAll();
        $viajes = $this->model->findAll();
        $this->view->showForm($moviles, $viajes, $viaje);
    }
}
