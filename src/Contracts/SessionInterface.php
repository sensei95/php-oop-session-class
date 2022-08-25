<?php

namespace App\Contracts;

interface SessionInterface
{
    /**
     * @param string $key
     * @return mixed
     */
    public function has(string $key): bool;

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void;

    /**
     * @return void
     */
    public function clear(): void;

    /**
     * @param string $key
     * @return void
     */
    public function remove(string $key): void;
}