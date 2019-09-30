<?php

namespace cinema\cart\storage;

use cinema\cart\CartItem;
use yii\db\Connection;
use yii\web\User;

class HybridStorage implements StorageInterface
{

    /**
     * @var StorageInterface
     */
    private $storage;

    private $cookieKey;

    private $cookieTimeout;

    private $db;
    /**
     * @var User
     */
    private $user;


    public function __construct(User $user, $cookieKey, $cookieTimeout, Connection $db)
    {
        $this->user = $user;
        $this->cookieKey = $cookieKey;
        $this->cookieTimeout = $cookieTimeout;
        $this->db = $db;
    }

    public function getStorage()
    {
        if ($this->storage === null) {
            $cookieStorage = new CookieStorage($this->cookieKey, $this->cookieTimeout);
            if ($this->user->isGuest) {
                 $this->storage = $cookieStorage;
            } else {
                $dbStorage = new DbStorage($this->user->getId(), $this->db);
                if ($cookieItems = $cookieStorage->load()){
                    $dbItems = $dbStorage->load();
                    $items = array_merge(array_udiff($cookieItems, $dbItems, function (CartItem $cookieItem, CartItem $dbItem) {
                        return $cookieItem->getId() === $dbItem->getId();
                    }),
                        $dbItems
                    );
                    $dbStorage->save($items);
                    $cookieStorage->save([]);
                }

                $this->storage = $dbStorage;
            }
        }

        return $this->storage;
    }

    /**
     * @return CartItem[]
     */
    public function load(): array
    {
        return $this->getStorage()->load();
    }

    /**
     * @param array $items
     * @throws \yii\db\Exception
     */
    public function save(array $items): void
    {
        $this->getStorage()->save($items);
    }
}