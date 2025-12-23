<?php

namespace App\Models;

use App\Utils\Sqlite;

class MMonitoreo
{
    private int $id;
    private string $latitud;
    private string $longitud;
    private string $codigo;
    private int $viaje_id;

    public function __construct()
    {
        $this->id = 0;
        $this->latitud = '';
        $this->longitud = '';
        $this->codigo = '';
        $this->viaje_id = 0;
    }

    public function setRequest(array $data): void
    {
        $this->id = array_key_exists('id', $data) ?
            (int)$data ['id'] : 0;
        $this->latitud = array_key_exists('latitud', $data) ?
            $data ['latitud'] : '';
        $this->longitud = array_key_exists('longitud', $data) ?
            $data ['longitud'] : '';
        $this->codigo = array_key_exists('codigo', $data) ?
            $data ['codigo'] : '';
        $this->viaje_id = array_key_exists('viaje_id', $data) ?
            (int)$data ['viaje_id'] : 0;
    }

    public function find($value, string $column = 'id'): array
    {
        $query = "select * from monitoreo where $column=?;";
        return Sqlite::fetchOne($query, [$value]);
    }

    public function findAll(): array
    {
        $query = "select * from monitoreo order by id desc ;";
        return Sqlite::fetchAll($query);
    }

    public function findEncomiendaByCodigo(string $codigo): array
    {
        $query = "SELECT * ";
        $query .= "FROM viaje v, movil m, monitoreo g, conductor c ";
        $query .= "WHERE v.movil_id=m.id AND v.id=g.viaje_id AND m.conductor_id=c.id AND v.codigo=?;";

        return Sqlite::fetchOne($query, [trim($codigo)]);
    }

    public function save(): array
    {
        if ($this->id !== 0) {
            $query = 'update monitoreo set latitud=?, longitud=? where viaje_id=? ;';
            $values = [$this->latitud, $this->longitud, $this->viaje_id];
            $id = Sqlite::execUpdateOrDelete($query, $values);
            return $id > 0 ? $this->find($this->viaje_id, 'viaje_id') : ['error' => 'error'];
        }
        $query = 'insert into monitoreo (latitud,longitud,codigo,viaje_id) values (?,?,?,?);';
        $values = [$this->latitud, $this->longitud, $this->codigo, $this->viaje_id];
        $id = Sqlite::execInsert($query, $values);
        return $id > 0 ? $this->find($id) : ['error' => 'error'];
    }

    public function updatePosition(array $request): bool
    {
        $latitud = $request['latitud'] ?? '';
        $longitud = $request['longitud'] ?? '';
        $codigo = $request['codigo'] ?? '';

        $query = 'update monitoreo set latitud=?, longitud=? where codigo=? ;';
        $values = [$latitud, $longitud, $codigo];
        return Sqlite::execUpdateOrDelete($query, $values) > 0;
    }
}
