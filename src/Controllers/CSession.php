<?php

declare(strict_types=1);

namespace App\Controllers;

class CSession
{
    private static $session;

    private function __construct()
    {
    }

    public static function getInstance(): CSession
    {
        if (!self::$session instanceof self) {
            self::$session = new self();
        }

        return self::$session;
    }

    public function start(): void
    {
        session_start();
    }

    public function setData(array $data): void
    {
        $_SESSION['rol'] = '';
        foreach ($data as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    public function getUserId(): int
    {
        return array_key_exists('id', $_SESSION) ? (int)$_SESSION['id'] : 0;
    }

    public function getUserName(): string
    {
        return $_SESSION['usuario'] ?? '';
    }

    public function getRol(): string
    {
        return $_SESSION['rol'] ?? '';
    }

    public function isUserAuthenticated(): bool
    {
        return array_key_exists('usuario', $_SESSION);
    }

    public function closeSession(): void
    {
        session_unset();
        session_destroy();
    }
}
