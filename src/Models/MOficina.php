<?php

declare(strict_types=1);

namespace App\Models;

use App\Utils\Sqlite;

class MOficina
{
    private int $id;
    private string $nombre;
    private string $direccion;
    private string $celular;

    public function __construct()
    {
        $this->id = 0;
        $this->nombre = '';
        $this->direccion = '';
        $this->celular = '';
    }

    public function setRequest(array $data): void
    {
        $this->id = array_key_exists('id', $data) ? (int)$data['id'] : 0;
        $this->nombre = array_key_exists('nombre', $data) ? trim($data['nombre']) : '';
        $this->direccion = array_key_exists('direccion', $data) ? trim($data['direccion']) : '';
        $this->celular = array_key_exists('celular', $data) ? trim($data['celular']) : '';
    }

    public function find($value, string $column = 'id'): array
    {
        $query = "select * from oficina where $column=?";
        return Sqlite::fetchOne($query, [$value]);
    }

    public function findAll(): array
    {
        $query = "select * from oficina order by nombre;";
        return Sqlite::fetchAll($query);
    }

    public function save(): array
    {
        if ($this->id !== 0) {
            $query = 'update oficina set nombre=?, direccion=?, celular=? where id=?;';
            $values = [$this->nombre, $this->direccion, $this->celular, $this->id];
            $id = Sqlite::execUpdateOrDelete($query, $values);
            return $id > 0 ? $this->find($this->id) : ['error' => 'error'];
        }

        $query = 'insert into oficina (nombre, direccion, celular) values (?,?,?);';
        $values = [$this->nombre, $this->direccion, $this->celular];
        $id = Sqlite::execInsert($query, $values);
        return $id > 0 ? $this->find($id) : ['error' => 'error'];
    }
}
