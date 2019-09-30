<?php

namespace cinema\cart\storage;

use cinema\cart\CartItem;
use cinema\entities\Cinema\Ticket;
use yii\helpers\Json;
use yii\web\Cookie;

class CookieStorage implements StorageInterface
{
    private $key;
    private $timeout;

    public function __construct(string $key, int $timeout)
    {
        $this->key = $key;
        $this->timeout = $timeout;
    }

    /**
     * @return CartItem[]
     */
    public function load(): array
    {
        if ($cookie = \Yii::$app->request->cookies->get($this->key)) {
            return array_filter(array_map(function (array $row) {
                if (isset($row['t']) && $ticket = Ticket::find()->andWhere(['id' => $row['t']])->one()) {
                    /** @var Ticket $ticket */
                    return new CartItem($ticket);
                }
                return false;
            }, Json::decode($cookie->value)));
        }
        return [];
    }

    /**
     * @param CartItem[]
     */
    public function save(array $items): void
    {
        \Yii::$app->response->cookies->add($cookie = new Cookie([
            'name' => $this->key,
            'value' => Json::encode(array_map(function (CartItem $item) {
                return [
                    't' => $item->getId()
                ];
            }, $items))
        ]));
    }
}