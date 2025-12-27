<?php

declare(strict_types=1);

namespace App\Models;

use App\Utils\Sqlite;

class MUsuario
{
    private int $id;
    private string $nombre;
    private string $contrasenia;
    
    public function __construct()
    {
        $this->id = 0;
        $this->nombre = '';
        $this->contrasenia = '';
    }

    public function setRequest(array $data): void
    {
        $this->id = \array_key_exists('id', $data) ? (int)$data['id'] : 0;
        $this->nombre = \array_key_exists('username', $data) ? trim($data['username']) : '';
        $this->contrasenia = \array_key_exists('password', $data) ? trim($data['password']) : '';
    }

    public function save(): array
    {
        if ($this->id !== 0) {
            $query = 'update usuario set nombre=?, contrasenia=?, updated_at=? where id=?;';
            $values = [$this->nombre, $this->passwordHash($this->contrasenia), date('Y-m-d H:i:s'), $this->id];
            $id = Sqlite::execUpdateOrDelete($query, $values);
            return $id !== 0 ? $this->find($id) : ['error' => 'Error'];
        }

        $query = 'insert into usuario (nombre,contrasenia,updated_at) values(?,?,?)';
        $values = [$this->nombre, $this->passwordHash($this->contrasenia), date('Y-m-d H:i:s')];
        $id = Sqlite::execInsert($query, $values);
        return $id !== 0 ? $this->find($id) : ['error' => 'Error'];
    }

    public function fetchUser(string $nombre): array
    {
        $query = "select * from usuario where nombre=?;";
        return Sqlite::fetchOne($query, [$nombre]);
    }

    public function find($value, string $column = 'id'): array
    {
        $query = "select * from usuario where $column=?;";
        return Sqlite::fetchOne($query, [$value]);
    }

    private function passwordHash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);
    }

    public function passwordVerify(string $passwordPlain, string $passwordHash): bool
    {
        return password_verify($passwordPlain, $passwordHash);
    }
}
