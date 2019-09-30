<?php
namespace cinema\cart\storage;

use cinema\cart\CartItem;

interface StorageInterface
{
    /**
     * @return CartItem[]
     */
    public function load(): array;

    /**
     * @param CartItem[]
     */
    public function save(array $items): void;
}