<?php

declare(strict_types=1);

namespace App\Models;

use App\Utils\Sqlite;

class MOperador
{
    private int $id;
    private string $nombre;
    private string $contrasenia;
    private string $rol;
    private int $oficina_id;

    public function __construct()
    {
        $this->id = 0;
        $this->nombre = '';
        $this->contrasenia = '';
        $this->rol = '';
        $this->oficina_id = 0;
    }

    public function setRequest(array $data): void
    {
        $this->id = array_key_exists('id', $data) ? (int)$data['id'] : 0;
        $this->nombre = array_key_exists('username', $data) ? trim($data['username']) : '';
        if (array_key_exists('password', $data) && !empty($data['password'])) {
            $this->contrasenia = trim($data['password']);
        }
        $this->rol = array_key_exists('rol', $data) ? trim($data['rol']) : 'operador';
        $this->oficina_id = array_key_exists('oficina_id', $data) ? (int)$data['oficina_id'] : 0;
    }

    public function find($id): array
    {
        $query = "SELECT op.*, of.nombre as oficina 
                  FROM operador op inner join oficina of on 
                  op.oficina_id = of.id
                  WHERE op.id=$1 and op.rol='operador' AND op.soft_delete=0";
        return Sqlite::fetchOne($query, [$id]);
    }

    public function findAll(): array
    {
        $query = "SELECT op.id, op.nombre, op.rol, of.nombre as oficina 
                  FROM operador op inner join oficina of on 
                  op.oficina_id = of.id
                  WHERE op.rol='operador' AND op.soft_delete=0 ORDER BY op.nombre;";
        return Sqlite::fetchAll($query);
    }

    public function save(): array
    {
        if ($this->id !== 0) {
            $query = 'update operador set nombre=?, contrasenia=?, rol=? ,oficina_id=?, updated_at=? where id=?;';
            $values = [$this->nombre, $this->passwordHash($this->contrasenia), $this->rol, $this->oficina_id, date('Y-m-d H:i:s'), $this->id];
            $id = Sqlite::execUpdateOrDelete($query, $values);
            return $id !== 0 ? $this->find($id) : ['error' => 'Error'];
        }

        $query = 'insert into operador (nombre,contrasenia,rol,oficina_id,updated_at) values(?,?,?,?,?)';
        $values = [$this->nombre, $this->passwordHash($this->contrasenia), $this->rol, $this->oficina_id, date('Y-m-d H:i:s')];
        $id = Sqlite::execInsert($query, $values);
        return $id !== 0 ? $this->find($id) : ['error' => 'Error'];
    }

    private function passwordHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);
    }
}
