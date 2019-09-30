<?php
namespace cinema\cart;

use cinema\cart\cost\calculator\CalculatorInterface;
use cinema\cart\cost\Cost;
use cinema\cart\storage\StorageInterface;

class Cart
{
    private $storage;

    private $calculator;

    /**
     * @var CartItem[]
     */
    private $items;

    public function __construct(StorageInterface $storage, CalculatorInterface $calculator)
    {
        $this->storage = $storage;
        $this->calculator = $calculator;
    }

    public function getItems(){
        $this->loadItems();
        return $this->items;
    }

    public function loadItems(): void
    {
        if ($this->items == null) {
            $this->items = $this->storage->load();
        }
    }

    public function add(CartItem $item): void
    {
        $this->loadItems();
        foreach ($this->items as $current) {
            if ($item->getId() === $current->getId()) {
                throw new \DomainException("Ticket is already in cart");
            }
        }
        $this->items[] = $item;
        $this->saveItems();
    }

    public function remove($id): void
    {
        $this->loadItems();
        foreach ($this->items as $i => $item) {
            if ($item->getId() == $id) {
                unset($this->items[$i]);
                $this->saveItems();
                return;
            }
        }
        throw new \DomainException("Item not found");
    }

    public function check($id)
    {
        $this->loadItems();
        foreach ($this->items as $item) {
            if ($item->getId() === $id) {
                return true;
            }
        }
        return false;
    }

    public function getAmount()
    {
        $this->loadItems();
        return count($this->items);
    }

    public function getCost(): Cost
    {
        $this->loadItems();
        return $this->calculator->getCost($this->items);
    }

    public function clear()
    {
        $this->items = [];
        $this->saveItems();
    }

    public function saveItems()
    {
        $this->storage->save($this->items);
    }

}