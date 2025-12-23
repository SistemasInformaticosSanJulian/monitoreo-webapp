<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\MConductor;
use App\Views\VConductor;

class CConductor
{
    private VConductor $view;
    private MConductor $model;

    public function __construct()
    {
        $this->view = new VConductor();
        $this->model = new MConductor();
    }

    public function showForm(int $id = 0): void
    {
        $conductor = $this->model->find($id);
        $conductores = $this->model->findAll();
        $this->view->showForm($conductores, $conductor);
    }

    public function store(array $request): void
    {
        $this->model->setRequest($request);
        $conductor = $this->model->save();
        if (!array_key_exists('error', $conductor)) {
            header('Location: /conductor/' . $conductor['id']);
            return;
        }

        $conductores = $this->model->findAll();
        $this->view->showForm($conductores, $conductor);
    }
}