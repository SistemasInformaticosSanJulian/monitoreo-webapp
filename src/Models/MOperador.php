<?php

declare(strict_types=1);

namespace App\Models;

use App\Utils\Sqlite;

class MOperador
{
    private int $id;
    private string $nombre;
    private string $contrasenia;
    public function __construct()
    {
        $this->id = 0;
        $this->nombre = '';
        $this->contrasenia = '';
        $this->oficina_id = 0;
    }

    public function setRequest(array $data): void
    {
        $this->id = array_key_exists('id', $data) ? (int)$data['id'] : 0;
        $this->nombre = array_key_exists('username', $data) ? trim($data['username']) : '';
        if (array_key_exists('password', $data) && !empty($data['password'])) {
            $this->contrasenia = trim($data['password']);
        }
        $this->oficina_id = array_key_exists('oficina_id', $data) ? (int)$data['oficina_id'] : 0;
    }

    public function find($id): array
    {
        $query = "SELECT u.*, o.oficina_id, off.nombre as oficina_nombre 
                  FROM usuario u 
                  LEFT JOIN operador o ON u.id = o.usuario_id 
                  LEFT JOIN oficina off ON o.oficina_id = off.id
                  WHERE u.id=? AND u.rol='operador' AND u.soft_delete=0;";
        return Sqlite::fetchOne($query, [$id]);
    }

    public function findAll(): array
    {
        $query = "SELECT u.*, off.nombre as oficina_nombre 
                  FROM usuario u 
                  LEFT JOIN operador o ON u.id = o.usuario_id 
                  LEFT JOIN oficina off ON o.oficina_id = off.id
                  WHERE u.rol='operador' AND u.soft_delete=0 ORDER BY u.nombre;";
        return Sqlite::fetchAll($query);
    }

    public function save(): array
    {
        if ($this->id !== 0) {
            // Update Usuario
            if (!empty($this->contrasenia)) {
                $query = 'update usuario set nombre=?, contrasenia=?, updated_at=? where id=? and rol=\'operador\';';
                $values = [$this->nombre, $this->passwordHash($this->contrasenia), date('Y-m-d H:i:s'), $this->id];
            } else {
                $query = 'update usuario set nombre=?, updated_at=? where id=? and rol=\'operador\';';
                $values = [$this->nombre, date('Y-m-d H:i:s'), $this->id];
            }
            Sqlite::execUpdateOrDelete($query, $values);

            // Update or Insert Operador profile
            $profile = Sqlite::fetchOne("select id from operador where usuario_id=?;", [$this->id]);
            if ($profile) {
                Sqlite::execUpdateOrDelete("update operador set oficina_id=? where usuario_id=?;", [$this->oficina_id, $this->id]);
            } else {
                Sqlite::execInsert("insert into operador (usuario_id, oficina_id) values (?,?);", [$this->id, $this->oficina_id]);
            }

            return $this->find($this->id);
        }

        // Insert Usuario
        $query = 'insert into usuario (nombre, contrasenia, rol, updated_at) values (?,?,?,?);';
        $values = [$this->nombre, $this->passwordHash($this->contrasenia), 'operador', date('Y-m-d H:i:s')];
        $usuarioId = Sqlite::execInsert($query, $values);

        if ($usuarioId > 0) {
            // Insert Operador profile
            Sqlite::execInsert("insert into operador (usuario_id, oficina_id) values (?,?);", [$usuarioId, $this->oficina_id]);
            return $this->find($usuarioId);
        }

        return ['error' => 'error'];
    }

    private function passwordHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);
    }
}
