<?php

namespace App\Session;

use App\Contracts\SessionInterface;

class Session implements SessionInterface
{
    /**
     * @var bool
     */
    private bool $isStarted = false;

    /**
     * @return bool
     */
    public function isStarted(): bool
    {
        return $this->isStarted;
    }


    /**
     * @return bool
     */
    public function start(): bool
    {
        if($this->isStarted)
        {
            return true;
        }

        if(session_status() === PHP_SESSION_ACTIVE){
            $this->isStarted = true;
            return true;
        }

        session_start();
        $this->isStarted = true;
        return true;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->has($key) ? $_SESSION[$key] : $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @return void
     */
    public function clear(): void
    {
        $_SESSION = [];
    }

    /**
     * @param string $key
     * @return void
     */
    public function remove(string $key): void
    {

        if($this->has($key)){
            unset($_SESSION[$key]);
        }
    }
}