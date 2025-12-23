<?php

declare(strict_types=1);

namespace App\Models;

use App\Utils\Sqlite;

class MCliente
{
  private int $id;
  private string $nombres;
  private string $apellidos;
  private string $direccion;
  private string $celular;
  private string $correo_electronico;
  private int $usuario_id;

  public function __construct()
  {
    $this->id = 0;
    $this->nombres = '';
    $this->apellidos = '';
    $this->direccion = '';
    $this->celular = '';
    $this->correo_electronico = '';
    $this->usuario_id = 0;
  }

  public function setRequest(array $data): void
  {
    $this->id = \array_key_exists('id', $data) ?
      (int)$data['id'] : 0;
    $this->nombres = \array_key_exists('nombres', $data) ?
      trim($data['nombres']) : '';
    $this->apellidos = \array_key_exists('apellidos', $data) ?
      trim($data['apellidos']) : '';
    $this->direccion = \array_key_exists('direccion', $data) ?
      trim($data['direccion']) : '';
    $this->celular = \array_key_exists('celular', $data) ?
      trim($data['celular']) : '';
    $this->correo_electronico = \array_key_exists('correo_electronico', $data) ?
      trim($data['correo_electronico']) : '';
    $this->usuario_id = \array_key_exists('usuario_id', $data) ?
      (int)$data['usuario_id'] : 0;
  }

  public function save(): array
  {
    if ($this->id !== 0) {
      $query = 'update cliente set nombres=?, apellidos=?, direccion=?, celular=?, correo_electronico=?, usuario_id=? where id=?;';
      $values = [$this->nombres, $this->apellidos, $this->direccion, $this->celular, $this->correo_electronico, $this->usuario_id, $this->id];
      $id = Sqlite::execUpdateOrDelete($query, $values);
      return $id !== 0 ? $this->find($this->id) : ['error' => 'Error'];
    }

    $query = 'insert into cliente (nombres,apellidos,direccion,celular,correo_electronico,usuario_id) ';
    $query .= 'values(?,?,?,?,?,?)';
    $values = [$this->nombres, $this->apellidos, $this->direccion, $this->celular, $this->correo_electronico, $this->usuario_id];
    $id = Sqlite::execInsert($query, $values);
    return $id !== 0 ? $this->find($id) : ['error' => 'Error'];
  }

  public function find($value, string $column = 'id'): array
  {
    $query = "select * from cliente where $column=?;";
    return Sqlite::fetchOne($query, [$value]);
  }
}
