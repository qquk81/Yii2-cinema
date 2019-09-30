<?php

namespace cinema\cart\storage;
use cinema\cart\CartItem;
use cinema\entities\Cinema\Ticket;
use yii\db\Connection;
use yii\db\Query;

class DbStorage implements StorageInterface
{
    private $userId;
    private $db;

    public function __construct($userId, Connection $db)
    {
        $this->userId = $userId;
        $this->db = $db;
    }

    /**
     * @return CartItem[]
     */
    public function load(): array
    {
        $rows = (new Query())
            ->select('*')
            ->from('{{%cart_items}}')
            ->where(['customer_id' => $this->userId])
            ->orderBy(['ticket_id' => SORT_ASC])
            ->all($this->db);

        return array_filter(
            array_map(function (array $row) {
                if ($ticket = Ticket::find()->andWhere(['id' => $row['ticket_id']])->one() ) {
                    return new CartItem($ticket);
                }
            }, $rows)
        );
    }

    /**
     * @param array $items
     * @throws \yii\db\Exception
     */
    public function save(array $items): void
    {
        $this->db->createCommand()->delete('{{%cart_items}}',[
            'customer_id' => $this->userId
        ])->execute();

        $this->db->createCommand()->batchInsert("{{%cart_items}}",
            [
                'customer_id',
                'ticket_id'
            ],
            array_map( function (CartItem $item) {
                return [
                    'customer_id' => $this->userId,
                    'ticket_id' => $item->getId()
                ];
            },$items)
        )->execute();
    }
}