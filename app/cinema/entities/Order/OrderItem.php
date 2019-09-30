<?php

namespace cinema\entities\Order;

use cinema\entities\Cinema\Ticket;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $order_id
 * @property int $ticket_id
 * @property int $price
 *
 */
class OrderItem extends ActiveRecord
{
    public static function create(Ticket $ticket)
    {
        $item = new static();
        $item->ticket_id = $ticket->id;
        $item->price = $ticket->getPrice();
        return $item;
    }

    public function getCost(): int
    {
        return $this->price;
    }

    public function getTicket(): ActiveQuery
    {
        return $this->hasOne(Ticket::class, ['id' => 'ticket_id']);
    }

    public static function tableName(): string
    {
        return '{{%order_items}}';
    }
}