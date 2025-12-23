<?php

namespace App\Models;

use App\Utils\Sqlite;

class MMovil
{
    private int $id;
    private string $interno;
    private string $placa;
    private int $cantidad_asientos;
    private int $conductor_id;

    public function __construct()
    {
        $this->id = 0;
        $this->interno = '';
        $this->placa = '';
        $this->cantidad_asientos = 0;
        $this->conductor_id = 0;
    }

    public function setRequest(array $data): void
    {
        $this->id = array_key_exists('id', $data) ?
            (int)$data ['id'] : 0;
        $this->interno = array_key_exists('interno', $data) ?
            $data ['interno'] : '';
        $this->placa = array_key_exists('placa', $data) ?
            $data ['placa'] : '';
        $this->cantidad_asientos = array_key_exists('cantidad_asientos', $data) ?
            (int)$data ['cantidad_asientos'] : 0;
        $this->conductor_id = array_key_exists('conductor_id', $data) ?
            (int)$data ['conductor_id'] : 0;
    }

    public function find($value, string $column = 'id'): array
    {
        $query = "select * from movil where $column=?;";
        return Sqlite::fetchOne($query, [$value]);
    }

    public function findAll(): array
    {
        $query = "select m.*, c.nombres, c.apellidos, c.celular from movil m, conductor c ";
        $query .= "where m.conductor_id = c.id order by interno;";
        return Sqlite::fetchAll($query);
    }

    public function save(): array
    {
        if ($this->id !== 0) {
            $query = 'update movil set interno=?, placa=?, cantidad_asientos=?, conductor_id=? where id=? ;';
            $values = [$this->interno, $this->placa, $this->cantidad_asientos, $this->conductor_id, $this->id];
            $id = Sqlite::execUpdateOrDelete($query, $values);
            return $id > 0 ? $this->find($this->id) : ['error' => 'error'];
        }
        $query = 'insert into movil (interno, placa, cantidad_asientos, conductor_id) values (?,?,?,?);';
        $values = [$this->interno, $this->placa, $this->cantidad_asientos, $this->conductor_id];
        $id = Sqlite::execInsert($query, $values);
        return $id > 0 ? $this->find($id) : ['error' => 'error'];
    }
}
