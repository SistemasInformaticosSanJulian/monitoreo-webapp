<?php

namespace App\Models;

use App\Utils\Sqlite;

class MConductor
{
    private int $id;
    private string $nombres;
    private string $apellidos;
    private string $carnet;
    private string $fecha_nacimiento;
    private string $celular;
    private string $correo;
    private string $direccion;

    public function __construct()
    {
        $this->id = 0;
        $this->nombres = '';
        $this->apellidos = '';
        $this->carnet = '';
        $this->fecha_nacimiento = '';
        $this->celular = '';
        $this->correo = '';
        $this->direccion = '';
    }

    public function setRequest(array $data): void
    {
        $this->id = array_key_exists('id', $data) ?
            (int)$data ['id'] : 0;
        $this->nombres = array_key_exists('nombres', $data) ?
            $data ['nombres'] : '';
        $this->apellidos = array_key_exists('apellidos', $data) ?
            $data ['apellidos'] : '';
        $this->carnet = array_key_exists('carnet', $data) ?
            $data ['carnet'] : '';
        $this->fecha_nacimiento = array_key_exists('fecha_nacimiento', $data) ?
            $data ['fecha_nacimiento'] : '';
        $this->celular = array_key_exists('celular', $data) ?
            $data ['celular'] : '';
        $this->correo = array_key_exists('correo', $data) ?
            $data ['correo'] : '';
        $this->direccion = \array_key_exists('direccion', $data) ?
            $data ['direccion'] : '';
    }

    public function find($value, string $column = 'id'): array
    {
        $querry = "select * from conductor where $column=?;";
        return Sqlite::fetchOne($querry, [$value]);
    }

    public function findAll(): array
    {
        $querry = "select * from conductor order by nombres;";
        return Sqlite::fetchAll($querry);
    }

    public function save(): array
    {
        if ($this->id !== 0) {
            $query = 'update conductor set nombres=?, apellidos=?, carnet=?, fecha_nacimiento=?, celular=?, correo=?, direccion=? where id=?;';
            $values = [$this->nombres, $this->apellidos, $this->carnet, $this->fecha_nacimiento, $this->celular, $this->correo, $this->direccion, $this->id];
            $id = Sqlite::execUpdateOrDelete($query, $values);
            return $id > 0 ? $this->find($this->id) : ['error' => 'error'];
        }

        $query = 'insert into conductor (nombres, apellidos, carnet,fecha_nacimiento, celular, correo, direccion) values (?,?,?,?,?,?,?);';
        $values = [$this->nombres, $this->apellidos, $this->carnet, $this->fecha_nacimiento, $this->celular, $this->correo, $this->direccion];
        $id = Sqlite::execInsert($query, $values);
        return $id > 0 ? $this->find($id) : ['error' => 'error'];
    }
}
