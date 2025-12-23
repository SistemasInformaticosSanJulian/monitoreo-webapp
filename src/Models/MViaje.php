<?php

namespace App\Models;

use App\Utils\Sqlite;

class MViaje
{
    private int $id;
    private string $codigo;
    private string $origen;
    private string $destino;
    private string $fechahora_salida;
    private string $fechahora_llegada;
    private string $encomienda;
    private string $direccion_entrega;
    private string $emisor;
    private string $receptor;
    private string $estado;
    private string $movil_id;

    public function __construct()
    {
        $this->id = 0;
        $this->codigo = '';
        $this->origen = '';
        $this->destino = '';
        $this->fechahora_salida = '';
        $this->fechahora_llegada = '';
        $this->encomienda = '';
        $this->direccion_entrega = '';
        $this->emisor = '';
        $this->receptor = '';
        $this->estado = '';
        $this->movil_id = 0;
    }

    public function setRequest(array $data): void
    {
        $this->id = array_key_exists('id', $data) ?
            (int)$data ['id'] : 0;
        $this->codigo = array_key_exists('codigo', $data) ?
            $data ['codigo'] : '';
        $this->origen = array_key_exists('origen', $data) ?
            $data ['origen'] : '';
        $this->destino = array_key_exists('destino', $data) ?
            $data ['destino'] : '';
        $this->fechahora_salida = array_key_exists('fechahora_salida', $data) ?
            $data ['fechahora_salida'] : date('Y-m-d H:i:s');
        $this->fechahora_llegada = array_key_exists('fechahora_llegada', $data) ?
            $data ['fechahora_llegada'] : '';
        $this->encomienda = array_key_exists('encomienda', $data) ?
            $data ['encomienda'] : '';
        $this->direccion_entrega = array_key_exists('direccion_entrega', $data) ?
            $data ['direccion_entrega'] : '';
        $this->emisor = array_key_exists('emisor', $data) ?
            $data ['emisor'] : '';
        $this->receptor = array_key_exists('receptor', $data) ?
            $data ['receptor'] : '';
        $this->estado = array_key_exists('estado', $data) ?
            $data ['estado'] : '';
        $this->movil_id = array_key_exists('movil_id', $data) ?
            (int)$data ['movil_id'] : 0;
    }

    public function find($value, string $column = 'id'): array
    {
        $query = "select * from viaje where $column=?;";
        return Sqlite::fetchOne($query, [$value]);
    }

    public function findAll(): array
    {
        $query = "select v.*, m.interno from viaje v, movil m where v.movil_id = m.id ";
        $query .= "order by fechahora_salida desc limit 100;";
        return Sqlite::fetchAll($query);
    }

    public function save(): array
    {
        if ($this->id !== 0) {
            $query = 'update viaje set origen=?, destino=?, fechahora_salida=?,fechahora_llegada=?,encomienda=?,direccion_entrega=?,emisor=?,receptor=?,estado=?,movil_id=? where id=? ;';
            $values = [$this->origen, $this->destino, $this->fechahora_salida, $this->fechahora_llegada, $this->encomienda, $this->direccion_entrega, $this->emisor, $this->receptor, $this->estado, $this->movil_id, $this->id];
            $id = Sqlite::execUpdateOrDelete($query, $values);
            return $id > 0 ? $this->find($this->id) : ['error' => 'error'];
        }
        $query = 'insert into viaje (codigo, origen, destino, fechahora_salida, fechahora_llegada, encomienda, direccion_entrega, emisor, receptor, estado, movil_id) values (?,?,?,?,?,?,?,?,?,?,?);';
        $values = [$this->codigo, $this->origen, $this->destino, $this->fechahora_salida, $this->fechahora_llegada, $this->encomienda, $this->direccion_entrega, $this->emisor, $this->receptor, $this->estado, $this->movil_id];
        $id = Sqlite::execInsert($query, $values);
        return $id > 0 ? $this->find($id) : ['error' => 'error'];
    }
}
